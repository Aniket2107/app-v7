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
     <title>Recruiters Hub</title>
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
<a class="navbar-brand" href="#"><img src="images/color-logo.png"></a>
<ul class="navbar-right">
  <li class="dropdown">
    <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
  <img src="images/user.png" class="img-circle" alt="">     <span class="text"><?php echo $name; ?></span><span class="caret"></span> </a>
    <ul class="dropdown-menu" role="menu"><li><a href="company-profile"><i class="fa fa-user"></i>Agency Profile</a>   </li>
      <li><a href="edit-profile"><i class="fa fa-gears"></i>Your Account</a></li>
       <?php if($admin){
       echo'<li><a href="manage-users"><i class="fa fa-users"></i>Manage Users</a></li>';
	   if($rcountry=='India'){echo'
	   <li><a href="subscription_plans"><i class="fa fa-money"></i> Manage Subscription</a></li>';}
	   else{echo'
	    <li><a href="subscription-plans"><i class="fa fa-money"></i> Manage Subscription</a></li>';
		}echo'
     <li><a href="subscription-status"><i class="fa fa-info-circle"></i> Subscription Status</a></li>
	   ';
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
<h4>Client Section (Business)</h4>
    <li><a href="dashboard" role="tab" ><i class="fa  fa-fw fa-tachometer"></i>Dashboard</a></li>
    <li><a href="search" role="tab" ><i class="fa fa-fw fa-search"></i>Search Jobs</a>    </li>
    <li><a href="job" role="tab"><i class="fa fa-fw fa-files-o"></i>Engaged Jobs</a>    </li>
    <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Candidates</a>

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
    <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messages </a>    </li>
    <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Feedback Rating</a> </li>
<li><a href="psl-list" role="tab" > <i class="fa fa-list"></i>PSL</a> </li>
 <?php if($rcountry=='United Kingdom (UK)') echo '<li><a href="hire-resource"><i class="fa fa-database"></i>Rec-To-Rec</a></li>';  ?>
    <h4>Jobseeker Section (Jobsite)</h4>

<li><a href="candidate-search" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> CV Search <span class="label label-primary">Free</span></a>    </li>
    <li><a href="post-job" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Post Jobs <span class="label label-primary">Free</span></a>    </li>
    <li><a href="manage-responses" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Manage responses</a>    </li>
    <li><a href="manage-jobs" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Manage Jobs</a>    </li>
  </ul>
</div>


</div>

<div class="col-md-10 table-responsive">
<div class="account-navi-content">
               <div class="panel panel-default">
                <header class="panel-heading wht-bg ui-sortable-handle">
    <h3 class="panel-title"> Subscription Plans  </h3>
  </header>
        <div class="panel-body">
               <section class="price-table">


                    <div class="table-pricing">
  <div class="col-md-4 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">Basic</p>
   <p class="pricing-rate"> Rs.10,000 <span>MONTHLY</span> <span class="exclides-vat">+ GST </span> </p>
  <p class="description">An entry-level package designed for independent, specialist recruiters likely to fill ten jobs a month</p>
  <div class="clearfix"></div><div class="terms-of-business">
        by clicking this button I agree to the <a href="../terms">Terms of Business</a>
      </div>
      <form method="post" name="bsubscribe" action="summary">

<input type="hidden" name="plan" value="Basic"  />

  <input type="submit" name="subscribe" class="subs-button" value="Subscribe Now">
  </form>
 </div>
 <div class="pricing-list ">
    <ul>
      <li><i class="fa fa-fw fa-files-o"></i>Engage up to 20 Jobs per month | All Contract & 0-2 yrs Exp Permanent Jobs are free to engage</li>
      <li><i class="fa fa-suitcase"></i>Unlimited Sectors</li>
      <li><i class="fa fa-money"></i>On all Permanent Job Placement Fee - 20% handling fee to us - 80% to YOU 5% Commission on day rate for all Contract Jobs</li>
      <li><i class="fa fa-unlock-alt"></i>Same day access</li>
      <li><i class="fa fa-suitcase"></i>Free Job Board Access</li>
    </ul>
  </div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">Advanced</p>
  <p class="pricing-rate"> Rs.20,000 <span>MONTHLY</span> <span class="exclides-vat">+ GST </span> </p>
  <p class="description">An opportunity for experienced consultants to quickly access jobs and accelerate billings</p>
  <div class="terms-of-business">by clicking this button I agree to the <a href="../terms">Terms of Business</a> </div>
    <form method="post" name="asubscribe" action="summary">

<input type="hidden" name="plan" value="Advanced"  />

  <input type="submit" name="subscribe" class="subs-button" value="Subscribe Now">
  </form>
 </div>
 <div class="pricing-list ">
    <ul>
      <li><i class="fa fa-fw fa-files-o"></i>Engage up to 50 Jobs per month | All Contract & 0-2 yrs Exp Permanent Jobs are free to engage</li>
      <li><i class="fa fa-suitcase"></i>Unlimited sectors</li>
      <li><i class="fa fa-money"></i>On all Permanent Job Placement Fee - 10% handling fee to us - 90% to YOU 5% Commission on day rate for all Contract Jobs</li>
      <li><i class="fa fa-unlock-alt"></i> Instant access</li>
      <li><i class="fa fa-suitcase"></i>Free Job Board Access | Featured Agency Listing on our Jobsite</li>
    </ul>
  </div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">Premium</p>
  <p class="pricing-rate"> Call to discuss </p>
  <p class="description">An exclusive, invitation-only package for the marketplace' s best recruitment agencies and consistent performers          Unlimited Sectors</p>
  <div class="terms-of-business">by clicking this button I agree to the <a href="terms">Terms of Business</a></div>
 <a class="subs-button" href="#">  +44 02030267557 </a> </div>
 <div class="pricing-list ">
    <ul>
      <li><i class="fa fa-fw fa-files-o"></i>Unlimited Jobs</li>
      <li><i class="fa fa-suitcase"></i>Unlimited sectors</li>
      <li><i class="fa fa-money"></i>On all Permanent Job Placement Fee - 30% handling fee to us - 70% to YOU 5% Commission on day rate for all Contract Jobs</li>
      <li><i class="fa fa-unlock-alt"></i>Instant access</li>
      <li><i class="fa fa-suitcase"></i>Free Job Board Access | Top Agency Banner on our Jobsite</li>
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




 </body>
</html>
