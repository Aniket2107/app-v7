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
     <title>Franchise Advantages | Recruiters Hub</title>
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
        <h3 class="text-center"> Franchise Partner Benefits (<b>One time franchise setup fee apply</b> <a href="https://www.recruitinghub.com/recruiter/becomefranchise" ><b> APPLY NOW</b></a>)</h3>
      </header>
      <div class="panel-body">
              <div class="row results-table-filter">
                <div class="col-md-12">               
                    
                  </div>
                  
                  <p><b>Are you a good Account/Client Manager? Our franchise business is for YOU </b> <br><br>
                  
                      Within 25 miles radius of where you are is where all the monies are from Clients (Employers/Corporates) who require our product/services. You have Industrial/IT/Business/Science Parks & Commercial Complex that has 1000's of Companies around you and this is our target to reach. While 80% of everything we do as a SaaS platform is fully automated, the remaining 20% gap of human to human interaction, meeting the clients directly and managing the account is all that we require our franchise partners to fill. You can start locally and grow globally with all the tools and supply chain network we have established over the last 7 years.</p>
                  
                    <p style = "font-size: 16px;
            color: #21a021;"> Our recent Exhibition Stand 815 at International Franchise Show in Excel,London on 12th & 13th April 2024 <a href="https://www.recruitinghub.com/franchiseshow" target="_blank"><b> -> Click here</b></a> </p>
                  
                  <p>  <b>Download our Franchise Brochure from this link <a href="https://www.recruitinghub.com/Franchise%20Brochure%20-%20RecruitingHub.pdf" target="_blank">DOWNLOAD FRANCHISE BROCHURE</a></b> </p>


 Enjoy the benefits of our automation tools in B2B recruitment. <a href="https://www.recruitinghub.com/recruiter/becomefranchise"><b>Click here</b></a> for a product demo and we will setup a call to show you our platform and it's advantages to scale your recruitment business. We've got a fantastic B2B Recruitment VMS product that sits in between the Employers (Clients) and  Recruitment Vendors (Suppliers) helping Employers work with Recruitment Vendors to find candidates 2X faster. We currently have over 4000 recruitment vendors registered with us globally and by becoming our franchise partner we can help you grow your recruitment business faster through our smart automation tools. Recruitment is a big business in itself with Companies spending in billions on external recruitment vendors in each country to find candidates. We are approaching this market with a B2B marketplace tool aggregating Employers and Recruitment Agencies in 1 platform. By becoming our franchise partner in your city you are investing in to the future of the external recruitment industry. Imagine Amazon or Rightmove for Recruitment Agencies. <br><br>
 
<p> <b>We will transfer you clients already registered from within your territory and will be registering from your territory. You will own/manage clients to earn your franchise share from every single placement made from clients tagged to you. We will assign you an unique employer sign up link to acquire new clients from within your territory and from rest of the world and will provide you an Admin portal to manage clients and entire recruitment process.</b></p>
  
  We are currently having our legal entities in 3 Countries <b>UK | UAE | India </b> and they can be found here <a href="https://www.recruitinghub.com/bankdetails" target="_blank"><b>Our Companies</b></a><br><br>
  
  <p>  <b><a href="https://www.recruitinghub.com/Franchise%20Brochure%20-%20RecruitingHub.pdf" target="_blank">DOWNLOAD FRANCHISE BROCHURE</a></b> </p>
  
  <b><a class="btn btn-primary" href="https://www.recruitinghub.com/recruiter/becomefranchise" >Apply to become our Franchise Partner</a></b>
  

<p style = 'font-size: 16px;
            color: #a02121;'> <b>It will cost an ONE OFF franchise setup fee of</b></p>
            
<table class="table-bordered">

<tbody>
    
    <tr><th> <b>UK Franchise Fee:</b> <b>£25,000</b> + 20% VAT (we are looking to cover 48 counties in England, 33 in Scotland, 13 in Wales and 6 in N.Ireland)</th></tr>

<tr><td>(We can introduce you to our partners that can assist with government backed startup funding)</td></tr>

<tr><td>(The market size in UK, measured by revenue, of the Employment Placement Agencies industry was £17.7bn in 2022)</td></tr> 

<tr><td><b>ROI:</b> Your full investment return in 2 months based on just 6 placements given an average UK Placement fee as £5k per permanent placement.</td></tr> 

</tbody></table> <br>

<table class="table-bordered">

<tr><th> <b>India Franchise Fee:</b> <b>Rs.5 lakhs</b> + 18% GST for Tier1 Cities or <b>Rs.3 lakhs</b> + GST for Tier2 Cities. (We are looking to cover 300 cities in India)</th></tr>

<tr><td>(The Indian staffing market is currently a $10 billion industry, growing at 28% percent YoY and poised to become one of the largest by 2030)</td></tr>

<tr><td><b>ROI:</b> Your full investment return in 3 months based on just 12 placements given an average Indian Placement fee as Rs.50k per permanent placement.</td></tr>

</tbody></table> <br>

<table class="table-bordered">

<tr><th> <b>ROW (Rest of the World) Franchise Fee:</b>Equivalent to <b>£10,000</b></th></tr>

<tr><td>(The whole of recruitment market size is estimated at 750 billion USD) </td></tr>

