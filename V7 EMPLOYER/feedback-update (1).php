<?php
session_start();
require_once '../config.php';
if(isset($_POST['feedbackid']) && ($_POST['feedbackid']!=""))
{
$id=$_POST['feedbackid'];
$feedback=$_POST['feedback'];
$rating=$_POST['rating'];
$companyid=$_POST['companyid'];
$memberid=$_POST['memberid'];
$name=$_POST['name'];

/**$query=mysqli_query("select ratedby,ratedto from employerrating where ratedby <> ratedto and ratedto='$id'");
$rerate = mysqli_result($query, 0);
if($rerate)
 $query=mysqli_query("update employerrating set feedback='$feedback',rating='$rating' where ratedby='$companyid'and ratedto='$id'");
 else***/
$query = mysqli_query($link,"insert into employerrating (companyid,ratedby,employername,ratedto,feedback,rating,date)values('$companyid','$memberid','$name','$id','$feedback','$rating',now()) ");
}
header("location: rating"); 
		exit();
 ?>