<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$email='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
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
$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];
$res=mysqli_query($link,"select sector,id from jobsectors");
if(mysqli_num_rows($res)){
	while($row=mysqli_fetch_assoc($res)){
		$sector[]=$row;
	}
}
$content='';
$companyres = mysqli_query($link,"SELECT a.id as id,a.name as companyname, a.sectors as sectors,a.profile as companyprofile,b.firstname as name,a.address1,a.address2,a.address3,a.town,a.postcode,a.phone,a.benname,a.benbank,a.bensort,a.benacc,a.benswift,a.taxinfo,a.description,a.logo as logo,a.website,a.country,a.state, b.designation as designation,b.location as location,b.experience as experience FROM companyprofile a,members b WHERE a.id= b.companyid and b.memberid='$mid'"); 
$issubmitted = mysqli_num_rows($companyres);
if($issubmitted > 0){ 
    while($row = mysqli_fetch_array($companyres)){ 
		$company=$row;
				}
}
else
$content="No data.";
$tit= htmlspecialchars_decode($company['companyname'],ENT_QUOTES);
						$urlpart=str_replace(' ','-', strtolower ("$tit"));
						$urlpart=preg_replace('/[^A-Za-z0-9\-]/', '',$urlpart);
						$urlpart=str_replace('--','-', $urlpart);
?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>UK Franchise Payment | Recruiters Hub</title>
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
    <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging (<span class="label-primary"><?php echo $new; ?></span>)</a>    </li>
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
<li><a href="hire-resource" role="tab" > <i class="fa fa-database"></i>Bench Hiring </a> </li>
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
 
	

    <div class="col-md-12 ui-sortable no-padding">
      

	<div class="panel panel-default">
      <header class="panel-heading wht-bg ui-sortable-handle">
        <h3 class="text-center"><b>PAY TO BECOME OUR FRANCHISE IN THE UK </b></h3>
      </header>
      <div class="panel-body">
              <div class="row results-table-filter">
                <div class="col-md-12">               
                    
                  </div>
                  
           <!--Contact Form-->
           
           <h4 class="text-center" style="color: #783293;">You have been re-directed to this page to Pay to become our Franchise. We have also sent an email with all details regarding our franchise business.<br><br> 
           
           
               <div class="panel-body">
               <section class="price-table">


                     <div class="table-pricing">
  <div class="col-md-6 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">UK Franchise (We Market You)</p>
   <p class="pricing-rate"> £ 25,000   <span>One Off</span> <span class="exclides-vat">+ 20% VAT </span> </p>
  <p class="description">Launch/Grow your Recruitment Business through us</p>
<!--  <div class="clearfix"></div><div class="terms-of-business">
        by clicking this button I agree to the <a class="title" href="#" data-toggle="modal" data-target="#employer-terms">Terms of Service </a>
      </div>-->
      <!--<form method="post" name="bsubscribe" action="employers">

<input type="hidden" name="plan" value="Basic"  />

  <input type="submit" name="subscribe" class="subs-button" value="Pay Now">-->
  
<a class="subs-button" href="https://pay.gocardless.com/BRT00032SMXYADS" target="_blank"> Pay Now </a>

<input type="hidden" name="plan" value="Basic"  />

  
  </form>
 </div>
 <div class="pricing-list ">
    <ul>
 <li><i class="fa fa-filter"></i>We will use a portion of the franchise fee to  generate leads from within your territoty and sign up an average 5-7 new clients per month</li>
<li><i class="fa fa-arrows"></i>Through our marketing efforts we will sign up new clients in your territory <br>and help you acquire new clients from both inside and outside your territory using your unique Employer Sign Up link</li>
 <li><i class="fa fa-gbp"></i>An average earning potential of £7000/resource in your team per month </li>
  <li><i class="fa fa-chain"></i>Take full advantage of our software automation in the external recruitment industry </li>
 <li><i class="fa fa-users"></i>Over 4000 Recruitment Vendors to support delivery of candidates</li>
 
  <li><i class="fa fa-support"></i>We provide full IT,Admin,Sales,Marketing,Client Payment Collection support</li>
  
  <li><i class="fa fa-rocket"></i>ROI: Your full investment return in 2 months based on just 6 placements given an average UK Placement fee as £5k per permanent placement. </li>
  
      <li><i class="fa fa-gbp"></i><a href="https://www.recruitinghub.com/bankdetails" target="_blank">Use Pay Now button or Click here to pay into our bank account directly </a></li>
      
    <!--   <li>  <a class="subs-button center" href="https://pay.gocardless.com/BRT00032SMXYADS" target="_blank"> Pay Now </a> </li>-->
    </ul>
  </div>
</div>

<div class="col-md-6 col-sm-12 col-xs-12">
  <div class="pricing-header ">
  <p class="pricing-title">UK Franchise (You Market Yourself)</p>
   <p class="pricing-rate"> £ 15,000   <span>One Off</span> <span class="exclides-vat">+ 20% VAT </span> </p>
  <p class="description">Launch/Grow your Recruitment Business through us</p>
  <!--<div class="terms-of-business">by clicking this button I agree to the <a class="title" href="#" data-toggle="modal" data-target="#employer-terms">Terms of Service </a> </div> <br> <br>-->
   <a class="subs-button" href="https://pay.gocardless.com/BRT0003A6FEV7Y4" target="_blank"> Pay Now </a>
