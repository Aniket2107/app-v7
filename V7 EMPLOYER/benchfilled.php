<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$email=$iam=$candidatemsg='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$iam=$_SESSION['iam'];
$adminrights=$_SESSION['adminrights'];
$cid=$_SESSION['cid'];
$admin=$_SESSION['admin'];
$rcountry=$_SESSION['country'];
}
else{
$notification='Please login to access the page';
$_SESSION['notification']=$notification;
header('location: login'); 
exit;
}
require_once '../config.php';
			
$candidatearray=array();
//jobs posted recently
$content='';
$employerres=$jobtitleres=$candres='';
if(isset($_GET['submit'])){
if(isset($_GET['employer']) && ($_GET['employer']!='')){
$employer=$_GET['employer'];
$param='employer='.$employer;
$employerres="and d.name = '$employer'";
}
if(isset($_GET['jobtitle']) && ($_GET['jobtitle']!='')){
$jobtitle=$_GET['jobtitle'];
$param='jobtitle='.$jobtitle;
$jobtitleres="and a.jobtitle like '%$jobtitle%'";
}
if(isset($_GET['candidate']) && ($_GET['candidate']!='')){
$candidate=$_GET['candidate'];
$param='candidate='.$candidate;
$candres="and b.fname = '$candidate'";
}
}

/******if(isset($_POST['jobtitle']) && ($_POST['jobtitle']!='')  && isset($_POST['employer']) && ($_POST['employer']!='')){
	$jobtitle=$_POST['jobtitle'];
	$employer=$_POST['employer'];
	$candidateres = mysqli_query($link,"
	SELECT 
		a.jobid,a.jobtitle as jobtitle,	a.memberid,a.fee, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentjobtitle,c.status as candidatestatus,c.viewnotes,c.submitdate,c.candidateid as candidateid,d.name
	FROM 
		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 
	WHERE 
		a.jobid=c.jobid and b.id=c.candidateid and c.status='Filled' and a.jobtitle='$jobtitle' and e.memberid=a.memberid and 
		d.id=e.companyid and d.name = '$employer' and c.recruiterid='$mid' 
	ORDER BY 
		submitdate desc
		"); 
	}
elseif(isset($_POST['jobtitle']) && ($_POST['jobtitle']=='')  && isset($_POST['employer']) && ($_POST['employer']!='')){
	$employer=$_POST['employer'];
	$candidateres = mysqli_query($link,"
	SELECT 
		a.jobid,a.jobtitle as jobtitle,	a.memberid,a.fee, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentjobtitle,c.status as candidatestatus, c.viewnotes, c.submitdate,c.candidateid as candidateid, d.name
	FROM 
		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 
	WHERE 
		a.jobid=c.jobid and b.id=c.candidateid and c.status='Filled' and e.memberid=a.memberid and 
		d.id=e.companyid and d.name = '$employer' and c.recruiterid='$mid' 
	ORDER BY 
		submitdate desc
		"); 
	}
elseif(isset($_POST['jobtitle']) && ($_POST['jobtitle']!='')  && isset($_POST['employer']) && ($_POST['employer']=='')){
	$jobtitle=$_POST['jobtitle'];
	$candidateres = mysqli_query($link,"
	SELECT 
		a.jobid,a.jobtitle as jobtitle,	a.memberid,a.fee, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentjobtitle,c.status as candidatestatus,
		c.viewnotes,c.submitdate,c.candidateid as candidateid,d.name
	FROM 
		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e
	WHERE 
		a.jobid=c.jobid and b.id=c.candidateid and c.status='Filled' and a.jobtitle='$jobtitle'  and e.memberid=a.memberid and 
		d.id=e.companyid and c.recruiterid='$mid' 
	ORDER BY 
		submitdate desc
		"); 
	}
	else{
	$candidateres = mysqli_query($link,"
	SELECT 
		a.jobid,a.jobtitle as jobtitle,	a.memberid,a.fee, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentjobtitle,c.status as candidatestatus,
		c.viewnotes,c.submitdate,c.candidateid as candidateid,d.name
	FROM 
		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 
	WHERE 
		a.jobid=c.jobid and b.id=c.candidateid and c.status='Filled' and e.memberid=a.memberid and 
		d.id=e.companyid  and c.recruiterid='$mid' 
	ORDER BY 
		submitdate desc
		"); 
	}*******/
