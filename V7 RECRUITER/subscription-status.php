<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$email=$iam='';
$content=$errormsg=$message=$msg='';
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
		require_once '../config.php';
		$paidstatus= $engagedcount=$permonthcount =$subsexpirydate='';
		$eligiblecheck=mysqli_fetch_assoc(mysqli_query($link,"select a.name,a.paidstatus,a.engagedcount,a.permonthcount,a.subsexpirydate,a.subsdate,a.subspackage,a.amountpaid from companyprofile a,members b where a.id=b.companyid and b.memberid='$mid'"));
		$agencyname= $eligiblecheck['name'];
		$paidstatus= $eligiblecheck['paidstatus'];
		$engagedcount= $eligiblecheck['engagedcount'];
		$permonthcount= $eligiblecheck['permonthcount'];
		$subsexpirydate= $eligiblecheck['subsexpirydate'];
		$subsdate=$eligiblecheck['subsdate'];
		$subpackage=$eligiblecheck['subspackage'];
		$amountpaid=$eligiblecheck['amountpaid'];
		
		 $today = date("Y-m-d");
		 
		 
		 $sql=mysqli_query($link,"select * from paymentinfo where memberid='$mid' order by trans_date asc");
if(mysqli_num_rows($sql)>0){
while($res=mysqli_fetch_array($sql)){
$payinfo[]=$res;
}
	}else
	{
	$msg='No Subcription History found.';
	}
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

<ul class="navbar-right">
  <li class="dropdown">
    <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">
  <img src="images/user.png" class="img-circle" alt="">     <span class="text"><?php echo $name; ?></span><span class="caret"></span> </a>
    <ul class="dropdown-menu" role="menu"><li><a href="company-profile"><i class="fa fa-user"></i>Agency Profile</a>   </li>
      <li><a href="edit-profile"><i class="fa fa-gears"></i>Your Account</a></li>
       <?php if($admin){
       echo'<li><a href="manage-users"><i class="fa fa-users"></i>Manage Users</a></li>';
	 /**  if($rcountry=='India'){echo'
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

<div class="col-sm-10">
<div class="account-navi-content">
  <div class="tab-content">
 
    
    <section class="main-content-wrapper">
        <div class="pageheader pageheader--buttons">
          
        </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
      <header class="panel-heading wht-bg ui-sortable-handle">
   <h4>Subscription Status</h4>
  </header>
  
        <div class="panel-body">
<div class="table-responsive">
    <div class="col-sm-12">
    
    
       <div class="form-group">
         <div id="bottom-wizard">
      
			 <div class="pricing-list ">
   <h4><strong><?php echo $agencyname; ?></p></strong></h4><br>
  <p class="pricing-rate"><strong>PAID STATUS :</strong> <?php echo $paidstatus; ?>  </p>
  <p class="pricing-rate"><strong>AMOUNT PAID :</strong> <?php echo $amountpaid; ?>  </p>
  <p class="description"><strong>ENGAGED COUNT :</strong> <?php echo $engagedcount;echo'/';echo $permonthcount; ?></p>
   <p class="description"><strong>SUBSCRIPTION PACKAGE :</strong> <?php echo $subpackage;  ?></p>
   <p class="description"><strong>SUBSCRIPTION START DATE :</strong> <?php echo $subsdate; ?></p>
  <p class="description"><strong>SUBSCRIPTION EXPIRY DATE :</strong> <?php echo $subsexpirydate; ?></p>
 
  </div>
  <p class="description"><strong>SUBSCRIPTION HISTORY:
  
  </div><br/><br/><br/>
      <?php if($msg) {echo $msg;} else{ foreach($payinfo as $history){ ?>
      
			 <div class="pricing-list ">
   
  <p class="pricing-rate"><strong>PAID STATUS :</strong> <?php echo $history['order_status']; ?>  </p>
  <p class="pricing-rate"><strong>AMOUNT PAID :</strong> <?php echo $history['amount']; ?>  </p>
 <p class="pricing-rate"><strong>SUBSCRIBED PLAN :</strong> <?php echo $history['plan']; ?>  </p>
   <p class="description"><strong>DURATION :</strong> <?php echo $history['duration'];  ?></p>
   <p class="description"><strong>TRANSACTION DATE :</strong> <?php echo $history['trans_date'];  ?></p>
    <p class="description"><strong>SUBSCRIPTION START DATE :</strong> <?php echo $history['startdate']; ?></p>
  <p class="description"><strong>SUBSCRIPTION EXPIRED DATE :</strong> <?php echo $history['expirydate']; ?></p>
</br></br>

  
   </div>
     <?php } }?>     
</div>
        
     
                                         
        </div>
       </div>     
 
</div>
      </div>
      </div>
   


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
</div>    
      
      
      
      
     </div>
     </div>
     </div>
<div class="clearfix"></div>
</div>
</div>
 </body>
</html>
