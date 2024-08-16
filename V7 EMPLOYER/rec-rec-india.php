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

$cid=$_SESSION['cid'];

$ecountry=$_SESSION['country'];

}

else{

$notification='Please login to access the page';

$_SESSION['notification']=$notification;

header('location: login'); 

exit;

}

$content='';

require_once '../config.php';
$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];

if(isset($_POST['submit'])){

$consultant=$_POST['consultant'];

$jobtitle=$_POST['jobtitle'];

$skills=$_POST['skills'];

$totalexp=$_POST['totalexp'];

$currentloc=$_POST['currentloc'];

$availability=$_POST['availability'];

$visa=$_POST['visa'];

//$cv=$_POST['cv'];

$cv1=$_POST['cv1'];

//$assessment=$_POST['assessment'];

$currentcountry=$_POST['country'];



if(isset($_FILES['cv'])){

	 $cv=$_FILES['cv']['name'];

	 }

else

	$cv='';
	
if(isset($_FILES['assessment'])){

	 $assessment=$_FILES['assessment']['name'];

	 }

else

	$assessment='';

$sql=mysqli_query($link,"insert into resource (emid,consultant,jobtitle,skills,totalexperience,currentlocation,country,availability,postdate,visa,cv,cv1,assessment)values('$mid','$consultant','$jobtitle','$skills','$totalexp','$currentloc','$currentcountry','$availability',now(),'$visa','$cv','$cv1','$assessment')"); 

$id = mysqli_insert_id($link);

		if (!file_exists("resourcecvs/".$mid)) {

			mkdir("resourcecvs/".$mid,0777,true);

			}

			mkdir("resourcecvs/".$mid."/".$id,0777,true);

			 if (is_uploaded_file($_FILES["cv"]["tmp_name"]) ) {

			move_uploaded_file($_FILES['cv']['tmp_name'], "resourcecvs/".$mid."/".$id."/".$cv);

				}
			
			mkdir("resourceassessment/".$mid."/".$id,0777,true);
			
			if (is_uploaded_file($_FILES["assessment"]["tmp_name"]) ) {

			move_uploaded_file($_FILES['assessment']['tmp_name'], "resourceassessment/".$mid."/".$id."/".$assessment);

				}

				

if($sql){

$content='Successfully uploaded your Bench Resource. Upload more Resources Below';

}

else{

$content='Error - If you have difficulties, please use our live chat widget at bottom right corner to talk to us directly';

}

}

$sql=mysqli_query($link,"select * from citybycountry where country='UK'");

while($res=mysqli_fetch_array($sql)){

$row[]=$res;

}

?>

<!doctype html>

<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rec-Rec India | Employers Hub</title>

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

<div class="logo">

<a class="navbar-brand" href="#"><img src="images/color-logo.png"></a>

<!--<a class="btn btn-primary" href="postdashboard">

Helpline number +44 02030267557

</a>-->

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
    
    <h4>Recruiters Marketplace Section</h4>

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


<br>
<div class="col-md-10 table-responsive">
<div class="account-navi-content">
               <div class="panel panel-default">
                <header class="panel-heading wht-bg ui-sortable-handle">
    <h3 class="text-center"> <b>Hire a Recruiter in India</b> - Fixed Fee Plans  <a href="rec-rec">Or Click here to Hire a Recruiter in the UK</a>  <a href="rec-rec-us">Or Click here to Hire a Recruiter in the US</a></h3>
  </header>
        <div class="panel-body">
               <section class="price-table">


                    <div class="table-pricing">
  <div class="col-md-4 col-sm-12 col-xs-12">
 <div class="pricing-header ">
  <p class="pricing-title">Hire a Junior Recruiter @</p>
   <p class="pricing-rate"> Rs.20,000 <span>Monthly</span> <span class="exclides-vat">+ 18% GST </span> </p>
  <p class="description">For Startups likely to fill 5 roles a month</p>
<br>
<form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_JYlcZ4epWihcIh" async> </script> </form>

<input type="hidden" name="plan" value="Basic"  />

  
  </form>
 </div>
 <div class="pricing-list ">
    <ul>
 <li><i class="fa fa-user"></i>Qualified India Junior Recruiter (1-3 years exp)</li>
 <li><i class="fa fa-users"></i>Over 2000 India Recruiters registered with us. We will assign you the best Recruiter </li>
 <li><i class="fa fa-money"></i>Save over Rs.1 lakh in Placement fees Monthly</li>
    <li><i class="fa fa-linkedin"></i>Recruiter will have Linkedin Recruiter lite. </li>
    <li><i class="fa fa-search"></i>You will need to provide job board access. </li>
      <li><i class="fa fa-male"></i>Recruiter Starts in 3 days working remotely</li>
      <li><i class="fa fa-inr"></i>You pay us and we pay the recruiter</li>
      <li><i class="fa fa-male"></i>Onsite based commutation expenses paid extra by you directly to recruiter</li>
      <li><i class="fa fa-stop"></i>Monthly rolling contract unless cancelled with 2 weeks notice</li>
      <li><form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_JYlcZ4epWihcIh" async> </script> </form></li>
      <li><i class="fa fa-inr"></i><a href="https://www.recruitinghub.com/bankdetails" target="_blank">Or Click here to pay into our bank account directly </a></li>
    </ul>
  </div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">Hire a Senior Recruiter @</p>
  <p class="pricing-rate"> Rs.40,000 <span>Monthly</span> <span class="exclides-vat">+ 18% GST </span> </p>
  <p class="description">For Mid size Companies looking to fill over 10 roles a month</p>
  
    <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_JYljyD4XKPhH4v" async> </script> </form>

