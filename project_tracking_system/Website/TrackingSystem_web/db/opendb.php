<?php
  

	// $servername = "10.13.144.6";
	// $username = "user_".$subdivid;
	// $password = "Adm1n@".$subdivid;
	// $dbname = $dbtype."_".$subdivid;

    $servername = "92.205.11.109";
    $username = "e_tracking";
    $password = ")6!s0)6F%gM";
    $dbname = "employee_tracking_system";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
//	echo "Connection Successfull";
}
catch(PDOException $e)
    {
    echo  $e->getMessage();
    echo "Unsuccesfull! Try again...!";
    }

?>
