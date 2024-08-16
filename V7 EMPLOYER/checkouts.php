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

/**if (isset($_POST['plan']) && ($_POST['plan']=="Basic")){
$plan="Basic";
$amount=10000;
$productinfo= "Basic package";
}
elseif (isset($_POST['plan']) && ($_POST['plan']=="Advanced")){
$plan="Advanced";
$amount=20000;
$productinfo= "Advanced package";
}
else
{
$plan="";
$amount=0;
$productinfo= "Free Subscription";
}
if(isset($_POST['month'])){
$mnth=$_POST['month'];
$amt=$amount * $mnth;
$tamount=$amt + 1800;
}

$mobile=mysql_fetch_assoc(mysql_query("select a.mobile from members a,companyprofile b where memberid='$mid' and a.companyid=b.id"));
$phone=$mobile['mobile'];***/

if($_POST['submit']){
$amt=$_POST['amount'];
$plan=$_POST['plan'];
$mnth=$_POST['month'];
$startdate=$_POST['startdate'];
$fname=$_POST['firstname'];
$uemail=$_POST['email'];
$number=$_POST['phone'];

}

if(($mnth=='1')&&($plan=='Basic')){
$net=100;
}
elseif(($mnth=='3')&&($plan=='Basic')){
$net=300;

}
elseif(($mnth=='6')&&($plan=='Basic')){
$net=600;

}
elseif(($mnth=='12')&&($plan=='Basic')){
$net=1200;

}
elseif(($mnth=='1')&&($plan=='Advanced')){
$net=200;
}
elseif(($mnth=='3')&&($plan=='Advanced')){
$net=600;

}
elseif(($mnth=='6')&&($plan=='Advanced')){
$net=1200;

}
elseif(($mnth=='12')&&($plan=='Advanced')){
$net=2400;

}
elseif(($mnth=='1')&&($plan=='Premium')){
$net=300;
}
elseif(($mnth=='3')&&($plan=='Premium')){
$net=900;

}
elseif(($mnth=='6')&&($plan=='Premium')){
$net=1800;

}
elseif(($mnth=='12')&&($plan=='Premium')){
$net=3600;

}
else{
$net='';

}
$vat=$net * 0.2 ;
$tamount=$vat + $net;

$sql=mysqli_query($link,"select max(id) from paymentinfo");
$res=mysqli_fetch_array($sql);
$max=$res[0];
if($max>0)
$current=$max+1;
else
$current=1;
$currents=sprintf("%05d", $current);
$orderid='rh_'.$currents;


$paypal_url = 'https://www.paypal.com/sdk/js?client-id=ARJWpqv--BXVZz_bUw0cngrMCB2fFqPMO2sn2Zebf1FMoMNWGVMZKqKI9H0gK2o6l5JTA_sM_x0aaqth';
//$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
//$merchant_email = 'testaccount96@gmail.com';
$merchant_email ='accounts@recruitinghub.com';
$cancel_return = "https://www.recruitinghub.com/employer/failure.php";
$success_return="https://www.recruitinghub.com/employer/success.php?memberid=$mid&&plan=$plan&&cid=$cid&&orderid=$orderid&&useremail=$uemail&&number=$number&&month=$mnth&&startdate=$startdate";

$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];

?>
<!doctype html>
<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UK Subscription Plans | Employers Hub</title>

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
<h3 class="panel-title"> UK Checkout </h3>
</header>
<div class="panel-body">
<form name = "myform" action="<?php echo $paypal_url; ?>" method="post" target="_top" >
<input type="hidden" name="cmd" value="_xclick-subscriptions">
<input class="form-control" type = "hidden" name = "business" value = "<?php echo $merchant_email; ?>" >




<div class="form-group col-sm-12">
<label class="col-sm-2">Plan</label>
<div class="col-sm-10">
<input class="form-control" name="item_name" value="<?php echo $plan; ?>" readonly>
</div></div>

<input type="hidden" name="no_note" value="1">

<input type="hidden" name="src" value="0"> 

<div class="form-group col-sm-12">
<label class="col-sm-2">Total Amount Payable</label>
<div class="col-sm-10">
<input class="form-control" name="a3" value="£<?php echo $tamount; ?>"readonly> <small><p>(Net Amount + 20% VAT)</p></small>
</div></div> 

<div class="form-group col-sm-12">
<label class="col-sm-2">First Name</label>
<div class="col-sm-10">
<input class="form-control" name="billing_name" id="firstname" value="<?php echo $fname; ?>" readonly />
</div></div>

<div class="form-group col-sm-12">
<label class="col-sm-2">Email</label>
<div class="col-sm-10">
<input class="form-control" name="billing_email" id="email" value="<?php echo $uemail; ?>" readonly />
</div></div>


<div class="form-group col-sm-12">
<label class="col-sm-2">Phone</label>
<div class="col-sm-10">
<input class="form-control" name="billing_tel" value="<?php echo $number; ?>" readonly />
</div></div>

<div class="form-group col-sm-12">
<label class="col-sm-2">Duration</label>
<div class="col-sm-10">
<input class="form-control" name="p3" value="<?php echo $mnth; ?> Month" readonly>
</div></div>

<input type="hidden" name="t3" value="M">
<input type="hidden" name="currency_code" value="GBP">
<input type = "hidden" name = "cancel_return" value="<?php echo $cancel_return ?>">
<input type = "hidden" name = "return" value="<?php echo $success_return; ?>">
<input type="hidden" name="rm" value="2">
<!---<input type="hidden" name="cbt" value="Please Click Here to Complete Payment">--->

<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
 <input name="submit" value="Make Payment" class=" btn btn-primary" type="submit">

<!---<input type="image" name="submit"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif"
    alt="Subscribe">-->
</div></div>
</form>

</div>
</div>
</div>
</div>

</div>
<div class="clearfix"></div>
</div>
</div>
<script>
document.myform.submit();
</script>

<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || 
{widgetcode:"1f8211f2f5aa69bfd2e64274cb249d69f747f435e0dfe9837445d3ed8ad8672546be72282208d9c4fa10ef18b9f5d348", values:{},ready:function(){}};
var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;
s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>

</body>
</html>

