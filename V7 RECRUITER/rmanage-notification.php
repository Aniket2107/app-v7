<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$msg=$error='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$adminrights=$_SESSION['adminrights'];
$cid=$_SESSION['cid'];
$admin=$_SESSION['admin'];
$rcountry=$_SESSION['country'];

}
require_once '../config.php';
$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];

if(isset($_POST['submit'])){

if(isset($_POST['messagenotification'])){
  $messagenotification=$_POST['messagenotification'];
  $msgupdate=mysqli_query($link,"UPDATE members SET messagenotification='$messagenotification' where memberid='$mid'");
}

if(isset($_POST['recreminder'])){
  $recreminder=$_POST['recreminder'];
  $msgupdate=mysqli_query($link,"UPDATE members SET recreminder='$recreminder' where memberid='$mid'");
}

		if(isset($_POST['jobnotification'])&&!isset($_POST['shortlistnotification'])&&!isset($_POST['offernotification'])&&!isset($_POST['applicationnotification'])){
$jobalertnotification=$_POST['jobnotification'];
$q1=mysqli_query($link,"UPDATE members SET jobalertnotification='$jobalertnotification' where memberid='$mid'");
}

		elseif(!isset($_POST['jobnotification'])&&isset($_POST['shortlistnotification'])&&!isset($_POST['offernotification'])&&!isset($_POST['applicationnotification'])){
$shortlistnotification=$_POST['shortlistnotification'];

$q2=mysqli_query($link,"UPDATE members SET shortlistnotification='$shortlistnotification' where memberid='$mid'");
}

		elseif(!isset($_POST['jobnotification'])&&!isset($_POST['shortlistnotification'])&&isset($_POST['offernotification'])&&!isset($_POST['applicationnotification'])){
$offernotification=$_POST['offernotification'];
$q3=mysqli_query($link,"UPDATE members SET offernotification='$offernotification' where memberid='$mid'");
}

elseif(!isset($_POST['jobnotification'])&&!isset($_POST['shortlistnotification'])&&!isset($_POST['offernotification'])&&isset($_POST['applicationnotification'])){
$applicationnotification=$_POST['applicationnotification'];
$q4=mysqli_query($link,"UPDATE members SET applicationnotification='$applicationnotification' where memberid='$mid'");
}

		elseif(isset($_POST['jobnotification'])&&isset($_POST['shortlistnotification'])&&!isset($_POST['offernotification'])&&!isset($_POST['applicationnotification'])){
$jobalertnotification=$_POST['jobnotification'];
$shortlistnotification=$_POST['shortlistnotification'];
$q5=mysqli_query($link,"UPDATE members SET jobalertnotification='$jobalertnotification',shortlistnotification='$shortlistnotification' where memberid='$mid'");
}
	
		elseif(isset($_POST['jobnotification'])&&!isset($_POST['shortlistnotification'])&&isset($_POST['offernotification'])&&!isset($_POST['applicationnotification'])){
$jobalertnotification=$_POST['jobnotification'];
$offernotification=$_POST['offernotification'];
$q6=mysqli_query($link,"UPDATE members SET offernotification='$offernotification',$jobalertnotification='$jobalertnotification' where memberid='$mid'");
}

		elseif(isset($_POST['jobnotification'])&&!isset($_POST['shortlistnotification'])&&!isset($_POST['offernotification'])&&isset($_POST['applicationnotification'])){
$jobalertnotification=$_POST['jobnotification'];
$applicationnotification=$_POST['applicationnotification'];
$q7=mysqli_query($link,"UPDATE members SET jobalertnotification='$jobalertnotification',applicationnotification='$applicationnotification' where memberid='$mid'");
}

		elseif(!isset($_POST['jobnotification'])&&isset($_POST['shortlistnotification'])&&isset($_POST['offernotification'])&&!isset($_POST['applicationnotification'])){
$shortlistnotification=$_POST['shortlistnotification'];
$offernotification=$_POST['offernotification'];
$q8=mysqli_query($link,"UPDATE members SET offernotification='$offernotification',shortlistnotification='$shortlistnotification' where memberid='$mid'");
}
	
	    elseif(!isset($_POST['jobnotification'])&&isset($_POST['shortlistnotification'])&&!isset($_POST['offernotification'])&&isset($_POST['applicationnotification'])){
$shortlistnotification=$_POST['shortlistnotification'];
$applicationnotification=$_POST['applicationnotification'];
$q9=mysqli_query($link,"UPDATE members SET applicationnotification='$applicationnotification',shortlistnotification='$shortlistnotification' where memberid='$mid'");
}	

elseif(!isset($_POST['jobnotification'])&&!isset($_POST['shortlistnotification'])&&isset($_POST['offernotification'])&&isset($_POST['applicationnotification'])){
$offernotification=$_POST['offernotification'];
$applicationnotification=$_POST['applicationnotification'];
$q10=mysqli_query($link,"UPDATE members SET offernotification='$offernotification',$applicationnotification='$applicationnotification' where memberid='$mid'");
}


		elseif(isset($_POST['jobnotification'])&&isset($_POST['shortlistnotification'])&&isset($_POST['offernotification'])&&!isset($_POST['applicationnotification'])){
$jobalertnotification=$_POST['jobnotification'];
$shortlistnotification=$_POST['shortlistnotification'];
$offernotification=$_POST['offernotification'];

$q11=mysqli_query($link,"UPDATE members SET jobalertnotification='$jobalertnotification',shortlistnotification='$shortlistnotification',offernotification='$offernotification' where memberid='$mid'");
}

		elseif(isset($_POST['jobnotification'])&&isset($_POST['shortlistnotification'])&&!isset($_POST['offernotification'])&&isset($_POST['applicationnotification'])){
$jobalertnotification=$_POST['jobnotification'];
$shortlistnotification=$_POST['shortlistnotification'];

$applicationnotification=$_POST['applicationnotification'];

$q12=mysqli_query($link,"UPDATE members SET jobalertnotification='$jobalertnotification',shortlistnotification='$shortlistnotification',applicationnotification='$applicationnotification'  where memberid='$mid'");
}

		elseif(isset($_POST['jobnotification'])&&!isset($_POST['shortlistnotification'])&&isset($_POST['offernotification'])&&isset($_POST['applicationnotification'])){
$jobalertnotification=$_POST['jobnotification'];

$offernotification=$_POST['offernotification'];
$applicationnotification=$_POST['applicationnotification'];

$q13=mysqli_query($link,"UPDATE members SET jobalertnotification='$jobalertnotification',offernotification='$offernotification',applicationnotification='$applicationnotification'  where memberid='$mid'");
}


		elseif(!isset($_POST['jobnotification'])&&isset($_POST['shortlistnotification'])&&isset($_POST['offernotification'])&&isset($_POST['applicationnotification'])){

$shortlistnotification=$_POST['shortlistnotification'];
$offernotification=$_POST['offernotification'];
$applicationnotification=$_POST['applicationnotification'];

$q14=mysqli_query($link,"UPDATE members SET shortlistnotification='$shortlistnotification',offernotification='$offernotification',applicationnotification='$applicationnotification'  where memberid='$mid'");
}


		elseif(isset($_POST['jobnotification'])&&isset($_POST['shortlistnotification'])&&isset($_POST['offernotification'])&&isset($_POST['applicationnotification'])){
$jobalertnotification=$_POST['jobnotification'];
$shortlistnotification=$_POST['shortlistnotification'];
$offernotification=$_POST['offernotification'];
$applicationnotification=$_POST['applicationnotification'];

$q15=mysqli_query($link,"UPDATE members SET jobalertnotification='$jobalertnotification',shortlistnotification='$shortlistnotification',offernotification='$offernotification',applicationnotification='$applicationnotification'  where memberid='$mid'");
}
$msg="Settings saved successfully";
header('location: dashboard'); 
exit;
}else{
$error="SOME ERROR OCCURED";

}
?>

