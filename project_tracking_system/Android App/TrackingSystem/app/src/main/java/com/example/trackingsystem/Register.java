package com.example.trackingsystem;
import android.app.ProgressDialog;
import android.content.Intent;
import androidx.appcompat.app.AppCompatActivity;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;
import android.os.Bundle;
import android.os.AsyncTask;
import java.util.HashMap;
import org.json.JSONException;
import org.json.JSONObject;



public class Register extends AppCompatActivity {
    EditText et_name, et_email, et_password;
    public static final String URL_REGISTER = "https://ibbys.co.uk/TrackingSystem/API/employee_register.php";
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        et_name = findViewById(R.id.name);
        et_email = findViewById(R.id.email);
        et_password = findViewById(R.id.password);
    }
    public void register(View view)
    {
        final String name = et_name.getText().toString();
        final String email = et_email.getText().toString();
        final String password = et_password.getText().toString();

        if(name.isEmpty() && email.isEmpty() && password.isEmpty()){
            Toast.makeText(this, "Please fill all the fields", Toast.LENGTH_SHORT).show();
        }
        else if(name.isEmpty())
        {
            Toast.makeText(this, "Please Enter Name", Toast.LENGTH_SHORT).show();
        }
        else if(email.isEmpty())
        {
            Toast.makeText(this, "Please Enter Email", Toast.LENGTH_SHORT).show();
        }
        else if(password.isEmpty())
        {
            Toast.makeText(this, "Please Enter Password", Toast.LENGTH_SHORT).show();
        }
        else{
            class Login extends AsyncTask<Void, Void, String> {
                ProgressDialog pdLoading = new ProgressDialog(Register.this);

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
                    params.put("email", email);
                    params.put("password", password);
                    params.put("name", name);

                    //returing the response
                    return requestHandler.sendPostRequest(URL_REGISTER, params);
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
                        Toast.makeText(Register.this, "Exception: " + e, Toast.LENGTH_LONG).show();

                    }
                }
            }
            Login login = new Login();
            login.execute();
            Intent i = new Intent(getApplicationContext(),MainActivity.class);
            startActivity(i);

        }
    }

    public void login(View view){
        finish();
        Intent intent = new Intent(Register.this, MainActivity.class);
        startActivity(intent);


    }
}