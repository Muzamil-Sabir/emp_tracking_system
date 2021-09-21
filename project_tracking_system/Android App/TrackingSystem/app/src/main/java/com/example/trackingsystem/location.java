package com.example.trackingsystem;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import android.Manifest;
import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
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

public class location extends AppCompatActivity {
    public static final String URL_SEND_CURR_LOCATION = "https://ibbys.co.uk/TrackingSystem/API/sendCurrentLocation.php";

    FusedLocationProviderClient fusedLocationProviderClient;
    double lat;
    double lng;
    String c_address = "";
    String street = "";
    String country = "";
    String curr_user_id;
    EditText et_lat,et_lng,et_address,et_street,et_country;
    Button btn_send_location;
    public static final String USER_ID = "userid";

    SharedPreferences sharedPreferences;
    public static final String MY_PREFERENCES = "MyPrefs";


    @Override
    protected void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_location);

        fusedLocationProviderClient = LocationServices.getFusedLocationProviderClient(this);
        if(ActivityCompat.checkSelfPermission(location.this, Manifest.permission.ACCESS_FINE_LOCATION)== PackageManager.PERMISSION_GRANTED){
            getlocation();
        }
        else{
            ActivityCompat.requestPermissions(location.this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION},44);
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
                        Geocoder geocoder = new Geocoder(location.this,
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
                        c_address = address.get(0).getLocality();
                        street = address.get(0).getAddressLine(0);
                        country = address.get(0).getCountryName();

                        et_lat = findViewById(R.id.lat);
                        et_lng = findViewById(R.id.lng);
                        et_address = findViewById(R.id.address);
                        et_street = findViewById(R.id.street);
                        et_country = findViewById(R.id.country);

                        et_lat.setText(String.valueOf(lat));
                        et_lng.setText(String.valueOf(lng));
                        et_address.setText(c_address);
                        et_street.setText(street);
                        et_country.setText(country);


                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                }
                else{
                    Toast.makeText(location.this, "Location Null", Toast.LENGTH_LONG).show();
                }
            }
        });
    }


    public void sendlocation_to_server(View view)
    {
        sharedPreferences = getSharedPreferences(MY_PREFERENCES, Context.MODE_PRIVATE);
        curr_user_id = sharedPreferences.getString(USER_ID,null);
            class sendlocation_to_server extends AsyncTask<Void, Void, String> {
                ProgressDialog pdLoading = new ProgressDialog(location.this);

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
                    params.put("street_address", street);
                    params.put("country", country);
                    params.put("user_id", curr_user_id);

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
                        Toast.makeText(location.this, "Exception: " + e, Toast.LENGTH_LONG).show();

                    }
                }
            }
        sendlocation_to_server sendlocation_to_server = new sendlocation_to_server();
        sendlocation_to_server.execute();
        Intent i = new Intent(getApplicationContext(),MainActivity.class);
        startActivity(i);


    }
    public void welcome(View view){
        finish();
        Intent intent = new Intent(location.this, welcome.class);
        startActivity(intent);


    }
}