<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Manage Notification | Recruiters Hub</title>
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
	/**   if($rcountry=='India'){echo'
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
<h4>Vendor Section (Business)</h4>
    <li><a href="dashboard" role="tab" ><i class="fa  fa-fw fa-tachometer"></i>Dashboard</a></li>
    <li><a href="becomefranchise" role="tab" > <i class="fa fa-database"></i>Become our Franchise <span class="label label-primary">New</span></a> </li>
    <li><a href="search" role="tab" ><i class="fa fa-fw fa-search"></i>Search Roles</a>    </li>
    <li><a href="job" role="tab"><i class="fa fa-fw fa-files-o"></i>Engaged Roles</a>    </li>
    <li><a href="disengaged" role="tab"><i class="fa fa-scissors"></i>CLOSED / DISENGAGED</a>  
    <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Supply Candidates (STS)</a>

   <div class="collapse" id="candidatesDropdownMenu">
   <ul class="nav-sub" style="display: block;">
    <li><a href="add_new" role="tab" ><i class="fa fa-fw fa-plus-square"></i> Add New Candidate</a>  </li>
    <li><a href="all" role="tab" ><i class="fa fa-list"></i>All Candidates</a> </li>
    <li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback</a>  </li>
    <li><a href="interview" role="tab" > <i class="fa fa-users"></i> Shortlisted</a>  </li>
     <li><a href="offer" role="tab" > <i class="fa fa-envelope"></i>Offered</a>  </li>
      <li><a href="filled" role="tab" > <i class="fa fa-users"></i>Filled</a>  </li>
     
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i> Rejected</a> </li>
    </ul>
   </div>
   </li>
    <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging (<?php echo $new; ?>) </a>    </li>
    <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Feedback Rating</a> </li>
<li><a href="psl-list" role="tab" > <i class="fa fa-list"></i>PSL</a> </li>
<li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu1" data-toggle="collapse" aria-controls="candidatesDropdownMenu1" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Agency Settings</a>

   <div class="collapse" id="candidatesDropdownMenu1">
   <ul class="nav-sub" style="display: block;">
    <li><a href="company-profile" role="tab" > <i class="fa fa-briefcase"></i>Agency Profile</a> </li>
    <li><a href="add-user" role="tab" > <i class="fa fa-plus"></i>Add Users</a> </li>
    <li><a href="edit-profile" role="tab" > <i class="fa fa-plus"></i>Your Profile</a> </li>
    
    </ul>
   </div>
   </li>
 <li><a href="hire-resource" role="tab" > <i class="fa fa-database"></i>Bench Hiring <span class="label label-primary">Free</span></a> </li>
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
   
  </header>
  
        <div class="panel-body">
<div class="table-responsive">
  <!-- change -->
     <form method="post" action="rmanage-notification.php">
       <div class="form-group">
         <div id="bottom-wizard">
      <?php
			$sql1=mysqli_query($link,"SELECT jobalertnotification,shortlistnotification,messagenotification,offernotification,applicationnotification,recreminder FROM members WHERE memberid='$mid'"); 
      $members=mysqli_fetch_array($sql1);
            if($members['jobalertnotification']==1){
			echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0">JOB ALERT NOTIFICATION</p>
			<input type="radio" name="jobnotification" value="1" checked>ON<br>
  			<input type="radio" name="jobnotification" value="0">OFF </div>';
			}
			else{
			echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0">JOB ALERT NOTIFICATION</p>
			<input type="radio" name="jobnotification" value="1">ON<br>
  			<input type="radio" name="jobnotification" value="0" checked>OFF </div>';
         }   
		 if($members['shortlistnotification']==1){
			echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0">PROFILE SHORTLIST NOTIFICATION</p>
			<input type="radio" name="shortlistnotification" value="1" checked>ON<br>
  			<input type="radio" name="shortlistnotification" value="0">OFF </div>';
			}
			else{
			echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0">PROFILE SHORTLIST NOTIFICATION</p>
			<input type="radio" name="shortlistnotification" value="1">ON<br>
  			<input type="radio" name="shortlistnotification" value="0" checked>OFF </div>';
         } 
		    if($members['offernotification']==1){
			echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0">CANDIDATE OFFER NOTIFICATION</p>
			<input type="radio" name="offernotification" value="1" checked>ON<br>
  			<input type="radio" name="offernotification" value="0">OFF </div>';
			}
			else{
			echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0">CANDIDATE OFFER NOTIFICATION</p>
			<input type="radio" name="offernotification" value="1">ON<br>
  			<input type="radio" name="offernotification" value="0" checked>OFF </div>';
         }  
		    if($members['applicationnotification']==1){
			echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0"> CANDIDATE JOB APPLICATION NOTIFICATION</p>
			<input type="radio" name="applicationnotification" value="1" checked>ON<br>
  			<input type="radio" name="applicationnotification" value="0">OFF </div>';
			}
			else{
			echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0"> CANDIDATE JOB APPLICATION NOTIFICATION</p>
			<input type="radio" name="applicationnotification" value="1">ON<br>
  			<input type="radio" name="applicationnotification" value="0" checked>OFF </div>';
         } 
         if($members['messagenotification']==1){
      echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0"> MESSAGE NOTIFICATION </p>
      <input type="radio" name="messagenotification" value="1" checked>ON<br>
        <input type="radio" name="messagenotification" value="0">OFF </div>';
      }
      else{
      echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0"> MESSAGE NOTIFICATION </p>
      <input type="radio" name="messagenotification" value="1">ON<br>
        <input type="radio" name="messagenotification" value="0" checked>OFF </div>';
         } 
         
    //      if($members['recreminder']==1){
		//	echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0">REC REMINDER NOTIFICATION</p>
	//		<input type="radio" name="recreminder" value="1" checked>ON<br>
  	//		<input type="radio" name="recreminder" value="0">OFF </div>';
//			}
	//		else{
	//		echo'<div class="rtst" style="margin-bottom:15px;"> <p style="margin-bottom:0">REC REMINDER NOTIFICATION</p>
	//		<input type="radio" name="recreminder" value="1">ON<br>
  	//		<input type="radio" name="recreminder" value="0" checked>OFF </div>';
    //     }   
		   
           ?>
         
<div>
		<input name="submit" value="Save Settings" class=" btn btn-primary" type="submit">

		</div>
        
     
        </form>                                  
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
