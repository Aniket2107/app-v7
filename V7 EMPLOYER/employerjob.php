    <?php if (session_status() == PHP_SESSION_NONE) {

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



$eligible=0;

$param="";
if(isset($_GET['candidateid'])){
$candidateid=$_GET['candidateid'];
$param="&candidateid=".$candidateid;
}

require_once '../config.php';

if(isset($_SESSION['mark'])){
$highlight=$_SESSION['mark'];
}else{
$highlight='';
}

$replacewith = "hiddentext";
    $job['description'] = preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", $replacewith, $job['description']);
    $job['description'] = preg_replace("/^(\(?\d{3}\)?)?[- .]?(\d{3})[- .]?(\d{4})$/", $replacewith, $job['description']);
    $job['description'] = preg_replace("/^(\(?\d{4}\)?)?[- .]?(\d{3})[- .]?(\d{4})$/", $replacewith, $job['description']);

$paidstatus= $engagedcount=$permonthcount =$subsexpirydate='';

$eligiblecheck=mysqli_fetch_assoc(mysqli_query($link,"select a.paidstatus,a.engagedcount,a.permonthcount,a.subsexpirydate,a.subsdate from companyprofile a,members b where a.id=b.companyid and b.memberid='$mid'"));

$paidstatus= $eligiblecheck['paidstatus'];

$engagedcount= $eligiblecheck['engagedcount'];

$permonthcount= $eligiblecheck['permonthcount'];

$subsexpirydate= $eligiblecheck['subsexpirydate'];

 $today = date("Y-m-d");

if(($paidstatus=="success") && ($today < $subsexpirydate)){

$eligible=1;

}



$job='';

if(isset($_GET['EID']))

$jobid=$_GET['EID'];

$lastlogin=mysqli_num_rows(mysqli_query($link,"select a.lastlogin from members WHERE a.jobid='$jobid' and a.memberid=members.memberid and members.companyid=companyprofile.id and companyprofile.registerid=b.id"));


$jobres = mysqli_query($link,"SELECT a.*,b.website,b.accountmanager,companyprofile.profile as companydescription,b.replacementperiod,b.specialnotes FROM benchjobs a,employers b,companyprofile,members WHERE a.jobid='$jobid' and a.memberid=members.memberid and members.companyid=companyprofile.id and companyprofile.registerid=b.id"); 

$isposted = mysqli_num_rows($jobres);

if($isposted > 0){ 

while($row = mysqli_fetch_array($jobres)){ 

$job=$row;

    }

}

$param="";
$params=$_SERVER['QUERY_STRING'];
if (strpos($params,'page') !== false) {
$key="page";
parse_str($params,$ar);
$param=http_build_query(array_diff_key($ar,array($key=>"")));
}
else
$param=$params;

$isengaged=mysqli_num_rows(mysqli_query($link,"select * from benchrequest where jobid='$jobid' and recruiterid='$mid' and status not in ('Requested','Rejected')"));

$requested=mysqli_num_rows(mysqli_query($link,"select * from benchrequest where jobid='$jobid' and recruiterid='$mid' and status = 'Requested'"));


$total= $pager->total_rows;
$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];

