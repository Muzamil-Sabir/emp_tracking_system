<?php
include("../db/opendb.php");
  include("../check.php");
 $datetime =  date("Y-m-d H:i:s");
$response = array();
if($_POST['lat'] && $_POST['lng'] && $_POST['task_id'] && $_POST['remarks'] ){
	$lat = $_POST['lat'];
	$lng =$_POST['lng'];
    $remarks=$_POST['remarks'];
	$task_id = $_POST['task_id'];
	$query = "update tasks set status='completed',remarks='".$remarks."', lat='".$lat."',lng='".$lng."' ,submitted_at='".$datetime."' where task_id='".$task_id."'";
	$result = $conn->query($query);
	
 
	if($result){
		$response['error'] = false;
		$response['message'] = "Task Submitted Suuccesssfully";
		
	} else{
		
	    	$response['error'] = true;
		$response['message'] = "Someting Went Wrong";
	}
} else{
	$response['error'] = true;
	$response['message'] = "Insufficient Parameters";
}
echo json_encode($response);	
?>