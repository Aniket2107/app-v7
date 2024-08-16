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
$ecountry=$_SESSION['country'];
$notification='';
}
else{
$notification='Please login to access the page';
$_SESSION['notification']=$notification;
header('location: login'); 
exit;
}
if(isset($_GET['uid']))
$memberid=$_GET['uid'];
else
$memberid=$mid;

require_once '../config.php';
$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];
$content='';
$profileres = mysqli_query($link,"SELECT * FROM members WHERE memberid='$memberid'"); 
$ispresent = mysqli_num_rows($profileres);
if($ispresent > 0){ 
    while($row = mysqli_fetch_array($profileres)){ 
		$profile=$row;
				}
}
else
$content="No data.";

if(isset($_POST['submit'])){
	if(isset($_FILES['photo'])){
	 $photo=$_FILES['photo']['name'];
			 
			 
		if (!file_exists("photo/".$mid)) {
			mkdir("photo/".$mid,0777,true);
			}
		 if (is_uploaded_file($_FILES["photo"]["tmp_name"]) ) {
			move_uploaded_file($_FILES['photo']['tmp_name'], "photo/".$mid."/".$photo);
			mysqli_query($link,"update members set photo='$photo' where memberid='$mid'");
				}
				
	}
	/*if(isset($_POST['notifyjob']))
	$notify=$_POST['notifyjob'];
	else
	$notify=0; */
	
	mysqli_query($link,"update members set email='".$_POST['email']."',firstname='".$_POST['fname']."',lastname='".$_POST['lname']."',mobile='".$_POST['mobile']."',designation='".$_POST['jobtitle']."',location='".$_POST['location']."',linkedin='".$_POST['linkedin']."',biography='".$_POST['additionalinfo']."' where memberid='".$_POST['memberid']."'");
	$content="<p style = 'font-size: 16px;
            color: #21a021;
        '>Your profile is updated. Click here to go to Your Profile section -> <a href=https://www.recruitinghub.com/employer/company-profile><b>Company Profile</b></p></a>";
}

 ?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Your Profile | Employers Hub</title>
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
<div class="logo">
<a class="navbar-brand" href="#"><img src="images/color-logo.png"></a>
<!--<a class="btn btn-primary" href="postdashboard">
     Helpline number +44 02030267557
</a>-->
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
      <h4>Recruiters Marketplace Section</h4>
  <li><a href="dashboard" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Dashboard</a></li>
  <li><a href="postdashboard" role="tab"><i class="fa  fa-fw fa-plus"></i>Post New Job</a></li>
 <!-- <li><a href="requests" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Request from Agencies</a></li>-->

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
    <li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback</a>  </li>
    <li><a href="shortlist" role="tab" > <i class="fa fa-users"></i>Shortlisted</a>  </li>
        <li><a href="offer" role="tab" > <i class="fa fa-envelope"></i>Offered</a> </li>
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i>Rejected</a> </li>
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
   
     <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging (<?php echo $new; ?>)</a>    </li>
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
        

  <div class="row">
    <div class="col-sm-12">
    <a class="btn btn-primary" href="changepassword">
    <i class="fa fa-edit"></i>  Change Password
</a>
      <div class="panel panel-default">
       <header class="panel-heading wht-bg ui-sortable-handle">
    <h3 class="panel-title">Your Profile  </h3>
  </header>
        <div class="panel-body">
<?php if($content) echo $content; else { ?>
<form action="edit-profile" method="post" enctype="multipart/form-data">
<input type="hidden" name="memberid" value="<?php echo $memberid; ?>">
<div class="form-group col-sm-12">
<label class="col-sm-2">Email</label>
<div class="col-sm-10">
<input class="form-control" required value="<?php echo $profile['email']; ?>" name="email" type="text" <?php if($profile['admin']) echo "readonly"; ?>>
</div></div>

<div class="form-group col-sm-12">
<label class="col-sm-2">Full Name</label>
<div class="col-sm-10">
<input class="form-control" required value="<?php echo $profile['firstname']; ?>" name="fname" type="text">
</div></div>

<!--<div class="form-group col-sm-12">
<label class="col-sm-2">Last name</label>
<div class="col-sm-10">
<input class="form-control" required value="<?php echo $profile['lastname']; ?>" name="lname" type="text">
</div></div> -->

<div class="form-group col-sm-12">
<label class="col-sm-2">Job title</label>
<div class="col-sm-10">
<input class="form-control"  value="<?php echo $profile['designation']; ?>" name="jobtitle" type="text">
</div></div>

<div class="form-group col-sm-12">
<label class="col-sm-2">Mobile number</label>
<div class="col-sm-10">
<input class="form-control" required value="<?php echo $profile['mobile']; ?>" name="mobile" type="text">
</div></div>

<div class="form-group col-sm-12">
<label class="col-sm-2">Your Location</label>
<div class="col-sm-10">
<input class="form-control"  value="<?php echo $profile['location']; ?>" name="location" type="text">
</div></div>

<div class="form-group col-sm-12">
<label class="col-sm-2">Your Linkedin url</label>
<div class="col-sm-10">
<input class="form-control"  value="<?php echo $profile['linkedin']; ?>" name="linkedin" type="text">
</div></div>

<!--<div class="form-group col-sm-12">
<label class="col-sm-2">Twitter url</label>
<div class="col-sm-10">
<input class="form-control"  value="<?php echo $profile['twitter']; ?>" name="twitter" type="text">
</div></div>

<div class="form-group col-sm-12">
<label class="col-sm-2">Biography</label>
 <div class="col-sm-10">
<textarea class="form-control" name="additionalinfo"  rows="6"><?php echo $profile['biography']; ?></textarea>
</div></div>-->

<div class="form-group col-sm-12">
<label class="col-sm-2">Your Photo</label>
<div class="col-sm-10">
<input name="photo" type="file">

</div></div>

<!-- <div class="form-group col-sm-12">
<label class="col-sm-2">Password</label>
<div class="col-sm-10">
<input class="form-control" required="required"  type="password">
<p class="help-block">Leave blank to keep the current password</p>
</div></div> -->


<div class="form-group">
<div class="col-sm-offset-2 col-sm-10">
<input name="submit" value="Save Changes" class=" btn btn-primary" type="submit">
</div></div>
</form>
<?php } ?>
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

<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode:"1f8211f2f5aa69bfd2e64274cb249d69f747f435e0dfe9837445d3ed8ad8672546be72282208d9c4fa10ef18b9f5d348", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>



 </body>
</html>