//$candidateres = mysqli_query($link,"	SELECT a.jobid,a.jobtitle as jobtitle, a.memberid,a.fee, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentjobtitle,c.status as candidatestatus, c.viewnotes,c.submitdate,c.candidateid as candidateid,d.name FROM submitted_candidates c, jobs a, candidates b, companyprofile d, members e,request f WHERE a.jobid=c.jobid and b.id=c.candidateid and c.status='Filled' and e.memberid=a.memberid and d.id=e.companyid and c.recruiterid='$mid' and c.jobid=f.jobid and c.recruiterid=f.recruiterid and f.filledcount > 0 ORDER BY submitdate desc ");
$sql = "
	SELECT 
		a.jobid,a.jobtype,f.firstname as subuser,f.email as subuseremail,a.jobtitle as jobtitle,	a.memberid,a.fee, b.id, b.fname as fname, b.contactnumber,b.billable as billable,b.net as net,b.agencyshare as agencyshare,b.paymentadv as paymentadv,b.notes as notes,b.expectedcurrency as expectedcurrency,b.doj as doj,b.paymentdate as paymentdate,b.cv as cv,b.desiredsalary,b.currentjobtitle,c.status as candidatestatus,
		c.viewnotes,c.submitdate,c.candidateid as candidateid,d.name
	FROM 
		submitted_benchcandidates c,	benchjobs a,	benchcandidates b, companyprofile d, members e, members f
	WHERE 
		a.jobid=c.jobid and b.id=c.candidateid and c.status='Filled' and e.memberid=a.memberid and d.id=e.companyid  and f.companyid='$cid' and c.recruiterid=f.memberid and submitdate>=CURDATE()-INTERVAL 12 MONTH $employerres $jobtitleres $candres
	ORDER BY 
		doj desc
		"; 
	
$param="";
$params=$_SERVER['QUERY_STRING'];
if (strpos($params,'page') !== false) {
    $key="page";
	parse_str($params,$ar);
	$param=http_build_query(array_diff_key($ar,array($key=>"")));
}
else
$param=$params;
include('ps_pagination.php');
$pager = new PS_Pagination($link, $sql, 20, 10, $param);

$candidateres = $pager->paginate();

if(@mysqli_num_rows($candidateres)){ 
    while($row = mysqli_fetch_array($candidateres)){ 
	$candidatearray[]=$row;
				}
				
	$pages =  $pager->renderFullNav();
	$total= $pager->total_rows;
	$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];
}
else
$candidatemsg="<p style='
            font-size: 14px;
            color: #a02121;
        '>No Filled Candidates yet</p>";
?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Bench Filled | Employers Hub</title>
    <meta name="application-name" content="Recruiting-hub" />
     <link rel="icon" type="image/favicon.png" href="https://www.recruitinghub.com/images/favicon.png" />
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css1/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.custom.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/fonts/css/font-awesome.min.css" media="screen, projection">
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
         
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

<div class="col-sm-10">
<div class="account-navi-content">
  <div class="tab-content">
 
    
    <section class="main-content-wrapper">
        <div class="pageheader pageheader--buttons">
          
        </div>

  <div class="row">
    <div class="col-xs-12">
      <a class="btn btn-primary" href="add_new">
    <i class="fa fa-plus"></i> Add New Candidate
</a> <a class="btn btn-primary" href="https://www.recruitinghub.com/bankdetails" target="_blank">
    <i class="fa fa-bank"></i> RH Company Details</a> 
    <a class="btn btn-primary" href="https://recruitinghub.com/Agency Name - Candidate Name - Recruiting Hub Invoice.xlsx" target="_blank">
    <i class="fa fa-money"></i> Download Invoice Format</a> 
    <a class="btn btn-primary" href="https://recruitinghub.com/Invoicing Procedure.pdf" target="_blank">
    <i class="fa fa-search-plus"></i> Invoicing Procedure</a>
    <a class="btn btn-primary" href="edit-company">
    <i class="fa fa-dollar"></i> <i class="fa fa-gbp"></i> <i class="fa fa-inr"></i> <i class="fa fa-euro"></i> Update Your Bank Details so we can pay you</a>
    
      <div class="panel panel-default">
       <header class="panel-heading wht-bg ui-sortable-handle">
    <h3 class="panel-title">Filled Candidates
  </header>
  
  <div class="panel-body">
        <div class="text-left">
 Go to -> <a href="add_new" id="one">ADD NEW CANDIDATE</a> -> <a href="bench_all" id="two"><i class="fa fa-list"></i> ALL</a> -> <a href="benchawaiting-feedback" id="three"><i class="fa fa-clock-o"></i> AWAITING FEEDBACK</a> -> <a href="benchinterview" id="four"><i class="fa fa-user"></i> SHORTLISTED</a> -> <a href="benchoffer" id="five"><i class="fa fa-download"></i> OFFERED</a> -> <a href="benchrejected" id="six"><i class="fa fa-trash"></i> REJECTED</a> -> <strong><a href="benchfilled" id="seven"><i class="fa fa-money"></i> FILLED</a></strong> 
</div>

        <div class="panel-body">
        <div class="text-right">
 <a class="btn btn-primary" href="filled-download<?php if($param)
 echo'?'.$param; ?>">
   <i class="fa fa-file-excel-o" ></i> Download in Excel
