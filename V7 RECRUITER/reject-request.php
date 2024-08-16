<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$email='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$adminrights=$_SESSION['adminrights'];
$admincountry= $_SESSION['admincountry'];
$usertype=$_SESSION['usertype'];
}

else{

$notification='Please login to access the page';

$_SESSION['notification']=$notification;

header('location: index'); exit;

}

require_once '../config.php';

if(isset($_GET['requestid']) || isset($_POST['allcheck'])){

	$requestid=$_GET['requestid'];
	// $requestid=$value;

	//echo $requestid;
	
	mysqli_query($link,"Update request set status='Rejected' WHERE requestid='$requestid'"); 

	//mysqli_query($link,"update jobs INNER JOIN request ON request.jobid = jobs.jobid set jobs.status='open', jobs.engagedby = '' WHERE request.requestid='$requestid'");

	header('location: jobs'); exit;

	$content="You have rejected the engagement(s)";

	

	
}
else{

$errormsg="Access denied";	
header('location: login'); exit;
}

