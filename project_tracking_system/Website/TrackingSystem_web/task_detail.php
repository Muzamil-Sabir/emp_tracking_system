<?php
$pageName="Task Detail";
include("check.php");
authenticate("ignore");
 include("db/opendb.php");

if(isset($_GET['task']))
{
  $task_id = $_GET['task'];
  $query = "SELECT tasks.task_id,tasks.task_tittle,tasks.task_description,tasks.assigned_at,tasks.status,
                      employees.name,employees.email,tasks.lat,tasks.lng,tasks.remarks,tasks.submitted_at from  tasks JOIN
                       employees on tasks.assigned_to = employees.id where tasks.task_id = '".$task_id."'";
                  $result = $conn->query($query);
                  foreach($result as $row)
                  {
                    $task_name = $row['task_tittle'];
                    $task_description = $row['task_description'];
                    $tasks_assigned_at = $row['assigned_at'];
                    $status = $row['status'];
                    $emp_name = $row['name'];
                    $emp_email = $row['email'];
                    $lat = $row['lat'];
                    $lng = $row['lng'];
                    $completed_on = $row['submitted_at'];
                    $remarks = $row['remarks'];
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
  <style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
   
    /* Optional: Makes the sample page fill the window. */

</style>
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
              <li class="breadcrumb-item active">Contact</li>
            </ol>
          </div>
        </div>
      </div>
    </section> -->

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Task Detail: <b> <?php echo $task_name ?> </b></h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
              <div class="row">
                <div class="col-12 col-sm-4">
                  <div  class="info-box <?php echo ($status=='pending')?'bg-danger':'bg-green' ?>">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted"> <font color="white">Task Status </font></span>
                      <span class="info-box-number text-center text-muted mb-0"><font color="white"><?php echo ucfirst($status)  ?> </font></span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-info">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted"> <font color="white">Assigned To </font> </span>
                      <span class="info-box-number text-center text-muted mb-0"> <font color="white"><?php echo $emp_name ?> </font> </span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box bg-secondary">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted"> <font color="white">Assigned At </font> </span>
                      <span class="info-box-number text-center text-muted mb-0">
                        <font color="white">
                        <?php echo date( 'M d Y g:i A ', strtotime($tasks_assigned_at)) ?>
                      </font>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <h3 class="card-title"> <b>Task Description: </b></h3>
                    <div class="post">
                      <br>
                      <!-- /.user-block -->
                      <p>
                       <?php echo $task_description ?>fdfgdfg
                      </p>

                      
                    </div>

                    <div class="post clearfix">
                      <h3 class="card-title"><b>Task Submission  Details:</b> </h3>
                    </div>

                    <div class="post">
                      <div class="row">
                <div class="col-12 col-sm-4">
                  <div class="info-box <?php echo ($status=='pending')?'bg-red':'bg-green' ?>">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted"> <font color="white">Submitted at </font> </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      <font color="white"> <?php echo ($status=='pending')?"Not Submitted yet":$completed_on ?>
                          </font> 
                        </span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box <?php echo ($status=='pending')?'bg-red':'bg-secondary' ?>">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted"> <font color="white"> Latitude </font></span>
                      <span class="info-box-number text-center text-muted mb-0">
                        <font color="white">
                       <?php echo ($status=='pending')?"Not Submitted yet":$lat ?>
                          </font>
                        </span>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="info-box <?php echo ($status=='pending')?'bg-red':'bg-primary' ?>">
                    <div class="info-box-content">
                      <span class="info-box-text text-center text-muted"> <font color="white"> Longitude </font></span>
                      <span class="info-box-number text-center text-muted mb-0">
                        <font color="white">
                      <?php echo ($status=='pending')?"Not Submitted yet":$lng ?>
                          </font>
                        </span>
                    </div>
                  </div>
                </div>
                 <h3 class="card-title"> <b>Remarks: </b></h3>
                    <div class="post">
                      <br>
                      <!-- /.user-block -->
                      <p>
                       <?php echo ($remarks=="")?"No Remarks Found":$remarks ?>
                      </p>
              </div>
                    </div>
                </div>
              </div>
            </div>
           
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

 <?php if($status=='completed' && $lat!=NULL && $lng!=NULL){ ?>
      <div class="row mb-2" style="height:650px">
          <div class="col-lg-12">

           
              <div  id="map" style="height: 100%;width: 100%"></div>
              
              <script>
                  var customLabel = {
                      restaurant: {
                          label: 'R'
                      },
                      bar: {
                          label: 'B'
                      }
                  };

                  function initMap() {  
                        var point=null;
                        var latt_focus = <?php echo $lat ?>;
                         var lng_focus = <?php echo $lng ?>;

                     var map = new google.maps.Map(document.getElementById('map'), {
                          center: new google.maps.LatLng(latt_focus, lng_focus),
                          zoom: 6
                      });


                      // Change this depending on the name of your PHP or XML file
                      downloadUrl('get_task_location.php?task=<?php echo $task_id ?>', function(data) {

                          var xml = data.responseXML;
                          var markers = xml.documentElement.getElementsByTagName('marker');
                          Array.prototype.forEach.call(markers, function(markerElem) {
                              
                              
                      
                                var updated_at = markerElem.getAttribute('submitted_at');
                              var latitude = markerElem.getAttribute('lat');
                              var longitude = markerElem.getAttribute('lng');
                                var tittleText="Employee Tracking";

                               point = new google.maps.LatLng(
                                  parseFloat(markerElem.getAttribute('lat')),
                                  parseFloat(markerElem.getAttribute('lng')));

                              // var infowincontent = document.createElement('div');
                              // var strong = document.createElement('strong');
                              // strong.textContent = "Name="+name
                              // infowincontent.appendChild(strong);
                              // infowincontent.appendChild(document.createElement('br'));

                              // var text = document.createElement('text');
                              // text.textContent = "Address="+cordinates_street_address
                              // infowincontent.appendChild(text);
                             
                              var marker = new google.maps.Marker({
                                  map: map,
                                  position: point,
                                  //icon:'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                                  //title: tittleText+'\n\n'+'latitude='+latitude+'\n'+'Longitude='+longitude+'\n'+'Mangnitude='+magnitude+'\n'+'Depth='+depth

                              });


                              // var marker = new google.maps.Marker({
                              //     map: map,
                              //     position: point,
                              //      icon: {
                              //     path: google.maps.SymbolPath.CIRCLE,
                              //     scale: 12.5,
                              //     fillColor: "darkgreen",
                              //     fillOpacity: 0.8,
                              //     strokeWeight: 0.4
                              //         },
                              //     //icon:'http://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                              //     // title: tittleText+'\n\n'+'latitude='+latitude+'\n'+'Longitude='+longitude+'\n'+'Mangnitude='+magnitude+'\n'+'Depth='+depth
                              //     title:name

                              // });

                      var contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<h4 id="firstHeading" class="firstHeading">Employees Tracking System</h4>' +
                    '<div id="bodyContent">' +
              
                    '<h6>Latitude:'+'&nbsp<b> '+latitude+'</b></h6>' +
                   '<h6>Longitude:'+'&nbsp<b> '+longitude+'</b></h6>' +
              
                    '<h6>Submitted at:'+'&nbsp<b> '+updated_at+'</b></h6>' +

                       
                    "</div>" +
                  "</div>";
                   
              var infowindow = new google.maps.InfoWindow({
                content: contentString
              });
                                         
                              marker.addListener('mouseover',function()
                              {
                                  infowindow.open(map, marker);
                              });
                               marker.addListener('mouseout',function()
                              {
                                  infowindow.close(map, marker);
                              });


                              // marker.addListener('click', function() {
                              //     //alert(name);

                              //     var urlData =  id;



                              //     window.location.href = "waveform.php?id="+urlData;
                              //     //document.writeln(encoded);
                              //  //   document.writeln(decoded);
                              //     infoWindow.setContent(infowincontent);
                              //     infoWindow.open(map, marker);
                              // });


                          });
                      });
                  }





                  function downloadUrl(url, callback) {
                      var request = window.ActiveXObject ?
                          new ActiveXObject('Microsoft.XMLHTTP') :
                          new XMLHttpRequest;

                      request.onreadystatechange = function() {
                          if (request.readyState == 4) {
                              request.onreadystatechange = doNothing;
                              callback(request, request.status);
                          }
                      };

                      request.open('GET', url, true);
                      request.send(null);
                  }

                  function doNothing() {}
              </script>
              <script async defer
                      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGdcSfLwqmDVg_HLbYAJo0qkbElSM5_fc&callback=initMap">
              </script>
              
          </div><!-- /.col -->

        </div><!-- /.row -->
          <?php } ?>
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