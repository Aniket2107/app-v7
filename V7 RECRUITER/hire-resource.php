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
}
else{
$notification='Please login to access the page';
$_SESSION['notification']=$notification;
header('location: login'); 
exit;
}
$content=$noti='';
require_once '../config.php';
require_once '../ps_pagination.php';
$nb_new_pm = mysqli_fetch_array(mysqli_query($link,'select count(*) as new_msg_count from personalmsg where ((fromuser="'.$mid.'" and fromread="no") or (touser="'.$mid.'" and toread="no")) and conversationid="1"'));
$new = $nb_new_pm['new_msg_count'];
$employers=array();
//$prm=0;
$keyres=$skillsres=$countryres=$locres=$expres=$availres=$visares='';
if(isset($_GET['search'])){

if(isset($_GET['keyword'])&&($_GET['keyword']!='')){
$keyword=$_GET['keyword'];
//if($prm>0)
$keyres="and ((jobtitle like '%$keyword%')||(consultant like '%$keyword%')||(cv1 like '%$keyword%')||(skills like '%$keyword%'))";
//$keyres="and jobtitle like '%$keyword%'";
//else
//$keyres="jobtitle like '%$keyword%'";
}

if(isset($_GET['skills'])&&($_GET['skills']!='')){
$skills=$_GET['skills'];
//if($prm>0)
$skillsres="and skills like '%$skills%'";
//else
//$skillsres="skills like '%$skills%'";
}

if(isset($_GET['country'])&&($_GET['country']!='')){
$country=$_GET['country'];
//if($prm>0)
$countryres="and country ='$country'";
//else
//$countryres="country like '%$country%'";
}

if(isset($_GET['loc'])&&($_GET['loc']!='')){
$loc=$_GET['loc'];
//if($prm>0)
$locres="and currentlocation ='$loc'";
//else
//$locres="currentlocation like '%$loc%'";
}

if(isset($_GET['exp'])&&($_GET['exp']!='')){
$exp=$_GET['exp'];
//if($prm>0)
$expres="and totalexperience  like '%$exp%'";
//else
//$expres="totalexperience like '%$exp%'";
}

if(isset($_GET['avail'])&&($_GET['avail']!='')){
$avail=$_GET['avail'];
//if($prm>0)
$availres="and availability  like '%$avail%'";
//else
//$availres="availability like '%$exp%'";
}
if(isset($_GET['visa'])&&($_GET['visa']!='')){
$visa=$_GET['visa'];
//if($prm>0)
$visares="and visa  like '%$visa%'";
//else
//$availres="availability like '%$exp%'";
}
}
$empres=mysqli_query($link,"SELECT * from resource where 1 $keyres $skillsres $countryres $locres $expres $availres $visares order by postdate desc");

$param="";
$params=$_SERVER['QUERY_STRING'];
if (strpos($params,'page') !== false) {
    $key="page";
	parse_str($params,$ar);
	$param=http_build_query(array_diff_key($ar,array($key=>"")));
}
else
$param=$params;

$pager = new PS_Pagination($link, $sql, 10, 10, $param);
$res = $pager->paginate();
if(@mysqli_num_rows($res)){
	while($rows = mysqli_fetch_assoc($res)){
		$jobarray[] = $rows;
	}
}
$pages =  $pager->renderFullNav();
$total= $pager->total_rows;

