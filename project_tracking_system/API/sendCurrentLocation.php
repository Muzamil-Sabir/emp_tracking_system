<?php
include("../db/opendb.php");
  include("../check.php");
 $datetime =  date("Y-m-d H:i:s");
$response = array();
if($_POST['lat'] && $_POST['lng'] && $_POST['street_address'] && $_POST['country'] && $_POST['user_id'] ){
	$lat = $_POST['lat'];
	$lng =$_POST['lng'];
	$street_address = $_POST['street_address'];
	$country = $_POST['country'];
	$user_id = $_POST['user_id'];
	$query = "update employees set lat='".$lat."',lng='".$lng."',cordinates_street_address='".$street_address."',cordinates_country='".$country."' ,cordinates_updated_at='".$datetime."' where id='".$user_id."'";
	$result = $conn->query($query);
	
 
	if($result){
		$response['error'] = false;
		$response['message'] = "Location sent Successfully";
		
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