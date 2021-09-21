package com.example.trackingsystem;

import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;


public class tasks_pending extends AppCompatActivity {
    public static  String URL_GET_PENDING_TASKS = "https://ibbys.co.uk/TrackingSystem/API/pending_tasks.php?user_id=";
    Button btn_pending_tasks;
    ListView listView;

    SharedPreferences sharedPreferences;
    public static final String MY_PREFERENCES = "MyPrefs";
    public static final String USER_ID = "userid";
    String curr_user_id;
    ArrayList<String> arrayList = new ArrayList<>();
    ArrayAdapter<String> arrayAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_tasks_pending);

        listView = findViewById(R.id.pending_tasks);


//        ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1,month);
//        listView.setAdapter(arrayAdapter);

        sharedPreferences = getSharedPreferences(MY_PREFERENCES, Context.MODE_PRIVATE);
        curr_user_id = sharedPreferences.getString(USER_ID,null);
        get_pending_tasks();

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> parent, View view,
                                    int position, long id) {
                // TODO Auto-generated method stub
                String UserInfo = listView.getItemAtPosition(position).toString();
                String taskId = UserInfo.substring(5, UserInfo .indexOf(" "));
               // Toast.makeText(getApplicationContext(), userId, Toast.LENGTH_LONG).show();
                Intent i =new Intent(tasks_pending.this, task_pending_details.class);
                i.putExtra("task_id", taskId);
                startActivity(i);
//                /***just to check if it has value***/
//                // Toast.makeText(getBaseContext(),"position is : "+position+" and value is +UserInfo,Toast.LENGTH_SHORT).show();
//                Toast.makeText(getBaseContext(), id + "", Toast.LENGTH_LONG).show();
            }
        });

    }



    public void get_pending_tasks(){



            class get_pending_tasks extends AsyncTask<Void, Void, String> {
                ProgressDialog pdLoading = new ProgressDialog(tasks_pending.this);

                @Override
                protected void onPreExecute() {
                    super.onPreExecute();

                    //this method will be running on UI thread
                    pdLoading.setMessage("\tFetching Tasks Please Wait");
                    pdLoading.setCancelable(false);
                    pdLoading.show();
                }

                @Override
                protected String doInBackground(Void... voids) {
                    //creating request handler object
                    RequestHandler requestHandler = new RequestHandler();

                    //creating request parameters
                    HashMap<String, String> params = new HashMap<>();
//                    params.put("user_id", curr_user_id);


                    //returing the response
                    return requestHandler.sendPostRequest(URL_GET_PENDING_TASKS+curr_user_id, params);
                }

                @Override
                protected void onPostExecute(String s) {

                    super.onPostExecute(s);
                    pdLoading.dismiss();

                    try {
                        //converting response to json object
                        //JSONObject obj = new JSONObject(s);

                            //if no error in response
                            if (s!=null) {
                                //Toast.makeText(getApplicationContext(), s, Toast.LENGTH_LONG).show();
                                JSONObject jsonObject = new JSONObject(s);
                                JSONArray jsonArray = jsonObject.getJSONArray("data");
                                for (int i=0;i<jsonArray.length();i++)
                                {
                                    JSONObject object = jsonArray.getJSONObject(i);
                                    int task_id = object.getInt("task_id");
                                    String task_tittle = object.getString("task_tittle");
                                    String task_description = object.getString("task_description");
                                    arrayList.add("Ref#:"+task_id+" "+task_tittle+":"+task_description);
                                }
                                loadIntoListView();
                               // loadIntoListView(s);
//                            String username = obj.getString("username");
//                            String user_id = obj.getString("user_id").toString();
//                            SharedPreferences.Editor editor = sharedPreferences.edit();
//                            editor.putString(USERNAME, username);
//                            editor.putString(EMAIL, email);
//                            editor.putBoolean(STATUS, true);
//                            editor.putString(USER_ID, user_id);
//                            editor.apply();
//
//                            finish();
//                            Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_LONG).show();
//                            Intent intent = new Intent(MainActivity.this, welcome.class);
//                            startActivity(intent);
                                // Toast.makeText(getApplicationContext(), obj.getString("message"), Toast.LENGTH_LONG).show();

                            }

                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(tasks_pending.this, "Exception: " + e, Toast.LENGTH_LONG).show();
                    }
                }
            }

            get_pending_tasks get_pending_tasks  = new get_pending_tasks();
            get_pending_tasks.execute();

    }


    private void loadIntoListView(){
        ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, arrayList);
        listView.setAdapter(arrayAdapter);
        

    }
}