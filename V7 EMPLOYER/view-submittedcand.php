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
$adminrights=$_SESSION['adminrights'];
$admin=$_SESSION['admin'];
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
if(isset($_GET['jobid']) && ($_GET['recruiterid'])){
$jid=$_GET['jobid'];
$rid=$_GET['recruiterid'];
}
$sql="select * from  appliedjobs  where recruiterid='$mid' and jobapplied='$jid' order by applieddate desc";

$param="";
$params=$_SERVER['QUERY_STRING'];
if (strpos($params,'page') !== false) {
    $key="page";
	parse_str($params,$ar);
	$param=http_build_query(array_diff_key($ar,array($key=>"")));
}
else
$param=$params;
include('../ps_pagination.php');
$pager = new PS_Pagination($link, $sql, 20, 10, $param);
$candidateres = $pager->paginate();
if(@mysqli_num_rows($candidateres)){ 
    while($row = mysqli_fetch_array($candidateres)){
			$candidatearray[]=$row;
				}
$pages =  $pager->renderFullNav();
}
else 
$candidatemsg="No candidates applied for the job you posted.";
?>
<!doctype html>
<html>
<head>
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Active Jobs | Employers Hub</title>
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
<a class="btn btn-primary" href="submit-a-job">
     Helpline number +44 02030267557
</a>
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
  <li><a href="dashboard" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Dashboard</a></li>
  <li><a href="submit-a-job" role="tab"><i class="fa  fa-fw fa-plus"></i>Post New Job</a></li>
  <li><a href="requests" role="tab"><i class="fa  fa-fw fa-tachometer"></i>Request from Agencies</a></li>

     <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu" data-toggle="collapse" aria-controls="candidatesDropdownMenu" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Jobs</a>

   <div class="collapse" id="candidatesDropdownMenu">
   <ul class="nav-sub" style="display: block;">
    <li><a href="submit-a-job" role="tab" ><i class="fa fa-fw fa-plus-square"></i> Post New Job</a>  </li>
   <li><a href="jobs" role="tab" ><i class="fa fa-list"></i> Active</a> </li>
    <li><a href="inactive" role="tab" ><i class="fa fa-list"></i> Inactive</a> </li>
    <li><a href="closed" role="tab" ><i class="fa fa-clock-o"></i> Closed</a>  </li>
    <li><a href="filled" role="tab" > <i class="fa fa-users"></i> Filled</a>  </li>
  
    </ul>
   </div>
   </li>
     <li class="candidates-nav nav-dropdown ">
  <a href="#candidatesDropdownMenu1" data-toggle="collapse" aria-controls="candidatesDropdownMenu1" title="Candidates" class="navbar-root your-candidates">
    <i class="fa fa-fw fa-caret-right"></i> Candidates (ATS)</a>

   <div class="collapse" id="candidatesDropdownMenu1">
   <ul class="nav-sub" style="display: block;">
   
    <li><a href="all" role="tab" ><i class="fa fa-list"></i> All</a> </li>
    <li><a href="awaiting-feedback" role="tab" ><i class="fa fa-clock-o"></i> Awaiting feedback</a>  </li>
    <li><a href="shortlist" role="tab" > <i class="fa fa-users"></i> Shortlisted</a>  </li>
        <li><a href="offer" role="tab" > <i class="fa fa-envelope"></i> Offer</a> </li>
    <li><a href="rejected" role="tab" > <i class="fa fa-trash"></i> Rejected</a> </li>
    </ul>
   </div>
   </li>
   
     <li><a href="msg" role="tab" ><i class="fa fa-fw fa-envelope-o"></i> Messaging (<?php echo $new; ?>)</a>    </li>
   <li><a href="rating" role="tab" > <i class="fa fa-users"></i> Feedback Rating</a> </li>
 <li><a href="psl-list" role="tab" > <i class="fa fa-list"></i> PSL</a> </li>
 <li><a href="company-profile" role="tab" > <i class="fa fa-plus"></i>Company Profile</a> </li>
 <li><a href="add-user" role="tab" > <i class="fa fa-plus"></i>Add Users</a> </li>
 <li><a href="view-all-resource-engagement" role="tab" > <i class="fa fa-database"></i>Request for Your Bench Resources <span class="label label-primary">Free</span></a> </li>  
    <li><a href="resources" role="tab" > <i class="fa fa-database"></i>Bench Hiring <span class="label label-primary">Free</span></a> </li>  </ul>
   
