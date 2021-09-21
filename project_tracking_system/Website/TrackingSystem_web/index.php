<?php
session_start();
if (!isset($_SESSION['Tracking_user'])) {
	header("location:login.php");
	}
	else{
		header("location:dashboard.php");
	}
?>