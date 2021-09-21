<?php
include("check.php");
authenticate("ignore");
$pageName="Add New Employee";

  //setting environment variables

$emp_add_status="";
$name = "";
$email = "";
$contact = "";
$address = "";
$password="";
if(isset($_POST['addemoloyee'])){ //checkif add buttton pressed or not
  include("db/opendb.php");
  $name = validateData($_POST['name']);
  $email = validateData($_POST['email']);
  $contact = validateData($_POST['contact']);
  $address =  validateData($_POST['address']);
  $password = base64_encode($_POST['password']);
  $datetime = date('Y-m-d H:i:s');
    $query = "select * from employees where email = '".$email."'"; //check if email already exist in db
    $result = $conn->query($query);
    
 
              if($result->rowCount()>0){ //if email exist in tb throw error message
                $emp_add_status = "Employee Already Exist";
                }
                else{
                    $isactive=1;
                        $query = "insert into employees(name,email,contact,address,password,isactive,added_at)values(:name,
                                    :email,:contact,:address,:password,:isactive,:added_at)";
                        $stmt = $conn->prepare($query);
                        $stmt->bindParam(':name', $name);
                          $stmt->bindParam(':email', $email);
                          $stmt->bindParam(':contact', $contact);
                            $stmt->bindParam(':address', $address);
                              $stmt->bindParam(':password', $password);
                                $stmt->bindParam(':isactive',$isactive);
                                $stmt->bindParam(':added_at',$datetime);
                              if($stmt->execute())
                              {
                                $emp_add_status = "success";
                              }
                    
                   
                   
                  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $pageName ?></title>

  <!-- Google Font: Source Sans Pro -->
 <!-- Google Font: Source Sans Pro -->
 <?php include("includes/head.php"); ?>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link"><?php  echo $pageName ?></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
   

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include("includes/sidebar.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> <br>
   
    <!-- Content Header (Page header) -->
   <!--  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $pageName ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $pageName ?></li>
            </ol>
          </div>
        </div>
      </div>
    </section> -->

    <!-- Main content -->
    <section class="content">

<div class="row">
    
  <div class="col-md-10">
      <?php
       if ($emp_add_status != "" && $emp_add_status != "success") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $emp_add_status . '</div>';
            } 
            
     if ($emp_add_status!="" && $emp_add_status == "success") {
                echo '<div class="alert alert-success"><strong>Employee Added: </strong> ' . $emp_add_status . '</div>';
            }
             ?>
            <!-- general form elements -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 style="color: yellow" class="card-title">Add New Employee</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST"  enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Employee Name</label>
                    <input type="text" name="name" required class="form-control" id="exampleInputEmail1" placeholder="Full Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="text" name="email" required class="form-control" id="exampleInputPassword1" placeholder="Email">
                  </div>
                   <div class="form-group">
                    <label for="exampleInputPassword1">Contact #</label>
                    <input type="text" required name="contact" class="form-control" id="exampleInputPassword1" placeholder="Phone #">
                  </div>

                   <div class="form-group">
                    <label for="exampleInputPassword1">Address </label>
                    <textarea placeholder="Address" rows="4" required class="form-control" name="address"></textarea>
                    
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password </label>
                    <input type="text"  required name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                 
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer pull-right">
                  <button type="submit" name="addemoloyee" class="btn btn-primary">Add Employee</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


            <!-- /.card -->
           

          </div>

</div>
 
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include("includes/footer.php"); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<?php include("includes/scripts.php"); ?>
</body>
</html>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<?php $conn=NULL; ?>