</a>
</div>
<div class="table-responsive">

  
  <div class="col-sm-12">
 <form method="get" action="filled">
       <div class="form-group">
        <br>
        <!-- <label>Search Candidates</label><br><br> -->
        <div class="col-sm-3">
        	<input name="jobtitle" class="form-control ui-autocomplete-input"  placeholder="Search by Job" autocomplete="off" type="text">
        </div>
        <div class="col-sm-3">
                                            <input name="employer" class="form-control ui-autocomplete-input" id="employer" placeholder="Search by Employer" autocomplete="off" type="text">
        </div> 
        <div class="col-sm-3">
                                            <input name="candidate" class="form-control ui-autocomplete-input" id="candidate" placeholder="Search by Candidate" autocomplete="off" type="text">
        </div> 
        <div class="col-sm-3">
        <div class="form-group">
                                            <input value="Search" class="btn btn-primary" name="submit" type="submit">
                                             </div>
        </div>
        </div>  
        </form>                                          
        </div>
      <h3>Total Filled in last one year: <?php echo $total; ?></h3>
    <?php if(!$candidatemsg){ ?>
   
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Candidate Name / ID</th>
                  <th>Job Title/ID/Type</th>
                  <?php if($adminrights)
                  echo'<th>Recruiter</th>';
				  ?>
                  <th>Client</th>
                  <th>DOJ <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Date of Candidate Joining the Employer"><i class="fa fa-question-circle"></i>
    </span></th>
                  <th>Payment Due By</th>
                  <th>Billable <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Candidate's Offer Amount or Billable Components of the Offer Amount"><i class="fa fa-question-circle"></i>
    </span></th>
                  <th>Advertised % / Rate</th>
                  <!--<th>Total Share</th>-->
                  <th>Agency Share</th>
                  <th>Paid</th>
                  <th>Notes</th>
                  <th>Status</th>
                </tr>
              </thead>
              
              
              <tbody>
                <?php
	    
	    foreach($candidatearray as $row){
			echo'
			
          <tr>
		  
  <td><b><a class="title" href="#" data-toggle="modal" data-target="#candidate-modal" id='.$row['id'].'>'.$row['fname'].'</a></b>
  <br>';	
  	 {echo date("j F, Y",strtotime($row['submitdate']));}
  	echo ' | <small>'.$row['id'].'</small></td>
  
  <td> <a class="title" href="#" data-toggle="modal" data-target="#engage-modal" id='.$row['jobid'].'>'.$row['jobtitle'].'</a><br><small>'.$row['jobid'].'</small> / <small>'.$row['jobtype'].'</small></td>';
  
  if($adminrights)
   echo '<td>'.$row['subuser'].'</td>
   
  <td>'.$row['name'].'</td>
  <td>';	
  	 {echo date("j F, Y",strtotime($row['doj']));}
  	echo '</td>
  <td>';	
  	 {echo date("j F, Y",strtotime($row['paymentdate']));}
  	echo '</td>
  <td>'.$row['expectedcurrency'].''.$row['billable'].'</td>
  <td>'.$row['fee'].'</td>
  <td><b>'.$row['expectedcurrency'].''.$row['agencyshare'].'</b></td>
  <td>'.$row['paymentadv'].'</td>
  <td>'.$row['notes'].'</td>
  <td><span class="badge badge-default">'.$row['candidatestatus'].'</span></td>
</tr>';
}
?>

</tbody>
</table>
 <?php } else echo $candidatemsg; ?> 
</div>
      </div>
      </div>
    </div>
  </div>
</section>
  <div class="modal fade" id="candidate-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="candidate-modal-label"></h4>
          </div>
          <div class="modal-body" id="candidate-modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  
    <div class="modal fade" id="engage-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="engage-modal-label"></h4>
          </div>
          <div class="modal-body" id="engage-modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
</div>     
      
      
      
     </div>
     </div>
     </div>
<div class="clearfix"></div>
</div>
</div>

<script>
$('#candidate-modal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            essayId = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'candidate-detail.php',
            data: 'EID=' + essayId,
            success: function(data) {
				$modal.find('#candidate-modal-body').html(data);
                $modal.find('#candidate-modal-label').html( $('#candidate_name').data('value'));
				
            }
        });
		
	});
	
/*** $( "#jobtitle" ).autocomplete({
	minLength: 2,
	source:'jsearch.php',
	 response: function(event, ui) {
            // ui.content is the array that's about to be sent to the response callback.
            if (ui.content.length === 0) {
                $("#e").text("No results found");
            } else {
                $("#e").empty();
            }
    },
	change: function(event, ui) {
            if (!ui.item) {
               $(this).val('');
            }
    }
    });	***/
$( "#employer" ).autocomplete({
	minLength: 2,
	source:'esearch.php',
	 response: function(event, ui) {
            // ui.content is the array that's about to be sent to the response callback.
            if (ui.content.length === 0) {
                $("#e").text("No results found");
            } else {
                $("#e").empty();
            }
    },
	change: function(event, ui) {
            if (!ui.item) {
               $(this).val('');
            }
    }
    });	
	 $('#engage-modal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            essayId = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'engage-modal-content.php',
            data: 'EID=' + essayId,
            success: function(data) {
				$modal.find('#engage-modal-body').html(data);
                $modal.find('#engage-modal-label').html( $('#job_title').data('value'));
				
            }
        });
    })
</script>

<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode:"1f8211f2f5aa69bfd2e64274cb249d69f747f435e0dfe9837445d3ed8ad8672546be72282208d9c4fa10ef18b9f5d348", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>

 </body>
</html>
