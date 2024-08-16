<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$mid=$name=$email=$iam='';
$content=$errormsg='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$iam=$_SESSION['iam'];
$ecountry=$_SESSION['country'];
$cid=$_SESSION['cid'];
$array1=$array2=$array3='';
}
else{
$notification='Please login to access the page';
$_SESSION['notification']=$notification;
header('location: login'); 
exit;
}
require_once '../config.php';
require '../Smtp/index.php';
require '../helpers/general.php';
$checks=array();
if(isset($_GET['candidateid']) || isset($_POST['allcheck'])){
	if(isset( $_POST['allcheck']))
		$checks=$_POST['allcheck'];
	else
	{
		$candidateid=$_GET['candidateid'];
		array_push($checks,$candidateid);
	}
}
	if(!empty($checks)){
	foreach($checks as $value) {
	$sql=mysqli_query($link,"UPDATE submitted_candidates a,jobs b set a.status='Shortlisted',a.prestatus='' where candidateid='$candidateid' and a.jobid=b.jobid ");
		$q2=mysqli_query($link,"select e.email,e.reconsidernotification,d.name,e.firstname from companyprofile d,members e ,submitted_candidates c where  d.id=e.companyid  and e.memberid=c.recruiterid and c.candidateid='$candidateid'");
		while($row2 = mysqli_fetch_array($q2)){
			$array2=$row2;
				}
		$q1=mysqli_query($link,"select a.jobtitle,d.name from jobs a,companyprofile d,members e ,submitted_candidates c where  d.id=e.companyid  and e.memberid=a.memberid and c.jobid=a.jobid and c.candidateid='$candidateid'  ");
		while($row1 = mysqli_fetch_array($q1)){
			$array1=$row1;
				}
		
		$q3=mysqli_query($link,"select fname,email  from candidates  where id='$candidateid'");
		while($row3= mysqli_fetch_array($q3)){
			$array3=$row3;
				}
		$content="Candidate has been reconsidered";
		$reconsidernotification=$array2['reconsidernotification'];
		if($reconsidernotification==1){
		
		$to = $array2['email'];



			$from = "noreply@recruitinghub.com";
            $r=	getAccountManagerDetail($link,$mid);


			$subject = "RecruitingHub.com - ".$array3['fname']." - Reconsider Notification for ".$array1['jobtitle']." from ".$array1['name']."   ";



			$message = '<html>



			<body bgcolor="#FFFFFF">



				<div>



	<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">



	  <tbody>



	  <tr>



		<td style="padding:12px 12px 0px 12px"><table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding:0px 14px"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding-top:5px;color:#313131"><table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td colspan="3" style="padding-left:14px"><div style="boder:0"><a href="https://www.recruitinghub.com/recruiter/login"><img src="https://www.recruitinghub.com/images/color-logo.png" alt="www.recruitinghub.com"></a></div></td>
              
              <td colspan="3" style="padding-right:12px"><div style="boder:0"><a href="https://www.recruitinghub.com/recruiter/login"><img src="https://www.recruitinghub.com/images/Reconsidered.png" alt="www.recruitinghub.com"></a></div></td>
            </tr>
            <tr>
              <td style="padding:0px 14px"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td style="padding-top:5px;color:#313131"><br>
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                          <tr>
                            <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                  <td valign="top"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                      <tr>
                                        <td><p>
                                         Dear '.$array2['firstname'].',<br>
                                          <br>
                                          Your Candidate <strong>'.$array3['fname'].'</strong> that was Rejected earlier for <strong>'.$array1['jobtitle'].'</strong> role from <strong>'.$array1['name'].' </strong>has been <b>Reconsidered</b> by the Client. <br>
                                          <br>
                                          <b>Please check Shorlisted folder in your Agency Login and open the profile to <b>ADD NOTES</b> for interview scheduling or for more details.</b></p>  Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">Agency Login</a></td>
                                      </tr>
                                      <tr>
                                        <td><p>&nbsp;</p></td>
                                      </tr>
                                      <tr>
                                        <td><p>Best Regards,<br>
                                            <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">www.recruitinghub.com </a> </p></td>
                                      </tr>
                                  </table></td>
                                  <td width="20"><p>&nbsp;</p></td>
                                </tr>
                            </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </tbody>
              </table></td>
            </tr>
          </tbody>
		  </table></td>                

					</tr>
		</tbody>
		</table>                    

					   </td>



					  </tr>
		</tbody>
		</table></td>



					<td width="20">&nbsp;</td>



					</td>



				  </tr>

			<tr>



			<td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>



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
'subject'=>$subject,'message'=>$message,'cc'=>$r['email'],'cc2'=>'noreply@recruitinghub.com','send'=>true];
  AsyncMail($params);
  
  //mail to candidate
  
  	$to = $array3['email'];



			$from = "noreply@recruitinghub.com";
            $r=	getAccountManagerDetail($link,$mid);


			$subject = "RecruitingHub.com - ".$array3['fname']." - Reconsider Notification for ".$array1['jobtitle']." from ".$array1['name']."   ";



			$message = '<html>



			<body bgcolor="#FFFFFF">



				<div>



	<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">



	  <tbody>



	  <tr>



		<td style="padding:12px 12px 0px 12px"><table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding:0px 14px"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding-top:5px;color:#313131"><table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
          <tbody>
            <tr>
              <td colspan="3" style="padding-left:14px"><div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/images/color-logo.png" alt="www.recruitinghub.com"></a></div></td>
              
               <td colspan="3" style="padding-right:12px"><div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/images/Reconsidered.png" alt="www.recruitinghub.com"></a></div></td>
            </tr>
            <tr>
              <td style="padding:0px 14px"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                    <tr>
                      <td style="padding-top:5px;color:#313131"><br>
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                          <tr>
                            <td><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                <tr>
                                  <td valign="top"><table border="0" cellspacing="0" cellpadding="0" width="100%">
                                      <tr>
                                        <td><p>
                                         Dear '.$array3['fname'].',<br>
                                          <br>
                                          Your profile <strong>'.$array3['fname'].'</strong> that was Rejected earlier for <strong>'.$array1['jobtitle'].'</strong> role from <strong>'.$array1['name'].' </strong>has been <b>Reconsidered</b> by the Client. <br>
                                          <br>
                                          <b>This is an automated email sent by Recruiting Hub to let you know the progress of your candidature in the interview process. The recruiter that submitted your profile is copied in this email who will liase with you for further process.</b></td>
                                      </tr>
                                      <tr>
                                        <td><p>&nbsp;</p></td>
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
                        </table></td>
                    </tr>
                  </tbody>
              </table></td>
            </tr>
          </tbody>
		  </table></td>                

					</tr>
		</tbody>
		</table>                    

					   </td>



					  </tr>
		</tbody>
		</table></td>



					<td width="20">&nbsp;</td>



					</td>



				  </tr>

			<tr>



			<td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>



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
'subject'=>$subject,'message'=>$message,'cc'=>$array2['email'],'cc2'=>'noreply@recruitinghub.com','send'=>true];
  AsyncMail($params);
  
   echo "<script>
alert('Candidate ReConsidered. An email notification has now been sent to the Recruiter');
</script>";
	}
	
	}
	}
else
$errormsg="Access denied";	


$notification='Please login to access the page';
$_SESSION['notification']=$notification;
	
//$sql=mysqli_query($link,"UPDATE submitted_candidates a inner join jobs b on a.jobid=b.jobid set a.status='Shortlisted',a.prestatus='Rejected' where candidateid='$candidateid' ");
		$consider = mysqli_num_rows($sql);
	if($consider>0){
	header('location: shortlist');
	}
	else{
	header('location: shortlist');
	}
	
			
	
	?>