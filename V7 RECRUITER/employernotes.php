<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$email='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$iam=$_SESSION['iam'];
$cid=$_SESSION['cid'];
$ecountry=$_SESSION['country'];
require_once '../config.php';
require '../Smtp/index.php';
require '../helpers/general.php';
$checks=array();
$pstatus=array();
//if(isset(($_POST['EID'])&&($_POST['jobids']))|| isset($_POST['allcheck']))){

		$candidateid=$_POST['jobid'];



if((isset($_POST['CID'])&&($_POST['jobid']))){
$j=$_POST['jobid'];


	
		$candidateid=$_POST['CID'];

	 
	$namesql=mysqli_query($link,"select fname from candidates where id='$candidateid'");
	$namerow=mysqli_fetch_assoc($namesql);



	$jobmemsql=mysqli_query($link,"select memberid from jobs where jobid=$j");
	$jobrow=mysqli_fetch_assoc($jobmemsql);
	
		$getmembersql=mysqli_query($link,"select firstname, email from members where memberid=$j");
	$jobrow=mysqli_fetch_assoc($jobmemsql);
	

	$jmid =  $jobrow['memberid'];
	$_SESSION['jmid'] = $jmid;
	$getmembersql=mysqli_query($link,"select firstname, email from members where memberid=$jmid");
	$employerrow=mysqli_fetch_assoc($getmembersql);
	$nameres[]=$namerow;
	
	$res=mysqli_query($link,"select a.candidateid,a.status,a.recruiterid,b.jobtitle,a.jobid from submitted_candidates a,jobs b WHERE a.candidateid='$candidateid' and a.jobid=b.jobid and a.jobid=$j");
	
	$row=mysqli_fetch_assoc($res);
	$pstatus[]=$row;

	// var_dump($pstatus);
	// exit;
}
			

