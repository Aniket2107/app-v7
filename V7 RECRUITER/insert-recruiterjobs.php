<?php
require '../Smtp/index.php';
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
  return $data;
}

$jobtitle=test_input($_POST['jobtitle']);
$novacancies=test_input($_POST['novacancies']);
$jobsector=test_input($_POST['jobsector']);
$country=test_input($_POST['country']);
 //$joblocation=test_input($_POST['joblocation']);
 if (isset($_POST['joblocation'])){
$joblocation=implode(',',$_POST['joblocation']);
}
else {
$joblocation='';
}
$email=$_POST['contactemail'];
$contactnumber=$_POST['contactnumber'];
$jobtype=test_input($_POST['jobtype']);
$minex=test_input($_POST['minex']);
$maxex=test_input($_POST['maxex']);
if($_POST['country']=='India'){
$currency=$_POST['indiacurrency'];
$minlakh=$_POST['minlakh'];
$minthousand=$_POST['minthousand'];
$maxlakh=$_POST['maxlakh'];
$maxthousand=$_POST['maxthousand'];
}
else{
$currency=$_POST['othercurrency'];
$minlakh=$_POST['from'];
$minthousand='';
$maxlakh=$_POST['to'];
$maxthousand='';
}

$ratetype=$_POST['ratetype'];


//$salary=test_input($_POST['salary']);
//$fullpackage=test_input($_POST['fullpackage']);
$description=test_input($_POST['description']);
$companyprofile=test_input($_POST['companyprofile']);

//$benefits=test_input($_POST['benefits']);
/**if (isset($_POST['benefits'])){
$benefits=implode(',',$_POST['benefits']);}
else {$benefits='';}***/
$degree=$_POST['degree'];
$keyskills=test_input($_POST['keyskills']);

if (isset($_POST['considerrelocation']))
$considerrelocation=$_POST['considerrelocation'];
else
$considerrelocation=0;
/*if (isset($_POST['relocationassistanc']))
$relocationassistanc=$_POST['relocationassistanc'];
else
$relocationassistanc=0;*/
$companyname=$_POST['companyname'];
$closingdate=$_POST['closingdate'];
if (isset($_POST['interviewstages']))
$interviewstages=$_POST['interviewstages'];
else
$interviewstages='';
$start_date = date('Y-m-d ');
$end_date = date('Y-m-d ', strtotime("+60 days"));

$sql=mysqli_query($link,"insert into recruiterjobs(memberid,companyname,jobtitle,novacancies,jobsector,country,joblocation,jobtype,contactemail,contactnumber,minex,maxex,minlakh,minthousand,maxlakh,maxthousand,ratetype,currency,description,companyprofile,keyskills,degree,relocate,closingdate,interviewstages,postdate,expirydate) values('$mid','$companyname','$jobtitle','$novacancies','$jobsector','$country','$joblocation','$jobtype','$email','$contactnumber','$minex','$maxex','$minlakh','$minthousand','$maxlakh','$maxthousand','$ratetype','$currency','$description','$companyprofile','$keyskills','$degree','$considerrelocation','$closingdate','$interviewstages',now(),'$end_date')");


$id = mysqli_insert_id($link);
if( mysqli_affected_rows($link)>0){
$candres=mysqli_query($link,"select name,email from canditate where emailactivated=1 and (years>='$minex' and years<='$maxex') and cv like '%$jobtitle%' and country like '%$country%'");
while($row = mysqli_fetch_assoc($candres)){

		$to =$row["email"];
		$from = "alerts@recruitinghub.com";;
		$subject = "RecruitingHub.com - Job Alert ($jobtitle) - Location ($joblocation)";
		$message = '<html>
		<body bgcolor="#FFFFFF">
			<div>
<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
  <tbody>
  <tr>
    <td style="padding:12px 12px 0px 12px">
    <table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
	  <tr>
      <td colspan="3" style="padding-left:14px">
      <div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div>
      </td>
       </tr>
	  <tr>
        <td style="padding:0px 14px">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
                   <tr>
                    <td style="padding-top:5px;color:#313131"><br>
					 
                      <table border="0" cellspacing="0" cellpadding="0" width="100%">
                        <tr>
                          <td><p>
                            Dear ' . $row['name'] . ',<br>
                            <br>
                            Greetings from <a href="https://www.recruitinghub.com" target="_blank">www.recruitinghub.com </a><br>
                            <br>
                            A new job <strong>'.$jobtitle.'</strong> has been posted by our recruiter on our marketplace. Click here to view the job <a href="https://www.recruitinghub.com/jobs/view-job-details?id='.$id.'">https://www.recruitinghub.com/jobs/view-job-details?id='.$id.'</a><br>
                            <br>
                            To Apply for this job,click here - <a href="https://www.recruitinghub.com/candidate-login" target="_blank">Login here</a> </p></td>
                        </tr>
                        <tr>
                          <td><p>&nbsp;</p></td>
                        </tr>
                        <tr>
                          <td><p>Best Regards,<br>
                              <a href="https://www.recruitinghub.com" target="_blank">www.recruitinghub.com </a> </p></td>
                        </tr>
                      </table>
                      <p>&nbsp;</p>
		</td>                
                </tr>            
                                   
                    </tbody>
                    </table>                    
                   </td>
                  </tr>
                 
                </tbody></table></td>
                <td width="20">&nbsp;</td>
                </td>
              </tr>
            
       
 		<tr>
        <td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>
          </p></td>
      </tr>
</tbody></table>
</div>
</body>
		</html>';
		// end of message
			
		$headers = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
	//	mail($to, $subject, $message, $headers);
		
		$params = ['from'=>'alerts@recruitinghub.com','name'=>'Recruiting Hub','to'=>$to,'subject'=>$subject,'message'=>$message,'server'=>'alert'];
      
     AsyncMail($params);
	

//$content="<h4>You have successfully posted a job on our Jobsite.</h4>";

		 }
		 	echo "<script>
alert('Job Post Successful! Share the Job link on your Social Media to attract more applicants.');
window.location.href='manage-jobs.php';
</script>";
		 
		} 
?>
		
				

		