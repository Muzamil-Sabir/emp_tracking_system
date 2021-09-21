<?php
include("check.php");
$add_billCategory_msg="";
$pageName="Free Units";
include("includes/opendb.php");
 $add_billCategory_msg="";
  $category="";
  $rank="";
  $categories = array();
  $query = "select * from connection_categories";
            $result = $conn->query($query);
            foreach($result as $row){
              array_push($categories,$row);

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
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $pageName ?></h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php
if(isset($_POST['btnaddcategory']))
{

      
     $category = validateData($_POST['txtcategory']);
     $rank =validateData($_POST['txtrank']);  

 //echo $name.$email.$password.$user;
     if ($category=='--Select Category--' && empty($rank)) {
        $add_billCategory_msg = 'Please Specify All Fields';
    } 
    else if ($category=='--Select Category--') {
        $add_billCategory_msg = 'Category Required!';
    }
 
     else if (empty($rank)) {
        $add_billCategory_msg = 'Specify rank!';
    } 
    
   
    else{

        
       
      $query="insert into connections_subcategories(categ_id,rank)values('$category','$rank')";
      $conn->query($query) or die("error");
      $add_billCategory_msg="success";
      $category="";
      $rank="";
      
    }
}

  ?>

    <!-- Main content -->
    <section class="content">
      
          <form method="post">
             <?php // check if any field is empty then through error message
       if ($add_billCategory_msg != "" && $add_billCategory_msg != "success") {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $add_billCategory_msg . '</div>';
            }// if billing type addess successfully then through success msg
            if ($add_billCategory_msg!="" && $add_billCategory_msg == "success") {
                echo '<div class="alert alert-success"><strong>category Added: </strong> ' . $add_billCategory_msg . '</div>';
            }
             ?>
              <div class="form-group row">
               
               <div class="col-sm-2">
                 <label class="col-sm- col-form-label">Category  </label>
                  <select class="form-control" name="txtcategory">
                    <option>--Select Category--</option>
                    <?php
                        foreach($categories as $value){
                     ?>
                    
                    <option value="<?php echo $value['categ_id'] ?>"><?php echo $value['categ_type'] ?></option>
                    <?php } ?>
                  </select> 
                </div>
        
                <div class="col-sm-2">
                  <label class="col-sm- col-form-label"> Rank </label>
                  <input type="text" value="<?php echo $rank ?>" class="form-control" name="txtrank" placeholder="Rank"/>
                </div>
                <div class="col-sm-2">
                  <label class="col-sm- col-form-label"> &nbsp; </label>
                 <button type="submit" class="btn btn-primary form-control" name="btnaddcategory" ><i class="fa fa-plus">&nbsp;</i>Add </button> </div>
              </div>
              
            </form>
          <?php   
          //check if url contain id or simply this will run when edit button is clicked to update billing type
          if(strstr($_SERVER['REQUEST_URI'], "id")) {
            if($_GET['id']!=""){ //id url id is not nuLL then proceed
            $id=$_GET['id'];
            //select record against specific id to update
              $q="select * from connection_categories where categ_id=$id";
              $result=$conn->query($q);
              $count=$result->rowCount();
              if($count>0){ //if it returns 0 rows then ignore else update fields will show
              foreach($result as $value)
              {
                $category=$value['categ_type'];
                $rank=$value['rank'];
               
              }

              echo '
              <br>
              <form method="post">

              <div class="form-group row">
                <label class="col-sm- col-form-label"> &nbsp; </label>
               <div class="col-sm-2">
                  <input type="text" Required value="'.$category.'" class="form-control"  name="txtucategory" placeholder="Category"/>
                </div>
        <label class="col-sm- col-form-label"> </label>
                <div class="col-sm-2">
                  <input Required type="text" value="'.$rank.'" class="form-control" name="txturank" placeholder="rank "/>
                </div>

                
                 <button type="submit" class="btn btn-primary" name="btnupdate"/><i class="fa fa-refresh">&nbsp;</i>Update Category</button>
                

                </div>
             

             
            </form>';
          }
            //check if update billing type button is clicked if clicked then update
            if(isset($_POST['btnupdate']))
            {
              $category=$_POST['txtucategory'];
              $rank=$_POST['txturank'];
              $query="update connection_categories set categ_type='$category',rank='$rank' where categ_id='$id'";
              
              $conn->query($query);
              $category="";
              $rank="";
              echo "<script> window.location.href='billing_category.php'; </script>";
            }
          }
        }

            ?>

       
      
       
         <div class="card">

    <div class="card-body">
      <?php  foreach($categories as $row){
       ?>
        <button id="add-new-button" class="btn btn-primary" onClick="window.location.href='sub_category.php?categ=<?php echo $row['categ_id']; ?>'"><b><?php echo $row['categ_type'];  ?></b></button>
      <?php } ?>
       <br> <br>
                <table id="example1" class="table table-bordered table-striped">
            <thead class="bg-blue">
              <tr>
                <th>Type</th>
                <th>rank</th>
                
                
                
                <th>Date & Time</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody>
              <?php 
              if(isset($_GET['categ'])){
                $categ_id = $_GET['categ'];
                  $query = "SELECT * from connections_subcategories
                            JOIN connection_categories
                            on connections_subcategories.categ_id = connection_categories.categ_id
                            where connections_subcategories.categ_id='$categ_id'";
              } 
              else{       
              $query = "SELECT connection_categories.categ_id, connection_categories.categ_type,connections_subcategories.rank,connections_subcategories.added_at from connection_categories,connections_subcategories
                WHERE connection_categories.categ_id = connections_subcategories.categ_id";
              }
              $result = $conn->query($query) or die("Query error");

              foreach ($result as $row) {
              ?>
                <tr>
                  <td><?php echo strtoupper($row['categ_type']);  ?></td>
                  <td><?php echo $row['rank']; ?></td>
                  <td><?php echo date( 'M d Y g:i A ', strtotime($row['added_at'])) ?></td>
                  <td>
                    <button class="btn btn-primary" name="btnedit" onClick="window.location.href='billing_category.php?id=<?php echo $row['categ_id']; ?>'"><i class="fa fa-edit">&nbsp;</i>Edit</button>
                    <button class="btn btn-danger" onClick="window.location.href='delete.php?categ_id=<?php echo $row['categ_id']; ?>'"><i class="fa fa-remove">&nbsp;</i>Delete</button>
                  </td>

                </tr>

              <?php
              }
              ?>
            </tbody>
            <tfoot class="bg-blue">
              <tr>

                 <th>Type</th>
                <th>rank</th>
                
                
                
                <th>Date & Time</th>
                <th>Action</th>
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