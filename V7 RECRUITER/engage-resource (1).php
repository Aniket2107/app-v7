<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../Smtp/index.php';
require_once '../config.php';
$mid=$name=$email=$iam='';
$content=$errormsg=$message=$engagereqmsg='';
if(isset($_SESSION['mid'])){
		$mid=$_SESSION['mid'];
		$name=$_SESSION['name'];
		$email=$_SESSION['email'];
		$iam=$_SESSION['iam'];
		$adminrights=$_SESSION['adminrights'];
		$cid=$_SESSION['cid'];
		$admin=$_SESSION['admin'];
		$rcountry=$_SESSION['country'];
if(isset($_GET['resrcid'])&& ($_GET['resrcid']!='')){
$resrcid=$_GET['resrcid'];
$sql=mysqli_fetch_assoc(mysqli_query($link,"select * from resource where id=$resrcid"));	
$sql1=mysqli_query($link,"select * from resource where id=$resrcid");
$countrow=mysqli_num_rows($sql1);
$empidofresource=$sql['emid'];

if($countrow){		
$sql2=mysqli_query($link,"insert into  resourceengagedetails (resourceid,empidofresource,engagedby,type,engagestatus,date)values('$resrcid','$empidofresource','$mid','Recruiter','1',now())");

if($sql2){
$engagereqmsg='<p style = "font-size: 16px;
            color: #21a05e;">Your request for engagement to access further information about this bench resource has been sent successfully to the Employer, please wait until they approve your request so you can contact them directly.</p>';
}
$emp=mysqli_fetch_assoc(mysqli_query($link,"select a.*,b.* from resource a, members b where a.id='$resrcid' and a.emid=b.memberid"));

$echeck=mysqli_fetch_assoc(mysqli_query($link,"select a.name from companyprofile a,members b where a.id=b.companyid and b.memberid='$mid'"));
$agencyname= $echeck['name'];
	
		$to = $emp['email'];
		$from = "noreply@recruitinghub.com";
		$subject = "Recruiting Hub - Bench Resource Engagement Alert for ".$emp['consultant']."";
		$message = '<html>
		<body bgcolor="#FFFFFF">
			<div>
<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
  <tbody>
  <tr>
    <td colspan=2 style="padding:12px 12px 0px 12px">
    <table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
	  <tr>
      <td colspan="3" style="padding-left:14px">
      <div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div>
      </td>
      
      <td colspan="3" style="padding-right:12px">
      <div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/image/Bench Request.png" alt="www.recruitinghub.com"></a></div>
      </td>
      
       </tr>
	  <tr>
        <td style="padding:0px 14px">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
                   <tr>
                    <td style="padding-top:5px;color:#313131"><br>
                   Dear '.$emp['firstname'].',<br>
                      <br>
                      Greetings from <a href="https://www.recruitinghub.com" target="_blank">www.recruitinghub.com </a>
		<p>You have been requested for an engagement for the bench resource "<strong>'.$emp['consultant'].'</strong>" you uploaded on our platform with the Title "<strong>'.$emp['jobtitle'].'</strong>" by "<strong>'.$agencyname.'</strong>" </p>
		<p>Please login to your employer account and go to <b>BENCH HIRING</b> -> <b>"APPROVE REQUEST FOR YOUR BENCH RESOURCES"</b> folder to approve the request so they can get access to your contact info and get in touch with you directly. Login here <a href="https://www.recruitinghub.com/employer/login" target="_blank">Employer Login</a></p>
		<p>Do use our messaging system to interact with the company directly</p>
		<p>Best Regards,</p>
		<P><a href="https://www.recruitinghub.com/">www.recruitinghub.com</a></p>
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
		   <td width="346" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px">You can unsubscribe to this alerts by switching off Notification in Manage Notification link in your login<br>
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
	
	$params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$to,'subject'=>$subject,'message'=>$message,'send'=>true];
	AsyncMail($params);
	}	
	}
	}		
