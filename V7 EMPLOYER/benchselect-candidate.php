<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$email=$iam='';
$content=$errormsg='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$iam=$_SESSION['iam'];
$ecountry=$_SESSION['country'];
$cid=$_SESSION['cid'];
$adminrights=$_SESSION['adminrights'];


//echo  $mid;
require_once '../config.php';
require '../Smtp/index.php';
require '../helpers/general.php';

$checks=array();
if(isset($_GET['candidateid']) || isset($_POST['allcheck'])){
	if(isset( $_POST['allcheck']))
		$checks=$_POST['allcheck'];
	else
	{
		$candidateid=$_GET['candidateid'];
		array_push($checks,$candidateid);
	}
}
	if(!empty($checks)){
	foreach($checks as $value) {
	$candidateid=$value;
	$recruiter=mysqli_fetch_assoc(mysqli_query($link,"select recruiterid from benchcandidates where id='$candidateid'"));




  if($adminrights){
    $cidsql=mysqli_query($link,"select jobid from submitted_benchcandidates where candidateid='$candidateid'");
    $cjobrow=mysqli_fetch_assoc($cidsql);
    $jmid =  $cjobrow['jobid'];
  

    $jobmemsql=mysqli_query($link,"select memberid from benchjobs where jobid=$jmid");
    $jobrow=mysqli_fetch_assoc($jobmemsql);
    $mid = $jobrow['memberid'];
  }



  






  


		mysqli_query($link,"Update jobs INNER JOIN submitted_candidates ON submitted_candidates.jobid = jobs.jobid set submitted_candidates.status='Shortlisted',submitted_candidates.feedbackdate=now() WHERE submitted_candidates.candidateid='$candidateid' and jobs.memberid='$mid'");
		mysqli_query($link,"Update jobs INNER JOIN submitted_candidates ON submitted_candidates.jobid = jobs.jobid set jobs.status='Shortlisted' WHERE submitted_candidates.candidateid='$candidateid' and jobs.memberid='$mid'");
		
	$content="You have Shortlisted the candidate(s). Please message the agency to  schedule interview.";
	
	$q2=mysqli_query($link,"select e.email,e.firstname,e.shortlistnotification,d.name from companyprofile d,members e ,submitted_benchcandidates c where  d.id=e.companyid  and e.memberid=c.recruiterid and c.candidateid='$candidateid'");
		while($row2 = mysqli_fetch_array($q2)){
			$array2=$row2;
				}
		$q1=mysqli_query($link,"select a.jobtitle,a.jobid,d.name from benchjobs a,companyprofile d,members e ,submitted_benchcandidates c where  d.id=e.companyid  and e.memberid=a.memberid and c.jobid=a.jobid and c.candidateid='$candidateid'  ");
		while($row1 = mysqli_fetch_array($q1)){
			$array1=$row1;
				}
		$q3=mysqli_query($link,"select fname,email  from benchcandidates  where id='$candidateid'");
		while($row3= mysqli_fetch_array($q3)){
			$array3=$row3;
				}
		$shortlistnotification=$array2['shortlistnotification'];	
		if($shortlistnotification==1){
	//mail to agency
	
	$to = $array2['email'];



			$from = "noreply@recruitinghub.com";
            $r=	getAccountManagerDetail($link,$mid);
            $c=	getCandidatesDetail($link,$mid);

			$subject = "Recruiting Hub - Congrats! ".$array3['fname']." submitted for ".$array1['jobtitle']." has been Shortlisted by ".$array1['name']."";



			$message = '<html>
		<body bgcolor="#FFFFFF">
		<div>
<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
  <tbody>
  <tr>
    <td  colspan="2" style="padding:12px 12px 0px 12px">
    	<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
      	<tbody>
	  		<tr>	
            	<td colspan="3" style="padding-left:14px"><div style="boder:0"><a href="https://www.recruitinghub.com/recruiter/login"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div></td>
            	
            	<td colspan="3" style="padding-right:12px"><div style="boder:0"><a href="https://www.recruitinghub.com/recruiter/login"><img src="https://www.recruitinghub.com/images/Shortlisted.png" alt="www.recruitinghub.com"></a></div></td>
            	
            
          </tr>
	  <tr>
        <td style="padding:0px 14px"><table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr>
            <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody><tr>
                <td valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                                    <tr>
                                      <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                          <tr>
                                            <td valign="top"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                <tr>
                                                  <td><p><br>
                                                     Dear '.$array2['firstname'].',<br>
                                                    <br>
                                                    
                                                    <p style = "font-size: 14px;
            color: #a02121;">  PLEASE DO NOT REPLY TO THIS EMAIL AS EMAILS ARE NOT MONITORED FOR THIS EMAIL ID. LOGIN TO YOUR ACCOUNT TO RESPOND AS APPROPRIATE </p>   
            
                                                    Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">Recruiter Login</a><br>
                                                    <br>
                                                    Congrats! Your profile <strong>'.$array3['fname'].'</strong> submitted for <strong>'.$array1['jobtitle'].'</strong> from <strong>'.$array1['name'].'</strong> has been <strong>Shortlisted</strong>. <br>
                                                    <br>
                                                    Please open the profile and click "ADD NOTES" or use the  MESSAGING tool from your Recruiter Login to update further progress of this candidature. Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">Recruiter Login</a></p></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td><p>Best Regards,<br>
                                                      <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">www.recruitinghub.com </a> </p></td>
                                                </tr>
                                            </table></td>
                                            <td width="20"><p>&nbsp;</p></td>
                                          </tr>
                                      </table></td>
                                    </tr>            
                                    <tr>
                    <td>&nbsp;</td>
                  </tr>
                                  
                  <tr>
                    <td style="padding:4px 0 0 0;line-height:16px;color:#313131"><br>
                      <br>                  </td>
				  </tr>
                </tbody></table></td>
                <td width="20">&nbsp;</td>
                     </tr>
            </tbody></table></td>
          </tr>
        </tbody>
       </table>
      </td>
      </tr>
    </tbody>
   </table>
 </td>
 </tr>
 <tr>
        <td width="272" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>
          </p></td>
        <td width="346" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px">You can unsubscribe to this alerts by switching off Notification in Manage Notification link in your login<br>
          </p></td>
      </tr>
</tbody>
</table>
</div>
</body>
		</html>';


			// end of message


			$headers = "From: $from\r\n";

			$headers .= "Content-type: text/html\r\n";
		//mail($to, $subject, $message, $headers);

$params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$to,
'subject'=>$subject,'message'=>$message,'cc'=>$r['email'],'cc2'=>'noreply@recruitinghub.com','send'=>true];
  AsyncMail($params);
  
  //mail to candidate
  
  	$to = $array3['email'];



			$from = "noreply@recruitinghub.com";
            $r=	getAccountManagerDetail($link,$mid);
            $c=	getCandidatesDetail($link,$mid);

			$subject = "Recruiting Hub - Congrats! ".$array3['fname']." submitted for ".$array1['jobtitle']." has been Shortlisted by ".$array1['name']."";



			$message = '<html>
		<body bgcolor="#FFFFFF">
		<div>
<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
  <tbody>
  <tr>
    <td  colspan="2" style="padding:12px 12px 0px 12px">
    	<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
      	<tbody>
	  		<tr>	
            	<td colspan="3" style="padding-left:14px"><div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div></td>
            	
            	<td colspan="3" style="padding-right:12px"><div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/images/Shortlisted.png" alt="www.recruitinghub.com"></a></div></td>
          </tr>
	  <tr>
        <td style="padding:0px 14px"><table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr>
            <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody><tr>
                <td valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                                    <tr>
                                      <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                          <tr>
                                            <td valign="top"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                <tr>
                                                  <td><p><br>
                                                     Dear '.$array3['fname'].',<br>
                                                
                                                    <br>
                                                    
                                                    <p style = "font-size: 14px;
            color: #a02121;">  PLEASE DO NOT REPLY TO THIS EMAIL AS EMAILS ARE NOT MONITORED FOR THIS EMAIL ID. </p>  
        
                                                    Congrats! Your profile <strong>'.$array3['fname'].'</strong> submitted for <strong>'.$array1['jobtitle'].'</strong> role posted by <strong>'.$array1['name'].'</strong> has been <strong>Shortlisted</strong>. <br>
                                                    <br>
                                                    <b>This is an automated email sent by Recruiting Hub to let you know the progress of your candidature in the interview process. The recruiter that submitted your profile is copied in this email who will liase with you for further process.</b></td>
                                                </tr>
                                               
                                                <tr>
                                                  <td><p>Best Regards,<br>
                                                      <a href="https://www.recruitinghub.com" target="_blank">www.recruitinghub.com </a> </p></td>
                                                </tr>
                                            </table></td>
                                            <td width="20"><p>&nbsp;</p></td>
                                          </tr>
                                      </table></td>
                                    </tr>            
                                    <tr>
                    <td>&nbsp;</td>
                  </tr>
                                  
                  <tr>
                    <td style="padding:4px 0 0 0;line-height:16px;color:#313131"><br>
                      <br>                  </td>
				  </tr>
                </tbody></table></td>
                <td width="20">&nbsp;</td>
                     </tr>
            </tbody></table></td>
          </tr>
        </tbody>
       </table>
      </td>
      </tr>
    </tbody>
   </table>
 </td>
 </tr>
 <tr>
        <td width="272" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>
          </p></td>
        <td width="346" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px"><br>
          </p></td>
      </tr>
</tbody>
</table>
</div>
</body>
		</html>';


			// end of message


			$headers = "From: $from\r\n";

			$headers .= "Content-type: text/html\r\n";
		//mail($to, $subject, $message, $headers);

$params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$to,
'subject'=>$subject,'message'=>$message,'cc'=>$array2['email'],'cc2'=>'noreply@recruitinghub.com','send'=>true];
  AsyncMail($params);
  
  
  echo "<script>
alert('Shorlisted Candidate. An email notification has now been sent to the Recruiter');
</script>";

	}

	}	
	}
