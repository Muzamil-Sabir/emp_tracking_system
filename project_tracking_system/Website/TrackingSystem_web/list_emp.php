<?php
include("check.php");
authenticate("ignore");
date_default_timezone_set("Asia/Karachi");
$pageName="Employees List";
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
   <!--  <button type="button" data-toggle="modal" data-target="#modal-primary" style="margin-left: 2%" class="btn  bg-gradient-primary btn-lg">Add New Consumer</button>
   
    <section class="content-header">
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

  <button class=" btn btn-warning" onclick="location.href='list_emp.php?emp=0'">Pending</button> 
   <button class=" btn btn-success" onclick="location.href='list_emp.php?emp=1'">Approved</button> 
    <button class=" btn btn-danger" onclick="location.href='list_emp.php?emp=-1'">Rejected</button> 
   <hr>
         <div class="card">
    <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-secondary">
              <tr style="color:white">
               
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                 <th>Contact</th>
              
              <!--   <th>UnitFMN</th> -->
                <th>password</th>
              <!--   <th>Furniture</th>
                <th>Water</th> -->
                <th>Status</th>
                <th>Added at</th>
                <th>Action</th>
                <!-- <th width="15%">Action</th> -->

                </tr>
            </thead>
            <tbody>
              <?php
              require_once("db/opendb.php");
              // $id = "1710177817915";
              if (isset($_GET['emp'])) {
                $isactive= $_GET['emp'];
                $query = "select * from employees where isactive = '".$isactive."'";
              }
              else{
              $query = "select * from employees ";
            }
              $result = $conn->query($query) or die("Query error");

              foreach ($result as $row) {
              ?>

              
                 <tr>
                 
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo ($row['address']=="")?"N/A":$row['address']; ?></td>
                   <td><?php echo ($row['contact']=="")?"N/A":$row['contact']; ?></td>
                  <td><?php echo $row['password']; ?></td>
                    <?php if($row['isactive']==1){ ?>
                       <td class="bg-green"><?php echo "Approved"?></td>
                    <?php } ?>
                    <?php if($row['isactive']==0){ ?>
                       <td class="bg-yellow"><?php echo "Pending"?></td>
                    <?php } ?>
                <?php if($row['isactive']==-1){ ?>
                       <td class="bg-red"><?php echo "Rejected"?></td>
                    <?php } ?>
                
                 
                  
                
                 
                  <td><?php echo date( 'M d Y g:i A ', strtotime($row['added_at'])) ?></td>
                <td> <div class="input-group-prepend">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                      Action
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="enable_disable_emp.php?emp=<?php echo $row['id'] ?>&isactive=<?php echo $row['isactive'] ?>"><?php echo ($row['isactive']==1)?"Disable":"Approve" ?></a>
                   
                    </div>
                  </div></td>

              <?php
              }
              ?>
            </tbody>
            <tfoot class="bg-secondary">
                  <tr style="color:white">
               
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                 <th>Contact</th>
               
              <!--   <th>UnitFMN</th> -->
                <th>password</th>
              <!--   <th>Furniture</th>
                <th>Water</th> -->
                <th>Status</th>
                <th>Added at</th>
                <th></th>
               <!--  <th width="15%">Action</th> -->

                </tr>

            </tfoot>
          </table>


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
      "responsive": true, "lengthChange": true, "autoWidth": false
      
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