if($job){



?>

<!doctype html>
<html>
<head>
 <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <title>Search Bench Roles | Employers Hub</title>
<meta name="application-name" content="Recruiting-hub" />
 <link rel="icon" type="image/favicon.png" href="https://www.recruitinghub.com/images/favicon.png" />
<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css1/style.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/fonts/css/font-awesome.min.css" media="screen, projection">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

     
</head>
<body>

<div class="header-inner">
<div class="header-top">
<a class="navbar-brand" href="#"><img src="images/color-logo.png"></a>
<ul class="navbar-right">
<li class="dropdown">
<a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
<img src="images/user.png" class="img-circle" alt="">     <span class="text"><?php echo $name; ?></span><span class="caret"></span> </a>
<ul class="dropdown-menu" role="menu"><li><a href="company-profile"><i class="fa fa-user"></i>Agency Profile</a>   </li>
  <li><a href="edit-profile"><i class="fa fa-gears"></i>Your Account</a></li>
  <?php if($admin){
   echo'<li><a href="manage-users"><i class="fa fa-users"></i>Manage Users</a></li>';
/** if($rcountry=='India'){echo'
 <li><a href="subscription_plans"><i class="fa fa-money"></i> Manage Subscription</a></li>';}
 else{echo'
  <li><a href="subscription-plans"><i class="fa fa-money"></i> Manage Subscription</a></li>';
}echo'
 <li><a href="subscription-status"><i class="fa fa-info-circle"></i> Subscription Status</a></li>
 ';**/
}
 ?>
  
  <li><a href="rmanage-notification"><i class="fa fa-bell"></i>Manage Notification</a></li>
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
      <h4>Recruiters Marketplace Section</h4>
  <li><a href="dashboard" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Dashboard</a></li>
  <li><a href="postdashboard" role="tab"><i class="fa  fa-fw fa-plus"></i>Post New Job</a></li>
<!--  <li><a href="requests" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Request from Agencies</a></li>-->

     <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Jobs</a>

   <div class="collapse" id="candidatesDropdownMenu">
   <ul class="nav-sub" style="display: block;">
    <li><a href="postdashboard" role="tab" ><i class="fa fa-fw fa-plus-square"></i> Post New Job</a>  </li>
   <li><a href="jobs" role="tab" ><i class="fa fa-list"></i>Active Jobs</a> </li>
    <li><a href="inactive" role="tab" ><i class="fa fa-list"></i>Inactive Jobs</a> </li>
    <li><a href="closed" role="tab" ><i class="fa fa-clock-o"></i>Closed Jobs</a>  </li>
    <li><a href="filled" role="tab" > <i class="fa fa-users"></i>Filled Jobs</a>  </li>
  
    </ul>
   </div>
   </li>
   
     <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu1" data-toggle="collapse" aria-controls="candidatesDropdownMenu1" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Candidates (ATS)</a>

   <div class="collapse" id="candidatesDropdownMenu1">
   <ul class="nav-sub" style="display: block;">
   
    <li><a href="all" role="tab" ><i class="fa fa-list"></i>All Candidates</a> </li>
    <li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback (<?php echo $submittedcount; ?>)</a>  </li>
    <li><a href="shortlist" role="tab" > <i class="fa fa-users"></i>Shortlisted (<?php echo $submittedcount1; ?>)</a>  </li>
        <li><a href="offer" role="tab" > <i class="fa fa-envelope"></i>Offered (<?php echo $submittedcount2; ?>)</a> </li>
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i>Rejected (<?php echo $submittedcount3; ?>)</a> </li>
    <li><a href="filledcandidates" role="tab" > <i class="fa fa-users"></i>Filled (<?php echo $submittedcount4; ?>)</a> </li>
    </ul>
   </div>
   </li>
   
   <li><?php 
	   if($ecountry=='India'){echo'
	   <li><a href="rec-rec-india"><i class="fa fa-money"></i> Recruiter-On-Demand <span class="label label-primary">New</span></a></li>';}
	   elseif($ecountry=='United Kingdom (UK)'){echo'
	    <li><a href="rec-rec"><i class="fa fa-money"></i> Recruiter-On-Demand <span class="label label-primary">New</span></a></li>';}
	    elseif($ecountry=='United States Of America (US)'){echo'
	    <li><a href="rec-rec-us"><i class="fa fa-money"></i> Recruiter-On-Demand <span class="label label-primary">New</span></a></li>';}
	    else{echo'
	    <li><a href="rec-rec"><i class="fa fa-money"></i> Recruiter-On-Demand <span class="label label-primary">New</span></a></li>';}
	    
	    echo'
	   ';
	   ?></li>
   
     <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging (<span class="label-primary"><?php echo $new; ?></span>)</a>    </li>
     
     
     <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu2" data-toggle="collapse" aria-controls="candidatesDropdownMenu2" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i>Rating/PSL/Block</a>

   <div class="collapse" id="candidatesDropdownMenu2">
   <ul class="nav-sub" style="display: block;">
   
   <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Rating/PSL/Block</a> </li>
   <li><a href="psl-list" role="tab" > <i class="fa fa-list"></i>PSL List</a> </li>
    <li><a href="block-list" role="tab" > <i class="fa fa-list"></i>Block List</a> </li>
    </ul>
   </div>
   </li>
   
   <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu3" data-toggle="collapse" aria-controls="candidatesDropdownMenu3" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i>Company Settings</a>

   <div class="collapse" id="candidatesDropdownMenu3">
   <ul class="nav-sub" style="display: block;">
   
   <li><a href="company-profile" role="tab" > <i class="fa fa-plus"></i>Company Profile</a> </li>
   <li><a href="edit-profile" role="tab" > <i class="fa fa-plus"></i>Your Profile</a> </li>
<li><a href="add-user" role="tab" > <i class="fa fa-plus"></i>Add Users</a> </li>
<li><a href="emanage-notification" role="tab" > <i class="fa fa-plus"></i>Notifications</a> </li>
    </ul>
   </div>
   </li>
   
   <h4>Bench Hiring Exchange <span class="label label-primary">New</span></h4>
   
   <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu4" data-toggle="collapse" aria-controls="candidatesDropdownMenu4" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i>YOUR BENCH JOBS </a>

   <div class="collapse" id="candidatesDropdownMenu4">
   <ul class="nav-sub" style="display: block;">
       
    <li><a href="post-benchjob" role="tab" > <i class="fa fa-fw fa-plus-square"></i>Post Bench Job </a> </li>
    
    <li><a href="benchjobs" role="tab" > <i class="fa fa-list"></i>Manage Bench Jobs </a> </li>
    
    <li><a href="benchall" role="tab" > <i class="fa fa-database"></i>Manage Submissions Received</a> </li>
    
    </ul>
   </div>
   </li>
    
    <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu5" data-toggle="collapse" aria-controls="candidatesDropdownMenu5" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i>OTHER BENCH JOBS </a>

   <div class="collapse" id="candidatesDropdownMenu5">
   <ul class="nav-sub" style="display: block;">
    
    
    
     <li><a href="searchbenchjobs" role="tab" > <i class="fa fa-search"></i>Search Bench Jobs </a> </li>
       
       <li><a href="engagedbenchjob" role="tab" > <i class="fa fa-user"></i>Engaged Bench Jobs </a> </li>
       
       
        <li><a href="add_new" role="tab" > <i class="fa fa-plus"></i>Add Resource </a> </li>
        
        <li><a href="bench_all" role="tab" > <i class="fa fa-envelope"></i>Manage Submissions Made</a> </li>
        
    </ul>
   </div>
   </li>
       
       <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu7" data-toggle="collapse" aria-controls="candidatesDropdownMenu7" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i>BENCH DATABASE </a>

   <div class="collapse" id="candidatesDropdownMenu7">
   <ul class="nav-sub" style="display: block;">
       
        <li><a href="search-resources" role="tab" > <i class="fa fa-search"></i>Search Bench Resources from Others </a> </li>  
   
   <li><a href="resources" role="tab" > <i class="fa fa-upload"></i>Upload Your Bench Resources </a> </li>
    
   <li><a href="view-resources" role="tab" > <i class="fa fa-eye"></i>View Your Bench Resources </a> </li>  
  
  <li><a href="view-all-resource-engagement" role="tab" > <i class="fa fa-reply"></i>Approve Request</a> </li> 
     
    </ul>
   </div>
   </li>
   
    
    <li> <a href="logout"><i class="fa fa-sign-out"></i>Logout</a></li>
     

    
    </ul>
   
</div>
</div>



<div class="col-sm-10" id="paragraph">
    
<header class="panel-heading panel-heading--buttons wht-bg">
          <h4 class="gen-case"><a href="searchbenchjobs"><< Go Back</a></h4>
  </header>

<div class="panel panel-default">
      <header class="panel-heading wht-bg ui-sortable-handle">
    <h3 class="panel-title"><b><?php echo $job['jobtitle']; ?></b> | Job ID - <?php echo $job['jobid']; ?> <i class="fa fa-map-marker"></i> <b><?php echo $job['joblocation']; ?>,<?php echo $job['country']; ?></b> | <i class="fa fa-send"></i> 1st Posted: <?php echo date("F j, Y",strtotime($job['postdate']));  ?> <i class="fa fa-sort"></i> Last Updated: <b><?php echo date("F j, Y",strtotime($job['updatedate']));  ?></b> | <i class="fa fa-user"></i> <b><?php echo $job['novacancies'];?></b> Vacancy <br>
  </header>
  
  
  
<div id="job_title" data-value="<b><?php echo $job['jobtitle'];?></b> | Job ID: <b><?php echo $job['jobid'];?></b> | Job Status: <b><?php echo $job['status'];?></b> | 1st Posted: <?php echo $job['postdate'];?> | Last Updated: <b><?php echo $job['updatedate'];?></b>"></div>


<table class="table table-striped">

<thead></thead>

<tbody>
  

 <tr>

<td>
<?php if(!$isengaged) 
if(in_array($job['jobsector'],$mysector))
        echo '<a title="Engage" class="btn btn-default" href="engagebenchjob?jobid='.$row['jobid'].'&employerid='.$job['memberid'].'">Engage</a>';
        else
        echo '<a title="Engage" class="btn btn-default" href="engagebenchjob?jobid='.$job['jobid'].'&employerid='.$job['memberid'].'">Engage</a>';
?>

</td>
</tr>

<?php //} ?>

  
 <!-- <?php if($job['description1']){ ?>
<tr>
<td><b>Job Description (uploaded as file)</b></td>
<td><b><a href="../employer/jobdescription/<?php echo $job['memberid'] ?>/<?php echo $job['jobid'] ?>/<?php echo $job['description1']; ?>" target="_blank"><?php echo $job['description1']; ?></b></a>
</td>
</tr>    
<?php } ?>
-->

<tr>

  <td>Client Name:</td>

  <td>Client Details will become available to you once you hit the Engage Button above </td>

</tr>

<tr>

  <td>Best Practices:</td>

  <td><a href="bestpractices-recruiter" target="_blank"><b>BEST PRACTICES (Read this before working on any requirement)</b></a> </td>

</tr>

<tr>

<tr>

  <td>Job Sector:</td>

  <td><?php echo $job['jobsector'];?> </td>

</tr>

<tr>

  <td>Interviewer / Hiring Manager Comments:</td>

  <td><p style = 'font-size: 16px;
            color: #a02121;'><b><?php echo $job['interviewcomments'];?></b></p></td>

  </tr>
  
   

<tr>

  <td>Job Type:</td>

  <td><b><?php echo ucwords($job['jobtype']);?></b> </td>

</tr>

<tr>

  <td>Working:</td>

  <td><?php echo ucwords($job['working']);?> </td>

</tr>

<tr>

  <td>Experience:</td>

  <td><?php echo $job['minex'];?> - <?php echo $job['maxex'];?> Years</td>

</tr>

<tr>
<?php if(($job['country']=='UK') && ($job['jobtype']=='Contract')) { 

  echo'<td>End Rate to RH from Client</td>'; }elseif(($job['country']=='US') && (($job['jobtype']=='Contract')||($job['jobtype']=='Corp-To-Corp'))) { echo '<td>End Rate</td>'; }else{ echo '<td>Candidate Salary Range / End Rate</td>';  } ?>

  <td> <?php if(($job['country']=='India')&&($job['jobtype']=='Contract')){  if($job['minlakh']) echo $job['minlakh']; else echo '0';echo '-';if($job['maxlakh']) echo $job['maxlakh'];else echo '0';   if($job['currency']=='GBP')echo '&pound;';elseif($job['currency']=='USD') echo '$'; else echo $job['currency'];     } elseif($job['country']=='India'){echo'Rs. ';if($job['minlakh']) echo $job['minlakh'].',';  if($job['minthousand']==0) echo '00,'; else echo $job['minthousand'].','; echo '000'; echo' - '; if($job['maxlakh']) echo $job['maxlakh'].',';  if($job['maxthousand']==0) echo '00,'; else echo $job['maxthousand'].','; echo '000';}else{ if($job['minlakh']) echo $job['minlakh']; else echo '0';echo '-';if($job['maxlakh']) echo $job['maxlakh'];else echo '0';   if($job['currency']=='GBP')echo '&pound;';elseif($job['currency']=='USD') echo '$';else echo $job['currency'];    }?><?php if($job['ratetype']) echo '/'.$job['ratetype']; else echo ''; ?> </td>

</tr>	

   
<?php if((($job['country']!='UK') && ($job['jobtype']!='Contract')) &&(($job['country']!='US') && ($job['jobtype']!='Contract')) &&(($job['country']!='US') && ($job['jobtype']!='Corp-To-Corp'))) { ?>

<tr>
  <td><b>Placement Fee:</b></td>

  <td>

  <b><?php if($job['fee']){ ?>  <?php echo $job['fee'];?> <?php } else { ?> (<?php  echo $job['currency'] ?> / ) <?php echo $job['rfee']; }?><?php if($job['ratetype']) echo '/'.$job['ratetype']; else echo ''; ?> %</b> of the Candidate's Offered Annual Base Salary (ABS/CTC) as our one time placement fee.

  </td>

</tr><?php  } ?>

<tr>

<tr>

  <td><b>What you will earn from the fee?</b></td>

  <td>Please read <b>"Point.9"</b> from this link -> <a href="https://recruitinghub.com/forrecruiters" target="_blank"><b>Recruiter FAQ's</b></a></td>

</tr>

<tr>

  <td>When will i get paid my fee?</td>

  <td><?php echo $job['replacementperiod'];?></td>

  </tr>
  
  <tr>

      <td><b>Want to manage this Client?</b></td>

      <td><a href="becomefranchise" target="_blank"><b>Become our Franchise Partner</b></a></td>

      </tr>
  
 <!--  <tr>

  <td>Currency:</td>

  <td><?php if($job['currency']=='GBP') { echo '&pound'; } elseif($job['currency']=='USD'){ echo '$';} else { echo $job['currency']; } ?> </td>

</tr>-->
<?php //if( (($job['minex']=='0')&&($job['maxex']=='2'))||(($job['minex']=='1')&&($job['maxex']=='2'))||(($job['minex']=='0')&&($job['maxex']=='1')) && ($job['country']=='India')){ ?>

<!--    <tr>

    <td><b>RH Account Manager</b>:</td>

    <td><?php echo $job['accountmanager'];?>

    </td>

  </tr> -->

<tr>

    <td>Who should i contact regarding this role?</td>

    <td>Keeping it between you (Vendor) and Employer (Client) with no more need for a middle man, you can now "Message Employer" directly after clicking Engage button for clarification (if any) about this role. Click <b>"ADD NOTES"</b> after submitting your candidate to follow up for feedback. An email notification will automatically be sent to the registered email id of the client copying the Account Manager of this client.

    </td>

  </tr>


<!--<tr>

  <td>Reason for Vacancy:</td>

  <td><?php echo $job['vacancyreason'];?></td>

</tr>-->



<!--<tr>

  <td>Education:</td>

  <td><?php echo $job['degree'];?></td>

</tr>-->

<!--<tr>

  <td>IR35:</td>

  <td><?php echo $job['ir35'];?></td>

</tr> -->


<!--<tr>

  <td>Predicted time for CV feedback:</td>

  <td><?php echo $job['feedback'];?></td>

</tr>-->



<!--<tr>

  <td>Key Skills:</td>

  <td><?php echo $job['keyskills'];?></td>

  </tr>-->



<tr>

  <td>Notice Period (How Soon Client Wants Candidate to Join):</td>

  <td><?php echo $job['notice'];?></td>

  </tr>
  
  <tr>

  <td>No of Vacancies:</td>

  <td><?php echo $job['novacancies'];?> Vacancy</td>

  </tr>
  

  
  <tr>

  <td>CV limit:<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="No of CV's you can submit"><i class="fa fa-question-circle"></i>
    </span></td>

  <td><?php echo $job['cvlimit'];?> CV's per Agency</td>

  </tr>

  <tr>

  <td>Agency Limit:<span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="No of Agencies Engaged Vs No of Agencies allowed to work on this role"><i class="fa fa-question-circle"></i>
    </span></td>

  <td><?php echo $job['agencycount'].'/'.$job['agencylimit'];?> Agencies Allowed to Work on this Role</td>

</tr>

<tr>

  <td>Special Notes about the Client (if any):</td>

  <td><p style = 'font-size: 14px;
            color: #a02121;'><b><?php echo $job['specialnotes'];?></b></p></td>

  </tr>

<?php //} ?>
  
<!--  <?php if($job['description1']){ ?>
<tr>
<td><b>Job Description (uploaded as file)</b></td>
<td><b><a href="../employer/jobdescription/<?php echo $job['memberid'] ?>/<?php echo $job['jobid'] ?>/<?php echo $job['description1']; ?>" target="_blank"><?php echo $job['description1']; ?></b></a>
</td>
</tr>    
<?php } ?> -->
  

  <!--<tr>

  <td>CV Submission Closing Date:</td>

  <td><?php echo $job['closingdate'];?></td>

  </tr>-->
  
  <!--<tr>

  <td>Stages of Interview Process:</td>

  <td><?php echo $job['interviewstages'];?> stages</td>

</tr>-->
  

  
  
  
  

</tbody>

</table>



<hr>

<!--<?php if($highlight!='') { ?>
<input type="hidden" id="searchandmark" value="<?php echo $highlight; ?>">
<?php } ?> -->
    
<b>Job Description:</b>  <p><textarea rows="30" cols="80" class="form-control" readonly><?php echo $job['description'] ?></textarea></p>



 <!-- <?php if($job['description1']){ ?>
<tr>
<td><b>Download Job Description:</b></td>
<td><b><a href="../employer/jobdescription/<?php echo $job['memberid'] ?>/<?php echo $job['jobid'] ?>/<?php echo $job['description1']; ?>" target="_blank"><?php echo $job['description1']; ?></b></a>
</td>
</tr>     -->

<br>

<tr>

  <td><b>Client Name</b>:</td>

  <td>Client Details will become available to you once you hit the Engage Button Below</td>

</tr>

<br><br>

<tr>
<td>
<?php if(!$isengaged) 
if(in_array($job['jobsector'],$mysector))
        echo '<a title="Engage" class="btn btn-default" href="engagebenchjob?jobid='.$row['jobid'].'&employerid='.$job['memberid'].'">Engage</a>';
        else
        echo '<a title="Engage" class="btn btn-default" href="engagebenchjob?jobid='.$job['jobid'].'&employerid='.$job['memberid'].'">Engage</a>';
?>

</td>
</tr>

<?php } ?>
  

  <tr>
      
 
<hr>

<tr>
<td>


</div>
</td>
</tr>

<tr>


</tr>

<hr>


</div>
<div class="clearfix"></div>
</div>


<?php }



?>

<script>
$('.confirmation').on('click', function () {
        return confirm('Are you sure you want to dis-engage from this role as it cannot be re-engaged by you again?');
    });
    </script>
    
    
    
    <script>
/**$(document).ready(function(){

if($('#searchandmark').val().length !== 0){

       $('#paragraph').each(function(){
	   
       $(this).html($(this).html().replace($('#searchandmark').val(),"<span class = 'highlight'>"+$('#searchandmark').val()+"</span>"));
    });
	
  }});**/
$(document).ready(function(){
var src_str = $("#paragraph").html();
var term = $("#searchandmark").val();
term = term.replace(/(\s+)/,"(<[^>]+>)*$1(<[^>]+>)*");
var pattern = new RegExp("("+term+")", "gi");

src_str = src_str.replace(pattern, "<mark style='background-color:yellow;'>$1</mark>");
src_str = src_str.replace(/(<mark>[^<>]*)((<[^>]+>)+)([^<>]*<\/mark>)/,"$1</mark>$2<mark>$4");

$("#paragraph").html(src_str);

});
</script>

</body>

</html>