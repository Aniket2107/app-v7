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
$job='';
require_once '../config.php';
require '../Smtp/index.php';
require '../helpers/general.php';

if(isset($_SESSION['mark'])){
$highlight=$_SESSION['mark'];
}else{
$highlight='';
}



if(isset($_POST['EID']))
$candidateid=$_POST['EID'];



$candidateres =mysqli_query($link,"SELECT a.*,b.email as recruiteremail,c.name as agency,sc.status as candidatestatus,sc.submitdate as submitdate,j.jobtitle as jobtitle,sc.candidateid as candidateid,sc.employernotes as employernotes,sc.employernotesdate as employernotesdate,sc.empduplicatenotes as empduplicatenotes,sc.empduplicatenotesdate as empduplicatenotesdate,sc.recduplicatenotes as recduplicatenotes,sc.comment as comment,sc.recduplicatenotesdate as recduplicatenotesdate,sc.recruiternotes as recruiternotes,sc.recruiternotesdate as recruiternotesdate,sc.amnotes as amnotes,sc.amnotesdate as amnotesdate,sc.recruiterid as recruiterid,sc.jobid,b.firstname as recsubuser from candidates a,members b, companyprofile c,submitted_candidates sc, jobs j  where a.id=$candidateid and j.jobid=sc.jobid and b.memberid=a.recruiterid and a.id=sc.candidateid and c.id=b.companyid");


$ispresent =mysqli_num_rows($candidateres);


