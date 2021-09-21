<?php
include("../db/opendb.php");
$response = array();
if($_POST['email'] && $_POST['password']){
	$email = $_POST['email'];
	$password = base64_encode($_POST['password']);
	$query = "select * from employees where email='".$email."' and password = '".$password."'";
	$result = $conn->query($query);
	if($result->rowCount()>0){
	        
	    $query = "select * from employees where email='".$email."' and password = '".$password."' and isactive=1"; 
	    $result2 = $conn->query($query);
	    	if($result2->rowCount()>0){
	   foreach($result as $row){
		$response['error'] = false;
		$response['message'] = "Login Successful!";
		$response['email'] = $row['email'];
		$response['username'] = $row['name'];
		$response['user_id'] = $row['id'];
	    }
    	}
    	else{
    	 $response['error'] = true;
		$response['message'] = "Account Inactive";
    	}
	} else{
		$response['error'] = true;
		$response['message'] = "Invalid Email or Password";
	
	}
} else {
	$response['error'] = true;
	$response['message'] = "Insufficient Parameters";
}
echo json_encode($response);
?>