<tr><td><b>ROI:</b> Your full investment return in 2 months based on just 3 placements given an average Placement fee as $5000 per permanent placement. </td></tr>

</tbody></table>
            
 <br>
   
   plus your regular monthly working capital (bills)<br><br>
   
   <a href="https://www.recruitinghub.com/recruiter/franchisepaymentpage" target="_blank"> <b>Pay for Franchise</b></a><br><br>
   
   <p style = 'font-size: 16px;
            color: #a02121;'> <b>What are you paying this one off fee for?</b></p>
   
   ▪ Software licensing Cost (read below the advantages)<br>
   ▪ Employer leads/New Client Acquisition<br>
   ▪ Access to over 4000 registered recruitment vendors on our platform worldwide who can supply candidates 2x faster to clients we onboard for you from within your territory or new clients you bring to the platform from within or outside your territory using your unique employer sign up link (we will provide you this link upon onboarding as our franchise partner)<br>
   ▪ Ownership of Clients originally signed up by you<br>
   ▪ Admin/CRM Portal access, RH email account, Live Chat facility etc<br>
   ▪ Product Training<br>
   ▪ Marketing Assistance<br>
   ▪ Accounts, Collection assistance<br>
   
   <br>
   
  <p style = 'font-size: 16px;
            color: #a02121;'> <b>What does our software automation in the entire recruitment process do to reduce your manual work in making placements faster?</b></p>
   
   ▪ Employers can sign up directly on our website or using your unique employer sign up link and create an employer account in less than 30 secs<br>
   ▪ Employers can post jobs in less than 1 min using our job parsing technology<br>
   ▪ When a job is posted by the employer our software algorithm will match the job and notify the PSL (Preferred Suppier List already added by the employer) & relevant recruitment agencies based on location and skills. We currently have a total on 4000 recruitment agencies registered with us in over 60 countries. <br>
   ▪ Automated email notifications will be sent for every single activity (e.g candidate submissions by engaged agencies, feedback update by employer, messaging/add notes used between employers & agencies) copying you (franchise partner) for employers tagged to you.<br>
   ▪ An automated feedback reminders sent Mon-Fri to employers tagged to you copying you in every reminder sent to the employer<br>
   ▪ An automated reminder sent to all employers tagged to you once a week reminding them to post new jobs.<br>
 
   
   <br>
   
   You can start remote, however having an office space is most preferred. We start with a 2 year franchise agreement auto renewed at the end of tenure without any renewal fee. You can view the standard agreement for Franchisee from this link <a href="Franchise Agreement - draft - RecruitingHub.pdf" target="_blank"><b>Franchisee Agreement</b></a><br><br>
   
    <p style = 'font-size: 16px;
            color: #a02121;'> <b>Revenue Model (What you will earn):</b></p>
    <b>60:20:20</b> split on every payment from your clients - 60% to Recruiter (Recruitment Agency that filled the vacancy, this could also be you), 20% to Franchise Partner (You), 20% to Recruiting Hub. If you filled the vacancy on your own for your client you will then earn 80% of the fee. A typical one person Franchisee can earn an average of £10,000 in the UK or Rs.2 lakhs in India or AED.20000 in UAE your share per month. Revenues will increase depending on your Sales & Account Management team size. Also the advantage of being our franchise partner is you get paid the same day as we get paid by the client which is typically (15days-60 days) unlike the 60 days or 90 days waiting period for recruitment vendors on our platform and unless the candidate has completed the replacement guarantee period.<br><br>
   
    <p style = 'font-size: 16px;
            color: #a02121;'> <b>Why would i pay a one off franchise setup fee to become a franchise partner when a recruitment vendor account is free to sign up?</b></p>
   This is one of the typical question we get from most of the interested franchise applicants. While a recruitment vendor registering on our platform for free becomes one among the 1000's of suppliers on the platform and do not own the clients whereas our franchise partners will own the client and enjoy the benefits of our automation tools and earn their share from every single placement made for their clients irrespective of which agency filled the vacancy + all the other benefits as mentioned above. <b>We will transfer you clients already registered from within your territory and will be registering from your territory and you will own/manage the clients and earn your franchise share from every single placement made from clients tagged to you. We will assign you an unique employer sign up link to acquire new clients from within your territory and from rest of the world and will provide you an Admin portal to manage clients and entire recruitment process.</b><br><br>
   
   <b><a class="btn btn-primary" href="https://www.recruitinghub.com/recruiter/becomefranchise" >Apply to become our Franchise Partner</a></b>
   
   <p>  <b><a href="https://www.recruitinghub.com/Franchise%20Brochure%20-%20RecruitingHub.pdf" target="_blank">DOWNLOAD FRANCHISE BROCHURE</a></b> </p>

<br> <br>

<b>Read more from our FAQS here <a href="https://www.recruitinghub.com/franchise" target="_blank"> Read FAQs</a></b>

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

  <!--<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || 
{widgetcode:"1f8211f2f5aa69bfd2e64274cb249d69f747f435e0dfe9837445d3ed8ad8672546be72282208d9c4fa10ef18b9f5d348", values:{},ready:function(){}};
var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;
s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>-->

 </body>
</html>
