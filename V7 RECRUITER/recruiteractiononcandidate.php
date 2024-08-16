<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$email=$iam='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$iam=$_SESSION['iam'];
$adminrights=$_SESSION['adminrights'];
$cid=$_SESSION['cid'];
$admin=$_SESSION['admin'];
$rcountry=$_SESSION['country'];

$notification='';
}
else{
$notification='Please login to access the page';
$_SESSION['notification']=$notification;
header('location: login'); 
exit;
}
require_once '../config.php';
$content='';
 
if(isset($_GET['jid']) && ($_GET['jid']!='')){
$jid=$_GET['jid'];
}
if(isset($_GET['canid']) && ($_GET['canid']!='')){
$canid=$_GET['canid'];
}
if(isset($_GET['action']) && ($_GET['action']!='')){
$action=$_GET['action'];
}
if($action=='true'){
mysqli_query($link,"update appliedjobs set status='Shortlisted' where recruiterid='$mid' and jobapplied=$jid and candidateid=$canid");
}
elseif($action=='false'){
mysqli_query($link,"update appliedjobs set status='Rejected' where recruiterid='$mid' and jobapplied=$jid and candidateid=$canid");
}
header('location:manage-responses');
exit;


 ?>
