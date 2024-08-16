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


$paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
//$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
//$merchant_email = 'testaccount96@gmail.com';
$merchant_email ='madhan@recruitinghub.com';
$cancel_return = "https://www.recruitinghub.com/recruiter/failure.php";
$success_return="https://www.recruitinghub.com/recruiter/success.php?memberid=$mid&&plan=$plan&&cid=$cid&&orderid=$orderid&&useremail=$uemail&&number=$number&&month=$mnth&&startdate=$startdate";

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
<h3 class="panel-title"> Subscription Details </h3>
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
<label class="col-sm-2">Total Amount Payable (in Pounds)</label>
<div class="col-sm-10">
<input class="form-control" name="a3" value="<?php echo $tamount; ?>"readonly>
</div></div> 
<div class="form-group col-sm-12">
<label class="col-sm-2">Month(s)</label>
<div class="col-sm-10">
<input class="form-control" name="p3" value="<?php echo $mnth; ?>" readonly>
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

</body>
</html>

