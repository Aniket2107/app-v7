<?php
$job='';
require_once '../config.php';
if(isset($_POST['EID']))
$jobid=$_POST['EID'];

$jobres = mysqli_query($link,"SELECT a.*,b.accountmanager FROM jobs a,employers b,companyprofile,members WHERE a.jobid='$jobid' and a.memberid=members.memberid and members.companyid=companyprofile.id and companyprofile.registerid=b.id"); 
$isposted = mysqli_num_rows($jobres);
if($isposted > 0){ 
    while($row = mysqli_fetch_array($jobres)){ 
		$job=$row;
				}
}
if($job){
?>
<div id="job_title" data-value="<?php echo $job['jobtitle'];?> | Job ID: <?php echo $job['jobid'];?> | Posted: <?php echo $job['postdate'];?> | Updated: <?php echo $job['updatedate'];?> "> </div>
<table class="table table-striped">
<thead></thead>
  <tbody>
    <tr>
      <td>Job Sector:</td>
      <td><?php echo $job['jobsector'];?> </td>
    </tr>
    <tr>
      <td>Job Type:</td>
      <td><?php echo ucwords($job['jobtype']);?> </td>
    </tr>
    
    <tr>
      <td>Working:</td>
      <td><?php echo ucwords($job['working']);?> </td>
    </tr>
    
    <tr>
      <td>Country:</td>
      <td><?php echo $job['country'];?> </td>
    </tr>
    
    <tr>
      <td>Location:</td>
      <td><?php echo $job['joblocation'];?> </td>
    </tr>
    
    <tr>
      <td>City:</td>
      <td><?php echo $job['city'];?> </td>
    </tr>
    
 <tr>
      <td>Experience:</td>
      <td><?php echo $job['minex'];?> - <?php echo $job['maxex'];?> Years</td>
    </tr>
    <tr>
      <td>Salary/End Rate:</td>
      <td><?php if($job['country']=='India'){echo'Rs. ';if($job['minlakh']) echo $job['minlakh'].',';  if($job['minthousand']==0) echo '00,'; else echo $job['minthousand'].','; echo '000'; echo' - '; if($job['maxlakh']) echo $job['maxlakh'].',';  if($job['maxthousand']==0) echo '00,'; else echo $job['maxthousand'].','; echo '000';}else{ if($job['minlakh']) echo $job['minlakh']; else echo '0';echo '-';if($job['maxlakh']) echo $job['maxlakh'];else echo '0';   echo $job['currency']; } ?> / <?php echo $job['ratetype'];?></td>
    </tr>

   
    <tr>
      <td>Placement Fee:</td>
      <td>
        (<?php echo $job['currency'] ?> / %) <?php echo $job['fee'];?>
      </td>
    </tr>

  <!--    <tr>
        <td>Account Manager:</td>
        <td><?php echo $job['accountmanager'];?>
        </td>
      </tr> -->

    <!--<tr>
      <td>Reason for vacancy:</td>
      <td><?php echo $job['vacancyreason'];?></td>
    </tr>-->

    <tr>
      <td>Education:</td>
      <td><?php echo $job['degree'];?></td>
    </tr>

   <tr>
      <td>IR35:</td>
      <td><?php echo $job['ir35'];?></td>
    </tr>

    <!--<tr>
      <td>Predicted time for CV feedback:</td>
      <td><?php echo $job['feedback'];?></td>
    </tr>-->

   <!-- <tr>
      <td>Key Skills:</td>
      <td><?php echo $job['keyskills'];?></td>
      </tr>-->
      
	<tr>
      <td>Notice Period:</td>
      <td><?php echo $job['notice'];?></td>
      </tr>
      
    <tr>
      <td>No of vacancies:</td>
      <td><?php echo $job['novacancies'];?> Vacancy</td>
      </tr>
      
      <tr>
      <td>CV limit:</td>
      <td><?php echo $job['cvlimit'];?> CV's Per Agency</td>
      </tr>
      
      <tr>

      <td>Agency Limit:</td>

      <td><?php echo $job['agencycount'].'/'.$job['agencylimit'];?> Agencies</td>

    </tr>
<?php //} ?>

      
      <?php if($job['description1']){ ?>
    <tr>
    <td>Job Description (uploaded as file)</td>
    <td><a href="../employer/jobdescription/<?php echo $job['memberid'] ?>/<?php echo $job['jobid'] ?>/<?php echo $job['description1']; ?>" target="_blank"><?php echo $job['description1']; ?></a>
    </td>
    </tr>    
    <?php } ?>
      
      <!--<tr>
      <td>CV Submission closing:</td>
      <td><?php echo $job['closingdate'];?></td>
      </tr>-->
      
      <!--<tr>
      <td>Stages of Interview Process:</td>
      <td><?php echo $job['interviewstages'];?> stages</td>
    </tr>-->
    
    <tr>
      <td>Priority:</td>
      <td><?php echo $job['priority'];?></td>
    </tr>
      
      <tr>
      <td>Interviewer Comments:</td>
      <td><?php echo $job['interviewcomments'];?></td>
      </tr>
     

  </tbody>
</table>


<hr>

  <p><?php echo $job['description'];?></p>

<hr>

<?php } ?>
 