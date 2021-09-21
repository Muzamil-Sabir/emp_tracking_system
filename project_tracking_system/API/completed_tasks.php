<?php
include("../db/opendb.php");
$response['data'] = array();
if($_GET['user_id']){
	$user_id = $_GET['user_id'];

	$query = "select task_id, task_tittle,task_description from tasks where assigned_to='".$user_id."' and status = 'completed'";
	$result = $conn->query($query);
	if($result->rowCount()>0){
	    
	   foreach($result as $row){
	   	//$data["task_tittle"] = $row['task_tittle'];
	   	array_push($response["data"], array("task_id"=>$row['task_id'],"task_tittle"=>$row['task_tittle'],"task_description"=>$row['task_description']));
		//array_push($response,$row);
		//$response[] = array("task_tittle"=>$row['task_tittle'],"task_description"=>$row['task_description']);
	    }
	    // $response['message'] = "Tasks Found";
	    // $response['error'] = "false";
	} else{
		$response['error'] = false;
		$response['message'] = "No Pending Tasks";
	
	}
} else {
	$response['error'] = true;
	$response['message'] = "Insufficient Parameters";
}
echo json_encode($response);

$conn=null;
?>