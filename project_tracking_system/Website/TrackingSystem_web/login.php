  
  <?php
session_start();
// if(isset($_SESSION['Tracking_user']) && !empty($_SESSION['Tracking_user']))
// {
//   header("location:dashboard.php");
// }
function validateData($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
require("db/opendb.php"); 
  $login_error_message = '';
  $username="";
  $password="";
  if (isset($_POST['btnLogin'])) { //check if login button clicked or not if yes then proceeed


     $username = validateData($_POST['txtusername']); //validate username
    $password = validateData($_POST['txtpassword']); //validate password

    if (empty($username) && empty($password)) {  //check if username & password null or not
        $login_error_message = 'Username and password is required!';
    } 
     else if (empty($username)) { //check username field contains value or not
        $login_error_message = 'Username field is required!';
    } else if (empty($password)) { //check password field contains value or not
        $login_error_message = 'Password field is required!';
    }
    else{ //if both username and password field contains value then search user

      $query= 'select * from users where email=:username and password=:password';
      $stmt=$conn->prepare($query);  //prepare query to prevent sql injection
      $stmt->bindparam(':username',$username);
      $stmt->bindparam(':password',$password);

      try{

        $result=$stmt->execute();
        $count=$stmt->rowCount();
        if($count>0){ //is query return some record then settin session
         while($row= $stmt->fetch())
        {
         
          $_SESSION['Tracking_user']=$row;  //set session variable
           $_SESSION['LAST_ACTIVE_TIME'] = time();

          }

          header("location:dashboard.php");

        }
        else{
                $login_error_message = 'Username or password is invalid!';

        }

      }
      catch(Exception $e){
      echo $e->getMessage();

      }

    } 
}
 ?>

<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript">
  
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}


function focusCheck(){
var email=document.getElementById("txtusername").value;
var password=document.getElementById("txtpassword").value;
  //alert("yes");
  if(email=="")
  {

    document.getElementById("txtusername").focus();
  
    
  }

  else if(password=="")
  {

    document.getElementById("txtpassword").focus();
    document.getElementById('txtpassword').style.borderColor='red';

  }
}
  
</script>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Employee Tracking System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page" onload="focusCheck();" style="background-color: #d2d6de;">

<div class="login-box">
  <div class="login-logo">
    <img src="images/login_logo.png" height="300">
    <br>
  <!--   <a href="login.php"><strong> <b>Employee Tracking</b> </strong>System</a> -->
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"></p>
<?php     if ($login_error_message != "") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $login_error_message . '</div>';
            } ?>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="txtusername" id="txtusername" value="<?php echo $username ?>" id="txtemail" class="form-control" placeholder="Email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="txtpassword" id="txtpassword" value="<?php echo $password ?>" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="btnLogin" class="btn btn-primary">Sign In</button>
             <button type="reset" name="btnLogin" class="btn btn-primary">Reset</button>

          </div>
          <!-- /.col -->
          <div class="col-4">

           <!--  <button type="submit" name="btnLogin" class="btn btn-primary btn-block">Sign In</button> -->

          </div>
          
          <!-- /.col -->
        </div>
        <div class="row">
          &nbsp;
        </div>
        <div class="row">
         <!--  Powered by: <a href="https://www.cisnr.com"> <b> &nbsp; CISNR </b> </a> -->
        </div>
      </form>

   
      <!-- /.social-auth-links -->

     
    
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