else
$errormsg="Access denied";	
}
else{
$notification='Please login to access the page';
$_SESSION['notification']=$notification;
header('location: login'); 
exit;
}
?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Employers Hub</title>
    <meta name="application-name" content="Recruiting-hub" />
    <link rel="icon" type="image/favicon.png" href="https://www.recruitinghub.com/images/favicon.png" />
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/fonts/css/font-awesome.min.css" media="screen, projection">
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

         
</head>
<body>

<div class="header-inner">
<div class="header-top">
<div class="logo">
<a class="navbar-brand" href="#"><img src="images/color-logo.png"></a>
<a class="btn btn-primary" href="submit-a-job">
     Helpline number 
</a>
</div>
<ul class="navbar-right">
  <li class="dropdown">
    <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
  <img src="images/user.png" class="img-circle" alt="">     <span class="text"><?php echo $name; ?></span><span class="caret"></span> </a>
    <ul class="dropdown-menu" role="menu"><li><a href="company-profile"><i class="fa fa-user"></i>Agency Profile</a>   </li>
      <li><a href="edit-profile"><i class="fa fa-gears"></i>Your Account</a></li>
       <li><a href="manage-users"><i class="fa fa-users"></i>Manage Users</a></li>
         <li><a href="emanage-notification"><i class="fa fa-bell"></i>Manage Notification</a></li>
      <li class="divider"></li>
      <li> <a href="logout"><i class="fa fa-sign-out"></i>Logout</a></li>
    </ul>
  </li>