if($ispresent > 0){ 
   $row =mysqli_fetch_array($candidateres);
}
if($row){
?>



<div id="candidate_name" data-value=""><b><?php echo $row['fname'];?></b> - ID: <?php echo $row['id'];?> - Submitted: <b><?php echo date("j F, Y",strtotime($row['submitdate']));  ?></b> | Status - <b><?php echo $row['candidatestatus'];?></b> <b><p style = 'font-size: 14px;
            color: #a02121;'><?php echo $row['comment'];?></p></b> 

<br>

Employer Notes: 
<?php 

        echo '<li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD EMPLOYER NOTES (so we can email the Recruiter & the Candidate)</b></a></li>';
?>
<small><?php echo $row['employernotesdate'];?></small> <textarea rows='3' cols='80' class='form-control'  name='employernotes' readonly='readonly'><?php echo $row['employernotes'];?></textarea>  <br>Employer Duplicate Notes: <small><?php echo $row['empduplicatenotesdate'];?></small> <textarea rows='3' cols='80' class='form-control'  name='empduplicatenotes' readonly='readonly'><?php echo $row['empduplicatenotes'];?></textarea> <br>Recruiter Notes: <small><?php echo $row['recruiternotesdate'];?></small> <textarea rows='3' cols='80' class='form-control'  name='recruiternotes' readonly='readonly'><?php echo $row['recruiternotes'];?></textarea><br>AM Notes: <small><?php echo $row['amnotesdate'];?></small> <textarea rows='3' cols='80' class='form-control'  name='amnotes' readonly='readonly'><?php echo $row['amnotes'];?></textarea></div> 


  
<table class="table table-striped">
<thead></thead>
  <tbody>
      
  <!--  <tr>
      <td>Details:</td>
      <td><b><?php echo $row['fname'];?></b> - ID: <?php echo $row['id'];?> - Submitted: <b><?php echo date("j F, Y",strtotime($row['submitdate']));  ?></b> - Status - <b><?php echo $row['candidatestatus'];?></b> <br><br>Employer Notes: <small><?php echo $row['employernotesdate'];?></small> <textarea rows='3' cols='80' class='form-control'  name='employernotes' readonly='readonly'><?php echo $row['employernotes'];?></textarea>   <br>Employer Duplicate Notes: <small><?php echo $row['empduplicatenotesdate'];?></small> <b><?php echo $row['empduplicatenotes'];?></b> <br><br>Recruiter Notes: <small><?php echo $row['recruiternotesdate'];?></small> <textarea rows='3' cols='80' class='form-control'  name='recruiternotes' readonly='readonly'><?php echo $row['recruiternotes'];?></textarea> <br>AM Notes: <small><?php echo $row['amnotesdate'];?></small> <textarea rows='3' cols='80' class='form-control'  name='amnotes' readonly='readonly'><?php echo $row['amnotes'];?></textarea> </td>
    </tr> -->
      


      <tr>
      <td><b>Download CV:</b></td>
     <?php  if(file_exists ('../recruiter/candidatecvs/'.$row['recruiterid'].'/'.$row['id'].'/'.$row['cv'])) {?>
      <td><a href="<?php echo '../recruiter/candidatecvs/'.$row['recruiterid'].'/'.$row['id'].'/'.$row['cv']; ?>" target="_blank"  title="view cv"><b>DOWNLOAD CV</b></a></td>
      <?php } else{ ?>
      <td> CV not found </td>
      <?php } ?>
     
    </tr>
    
    <tr>
       <td>Download Additional/Audio/Video file of Candidate:</td>
     <?php  if(file_exists ('../recruiter/video/'.$row['recruiterid'].'/'.$row['id'].'/'.$row['video']) && $row['video']) {?>
      <td><a href="<?php echo '../recruiter/video/'.$row['recruiterid'].'/'.$row['id'].'/'.$row['video']; ?>" target="_blank"  title="view video"><b>DOWNLOAD ADDITIONAL/AUDIO/VIDEO FILE OF CANDIDATE (Available)</b></a></td>
      <?php } else{ ?>
      <td> No Additional/Audio/Video file found </td>
      <?php } ?>
    </tr>
    
<tr>
      <td>Add Notes:</td>
      <td><?php 

        echo '<li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD EMPLOYER NOTES</b></a></li>';
?>
  </td>
    </tr>
      
  <tr class="float-right">
      <td><b>Provide Feedback:</b></td>
    <td>
    <div class="btn-group">
      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu--right" role="menu">
<?php 	if($row['candidatestatus']=="Awaiting Feedback" || $row['candidatestatus']=="Shortlisted") {   

if($row['candidatestatus']=="Awaiting Feedback") {


        echo '<li><a title="Select Candidate" href="select-candidate?candidateid='.$row['candidateid'].'"><b>Shortlist</b></a></li>

            <li> <a class="title" href="#"  data-toggle="modal" data-target="#feedback-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>CV Reject</a></li>
            <li> <a class="title" href="#"  data-toggle="modal" data-target="#duplicate-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Duplicate</a></li>
            <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>';
 } else { 

echo '<li><a title="Offer Candidate" href="offer-candidate?candidateid='.$row['candidateid'].'"><b>Offer</b></a></li>
			 <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Interview Reject</a></li>
			 <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>'; 
 } 
echo'
		</ul>
    </div>';
	}
	
		elseif($row['candidatestatus']=="Offered"){
	  	   echo'

		   <li><a title="Fill vacancy" href="fill-candidate?candidateid='.$row['candidateid'].'"><b>Fill Vacancy</b></a></li>
		   <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Offer Reject</a></li>
		   <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>
		   ';
			
			echo'
		</ul>
    </div>';
	}
	elseif($row['candidatestatus']=="Filled"){
	  	   echo'

		   <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Move Back to Offer Rejected</a></li>';
			
			echo'
		</ul>
    </div>';
	}
	elseif($row['candidatestatus']=="Duplicate"){
	  	   echo'

		   <li> <a class="title" href="#"  data-toggle="modal" data-target="#duplicate-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Reply Duplicate Reason</a></li>
		<li><a title="Reconsider" href="reconsider?candidateid='.$row['candidateid'].'">Reconsider</a></li>';
			
			echo'
		</ul>
    </div>';
	}
	else { 

echo '<li><a title="Reconsider" href="reconsider?candidateid='.$row['candidateid'].'">Reconsider</a></li>';
 } ?>

      </ul>
    </div>
  </td>
  </tr>
  

  
    
    <tr>
      <td>Email:</td>
      <td><?php echo $row['email'];?> </td>
    </tr>
	<tr>
      <td>Contact number:</td>
      <td><?php echo $row['contactnumber']; ?> </td>
    </tr>
    <tr>
      <td>Total Experience:</td>
      <td><?php echo $row['minex'].' years '.$row['maxex'].' months'; ?> </td>
    </tr>
    <tr>
      <td>Current Employer:</td>
      <td><?php echo $row['currentemployer'];?> </td>
    </tr>

    <tr>
      <td>Current Job Title:</td>
      <td><?php echo $row['currentjobtitle'];?> </td>
    </tr>
    
    <tr>
      <td>Job Type:</td>
      <td><?php echo $row['jobtype'];?> </td>
    </tr>
	
     <tr>
      <td>Current Salary/Rate:</td>
      <td><?php echo $row['currentcurrency'];?> <?php echo $row['currentsalary'];?> / <?php echo $row['typesalary'];?></td>
    </tr>

	 <tr>
      <td>Expected Salary/Rate:</td>
      <td><?php echo $row['currentcurrency'];?> <?php echo $row['desiredsalary'];?> / <?php echo $row['typesalary'];?></td>
    </tr>
    
	<tr>
      <td>Nationality:</td>
      <td><?php echo $row['nationality'];?> </td>
    </tr>


	 <tr>
      <td>Notice Period:</td>
      <td><?php echo $row['notice'];?> </td>
    </tr>
    
   
     <tr>
      <td>Willing to Relocate:</td>
      <td><?php if($row['relocate']) echo 'Yes'; else echo 'No';?> </td>
    </tr>
    
    <tr>
      <td>Current Country:</td>
      <td><?php echo $row['country'];?> </td>
    </tr>

	 <tr>
      <td>Current City:</td>
      <td><?php echo $row['location'];?> </td>
    </tr>
    
    <tr>
      <td>Additional Information:</td>
      <td><p style = 'font-size: 14px;
            color: #a02121;'><b><?php echo $row['additionalinfo'];?></b></p></td>
    </tr>
        
     <tr>
      <td>Download CV:</td>
     <?php  if(file_exists ('../recruiter/candidatecvs/'.$row['recruiterid'].'/'.$row['id'].'/'.$row['cv'])) {?>
      <td><a href="<?php echo '../recruiter/candidatecvs/'.$row['recruiterid'].'/'.$row['id'].'/'.$row['cv']; ?>" target="_blank"  title="view cv"><b>DOWNLOAD CV</b></a></td>
      <?php } else{ ?>
      <td> CV not found </td>
      <?php } ?>
     
    </tr>
    
   <tr>
       <td>Download Audio/Video/Additional file of Candidate:</td>
     <?php  if(file_exists ('../recruiter/video/'.$row['recruiterid'].'/'.$row['id'].'/'.$row['video']) && $row['video']) {?>
      <td><a href="<?php echo '../recruiter/video/'.$row['recruiterid'].'/'.$row['id'].'/'.$row['video']; ?>" target="_blank"  title="view video">Download Audio/Video/Additional file of Candidate (Available)</a></td>
      <?php } else{ ?>
      <td> No Audio/Video/Additional file found </td>
      <?php } ?>
    </tr>
    
    <tr>
      <tr class="float-right">
      <td><b>Provide Feedback:</b></td>
    <td>
    <div class="btn-group">
      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu--right" role="menu">
<?php 	if($row['candidatestatus']=="Awaiting Feedback" || $row['candidatestatus']=="Shortlisted") {   

if($row['candidatestatus']=="Awaiting Feedback") {


        echo '<li><a title="Select Candidate" href="select-candidate?candidateid='.$row['candidateid'].'"><b>Shortlist</b></a></li>

            <li> <a class="title" href="#"  data-toggle="modal" data-target="#feedback-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>CV Reject</a></li>
            <li> <a class="title" href="#"  data-toggle="modal" data-target="#duplicate-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Duplicate</a></li>
            <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>';
 } else { 

echo '<li><a title="Offer Candidate" href="offer-candidate?candidateid='.$row['candidateid'].'"><b>Offer</b></a></li>
			 <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Interview Reject</a></li>
			 <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>'; 
 } 
echo'
		</ul>
    </div>';
	}
	
		elseif($row['candidatestatus']=="Offered"){
	  	   echo'

		   <li><a title="Fill vacancy" href="fill-candidate?candidateid='.$row['candidateid'].'"><b>Fill Vacancy</b></a></li>
		   <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Offer Reject</a></li>
		   <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>
		   ';
			
			echo'
		</ul>
    </div>';
	}
	elseif($row['candidatestatus']=="Filled"){
	  	   echo'

		   <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Move Back to Offer Rejected</a></li>';
			
			echo'
		</ul>
    </div>';
	}
	elseif($row['candidatestatus']=="Duplicate"){
	  	   echo'

		   <li> <a class="title" href="#"  data-toggle="modal" data-target="#duplicate-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Reply Duplicate Reason</a></li>
		<li><a title="Reconsider" href="reconsider?candidateid='.$row['candidateid'].'">Reconsider</a></li>';
			
			echo'
		</ul>
    </div>';
	}
	else { 

echo '<li><a title="Reconsider" href="reconsider?candidateid='.$row['candidateid'].'">Reconsider</a></li>';
 } ?>

      </ul>
    </div>
  </td>
  </tr>
    
	<tr>
      <td>Agency:</td>
      <td><?php echo $row['agency'] ?> </td>
    </tr>
    
    
<!--    <tr>
      <td>Share with your Hiring Manager:</td>
      <td><!-- AddToAny BEGIN -->
<!--<div class="a2a_kit a2a_kit_size_32 a2a_default_style">
<a class="a2a_dd" href="https://www.addtoany.com/share"></a>
<a class="a2a_button_email"></a>
<a class="a2a_button_whatsapp"></a>
</div>
<script>
var a2a_config = a2a_config || {};
a2a_config.num_services = 2;
</script>
<script async src="https://static.addtoany.com/menu/page.js"></script>
<!-- AddToAny END --> <!--</td>
    </tr>-->
    
  </tbody>
</table>


<hr>
 
  

  
   <h5>CV Copy</h5>
<textarea rows="30" cols="80" class="form-control"  name="cvcopy" readonly="readonly"><?php echo $row['resume'];?></textarea>    
  <hr>

<tr class="float-right">
      <td><b>Provide Feedback:</b></td>
    <td>
    <div class="btn-group">
      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu--right" role="menu">
<?php 	if($row['candidatestatus']=="Awaiting Feedback" || $row['candidatestatus']=="Shortlisted") {   

if($row['candidatestatus']=="Awaiting Feedback") {


        echo '<li><a title="Select Candidate" href="select-candidate?candidateid='.$row['candidateid'].'"><b>Shortlist</b></a></li>

            <li> <a class="title" href="#"  data-toggle="modal" data-target="#feedback-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>CV Reject</a></li>
            <li> <a class="title" href="#"  data-toggle="modal" data-target="#duplicate-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Duplicate</a></li>
            <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>';
 } else { 

echo '<li><a title="Offer Candidate" href="offer-candidate?candidateid='.$row['candidateid'].'"><b>Offer</b></a></li>
			 <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Interview Reject</a></li>
			 <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>'; 
 } 
echo'
		</ul>
    </div>';
	}
	
		elseif($row['candidatestatus']=="Offered"){
	  	   echo'

		   <li><a title="Fill vacancy" href="fill-candidate?candidateid='.$row['candidateid'].'"><b>Fill Vacancy</b></a></li>
		   <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Offer Reject</a></li>
		   <li> <a class="title" href="#"  data-toggle="modal" data-target="#notes-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'><b>ADD NOTES</b></a></li>
		   ';
			
			echo'
		</ul>
    </div>';
	}
	elseif($row['candidatestatus']=="Filled"){
	  	   echo'

		   <li> <a class="title" href="#" data-toggle="modal" data-target="#feedback-modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Move Back to Offer Rejected</a></li>';
			
			echo'
		</ul>
    </div>';
	}
	elseif($row['candidatestatus']=="Duplicate"){
	  	   echo'

		   <li> <a class="title" href="#"  data-toggle="modal" data-target="#duplicate-modal" data-dismiss="modal" id='.$row['candidateid'].' data-id='.$row['jobid'].'>Reply Duplicate Reason</a></li>
		<li><a title="Reconsider" href="reconsider?candidateid='.$row['candidateid'].'">Reconsider</a></li>';
			
			echo'
		</ul>
    </div>';
	}
	else { 

echo '<li><a title="Reconsider" href="reconsider?candidateid='.$row['candidateid'].'">Reconsider</a></li>';
 } ?>

      </ul>
    </div>
  </td>
  </tr>
  
<?php 
}
 ?>

