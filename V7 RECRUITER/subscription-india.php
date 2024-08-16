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

$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];

if(isset($_POST['submit'])){
require_once 'insert-candidate.php';
}
/*fetch sector values to an array
$res=mysql_query("select sector from jobsectors");
if(mysql_num_rows($res)){
	while($row=mysql_fetch_assoc($res)){
		$sector[]=$row;
	}
}*/
 ?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>India Subscription | Employers Hub</title>
    <meta name="application-name" content="Recruiting-hub" />
     <link rel="icon" type="image/favicon.png" href="https://www.recruitinghub.com/images/favicon.png" />
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.custom.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/fonts/css/font-awesome.min.css" media="screen, projection">
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

         
</head>
<body>

<div class="header-inner">
<div class="header-top">
<div class="logo">
<a class="navbar-brand" href="#"><img src="images/color-logo.png"></a>

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
  <li><a href="submit-a-job" role="tab"><i class="fa  fa-fw fa-plus"></i>Post New Job</a></li>
  <li><a href="requests" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Request from Agencies</a></li>

     <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Jobs</a>

   <div class="collapse" id="candidatesDropdownMenu">
   <ul class="nav-sub" style="display: block;">
    <li><a href="submit-a-job" role="tab" ><i class="fa fa-fw fa-plus-square"></i> Post New Job</a>  </li>
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
    <li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback</a>  </li>
    <li><a href="shortlist" role="tab" > <i class="fa fa-users"></i>Shortlisted</a>  </li>
        <li><a href="offer" role="tab" > <i class="fa fa-envelope"></i>Offered</a> </li>
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i>Rejected</a> </li>
    </ul>
   </div>
   </li>
   
     <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging (<?php echo $new; ?>)</a>    </li>
   <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Feedback Rating</a> </li>
 <li><a href="psl-list" role="tab" > <i class="fa fa-list"></i> PSL</a> </li>
 <li><a href="company-profile" role="tab" > <i class="fa fa-plus"></i>Company Profile</a> </li>
 <li><a href="add-user" role="tab" > <i class="fa fa-plus"></i>Add Users</a> </li>
 <li><a href="view-all-resource-engagement" role="tab" > <i class="fa fa-database"></i>Request for Your Bench Resources <span class="label label-primary">Free</span></a> </li>  
    <li><a href="resources" role="tab" > <i class="fa fa-database"></i>Bench Hiring <span class="label label-primary">Free</span></a> </li>  </ul>
   
</div>
</div>

<div class="col-md-10 table-responsive">
<div class="account-navi-content">
               <div class="panel panel-default">
                <header class="panel-heading wht-bg ui-sortable-handle">
    <h3 class="panel-title"> Hire a Recruiter Plans  </h3>
  </header>

        <div class="panel-body">
               <section class="price-table">


                    <div class="table-pricing">
  <div class="col-md-4 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">Part-time Recruiter</p>
   <p class="pricing-rate"> Rs.10,000 <span>Monthly</span> <span class="exclides-vat">+ GST </span> </p>
  <p class="description">An entry-level package designed for startups likely to fill 5 jobs a month</p>
  <div class="clearfix"></div><div class="terms-of-business">
        by clicking this button I agree to the <a href="../terms">Terms of Business</a>
      </div>
      <form method="post" name="bsubscribe" action="summary">

<input type="hidden" name="plan" value="Basic"  />

  <input type="submit" name="subscribe" class="subs-button" value="Pay Now">
  </form>
 </div>
 <div class="pricing-list ">
    <ul>
      <li><i class="fa fa-fw fa-files-o"></i>Recruiter works part-time</li>
      <li><i class="fa fa-suitcase"></i>You need to provide job board </li>
      <li><i class="fa fa-money"></i>Start in 3 days</li>
      <li><i class="fa fa-unlock-alt"></i>You pay us and we pay recruiter</li>
      <li><i class="fa fa-suitcase"></i>Cancel anytime</li>
    </ul>
  </div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">Full-time Recruiter</p>
  <p class="pricing-rate"> Rs.40,000 <span>Monthly</span> <span class="exclides-vat">+ GST </span> </p>
  <p class="description">For mid size companies looking to fill over 10 roles a month</p>
  <div class="terms-of-business">by clicking this button I agree to the <a href="../terms">Terms of Business</a> </div>
    <form method="post" name="asubscribe" action="summary">

<input type="hidden" name="plan" value="Advanced"  />

  <input type="submit" name="subscribe" class="subs-button" value="Pay Now">
  </form>
 </div>
 <div class="pricing-list ">
    <ul>
      <li><i class="fa fa-fw fa-files-o"></i>Recruiter works full-time</li>
      <li><i class="fa fa-suitcase"></i>Recruiter will have job board </li>
      <li><i class="fa fa-money"></i>Start immediately</li>
      <li><i class="fa fa-unlock-alt"></i>You pay us and we pay recruiter</li>
      <li><i class="fa fa-suitcase"></i>Cancel anytime</li>
    </ul>
  </div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">RPO</p>
  <p class="pricing-rate"> Call to discuss </p>
  <p class="description">For companies looking to ramp up hiring</p>
  <div class="terms-of-business">by clicking this button I agree to the <a href="terms">Terms of Business</a></div>
 <a class="subs-button" href="#">  +44 02030267557 </a> </div>
 <div class="pricing-list ">
    <ul>
      <li><i class="fa fa-fw fa-files-o"></i>Fill over 100 roles a month</li>
      <li><i class="fa fa-suitcase"></i>RPO</li>
      <li><i class="fa fa-money"></i>Dedicated Recruitment Team</li>
      <li><i class="fa fa-unlock-alt"></i>Instant start</li>
      <li><i class="fa fa-suitcase"></i>Cancel anytime</li>
    </ul>
  </div>
</div>

                    </div> 

        </section>           </div>
            </div>
            </div>
</div>

</div>
<div class="clearfix"></div>
</div>
</div>

<!-- Modal terms -->
<div class="modal fade" id="employer-terms" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="engage-modal-label">Terms of Service</h4>
</div>
<div class="modal-body" id="engage-modal-body">
<?php include_once 'terms.php'; ?>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<div class="modal fade" id="employer-policies" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="engage-modal-label">Privacy Policy</h4>
</div>
<div class="modal-body" id="engage-modal-body">
<?php include_once 'privacy.php'; ?>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>
<!-- /.modal -->


 </body>
</html>
