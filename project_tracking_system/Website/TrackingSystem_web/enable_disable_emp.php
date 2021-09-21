<?php
include("db/opendb.php");

$isactive = $_GET['isactive'];  //getting status
$emp_id = $_GET['emp'];  //getting emp id
if($isactive==0)
{	//change status
	$query = "update employees set isactive = 1 where id='".$emp_id."'";
}
else{
$query = "update employees set isactive = 0 where id='".$emp_id."'";
}
	$conn->query($query);
	header("Location: ".$_SERVER['HTTP_REFERER']);  //redirect to previous
?>