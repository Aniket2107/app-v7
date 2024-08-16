<?php
session_start();
require_once '../config.php';
$update=mysqli_query($link,"update members set onlinestatus=0 where memberid=".$_SESSION['mid']."");
session_destroy(); 
$_SESSION = array();
if(!isset($_SESSION['id'])){ 
$msg = "You are now logged out";
} else {
echo $msg = "<h2>Could not log you out</h2>";
} 
header("location: https://www.recruitinghub.com/recruiter/login"); 
		exit();
?> 