<?php 

if($iam == 'Employer' ){
  try {

    $sc =mysqli_query($link,"SELECT *  from submitted_candidates where candidateid=$candidateid"); 
 


    $rowF =mysqli_fetch_array($sc);
    //var_dump($rowF);
  
  if($rowF['viewed'] == 0 && $rowF['status'] == 'Awaiting Feedback'){
    mysqli_query($link,"UPDATE submitted_candidates SET viewed=1,viewedtime=NOW() where candidateid=$candidateid");
    
    //sending viewed notification
        
	//mail to agency
	
	$to = $row['recruiteremail'];



			$from = "noreply@recruitinghub.com";
            $r=	getAccountManagerDetail($link,$mid);
            $c=	getCandidatesDetail($link,$mid);

			$subject = "Recruiting Hub - ".$row['fname']." submitted for ".$row['jobtitle']." has been VIEWED by the client ".$row['employername']."";



			$message = '<html>
		<body bgcolor="#FFFFFF">
		<div>
<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
  <tbody>
  <tr>
    <td  colspan="2" style="padding:12px 12px 0px 12px">
    	<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
      	<tbody>
	  		<tr>	
            	<td colspan="3" style="padding-left:14px"><div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div></td>
            	
            	<td colspan="3" style="padding-right:12px"><div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/images/Viewed.png" alt="www.recruitinghub.com"></a></div></td>
            	
            
          </tr>
	  <tr>
        <td style="padding:0px 14px"><table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody><tr>
            <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody><tr>
                <td valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                                    <tr>
                                      <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                          <tr>
                                            <td valign="top"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                                <tr>
                                                  <td><p><br>
                                                     Dear '.$row['recsubuser'].',<br>
                                                    <br>
                                                    
                                                    <p style = "font-size: 14px;
            color: #a02121;">  PLEASE DO NOT REPLY TO THIS EMAIL AS EMAILS ARE NOT MONITORED FOR THIS EMAIL ID. LOGIN TO YOUR ACCOUNT TO RESPOND AS APPROPRIATE </p>   
            
                                                
                                                    <br>
                                                   Your Candidate <strong>'.$row['fname'].'</strong> submitted for <strong>'.$row['jobtitle'].'</strong> from <strong>'.$row['name'].'</strong> has been <strong>VIEWED</strong> by the client <strong>'.$row['employername'].'</strong> <br>
                                                    <br>
                                                    No action required from your end as we are just letting you know that the client has clicked opened the profile of the candidate you submitted and viewing the details now. Please wait for the client to update further feedback like Shortlist/CV Reject. If you dont hear further feedback after 24 hours from this time please open the profile and click "<b>ADD NOTES</b>" from your Recruiter Login for client to update further progress of this candidature. <br><br>
                                                    
                                                    Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">Recruiter Login</a></p></td>
                                                </tr>
                                                
                                                <tr>
                                                  <td><p>Best Regards,<br>
                                                      <a href="https://www.recruitinghub.com" target="_blank">www.recruitinghub.com </a> </p></td>
                                                </tr>
                                            </table></td>
                                            <td width="20"><p>&nbsp;</p></td>
                                          </tr>
                                      </table></td>
                                    </tr>            
                                    <tr>
                    <td>&nbsp;</td>
                  </tr>
                                  
                  <tr>
                    <td style="padding:4px 0 0 0;line-height:16px;color:#313131"><br>
                      <br>                  </td>
				  </tr>
                </tbody></table></td>
                <td width="20">&nbsp;</td>
                     </tr>
            </tbody></table></td>
          </tr>
        </tbody>
       </table>
      </td>
      </tr>
    </tbody>
   </table>
 </td>
 </tr>
 <tr>
        <td width="272" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>
          </p></td>
        <td width="346" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px">You can unsubscribe to this alerts by switching off Notification in Manage Notification link in your login<br>
          </p></td>
      </tr>
</tbody>
</table>
</div>
</body>
		</html>';


			// end of message


			$headers = "From: $from\r\n";

			$headers .= "Content-type: text/html\r\n";
		//mail($to, $subject, $message, $headers);

$params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$to,
'subject'=>$subject,'message'=>$message,'cc'=>$r['email'],'cc2'=>'noreply@recruitinghub.com','send'=>true];
  AsyncMail($params);
        
    
    
  }
  //  mysqli_query($link,"UPDATE submitted_candidates SET viewed=1,viewedtime='".date('Y-m-d H:i:s')."' where candidateid=$candidateid");
  }
  
  catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }


} ?>

<script>
/**$(document).ready(function(){

if($('#searchandmark').val().length !== 0){

       $('#paragraph').each(function(){
	   
       $(this).html($(this).html().replace($('#searchandmark').val(),"<span class = 'highlight'>"+$('#searchandmark').val()+"</span>"));
    });
	
  }});**/
$(document).ready(function(){
var src_str = $("#paragraph").html();
var term = $("#searchandmark").val();
term = term.replace(/(\s+)/,"(<[^>]+>)*$1(<[^>]+>)*");
var pattern = new RegExp("("+term+")", "gi");

src_str = src_str.replace(pattern, "<mark style='background-color:yellow;'>$1</mark>");
src_str = src_str.replace(/(<mark>[^<>]*)((<[^>]+>)+)([^<>]*<\/mark>)/,"$1</mark>$2<mark>$4");

$("#paragraph").html(src_str);

});
</script>
