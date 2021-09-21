<?php
include("check.php"); //authenticate user
authenticate("ignore");
 include("db/opendb.php"); //open database connection
$pageName="Add New Task";
$add_billCategory_msg="";


if(isset($_POST['addemoloyee'])){ //check if button clicked or not
 //getting values frompost request
  $task_tittle = validateData($_POST['task_tittle']);
  $description = validateData($_POST['description']);
  $assigned_to = validateData($_POST['assigned_to']);
   $datetime = date('Y-m-d H:i:s');
    
   
       $isactive=1;
        $query = "insert into tasks(task_tittle,task_description,assigned_to,assigned_at)values(:task_tittle,:task_description,:assigned_to,:assigned_at)";
             $stmt = $conn->prepare($query);
              $stmt->bindParam(':task_tittle', $task_tittle);
              $stmt->bindParam(':task_description', $description);
              $stmt->bindParam(':assigned_to', $assigned_to);
               $stmt->bindParam(':assigned_at', $datetime);
                if($stmt->execute())
                  {
                      $add_billCategory_msg = "success";
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
   
  

    <!-- Main content -->
    <section class="content">

<div class="row">
    
  <div class="col-md-10">
      <?php
       if ($add_billCategory_msg != "" && $add_billCategory_msg != "success") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $add_billCategory_msg . '</div>';
            } 

     if ($add_billCategory_msg!="" && $add_billCategory_msg == "success") {
                echo '<div class="alert alert-success"><strong>Task Added: </strong> ' . $add_billCategory_msg . '</div>';
            }
             ?>
            <!-- general form elements -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 style="color: yellow" class="card-title">Add New Task</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST"  enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Task Tittle</label>
                    <input type="text" name="task_tittle" required class="form-control" id="exampleInputEmail1" placeholder="Task Tittle">
                  </div>
                  <div class="form-group">
                   
                    <label for="exampleInputPassword1">Task Description</label>
                     <textarea name="description" rows="5" placeholder="Some Description about Task" required class="form-control"></textarea>
                  </div>
                   <div class="form-group">
                    <label for="exampleInputPassword1">Assigned To</label>
                    <select required name="assigned_to" class="form-control">
                      <option value="0">-Select Employee-</option>
                      <?php 
                      $query = "select * from employees where isactive =1";
                      $result = $conn->query($query);
                      foreach($result as $row)
                      {
                         ?>
                         <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                       <?php } ?>
                      
                    </select>
                  
                  </div>

                   
                  
                 
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer pull-right">
                  <button type="submit" name="addemoloyee" class="btn btn-primary">Add Task</button>
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
      "responsive": true, "lengthChange": true, "autoWidth": false,
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