<input type="hidden" name="plan" value="Advanced"  />

  
  </form>
 </div>
 <div class="pricing-list ">
    <ul>
<li><i class="fa fa-user"></i>Qualified India Senior Recruiter (3-8 years exp)</li>
<li><i class="fa fa-users"></i>Over 2000 India Recruiters registered with us. We will assign you the best Recruiter </li>
<li><i class="fa fa-money"></i>Save over Rs.5 lakhs in Placement fees Monthly</li>
   <li><i class="fa fa-linkedin"></i>Recruiter will have Linkedin Recruiter lite </li>
   <li><i class="fa fa-search"></i>You will need to provide job board access. </li>
      <li><i class="fa fa-male"></i>Recruiter Starts in 3 days working remotely</li>
      <li><i class="fa fa-inr"></i>You pay us and we pay the recruiter</li>
      <li><i class="fa fa-male"></i>Onsite based commutation expenses paid extra by you directly to recruiter</li>
     <li><i class="fa fa-stop"></i>Monthly rolling contract unless cancelled with 2 weeks notice</li>
     <li> <form><script src="https://checkout.razorpay.com/v1/payment-button.js" data-payment_button_id="pl_JYljyD4XKPhH4v" async> </script> </form></li>
      <li><i class="fa fa-inr"></i><a href="https://www.recruitinghub.com/bankdetails" target="_blank">Or Click here to pay into our bank account directly </a></li>
    </ul>
  </div>
</div>
<div class="col-md-4 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">RPO</p>
  <p class="pricing-rate"> Chat to discuss </p>
  <p class="description">For companies looking to ramp up hiring</p>
  
 <a class="subs-button" href="#">Click Live Chat below to talk to us </a> </div>
 <div class="pricing-list ">
    <ul>
      <li><i class="fa fa-fw fa-files-o"></i>Fill over 100 roles a month</li>
      <li><i class="fa fa-suitcase"></i>You pay a Retainer fee (deposit) upfront based on hiring numbers we agree on a call</li>
      <li><i class="fa fa-suitcase"></i>All successful placement fees will be deducted from the retainer fee. No extra cost</li>
      <li><i class="fa fa-users"></i>Dedicated Account Manager & Recruitment Team support</li>
      <li><i class="fa fa-users"></i>We will manage the entire recruitment process for you working closely with your hiring managers</li>
      <li><i class="fa fa-unlock-alt"></i>Instant start</li>
      <li><i class="fa fa-phone"></i>Talk to us now. Use the live chat button at bottom</li>
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

<script>


$('[name=cv]').change((e)=>{

var formData = new FormData();
formData.append('file', e.target.files[0]);

function objectExtract (data){

let arr =[]
 for(key in data) {
    if(data.hasOwnProperty(key)) {
        arr.push(data[key]);
    }
}
return arr.join()

}

$.ajax({
type: "POST",
url: "../parser/index.php",    
contentType: false,
processData: false,
data: formData,
success: function (data) {
 // alert(data);

console.log(data);
if(data.length > 0){
  let result = JSON.parse(data);

  let {text,name,email,mobile,location,country,skills,exp} = result[0]

 
  if(name && $('[name="consultant"]').val() === ''){

    $('[name="consultant"]').val(name);
  }
//   if(mobile){
//     $('[name=contactnumber]').val(mobile[0]);
//   }
//   if(email){
//     $('[name="email"]').val(email[0]);
//   }
  if(location){
    $('[name="currentloc"]').val(location[0]);
  }
  if(country){
    $('[name="country"]').val(country[0]);
  }
  if(skills && typeof skills === 'object'){
   // objectExtract()
    $('[name="skills"]').val(objectExtract(skills))
  }

  // if(exp){

  //   $('[name="country"]').val(country[0]);
  //   objectExtract(skills)
  // }

  if(exp){

    $('[name="totalexp"]').val(exp[0].split(' ')[0]);
   // objectExtract(skills)
  }

  


}
    
  }
});

//console.log(formData)
})
</script>


<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq ||
{widgetcode:"1f8211f2f5aa69bfd2e64274cb249d69f747f435e0dfe9837445d3ed8ad8672546be72282208d9c4fa10ef18b9f5d348", values:{},ready:function(){}};
var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;
s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>

</body>

</html>