<input type="hidden" name="plan" value="Advanced"  />

  
  </form>
 </div>
 <div class="pricing-list ">
    <ul>
<li><i class="fa fa-filter"></i>YOU will generate leads from within your territoty and sign up an average 5-7 new clients per month</li>
<li><i class="fa fa-arrows"></i>Through your marketing efforts you will sign up new clients in your territory <br>and acquire new clients from both inside and outside your territory using your unique Employer Sign Up link</li>
 <li><i class="fa fa-gbp"></i>You have an average earning potential of £7000/resource in your team per month </li>
  <li><i class="fa fa-chain"></i>Take full advantage of our software automation in the external recruitment industry </li>
 <li><i class="fa fa-users"></i>Over 4000 Recruitment Vendors to support delivery of candidates</li>
 
  <li><i class="fa fa-support"></i>We provide full IT,Admin,Sales,Marketing,Client Payment Collection support</li>
  
  <li><i class="fa fa-rocket"></i>ROI: Your full investment return in 2 months based on just 6 placements given an average UK Placement fee as £5k per permanent placement. </li>
  
      <li><i class="fa fa-gbp"></i><a href="https://www.recruitinghub.com/bankdetails" target="_blank">Use Pay Now button or Click here to pay into our bank account directly </a></li>
      
    <!--   <li>  <a class="subs-button center" href="https://pay.gocardless.com/BRT00032SMXYADS" target="_blank"> Pay Now </a> </li>-->
    </ul>
  </div>
</div>

                        </div>



                    </div>

                </form>
<!--Contact End-->

<!-- custom script -->


<script>

$(function() {

$('#submit_btn').click(function(){	

var name = $("input#your_name").val();

var cname = $("input#your_cname").val();

var email = $("input#your_email").val();

var mobile = $("input#your_mobile").val();

var city = $("input#your_city").val();

var country = $("input#your_country").val();

var linkedin = $("input#your_linkedin").val();

var message = $("textarea#message").val();





var name = $("input#your_name").val();

  		if (name == "") {

       // $("label#fname_error").show();

        $("input#your_name").focus();

        return false;

      }

var cname = $("input#your_cname").val();

  		if (cname == "") {

       // $("label#fname_error").show();

        $("input#your_cname").focus();

        return false;

      }

var mobile = $("input#your_mobile").val();

  		if (mobile == "") {

        //$("label#lname_error").show();

        $("input#your_mobile").focus();

        return false;

      }

var email = $("input#your_email").val();

  if (email.trim() == "") {

	$("span#your_email_error").removeAttr('style');

	$("input#your_email").focus();

	return false;

  } else {

	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

	if (!reg.test(email)) {

		$("span#your_email_error").removeAttr('style');

	  return false;

        }



	 } 

var city = $("input#your_city").val();

  		if (city == "") {

       // $("label#fname_error").show();

        $("input#your_city").focus();

        return false;

      }
      
var country = $("input#your_country").val();

  		if (country == "") {

       // $("label#fname_error").show();

        $("input#your_country").focus();

        return false;

      }

var linkedin = $("input#your_linkedin").val();

  		if (linkedin == "") {

       // $("label#fname_error").show();

        $("input#your_linkedin").focus();

        return false;

      }

var message = $("textarea#message").val();

  		if (message == "") {

       // $("label#message_error").show();

        $("textarea#message").focus();

        return false;

      }



	 

var dataString = 'name='+ name + '&cname='+ cname + '&mobile='+ mobile +'&email='+ email +'&city='+ city +'&country='+ country +'&linkedin='+ linkedin + '&message=' + message;

  $.ajax({

    type: "POST",

    url: "send-franchise.php",

    data: dataString,

    success: function(data) {

      //$('#contact_form').html("<span id='message'></span>");

	 if(data=="<div class='msg-sent'>Your Message has been sent Successfully!.</div>"){

      $('#contact_form').html(data)

      //.append("<p>Agent will be in touch soon.</p>")

      

	  }else{

	$('#contact_form').html(data);

	}

    }

	

  });

 //return false;

    });

});

</script>


                </div>
       </div>
       
	   </div>



   
  
  
  

</div>
       
	   </div>
  
  </div>
    <div class="col-md-5 column ui-sortable no-padding-right">
    
 
  </div>
</div>
</div>
</div>             

     <div class="clearfix"></div>
     </div>
     </div>
<div class="clearfix"></div>

</div>
</div>
</div>

<script>
		(function(){
			  var words = [
				  '"<b>Current Trend</b>',
				  '"<b>Future</b>'
				  ], i = 0;
			  setInterval(function(){
				  $('#changingword').fadeOut(function(){
					  $(this).html(words[i=(i+1)%words.length]).fadeIn();
				  });
			  }, 3000);
				
		  })();
	</script>
	
	<script>
		(function(){
			  var words = [
				  '"<b>Launch</b>',
				  '"<b>Grow</b>'
				  ], i = 0;
			  setInterval(function(){
				  $('#changingwordssss').fadeOut(function(){
					  $(this).html(words[i=(i+1)%words.length]).fadeIn();
				  });
			  }, 3000);
				
		  })();
	</script>

<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || 
{widgetcode:"1f8211f2f5aa69bfd2e64274cb249d69f747f435e0dfe9837445d3ed8ad8672546be72282208d9c4fa10ef18b9f5d348", values:{},ready:function(){}};
var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;
s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>

 </body>
</html>
