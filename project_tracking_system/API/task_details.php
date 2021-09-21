<?php
include("../db/opendb.php");
$response = array();
if($_GET['task_id']){
	$task_id = $_GET['task_id'];
	
	$query = "select * from tasks where task_id='$task_id'";
	$result = $conn->query($query);
	if($result->rowCount()>0){
	    
	   foreach($result as $row){
		$response['error'] = false;
		$response['message'] = "Task Found!";
		$response['task_tittle'] = $row['task_tittle'];
		$response['description'] = $row['task_description'];
		$response['assigned_at'] = $row['assigned_at'];
		$response['status'] = $row['status'];
		$response['submitted_at'] = $row['submitted_at'];
		$response['remarks'] = $row['remarks'];
	    }
	} else{
		$response['error'] = false;
		$response['message'] = "Invalid Email or Password";
	
	}
} else {
	$response['error'] = true;
	$response['message'] = "Insufficient Parameters";
}
echo json_encode($response);
?>