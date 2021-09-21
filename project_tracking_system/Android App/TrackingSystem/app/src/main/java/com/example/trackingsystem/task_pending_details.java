package com.example.trackingsystem;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

public class task_pending_details extends AppCompatActivity {
    public static final String URL_GET_TASK_DETAILS = "https://ibbys.co.uk/TrackingSystem/API/task_details.php?task_id=";
    SharedPreferences sharedPreferences;
    String task_id,task_tittle,description,status,assigned_at;
    TextView tv_task_tittle,tv_task_reference,tv_task_description,tv_task_status,tv_task_assigned_at;
    Button btn_submit_task;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_task_pending_details);
        Intent intent = getIntent();

         task_id = intent.getStringExtra("task_id");
//        Toast.makeText(getApplicationContext(), "taskid="+task_id, Toast.LENGTH_LONG).show();

        get_task_details();
        tv_task_reference = findViewById(R.id.task_reference);
        tv_task_reference.setText(String.valueOf(task_id));

        btn_submit_task =findViewById(R.id.submit_task);
        btn_submit_task.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i =new Intent(task_pending_details.this, submit_task.class);
                i.putExtra("task_id", task_id);
                startActivity(i);
            }
        });

    }



    public void get_task_details(){

       // Toast.makeText(getApplicationContext(), "new ID="+c_task, Toast.LENGTH_LONG).show();
            class get_task_details extends AsyncTask<Void, Void, String> {
                ProgressDialog pdLoading = new ProgressDialog(task_pending_details.this);

                @Override
                protected void onPreExecute() {
                    super.onPreExecute();

                    //this method will be running on UI thread
                    pdLoading.setMessage("\tGetting Details...");
                    pdLoading.setCancelable(false);
                    pdLoading.show();
                }

                @Override
                protected String doInBackground(Void... voids) {
                    //creating request handler object
                    RequestHandler requestHandler = new RequestHandler();

                    //creating request parameters
                    HashMap<String, String> params = new HashMap<>();
                    //params.put("task_id",c_task);


                    //returing the response
                    return requestHandler.sendPostRequest(URL_GET_TASK_DETAILS+task_id, params);
                }

                @Override
                protected void onPostExecute(String s){
                    super.onPostExecute(s);
                    pdLoading.dismiss();

                    try {
                        //converting response to json object
                        JSONObject obj = new JSONObject(s);
                        //if no error in response
                        if (!obj.getBoolean("error")) {
                            task_tittle = obj.getString("task_tittle");
                            description = obj.getString("description");
                            status = obj.getString("status");
                            assigned_at = obj.getString("assigned_at");


                            settingtoView();
                            //Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_LONG).show();
//                            Intent intent = new Intent(task_pending_details.this, welcome.class);
//                            startActivity(intent);
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(task_pending_details.this, "Exception: " + e, Toast.LENGTH_LONG).show();
                    }
                }
            }

            get_task_details get_task_details = new get_task_details();
            get_task_details.execute();

    }

    public  void settingtoView()
    {
        tv_task_tittle = findViewById(R.id.task_tittle);
//        tv_task_description = findViewById(R.id.task_description);
        tv_task_status = findViewById(R.id.task_status);
        tv_task_assigned_at = findViewById(R.id.task_assigned_At);
        tv_task_tittle.setText(task_tittle);
//        tv_task_description.setText(description);
        tv_task_status.setText(status);
        tv_task_assigned_at.setText(assigned_at);
    }
}