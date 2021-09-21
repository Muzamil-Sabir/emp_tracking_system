package com.example.trackingsystem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;

import org.jetbrains.annotations.NotNull;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;

public class submit_task extends AppCompatActivity {
    public static final String URL_SEND_CURR_LOCATION = "https://ibbys.co.uk/TrackingSystem/API/submit_task.php";

    String task_id,remarks;
EditText tv_remarks;
double lat,lng;
    FusedLocationProviderClient fusedLocationProviderClient;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_submit_task);

        Intent intent = getIntent();

        task_id = intent.getStringExtra("task_id");
        Toast.makeText(getApplicationContext(), "taskid="+task_id, Toast.LENGTH_LONG).show();

        fusedLocationProviderClient = LocationServices.getFusedLocationProviderClient(this);
        if(ActivityCompat.checkSelfPermission(submit_task.this, Manifest.permission.ACCESS_FINE_LOCATION)== PackageManager.PERMISSION_GRANTED){
            getlocation();
        }
        else{
            ActivityCompat.requestPermissions(submit_task.this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION},44);
        }
    }

    @SuppressLint("MissingPermission")
    private void getlocation(){
        fusedLocationProviderClient.getLastLocation().addOnCompleteListener(new OnCompleteListener<Location>() {
            @Override
            public void onComplete(@NonNull @NotNull Task<Location> task) {

                Location location = task.getResult();

                if(location!=null){

                    try {
                        Geocoder geocoder = new Geocoder(submit_task.this,
                                Locale.getDefault());

                        List<Address> address = geocoder.getFromLocation(
                                location.getLatitude(),location.getLongitude(),1
                        );
//                        Toast.makeText(location.this, "latitude"+address.get(0).getLatitude()+" "+"Longitude:"+address.get(0).getLongitude()
//                                        +" "+"Address"+address.get(0).getLocality()+" "+"Street"+address.get(0).getAddressLine(0)
//                                        +" "+"Country"+address.get(0).getCountryName(),
//                                Toast.LENGTH_LONG).show();
                        lat = address.get(0).getLatitude();
                        lng = address.get(0).getLongitude();
//                        c_address = address.get(0).getLocality();
//                        street = address.get(0).getAddressLine(0);
//                        country = address.get(0).getCountryName();




                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                }
                else{
                    Toast.makeText(submit_task.this, "Location Null", Toast.LENGTH_LONG).show();
                }
            }
        });
    }

    public void submit_task_with_location(View view)
    {
        tv_remarks = findViewById(R.id.task_remarks);
        remarks=tv_remarks.getText().toString();
        class submit_task_with_location extends AsyncTask<Void, Void, String> {
            ProgressDialog pdLoading = new ProgressDialog(submit_task.this);

            @Override
            protected void onPreExecute() {
                super.onPreExecute();

                //this method will be running on UI thread
                pdLoading.setMessage("\tLoading...");
                pdLoading.setCancelable(false);
                pdLoading.show();
            }

            @Override
            protected String doInBackground(Void... voids) {
                //creating request handler object
                RequestHandler requestHandler = new RequestHandler();

                //creating request parameters
                HashMap<String, String> params = new HashMap<>();
                params.put("lat", String.valueOf(lat));
                params.put("lng", String.valueOf(lng));
                params.put("remarks",remarks);
                params.put("task_id",task_id);

                //returing the response
                return requestHandler.sendPostRequest(URL_SEND_CURR_LOCATION, params);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);
                pdLoading.dismiss();

                try {
                    //converting response to json object
                    JSONObject obj = new JSONObject(s);
                    //if no error in response
                    if (!obj.getBoolean("error")) {
                        Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_LONG).show();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                    Toast.makeText(submit_task.this, "Exception: " + e, Toast.LENGTH_LONG).show();

                }
            }
        }
        submit_task_with_location submit_task_with_location = new submit_task_with_location();
        submit_task_with_location.execute();
        finish();
        Intent i = new Intent(getApplicationContext(),MainActivity.class);
        startActivity(i);


    }

}