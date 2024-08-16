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
 
if(isset($_GET['uid']) && isset($_GET['a'])){
$uid=$_GET['uid'];
$a=$_GET['a'];
if($a=='delete'){
mysqli_query($link,"delete from members where memberid='$uid'");
}
elseif($a=='disable'){
mysqli_query($link,"update members set active='0' where memberid='$uid'");
}
elseif($a=='enable'){
mysqli_query($link,"update members set active='1' where memberid='$uid'");
}
elseif($a=='admin'){
mysqli_query($link,"update members set adminrights = !adminrights where memberid='$uid'");
}
header('location:manage-users');
exit;
}

 ?>