if(mysqli_num_rows($empres)){
while($row=mysqli_fetch_assoc($empres)){
$employers[]=$row;
}
}
else{
$noti='No Resources found.';
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
        <title>Bench Hiring | Recruiters Hub</title>
        <meta name="application-name" content="Recruiting-hub" />
        <link rel="icon" type="image/favicon.png" href="https://www.recruitinghub.com/images/favicon.png" />
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/fonts/css/font-awesome.min.css" media="screen, projection">
        <link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.custom.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
        
          <style>
          .page_link {  display: inline-block;  }.page_link a {  color: black;  float: left;  padding: 5px 16px; background:#eee; text-decoration: none;}
          .page_link a.active {
  background-color: #4CAF50;
  color: white;
}

.page_link a:hover:not(.active) {background-color: #ddd;}

          </style>
          
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
/**if($rcountry=='India'){echo'
<li><a href="subscription_plans"><i class="fa fa-money"></i> Manage Subscription</a></li>';}
else{echo'
<li><a href="subscription-plans"><i class="fa fa-money"></i> Manage Subscription</a></li>';
}echo'
<li><a href="subscription-status"><i class="fa fa-info-circle"></i> Subscription Status</a></li>
<li><a href="subscription-history"><i class="fa fa-history" aria-hidden="true"></i> Subscription History</a></li>  ';**/
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
<li><a href="add_new" role="tab" ><i class="fa fa-fw fa-plus-square"></i>Add New Candidate</a>  </li>
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


<div class="row">
<div class="col-xs-12">
<section  class="panel panel-default">
<header class="panel-heading panel-heading--buttons wht-bg">
<h4 class="gen-case">Search our Database of Bench Resources UPLOADED BY EMPLOYERS</h4>
</header>
<div class="panel-body minimal">			
<div class="table-responsive ">
<div class="col-sm-12">
    
                <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <div class="form-group">

                <div class="col-sm-3">

                <input name="keyword" class="form-control" placeholder="Search by Keyword"  type="text">

                </div>
                
          <!--      <div class="col-sm-2">

                <input name="skills" class="form-control" placeholder="Search by Skills"  type="text">

                </div> -->

                                <div class="col-sm-2">



                <select class="form-control" name="country">

<option value="">Choose Country</option>

<option value="UK">UK</option>

<option value="US">US</option>

<option value="Middle East">Middle East</option>

<option value="India">India</option>

<option value="Europe">Europe</option>

<option value="Africa">Africa</option>

<option value="Malaysia">Malaysia</option>

<option value="Singapore">Singapore</option>

<option value="China">China</option>

<option value="Thailand">Thailand</option>

<option value="Indonesia">Indonesia</option>

<option value="Australia">Australia</option>

<option value="Philippines">Philippines</option>

<option value="Hong Kong">Hong Kong</option>

<option value="Japan">Japan</option>

<option value="New Zealand">New Zealand</option>

<option value="North Korea">North Korea</option>

<option value="South Korea">South Korea</option>

<option value="Russia">Russia</option>

<option value="Canada">Canada</option>

<option value="Mexico">Mexico</option>

<option value="South America">South America</option>

</select>

</div>

                <div class="col-sm-2">

                <input name="loc" class="form-control"  placeholder="Search by City" type="text">

                <!--<select name="loc" class="form-control"  placeholder="Search by Location" type="text">

                <option value="">Location</option>

                <?php 

                foreach($row as $c){

                echo '<option value='.$c['city'].'>'.$c['city'].'</option>';

                }

                ?>

                </select>-->

                

                </div>

                <!--<div class="col-sm-2">

                <input name="exp" class="form-control" placeholder="Experience" autocomplete="off" type="text">

                </div> -->

                <div class="col-sm-2">

                <select name="avail" class="form-control" placeholder="Search by Availability" autocomplete="off" type="text">									

                <option value="">Availability</option>

                <option value="Immediate">Immediate</option>

                <option value="2 Weeks Notice">2 Weeks Notice</option>

                </select>

                </div> 

                

                

                <!--</div></div><div class="col-sm-12">

                                <div class="form-group">



                <div class="col-sm-3">

                <input name="visa" class="form-control" placeholder="Visa Status" type="text">-->

                <!--<select name="visa" class="form-control" placeholder="Visa Status" autocomplete="off" type="text">									

                <option value="">Visa</option>

                <option value="British/ILR">British/ILR</option>

                <option value="Tier1 General">Tier1 General</option>

                <option value="Tier2 General">Tier2 General</option>

                <option value="Tier2 General Dependant">Tier2 General Dependant</option>

                <option value="Tier2 ICT">Tier2 ICT</option>

                <option value="Tier2 ICT Dependant">Tier2 ICT Dependant</option>

                <option value="EU Citizen">EU Citizen</option>

                </select>-->

                </div> 

                <div class="col-sm-2">

                <input value="Search" class="btn btn-primary" name="search" type="submit">

                </div>

                </div>

                </div>  

                </form>                                          
</div>

<!--<h3>Total Available Bench Resource:<?php echo $total; ?></h3>-->

				<?php if($noti){ echo $noti; }else{ ?>
                <table class="table table-striped">
                <thead>
                <tr>
                
                <th>Consultant</th>
                <th>Title</th>
                <th>Action</th>
                <th>Total Exp</th>
                <th>Location</th>
                <th>Availability</th>
                <th>Visa Status</th>
                
                
                
                </tr>
                </thead>
                
                
                <tbody>
                <?php
                foreach($employers as $row){ $reid=$row['id']; $statussql=mysqli_fetch_assoc(mysqli_query($link,"select * from resourceengagedetails where resourceid=$reid and engagedby=$mid limit 0,1"));
			    $sql1=mysqli_query($link,"select * from resourceengagedetails where resourceid=$reid and engagedby=$mid limit 0,1");
				$cnt=mysqli_num_rows($sql1);
                echo'
                <tr>
                <td ><b><a class="title" href="#" data-toggle="modal" data-target="#candidate-modal" id='.$row['id'].'>'.$row['consultant']. ' </a></b><br>';	
  	 {echo date("j F, Y",strtotime($row['postdate']));}
  	echo '
                </td>
                <td >'.$row['jobtitle'].'</td>';
                if(($statussql['finalstatus']==1)&&($statussql['engagestatus']==1)){ echo'<td><a class="title" href="#" data-toggle="modal" data-target="#resource-modal" id="'.$row['id'].'"><b>(APPROVED) View Resource Details</b></a></td>'; }elseif(($statussql['finalstatus']=='')&&($statussql['engagestatus']==1)){echo '<td>Requested</td>'; }elseif(($statussql['finalstatus']==0)&&($statussql['engagestatus']==1)){echo '<td>Not Approved</td>'; }elseif(!$cnt){echo '<td>
                <div class="btn-group">
				
                <a class="title" href="engage-resource?resrcid='.$row['id'].'"><b>Engage</b></a>
                
                </div>
                </td>
                
                <td >'.$row['totalexperience'].'</td>
                <td >'.$row['currentlocation'].' <br>'.$row['country'].'</td>
                <td >'.$row['availability'].'</td>
                <td >'.$row['visa'].'</td>
                
         
                </tr>';
                }
				}
                ?>
                </tbody>
                </table>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
</section>
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
    
<div class="modal fade" id="feedback-modal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content" id="feedback-modal-body">
</div>
</div>
</div>

<div class="modal fade" id="resource-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="resource-modal-label"></h4>
          </div>
          <div class="modal-body" id="resource-modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

<script>
	$('#candidate-modal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            essayId = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'resource-detail.php',
            data: 'EID=' + essayId,
            success: function(data) {
				$modal.find('#candidate-modal-body').html(data);
                $modal.find('#candidate-modal-label').html( $('#candidate_name').data('value'));
				
            }
        });
    });
</script>

<script>
$('#resource-modal').on('show.bs.modal', function(e) {
        var $modal = $(this),
            essayId = e.relatedTarget.id;
        $.ajax({
            cache: false,
            type: 'POST',
            url: 'resource-modal.php',
            data: 'EID=' + essayId,
            success: function(data) {
				$modal.find('#resource-modal-body').html(data);
                $modal.find('#resource-modal-label').html( $('#job_title').data('value'));
				
            }
        });
    });
$('#feedback-modal').on('show.bs.modal', function(e) {
var $modal = $(this),
element=$(e.relatedTarget),
essayId = element.attr('id'),
cname=element.data('id');
$.ajax({
cache: false,
type: 'POST',
url: 'feedback-modal.php',
data: { EID : essayId,cname : cname},
success: function(data) {
$modal.find('#feedback-modal-body').html(data);
}
});
});
</script>

</body>
</html>

