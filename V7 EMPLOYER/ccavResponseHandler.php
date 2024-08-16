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

include('crypto.php');
 $content='';
	error_reporting(0);
	
	$workingkey='rzp_live_JmIotm0AxxkFdC';
	//$workingkey='rzp_live_JmIotm0AxxkFdC';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingkey);		//Crypto Decryption used as per the specified working key.
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);	
	$order_status="";	
	 for($i = 0; $i < $dataSize; $i++) 
    {
        $information=explode('=',$decryptValues[$i]);
       $$information[0]=$information[1];
		
    }
		
if(!isset($bank_ref_no))
$bank_ref_no='';
if(!isset($card_name))
$card_name='';
if(!isset($billing_country))
$billing_country='';
	
if(!isset($order_status))
$order_status='';

if(!isset($payment_mode))
$payment_mode='';

if(!isset($status_message))
$status_message='';

if(!isset($currency))
$currency='';

if(!isset($billing_name))
$billing_name='';

if(!isset($amount))
$amount='';

if(!isset($billing_tel))
$billing_tel='';

if(!isset($billing_email))
$billing_email='';

if(!isset($merchant_param1))
$merchant_param1='';

if(!isset($merchant_param2))
$merchant_param2=0;

if(!isset($merchant_param3))
$merchant_param3='';

if(!isset($trans_date))
$trans_date='';

if($merchant_param1=="Basic")
$permonthcount=20 * $merchant_param2;
else
$permonthcount=50 * $merchant_param2; 

//$sql=mysqli_query($link,"insert into paymentinfo(companyid,memberid,order_id,tracking_id,bank_ref_no,card_name,billing_country,order_status,payment_mode,status_message,currency,billing_name,amount,billing_tel,billing_email,plan,duration,trans_date,startdate,expirydate)values('$cid','$mid','$order_id','$tracking_id','$bank_ref_no','$card_name','$billing_country','$order_status','$payment_mode','$status_message','$currency','$billing_name','$amount','$billing_tel','$billing_email','$merchant_param1','$merchant_param2','$trans_date',CURDATE(),CURDATE() +  INTERVAL ".$merchant_param2." MONTH)");

$sql=mysqli_query($link,"insert into paymentinfo(companyid,memberid,order_id,tracking_id,bank_ref_no,card_name,billing_country,order_status,payment_mode,status_message,currency,billing_name,amount,billing_tel,billing_email,plan,duration,trans_date,startdate,expirydate)values('$cid','$mid','$order_id','$tracking_id','$bank_ref_no','$card_name','$billing_country','$order_status','$payment_mode','$status_message','$currency','$billing_name','$amount','$billing_tel','$billing_email','$merchant_param1','$merchant_param2','$trans_date','".$merchant_param3."','".$merchant_param3."' +  INTERVAL ".$merchant_param2." MONTH)");


if($order_status==="Success")
	{
		  $content= "<h3>Thank you. Your payment status is ". $order_status .".</h3><h4>Your Tracking ID for this transaction is ".$tracking_id.".</h4><h4>We have received a payment of Rs. " . $amount . ". You subscription is confirmed. Appreciate your business! </h4>";
		  
		   //mysqli_query($link,"update companyprofile inner join members on members.companyid=companyprofile.id set companyprofile.paidstatus='". $order_status ."', companyprofile.subspackage='". $merchant_param1 ."',companyprofile.subsdate= CURDATE(), companyprofile.subsexpirydate=CURDATE() +  INTERVAL ".$merchant_param2." MONTH,companyprofile.amountpaid='".$amount."', companyprofile.permonthcount= $permonthcount, companyprofile.engagedcount=0, companyprofile.modeofpayment='online',companyprofile.paidthrough='CCAvenue' where members.memberid='$mid'");

 mysqli_query($link,"update companyprofile inner join members on members.companyid=companyprofile.id set companyprofile.paidstatus='". $order_status ."', companyprofile.subspackage='". $merchant_param1 ."',companyprofile.subsdate= CURDATE(),companyprofile.substartdate='".$merchant_param3."', companyprofile.subsexpirydate='".$merchant_param3."' +  INTERVAL ".$merchant_param2." MONTH,companyprofile.amountpaid='".$amount."', companyprofile.permonthcount= $permonthcount, companyprofile.engagedcount=0, companyprofile.modeofpayment='online',companyprofile.paidthrough='CCAvenue' where members.memberid='$mid'");
		
	}
	else if($order_status==="Aborted")
	{
		$content="<h3>Thank you for subscribing with us.We will keep you posted regarding the status of your order through e-mail</h3>";
	
	}
	else if($order_status==="Failure")
	{
		 $content="<h3>Your order status is ". $order_status .".</h3>";
         $content.="<h4>Your tracking id for this transaction is ".$tracking_id.". You may try making the payment by clicking on the link below.</h4>";
	}
	else
	{
		$content="Security Error. Access denied";
	
	}