elseif(isset($_POST['submit'])){

 
	$amnotes=htmlspecialchars($_POST['reason'],ENT_QUOTES);
	
	$replacewith = "hiddentext";
    $amnotes = preg_replace("/[\w-]+@([\w-]+\.)+[\w-]+/", $replacewith, $amnotes);
    $amnotes = preg_replace("/^(\(?\d{3}\)?)?[- .]?(\d{3})[- .]?(\d{4})$/", $replacewith, $amnotes);
    $amnotes = preg_replace("/^(\(?\d{4}\)?)?[- .]?(\d{3})[- .]?(\d{4})$/", $replacewith, $amnotes);
    
	$jid=$_POST['jid'];
	$candidateid=$_POST['candidateid'];
	$i=0;	
	$fetchid=$_POST['recrid'];

	 $jmid = $_SESSION['jmid'] ;
	 
	 
	 
	 
	mysqli_query($link,"Update jobs INNER JOIN submitted_candidates ON submitted_candidates.jobid = jobs.jobid set submitted_candidates.amnotes='$amnotes',submitted_candidates.amnotesdate=now() WHERE submitted_candidates.candidateid='$candidateid' and submitted_candidates.jobid='$jid'");
		$jobmemsql=mysqli_query($link,"select jobtitle,memberid from jobs where jobid=$jid");
	$jobrow=mysqli_fetch_assoc($jobmemsql);
	$jobtitle =  $jobrow['jobtitle'];
	$memid =   $jobrow['memberid'];
	$getmembersql=mysqli_query($link,"select firstname, email from members where memberid=$memid");
	$employerrow=mysqli_fetch_assoc($getmembersql);

			if(mysqli_affected_rows($link)>0){
			$namesql1=mysqli_query($link,"select fname from candidates where id='$candidateid'");


	$namerow1=mysqli_fetch_assoc($namesql1);
			$fetchemail=mysqli_fetch_assoc(mysqli_query($link,"select email from members where memberid='".$fetchid."'"));
			$fetchname=mysqli_fetch_assoc(mysqli_query($link,"select firstname from members where memberid='".$fetchid."'"));
			$fetchempname=mysqli_fetch_assoc(mysqli_query($link,"select a.name from companyprofile a,members b where b.memberid='".$memid."' and a.id=b.companyid"));
			
				// $fetchid=mysqli_fetch_assoc(mysqli_query($link,"select a.name from companyprofile a,members b where b.memberid='".$memid."' and a.id=b.companyid"));
	
			foreach($jtitle as $valuejtitle){
			$fetchjtitle=$valuejtitle;
			}
		$r=	getAccountManagerDetail($link,$memid);
// 		var_dump($r);
// 		exit;
	//send notification to Agency
		$to =$fetchemail['email'] ;
		$from = "noreply@recruitinghub.com";
		$subject = "Recruiting Hub - (".$namerow1['fname'].") AM Notes on behalf of ".$fetchempname['name']." Added  for ".$jobtitle."";
		$message = '<html>
		<body bgcolor="#FFFFFF">
			<div>
<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
  <tbody>
  <tr>
    <td colspan="2" style="padding:12px 12px 0px 12px">
    <table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
	  <tr>
      <td colspan="3" style="padding-left:14px">
      <div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/images/color-logo.png" alt="www.recruitinghub.com"></a></div>
      </td>
       </tr>
	  <tr>
        <td style="padding:0px 14px">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
                   <tr>
                    <td style="padding-top:5px;color:#313131"><br>
                   Dear '.$fetchname['firstname'].',
                      <p>Greetings from <a href="https://www.recruitinghub.com/">www.recruitinghub.com</a></p>
                      
                      <p style = "font-size: 14px;
            color: #a02121;">  PLEASE DO NOT REPLY TO THIS EMAIL AS EMAILS ARE NOT MONITORED FOR THIS EMAIL ID. LOGIN TO YOUR ACCOUNT TO RESPOND AS APPROPRIATE </p>   
            
					  <p>AM notes on behalf of Employer <strong>'.$fetchempname['name'].'</strong> added for <strong>'.$namerow1['fname'].'</strong> submitted for <strong>'.$jobtitle.'</strong>
					  <br><br>
					  NOTES ADDED: <p style = "font-size: 14px;
            color: #a02121;"><strong>'.$amnotes.'</strong></p>
					  <p>Please open the Profile from your Recruiter login to read the AM Notes. You can also respond by ADDING NOTES when you open the Profile. NO ACTION IS REQUIRED FROM YOU IF THE AM NOTES ARE TARGETED TO THE EMPLOYER</p>
					  Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank"><b>Recruiter Login</b></a>
		
		
		<p>Best Regards,</p>
		<p><a href="https://www.recruitinghub.com/">www.recruitinghub.com</a></p>
					                </td>                
                </tr>            
                                   
                    </tbody>
                    </table>                    
                   </td>
                  </tr>
                 
                </tbody></table></td>
                <td width="20">&nbsp;</td>
                </td>
              </tr>
            
       
 		<tr>
       <td width="272" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>
          </p></td>
        <td width="346" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px">You can unsubscribe to this alerts by switching off Notification in Manage Notification link in your login<br>
          </p></td>
      </tr>
</tbody></table>
</div>
</body>
		</html>';
		// end of message
		$headers = "From: $from\r\n";
		$headers .= "Content-type: text/html\r\n";
		//mail($to, $subject, $message, $headers);
		
		$params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$to,
'subject'=>$subject,'message'=>$message,'cc'=>$r['email'],'send'=>true];
	AsyncMail($params);
	
	//mail to employer 
	
	$toemp =$employerrow['email'] ;
		$from = "noreply@recruitinghub.com";
		$subject = "Recruiting Hub - (".$namerow1['fname'].") AM Notes for ".$fetchempname['name']." Added  for ".$jobtitle."";
		$message = '<html>
		<body bgcolor="#FFFFFF">
			<div>
<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
  <tbody>
  <tr>
    <td colspan="2" style="padding:12px 12px 0px 12px">
    <table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
      <tbody>
	  <tr>
      <td colspan="3" style="padding-left:14px">
      <div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/images/color-logo.png" alt="www.recruitinghub.com"></a></div>
      </td>
       </tr>
	  <tr>
        <td style="padding:0px 14px">
        <table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
                   <tr>
                    <td style="padding-top:5px;color:#313131"><br>
                   Dear '.$fetchname['firstname'].',
                      <p>Greetings from <a href="https://www.recruitinghub.com/">www.recruitinghub.com</a></p>
					  <p>AM notes on behalf of Employer <strong>'.$fetchempname['name'].'</strong> added for <strong>'.$namerow1['fname'].'</strong> submitted for <strong>'.$jobtitle.'</strong>  </p>
					<p>  NOTES ADDED: <p style = "font-size: 14px;
            color: #a02121;"><strong>'.$amnotes.'</strong></p>
					  <p>Please open the Profile from your Recruiter login to read the AM Notes. You can also respond by Adding Notes when you open the Profile.</p>
					  Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">Recruiter Login</a>
		
		
		<p>Best Regards,</p>
		<p><a href="https://www.recruitinghub.com/">www.recruitinghub.com</a></p>
					                </td>                
                </tr>            
                                   
                    </tbody>
                    </table>                    
                   </td>
                  </tr>
                 
                </tbody></table></td>
                <td width="20">&nbsp;</td>
                </td>
              </tr>
            
       
 		<tr>
       <td width="272" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>
          </p></td>
        <td width="346" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px">You can unsubscribe to this alerts by switching off Notification in Manage Notification link in your login<br>
          </p></td>
      </tr>
</tbody></table>
</div>
</body>
		</html>';
	
	$paramsemp = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$employerrow['email'],
'subject'=>$subject,'message'=>$message,'cc'=>$r['email'],'send'=>true];
	AsyncMail($paramsemp);
	
			
	 echo "<script>
alert('AM Notes Successfully Added. An email notification has now been sent to the Recruiter');
window.location.href='myemployers-allcandidates.php';
</script>";
		}
	}
else
$errormsg="Access denied";	
}
?>


<?php  foreach($nameres as $namevalue) { echo '<h4 class="modal-title" id="notes-modal-label">'.$namevalue['fname'].'</h4>'; } ?>
<div id="feedback_name"><strong>Add Employer Notes - (An Automated Email Notification will be sent to the Recruiter)</strong> </div>
                   <?php if(!$errormsg){ 
			  			if($content)
							echo $content;
						else{ ?>
                            <form action="employernotes" method="post">
                        <textarea rows="5" cols="80" class="form-control"  name="reason" required></textarea> 
                                  <input type="hidden" name="candidateid" value="<?php echo $candidateid; ?>"/>
                                   <input type="hidden" name="jid" value="<?php echo $j; ?>"/>
                                         <?php  foreach($pstatus as $value)
                                    {
                                      echo '
											<input type="hidden" name="recrid" value="'. $value['recruiterid']. '">';
									
                                    }?>
                                <input type="submit"  name="submit" value="Submit">                             
                            </form>
                        <?php }
						}
			  else echo $errormsg; ?>
                  
          
          
          