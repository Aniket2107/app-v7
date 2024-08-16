<?php
session_start();
$mid='';
$name='';
$email='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$adminrights=$_SESSION['adminrights'];
$cid=$_SESSION['cid'];
$admin=$_SESSION['admin'];
$rcountry=$_SESSION['country'];
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
  $data = str_replace("`","",$data);
  return $data;
}

$fname=test_input($_POST['fname']);
$replacewith = "hiddentext";
    $fname = preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", $replacewith, $fname);
    $fname = preg_replace("/^(\(?\d{3}\)?)?[- .]?(\d{3})[- .]?(\d{4})$/", $replacewith, $fname);
 $fname = preg_replace("/^(\(?\d{4}\)?)?[- .]?(\d{3})[- .]?(\d{4})$/", $replacewith, $fname);
$email=test_input($_POST['email']);
$contactnumber=test_input($_POST['contactnumber']);
$currentemployer=test_input($_POST['currentemployer']);
$currentjobtitle=test_input($_POST['currentjobtitle']);
$minex=test_input($_POST['minex']);
$maxex=test_input($_POST['maxex']);
$jobtype=$_POST['jobtype'];
$currentsalary=$_POST['currentsalary'];
$currentcurrency=$_POST['currentcurrency'];
$desiredsalary=$_POST['desiredsalary'];
$expectedcurrency=$_POST['expectedcurrency'];
$typesalary=$_POST['typesalary'];
$nationality=test_input($_POST['nationality']);
if(isset($_FILES['video'])){
	 $video=$_FILES['video']['name'];
	 }
else
	$video='';
$notice=$_POST['notice'];
$country=$_POST['country'];
$location=$_POST['location'];
$cvcopy=mysqli_real_escape_string($link,$_POST['cvcopy']);
$replacewith = "hiddentext";
    $cvcopy = preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", $replacewith, $cvcopy);
    $cvcopy = preg_replace("/^(\(?\d{3}\)?)?[- .]?(\d{3})[- .]?(\d{4})$/", $replacewith, $cvcopy);
 $cvcopy = preg_replace("/^(\(?\d{4}\)?)?[- .]?(\d{3})[- .]?(\d{4})$/", $replacewith, $cvcopy);
if (isset($_POST['relocate']))
$relocate=$_POST['relocate'];
else
$relocate=0;
$additionalinfo=test_input($_POST['additionalinfo']);
//$additionalinfo=mysqli_real_escape_string(test_input($_POST['additionalinfo']));
if(isset($_FILES['cv'])){
	 $cv=str_replace("'","-",$_FILES['cv']['name']);
	 $cv=str_replace("`","",$cv);
	 }
else
	$cv='';
	
	$q=mysqli_query($link,"insert into benchcandidates(fname,email,contactnumber,currentemployer,currentjobtitle,minex,maxex,jobtype,currentsalary,currentcurrency,desiredsalary,expectedcurrency,typesalary,notice,country,location,nationality,relocate,additionalinfo,cv,video,resume,recruiterid,addeddate) values('$fname','$email','$contactnumber','$currentemployer','$currentjobtitle','$minex','$maxex','$jobtype','$currentsalary','$currentcurrency','$desiredsalary','$expectedcurrency','$typesalary','$notice','$country','$location','$nationality','$relocate','$additionalinfo','$cv','$video','$cvcopy','$mid',now())")or die("Error in query");

$id = mysqli_insert_id($link);
		
		if (!file_exists("benchcandidatecvs/".$mid)) {
			mkdir("benchcandidatecvs/".$mid,0777,true);
			}
			mkdir("benchcandidatecvs/".$mid."/".$id,0777,true);
			 if (is_uploaded_file($_FILES["cv"]["tmp_name"]) ) {
			move_uploaded_file($_FILES['cv']['tmp_name'], "benchcandidatecvs/".$mid."/".$id."/".$cv);
				}
$id = mysqli_insert_id($link);
		
		if (!file_exists("video/".$mid)) {
			mkdir("video/".$mid,0777,true);
			}
			mkdir("video/".$mid."/".$id,0777,true);
			 if (is_uploaded_file($_FILES["video"]["tmp_name"]) ) {
			move_uploaded_file($_FILES['video']['tmp_name'], "video/".$mid."/".$id."/".$video);
				}		
				
$content="<h4><p style = 'font-size: 16px;
            color: #a02121;'>You have successfully added a Bench Resource to your database BUT not submitted to an engaged Bench Job yet.</p> <p style = 'font-size: 16px;
            color: #a04721;'><a href='engagedbenchjob'><b>CLICK HERE TO SUBMIT TO AN ENGAGED JOB NOW</b></a></p></h4>";
		