?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Engage Resource | Recruiters Hub</title>
    <meta name="application-name" content="Recruiting-hub" />
     <link rel="icon" type="image/favicon.png" href="https://www.recruitinghub.com/images/favicon.png" />
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">
    <link href="../employer/css/bootstrap.min.css" rel="stylesheet">
    <link href="../employer/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../employer/css/fonts/css/font-awesome.min.css" media="screen, projection">
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../employer/js/bootstrap.min.js"></script>

         
</head>
<body>

<div class="header-inner">
<div class="header-top">
<a class="navbar-brand" href="#"><img src="../employer/images/color-logo.png"></a>
</div>
</div>

<div class="summary-wrapper">
<div class="col-sm-12 account-summary no-padding">

<div class="col-sm-2 no-padding">
<div class="account-navi">
  <ul class="nav nav-tabs">
<h4>Client Section (Business)</h4>
    <li><a href="dashboard" role="tab" ><i class="fa  fa-fw fa-tachometer"></i>Dashboard</a></li>
    <li><a href="https://www.recruitinghub.com/franchiseapply" target=_blank role="tab" > <i class="fa fa-database"></i>Become our Franchise <span class="label label-primary">New</span></a> </li>
    <li><a href="search" role="tab" ><i class="fa fa-fw fa-search"></i>Search Roles</a>    </li>
    <li><a href="job" role="tab"><i class="fa fa-fw fa-files-o"></i>Engaged Roles</a>    </li>
    <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Supply Candidates (STS)</a>

   <div class="collapse" id="candidatesDropdownMenu">
   <ul class="nav-sub" style="display: block;">
    <li><a href="add_new" role="tab" ><i class="fa fa-fw fa-plus-square"></i> Add new</a>  </li>
    <li><a href="all" role="tab" ><i class="fa fa-list"></i> All</a> </li>
    <li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback</a>  </li>
    <li><a href="interview" role="tab" > <i class="fa fa-users"></i> Interviewing</a>  </li>
     <li><a href="offer" role="tab" > <i class="fa fa-users"></i>Offered</a>  </li>
      <li><a href="filled" role="tab" > <i class="fa fa-users"></i>Filled</a>  </li>
     
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i> Rejected</a> </li>
    </ul>
   </div>
   </li>
    <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging </a>    </li>
    <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Feedback Rating</a> </li>
<li><a href="psl-list" role="tab" > <i class="fa fa-list"></i>PSL</a> </li>
<li><a href="company-profile" role="tab" > <i class="fa fa-plus"></i>Agency Profile</a> </li>
<li><a href="add-user" role="tab" > <i class="fa fa-plus"></i>Add Users</a> </li>
<li><a href="hire-resource" role="tab" > <i class="fa fa-database"></i>Bench Hiring <span class="label label-primary">Free</span></a> </li>
    <h4>Jobseeker Section (Jobsite)</h4>

<li><a href="candidate-search" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> CV Search <span class="label label-primary">Free</span></a>    </li>
    <li><a href="post-job" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Post Jobs <span class="label label-primary">Free</span></a>    </li>
    <li><a href="manage-responses" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Manage responses</a>    </li>
    <li><a href="manage-jobs" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Manage Jobs</a>    </li>
  </ul>
</div>


</div>

<div class="col-sm-10">
<div class="account-navi-content">
  <div class="tab-content">

    <section class="main-content-wrapper">
      <div class="pageheader pageheader--buttons">
          <div class="row">
            <div class="col-md-6">
              <h4>Bench Resource Engagement</h4>
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
<?php if($engagereqmsg){ 
			  			
                        echo $engagereqmsg;
						}
						?>
						Click here to Go to -> <a href="hire-resource" id="four"><b>BENCH HIRING</b></a> folder
			  		
          <div class="row">
            <div class="col-md-12 table-responsive">
              
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
