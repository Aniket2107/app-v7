<?php

require '../Smtp/index.php';

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
header('location: index'); 
exit;
}

$msg='';

require_once '../config.php';



if(isset($_POST['new']) && ($_POST['new']!= '') && isset($_POST['code']) && ($_POST['code']!= '')  ){
	$password=$_POST['new'];
	$email=$_POST['email'];
	$code=$_POST['code'];
	$query1="update members set password='$password' where email='$email' and activationcode='$code'";
	$result=mysqli_query($link,$query1);
	if(mysqli_affected_rows($link)){
	$msg="Your Password has been updated Successfully.";
	$message="Your Recruiting Hub Password has been Successfully Changed.";
			// $headers = "From: noreply@recruitinghub.com\r\n";
			// $headers .= "Content-type: text/html\r\n";

	//		mail($email, "Password changed", $message,$headers);
	
	$params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$email,'subject'=>'Recruiting Hub - Password Changed','message'=>$message,'send'=>true];
	AsyncMail($params);
	

//   $res =    SendMail($from = 'noreply@recruitinghub.com','Recruiting Hub',$email,$message,$msg);
//         if($res==200){

                $msg="Your Password has been updated Successfully";
              
       // }
	}
	else
				{
				$msg="Sorry your password could not be changed.";
			}
}
else{
	$code=rand(100,999);
	$message1="Your code to reset password for Recruiting Hub is: ".$code;
	$query1="update members set activationcode=$code where email='$email'";
	mysqli_query($link,$query1);
	
	//$headers = "From: noreply@recruitinghub.com\r\n";
//	$headers .= "Content-type: text/html\r\n";

$params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$email,'subject'=>'Recruiting Hub - Reset your password','message'=>$message1,'send'=>true];
			
     AsyncMail($params);

// if($res==200){
//   $msg="check your inbox";
// }
//	mail($email, "Reset your password", $message1,$headers);
}
?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Change Password | Recruiters Hub</title>
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
    <ul class="dropdown-menu" role="menu"><li><a href="company-profile"><i class="fa fa-user"></i>Company Profile</a>   </li>
      <li><a href="edit-profile"><i class="fa fa-gears"></i>Your Account</a></li>
        <?php if($admin){
       echo'<li><a href="manage-users"><i class="fa fa-users"></i>Manage Users</a></li>';
	   /**if($rcountry=='India'){echo'
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
<h4>Client Section</h4>
    <li><a href="dashboard" role="tab" ><i class="fa  fa-fw fa-tachometer"></i>Dashboard</a></li>
    <li><a href="https://www.recruitinghub.com/franchiseapply" target=_blank role="tab" > <i class="fa fa-database"></i>Become our Franchise <span class="label label-primary">New</span></a> </li>
    <li><a href="search" role="tab" ><i class="fa fa-fw fa-search"></i>Search Jobs</a>    </li>
    <li><a href="job" role="tab"><i class="fa fa-fw fa-files-o"></i>Engaged Jobs</a>    </li>
    <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Supply Candidates (STS)</a>

   <div class="collapse" id="candidatesDropdownMenu">
   <ul class="nav-sub" style="display: block;">
    <li><a href="add_new" role="tab" ><i class="fa fa-fw fa-plus-square"></i> Add new</a>  </li>
    <li><a href="all" role="tab" ><i class="fa fa-list"></i> All</a> </li>
    <li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback</a>  </li>
    <li><a href="interview" role="tab" > <i class="fa fa-users"></i> Shortlisted</a>  </li>
     <li><a href="offer" role="tab" > <i class="fa fa-users"></i>Offered</a>  </li>
      <li><a href="filled" role="tab" > <i class="fa fa-users"></i>Filled</a>  </li>
     
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i> Rejected</a> </li>
    </ul>
   </div>
   </li>
    <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging </a>    </li>
    <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Feedback Rating</a> </li>
<li><a href="psl-list" role="tab" > <i class="fa fa-list"></i>PSL</a> </li>
<li><a href="hire-resource" role="tab" > <i class="fa fa-database"></i>Bench Hiring <span class="label label-primary">Free</span></a> </li>
    <h4>Jobseeker Section</h4>

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
        

  <div class="row">
    <div class="col-sm-12">
         <div class="panel panel-default">
       <header class="panel-heading wht-bg ui-sortable-handle">
    <h3 class="panel-title">Change Password</h3>
  </header>
        <div class="panel-body">
<?php if(!$msg){ ?>	
			<form id="sky-form" method="post" action="changepassword">
            <input type="hidden" name="email" value="<?php echo $email; ?>" >
				
					     
					<div class="form-group col-sm-12">
					<label class="col-sm-2">New password</label>
                     <div class="col-sm-10">
						<input type="password" class="form-control" name="new" id="new" required>
							</div></div>
					<div class="form-group col-sm-12">
					<label class="col-sm-2">Confirm password</label>
                     <div class="col-sm-10">
                        <input type="password" class="form-control" name="confirm" id="confirm" required>
                      </div></div>
					<div class="form-group col-sm-12">
					<label class="col-sm-2">Enter the code</label>
                    <div class="col-sm-10">
						<input type="password" class="form-control" placeholder="Please check your email (inbox/spam folder) for the code" name="code" required>
                      </div> </div>    
                    
					<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">  
                   	 <input value="Submit" name="submit" class="btn btn-primary btns" type="submit"  />
                    </div></div>
                     </form>	
            <?php }else echo $msg; ?>	
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
</div>    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
			var password = document.getElementById("new"), confirm_password = document.getElementById("confirm");
		
		function validatePassword(){
		  if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("Passwords Don't Match");
		  } else {
			confirm_password.setCustomValidity('');
		  }
		}
		
		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
    </script>
  </body>
</html>
