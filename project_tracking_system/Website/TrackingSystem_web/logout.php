<?php
session_start();
unset($_SESSION['userid']);
unset($_SESSION['MetroCureUser']);
session_destroy();

header("Location: login.php");
exit;
?>