</ul>

</div>
</div>
<div class="summary-wrapper">
<div class="col-sm-12 account-summary no-padding">

<div class="col-sm-2 no-padding">
<div class="account-navi">
  <ul class="nav nav-tabs">
  <li><a href="dashboard" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Dashboard</a></li>
  <li><a href="submit-a-job" role="tab"><i class="fa fa-fw fa-plus"></i>Post New Job</a></li>
  <li><a href="requests" role="tab"><i class="fa fa-fw fa-tachometer"></i>Request from Agencies</a></li>

     <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Jobs</a>

   <div class="collapse" id="candidatesDropdownMenu">
   <ul class="nav-sub" style="display: block;">
    <li><a href="submit-a-job" role="tab" ><i class="fa fa-fw fa-plus-square"></i> Post New Job</a>  </li>
   <li><a href="jobs" role="tab" ><i class="fa fa-list"></i> Active</a> </li>
    <li><a href="inactive" role="tab" ><i class="fa fa-list"></i> Inactive</a> </li>
    <li><a href="closed" role="tab" ><i class="fa fa-clock-o"></i> Closed</a>  </li>
    <li><a href="filled" role="tab" > <i class="fa fa-users"></i> Filled</a>  </li>
  
    </ul>
   </div>
   </li>
     <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu1" data-toggle="collapse" aria-controls="candidatesDropdownMenu1" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Candidates (ATS)</a>

   <div class="collapse" id="candidatesDropdownMenu1">
   <ul class="nav-sub" style="display: block;">
   
    <li><a href="all" role="tab" ><i class="fa fa-list"></i> All</a> </li>
    <li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback</a>  </li>
    <li><a href="shortlist" role="tab" ><i class="fa fa-clock-o"></i> Shortlisted</a>  </li>
        <li><a href="offer" role="tab" > <i class="fa fa-trash"></i> Offer</a> </li>
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i> Rejected</a> </li>
    </ul>
   </div>
   </li>
   
     <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging</a>    </li>
     <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Feedback Rating</a> </li>
 <li><a href="psl-list" role="tab" > <i class="fa fa-list"></i> PSL</a> </li>
 <li><a href="company-profile" role="tab" > <i class="fa fa-plus"></i>Company Profile</a> </li>
 <li><a href="add-user" role="tab" > <i class="fa fa-plus"></i>Add Users</a> </li>
     <li><a href="view-all-resource-engagement" role="tab" > <i class="fa fa-database"></i>Request for Your Bench Resources <span class="label label-primary">Free</span></a> </li>
 <li><a href="resources" role="tab" > <i class="fa fa-database"></i>Bench Hiring <span class="label label-primary">Free</span></a> </li>  </ul>
   
</div>
</div>

<div class="col-sm-10">
<div class="account-navi-content">
  <div class="tab-content">

    <section class="main-content-wrapper">
      <div class="pageheader pageheader--buttons">
          <div class="row">
            <div class="col-md-6">
              <h4>Shortlist Update</h4>
            </div>
            <div class="col-md-6">
            <div class="panel-body panel-body--buttons text-right">

              </div>
            </div>
          </div>
        </div>


  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">

          <div class="row">
            <div class="col-md-12 table-responsive">
              <?php if(!$errormsg){ 
			  			if($content){
						echo $content; 
						echo '<br/><a href="new-msg?rid='.$recruiter['recruiterid'].'&jobid='.$array1['jobid'].'&cid='.$candidateid.'" class=""><b>CLICK HERE TO MESSAGE RECRUITER ON NEXT STEPS IN INTERVIEW PROCESS</b></a> <br><br> or <a href="shortlist"><b>GO TO SHORTLISTED FOLDER</b></a>';
						}
					}
			  else echo $errormsg; ?>
    </div>
   </div>
  </div>
   </div>
    </div>
  </div>
</section>
     </div>
     </div>
     </div>
<div class="clearfix"></div>
</div>
</div>
 </body>
</html>