?>
<!doctype html>
<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment Status | Employers Hub</title>

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

<a class="btn btn-primary" href="postdashboard">

Helpline number +44 02030267557

</a>

</div>

<ul class="navbar-right">

<li class="dropdown">

<a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">

<img src="images/user.png" class="img-circle" alt=""><span class="text"> <?php echo $name; ?></span><span class="caret"></span></a>

<ul class="dropdown-menu" role="menu"><li><a href="company-profile"><i class="fa fa-user"></i>Company Profile</a></li>

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

<li><a href="postdashboard" role="tab"><i class="fa  fa-fw fa-plus"></i>Post New Job</a></li>

<!--<li><a href="requests" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Request from Agencies</a></li>-->

<li class="candidates-nav nav-dropdown ">

<a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates"><i class="fa fa-fw fa-caret-right"></i> Jobs</a>

<div class="collapse" id="candidatesDropdownMenu">

<ul class="nav-sub" style="display: block;">

<li><a href="postdashboard" role="tab" ><i class="fa fa-fw fa-plus-square"></i> Post New Job</a></li>

<li><a href="jobs" role="tab" ><i class="fa fa-list"></i>Active Jobs</a></li>

<li><a href="inactive" role="tab" ><i class="fa fa-list"></i>Inactive Jobs</a></li>

<li><a href="closed" role="tab" ><i class="fa fa-clock-o"></i>Closed Jobs</a></li>

<li><a href="filled" role="tab" > <i class="fa fa-users"></i>Filled Jobs</a></li>

</ul>

</div>

</li>

<li class="candidates-nav nav-dropdown">

<a href="#candidatesDropdownMenu1" data-toggle="collapse" aria-controls="candidatesDropdownMenu1" title="Candidates" class="navbar-root your-candidates">

<i class="fa fa-fw fa-caret-right"></i> Candidates (ATS)</a>



<div class="collapse" id="candidatesDropdownMenu1">

<ul class="nav-sub" style="display: block;">

<li><a href="all" role="tab" ><i class="fa fa-list"></i>All Candidates</a></li>

<li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback</a></li>

<li><a href="shortlist" role="tab" > <i class="fa fa-users"></i>Shortlisted</a>  </li>

<li><a href="offer" role="tab" > <i class="fa fa-envelope"></i>Offered</a></li>

<li><a href="rejected" role="tab" > <i class="fa fa-trash"></i>Rejected</a></li>
<li><a href="filledcandidates" role="tab" > <i class="fa fa-users"></i>Filled</a> </li>

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
   
   <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu4" data-toggle="collapse" aria-controls="candidatesDropdownMenu4" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i>Bench Hiring <span class="label label-primary">Free</span></a>

   <div class="collapse" id="candidatesDropdownMenu4">
   <ul class="nav-sub" style="display: block;">
   
   <li><a href="resources" role="tab" > <i class="fa fa-database"></i>Upload Bench Resources </a> </li>
   <li><a href="view-all-resource-engagement" role="tab" > <i class="fa fa-database"></i>Request for Your Bench Resources </a> </li>  
   <li><a href="view-resources" role="tab" > <i class="fa fa-database"></i>View Your Bench Resources </a> </li>  
   <li><a href="search-resources" role="tab" > <i class="fa fa-database"></i>Search Bench Resources from Others </a> </li>  
     
    </ul>
   </div>
   </li>

	   </ul>

</div>

</div> 

<div class="col-md-10 table-responsive">
<div class="account-navi-content">
               <div class="panel panel-default">
                <header class="panel-heading wht-bg ui-sortable-handle">
    
  </header>
        <div class="panel-body">
      
        <?php echo $content;   
		?>
	 
                          </div>
            </div>
            </div>
</div>

</div>
<div class="clearfix"></div>
</div>
</div>
	
        