</div>
</div>

<div class="col-sm-10">
<div class="account-navi-content">
  <div class="tab-content">

    <section class="main-content-wrapper">
      


  <div class="row">
    <div class="col-xs-12">
   
                    <a class="btn btn-primary" href="submit-a-job">
    <i class="fa fa-plus"></i> Post New Job
</a>
      
      <div class="panel panel-default">
      <header class="panel-heading wht-bg ui-sortable-handle">
    <h3 class="panel-title"> Manage Submissions for <?php $s=mysqli_fetch_assoc(mysqli_query($link,"select jobtitle from jobs where jobid=$jid and memberid=$mid")); echo $s['jobtitle']; ?></h3>
  </header>
  
  <div class="panel-body">
        <div class="text-left">
 Go to -> <a href="submit-a-job" id="one">POST NEW JOB</a> -> <a href="jobs" id="two"><strong>ACTIVE</strong></a></a> -> <a href="inactive" id="three">INACTIVE (HOLD)</a> -> <a href="closed" id="four">CLOSED</a> -> <a href="filled" id="five">FILLED</a>  
</div>

        <div class="panel-body">

          <div class="row">
            <div class="col-md-12 table-responsive">
              <?php if(!$content){ ?>
              <div class="col-sm-12">
             <form method="GET" action="view-submittedcand" >
       <div class="form-group">
        
        
        </div>
        </div>  
        </form>
              </div>
              <h3>Total Results:<?php echo $total; ?></h3>
                <table class="table table-striped jobs-list">
                  <thead>
                    <tr>
                      <th>Candidate Name/ID</th>
                  <th>Job Title/ID</th>
                  <?php if($adminrights) { ?>
                  <th>Job Owner</th>
                  <?php } ?>
                  <th>Agency Name/ID</th>
                  <th>Contact</th>
                  <th>Exp Salary/Rate</th>
                  <th>Status</th>
                  <th>Action</th>
                     
              </thead>
              <tbody>
                <?php
	    foreach($candidatearray as $row){
	        $reason=htmlspecialchars_decode($row['comment'],ENT_QUOTES);
				if($row['prestatus']=='Awaiting Feedback')
				$row['candidatestatus']="CV Rejected";
			elseif($row['prestatus']=='Shortlisted')
				$row['candidatestatus']="Interview Rejected";
				elseif($row['prestatus']=='Offered')
				$row['candidatestatus']="Offer Rejected";

        if($row['viewed'] == 0){
          $viewed = '<small style="
          font-size: 10px;
          color: #a02121;
      ">Yet to be Viewed</small>';
        }else{

          $viewed = '<small style="
          font-size: 10px;
          color: #21a048;
      "> Viewed on '.$row['viewedtime'].' </small>';

        }

			echo'
          <tr>
		 
 <td><a class="title" href="#" data-toggle="modal" data-target="#candidate-modal" id='.$row['candidateid'].'>'.$row['candidatename']. '</a> '.$viewed.'<br>
    <small>Submitted: '.$row['submitdate'].' / '.$row['candidateid'].'</small> |  '.$row['jobtype'].'</td>
	
	<td>'.$row['jobtitle'].'<br><small>'.$row['jobid'].'</small></td>';
	
  if($adminrights){
    echo '<td><b>'.$row['subuser'].'</b><br><small>'.$row['subuseremail'].'</small></td>';
  }

	
	 echo '<td><a class="title" href="#" data-toggle="modal" data-target="#recruiter-modal" id='.$row['registerid'].'>'.$row['agency'].'</a><br>
    <small>'.$row['recruiterid'].'</small> </td>
    
	<td>'.$row['contactnumber'].'</td>
  <td>'.$row['expectedcurrency'].''.$row['desiredsalary'].' '.$row['typesalary'].'</td>
  <td><span class="badge badge-default">'.$row['candidatestatus'].'</span></td>
  <td>';
  if($row['candidatestatus']=="Awaiting Feedback" || $row['candidatestatus']=="Shortlisted"){
	  	   echo'
    <div class="btn-group">
      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu--right" role="menu">';
	  	if($row['candidatestatus']=="Awaiting Feedback")
		{
		echo '
		    <li><a title="Select Candidate" href="select-candidate?candidateid='.$row['candidateid'].'">Shortlist</a></li>
			<li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>CV Reject</a></li>
			<li><a title="Mark as Duplicate" href="mark-duplicate-candidate?candidateid='.$row['candidateid'].'">Duplicate</a></li>';
			}
			else{
			 echo '<li><a title="Offer Candidate" href="offer-candidate?candidateid='.$row['candidateid'].'">Offer</a></li>
			 <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Interview Reject</a></li>';
			 }
			echo'
		</ul>
    </div>';
	}
	else {
		
	}
	echo '
  </td>
</tr>';
}
?>
</tbody>
</table>
  <?php echo $pages; } else echo $candidatemsg; ?> 
    </div>
   </div>
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
<div class="modal fade" id="engage-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="engage-modal-label"></h4>
          </div>
          <div class="modal-body" id="engage-modal-body">
          </div>
          <div class="modal-footer" id="engage-modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      		<a class="btn btn-primary" href=""> Edit Job </a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="engage-modal-label"></h4>
          </div>
          <div class="modal-body" id="engage-modal-body">
          </div>
         
        </div>
      </div>
    </div>
    <script>
    $('#engage-modal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            essayId = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'engage-modal-content.php',
            data: 'EID=' + essayId,
            success: function(data) {
				$modal.find('#engage-modal-body').html(data);
                $modal.find('#engage-modal-label').html( $('#job_title').data('value'));
				$modal.find('#engage-modal-footer a').attr("href", "edit-a-job?id="+ essayId);
            }
        });
    });
	
	 $('#view-modal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            essayId = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'view-recruiters.php',
            data: 'EID=' + essayId,
            success: function(data) {
				$modal.find('#engage-modal-body').html(data);
                $modal.find('#engage-modal-label').html( $('#job_title').data('value'));
				
            }
        });
    });
	 $('#engaged-agencies').on('show.bs.modal', function(e) {
        var $modal = $(this),
            essayId = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'engage-modal-content.php',
            data: 'EID=' + essayId,
            success: function(data) {
				$modal.find('#engage-modal-body').html(data);
                $modal.find('#engage-modal-label').html( $('#job_title').data('value'));
				
            }
        });
    })
	$( "#recruiter" ).autocomplete({
	minLength: 2,
	source:'rsearch.php',
	 response: function(event, ui) {
            // ui.content is the array that's about to be sent to the response callback.
            if (ui.content.length === 0) {
                $("#e").text("No results found");
            } else {
                $("#e").empty();
            }
    },
	change: function(event, ui) {
            if (!ui.item) {
               $(this).val('');
            }
    }
    });	
</script>

<script type="text/javascript">
var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || 
{widgetcode:"1f8211f2f5aa69bfd2e64274cb249d69f747f435e0dfe9837445d3ed8ad8672546be72282208d9c4fa10ef18b9f5d348", values:{},ready:function(){}};
var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;
s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);d.write("<div id='zsiqwidget'></div>");
</script>

 </body>
</html>
