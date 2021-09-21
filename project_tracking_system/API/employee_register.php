<?php
include("../db/opendb.php");
include("../check.php");
$response = array();
if($_POST['email'] && $_POST['password'] && $_POST['name']){
	$email = $_POST['email'];
	$password =$_POST['password'];
	$name = $_POST['name'];
	$datetime = date('Y-m-d H:i:s');
	$query = "select * from employees where email = '".$email."'";
	$result = $conn->query($query);
	
 
	if($result->rowCount()>0){
		$response['error'] = false;
		$response['message'] = "User already registered";
		
	} else{
		
		$query = "insert into employees(name,email,password,added_at) values ('".$name."','".$email."','".$password."','".$datetime."')";
		$result2 = $conn->query($query);
		    
		if($result2){
			$response['error'] = false;
			$response['message'] = "User Registered Successfully";
		} else {
			$response['error'] = false;
			$response['message'] = "Cannot complete user registration";
		}
	}
} else{
	$response['error'] = true;
	$response['message'] = "Insufficient Parameters";
}
echo json_encode($response);	
?>