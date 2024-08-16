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

require_once '../config.php';
require '../Smtp/index.php';
require '../helpers/general.php';
$checks=array();
$pstatus=array();
if(isset($_GET['candidateid'])|| isset($_POST['allcheck'])){

	if(isset( $_POST['allcheck'])){
	
		$checks=$_POST['allcheck'];
		}
	else
	{
		$candidateid=$_GET['candidateid'];
		array_push($checks,$candidateid);
	}

	if(!empty($checks)){
	foreach($checks as $value) {
	$split=explode(',',$value);
	$candidateid=$split[0];
	$jobid=$split[1];
	$res=mysqli_query($link,"select a.candidateid,a.status,a.recruiterid,b.jobtitle,a.jobid from submitted_candidates a,jobs b WHERE a.candidateid='$candidateid' and a.jobid=b.jobid and b.memberid='$mid' and a.jobid=$jobid");
	
	$row=mysqli_fetch_assoc($res);
	$pstatus[]=$row;
		}
		
				}
				

}		
elseif(isset($_POST['submit'])){

    $allcheck=$_POST['allchecks'];
	$comment=htmlspecialchars($_POST['reason'],ENT_QUOTES);
	$prestatus=$_POST['status'];
	$fetchid=$_POST['recrid'];
	$jtitle=$_POST['jtitle'];
	$jid=$_POST['jid'];
	$i=0;	
	if(!empty($allcheck)){
	foreach($allcheck as $value) {
	$candidateid=$value;
	$prestatuscurrent=$prestatus[$i];
	foreach($fetchid as $valuefetch){
	foreach($jid as $valuejid){
		$fetchjid=$valuejid;
		if($prestatus[$i]=='Awaiting Feedback'){
	$statusres='CV Rejected';
	}elseif($prestatus[$i]=='Shortlisted'){
	$statusres='Interview Rejected';
	}
	elseif($prestatus[$i]=='Offered'){
	$statusres='Offer Rejected';
	}

	mysqli_query($link,"Update jobs INNER JOIN submitted_candidates ON submitted_candidates.jobid = jobs.jobid set submitted_candidates.status='Rejected', submitted_candidates.comment='$comment',submitted_candidates.prestatus='$prestatuscurrent' WHERE submitted_candidates.candidateid='$candidateid' and jobs.memberid='$mid' and submitted_candidates.jobid='$fetchjid'");
	
	
	if(mysqli_affected_rows($link)>0){
			
			$fetchemail=mysqli_fetch_assoc(mysqli_query($link,"select email from members where memberid='".$fetchid[$i]."'"));
			$fetchname=mysqli_fetch_assoc(mysqli_query($link,"select firstname from members where memberid='".$fetchid[$i]."'"));
			$namesql1=mysqli_query($link,"select fname from candidates where id='$candidateid'");
	$namerow1=mysqli_fetch_assoc($namesql1);
	$fetchempname=mysqli_fetch_assoc(mysqli_query($link,"select a.name from companyprofile a,members b where b.memberid='".$mid."' and a.id=b.companyid"));
			foreach($jtitle as $valuejtitle){
			$fetchjtitle=$valuejtitle;
			}

		$r=	getAccountManagerDetail($link,$mid);	
		$to =$fetchemail['email'] ;
		
	
		$from = "noreply@recruitinghub.com";
		$subject = "Recruiting Hub - ".$namerow1['fname']." has been ".$statusres." for ".$fetchjtitle."";
		$message = '<html>
		<body bgcolor="#FFFFFF">
			<div>
<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
  <tbody>
  <tr>
    <td colspan="2" style="padding:12px 12px 0px 12px">
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
                    Dear '.$fetchname['firstname'].',
                      <p>Greetings from <a href="https://www.recruitinghub.com/">www.recruitinghub.com</a></p>
					  <p>Your profile <strong>'.$namerow1['fname'].'</strong> submitted for <strong>'.$fetchjtitle.'</strong> for <strong>'.$fetchempname['name'].'</strong> has been <strong>'.$statusres.'</strong> for reason - <strong>'.$comment.'</strong></p>
					  <p>Please use our messaging system to get in touch with the Client directly for clarity.</p>
					  
					  <p>Please login to your account and upload quality profiles for the engaged job.</p>
		
		
		<p>Best Regards,</p>
		<p><a href="https://www.recruitinghub.com/">www.recruitinghub.com</a></p>
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
        <td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024<br>
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
		//mail($to, $subject, $message, $headers);
		
		  $params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$to,
'subject'=>$subject,'message'=>$message,'cc'=>$r['email'],'send'=>true];
  AsyncMail($params);
	
			/** header('location: awaiting-feedback');**/
			
			//  header('location:offer.php');
			$i++;}
			else
			$content="Unable to reject. Please contact the service provider.";
		} 
		}
		}
		}  
		
					  header('location: awaiting-feedback.php');

}
else
$errormsg="Access denied";	
}

?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reject All Candidates | Employers Hub</title>
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
     Helpline number +91 7810022022
</a>
</div>
<ul class="navbar-right">
  <li class="dropdown">
    <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
  <img src="images/user.png" class="img-circle" alt="">     <span class="text"><?php echo $name; ?></span><span class="caret"></span> </a>
    <ul class="dropdown-menu" role="menu"><li><a href="company-profile"><i class="fa fa-user"></i>Company Profile</a>   </li>
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
    <li><a href="shortlist" role="tab" > <i class="fa fa-users"></i> Shortlisted</a>  </li>
        <li><a href="offer" role="tab" > <i class="fa fa-trash"></i> Offer</a> </li>
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i> Rejected</a> </li>
    </ul>
   </div>
   </li>
   
     <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging</a>    </li>
     <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Feedback Rating</a> </li>
      <li><a href="psl" role="tab" > <i class="fa fa-list"></i>PSL</a> </li>
      <li><a href="company-profile" role="tab" > <i class="fa fa-plus"></i>Company Profile</a> </li>
     <li><a href="add-user" role="tab" > <i class="fa fa-plus"></i>Add Users</a> </li>
      <li><a href="view-all-resource-engagement" role="tab" > <i class="fa fa-database"></i>Request for Your Bench Resources <span class="label label-primary">Free</span></a> </li>
    <li><a href="resources" role="tab" > <i class="fa fa-database"></i>Bench Hiring <span class="label label-primary">Free</span></a> </li> </ul>
   
</div>
</div>

<div class="col-sm-10">
<div class="account-navi-content">
  <div class="tab-content">

    <section class="main-content-wrapper">
      <div class="pageheader pageheader--buttons">
          <div class="row">
            <div class="col-md-6">
              <h4>Reason for Rejection</h4>
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
			  			if($content)
							echo $content;
						else{ ?>
                            <form action="reject-candidate-allcheck" method="post">
                            	<input type="text" name="reason">
                                  <?php  foreach($pstatus as $value)
                                    {
                                      echo '<input type="hidden" name="allchecks[]" value="'. $value['candidateid']. '">
									        <input type="hidden" name="status[]" value="'. $value['status']. '">
											<input type="hidden" name="recrid[]" value="'. $value['recruiterid']. '">
											<input type="hidden" name="jtitle[]" value="'. $value['jobtitle']. '">
											<input type="hidden" name="jid[]" value="'. $value['jobid']. '">';
                                    }?>
                                <input type="submit"  name="submit" value="Submit">                             
                            </form>
                        <?php }
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
