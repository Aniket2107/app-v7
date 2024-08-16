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
$admincountry= $_SESSION['admincountry'];
$usertype=$_SESSION['usertype'];
}

else{

$notification='Please login to access the page';

$_SESSION['notification']=$notification;

header('location: index'); exit;

}

require_once '../config.php';
require '../Smtp/index.php';
require '../helpers/general.php';

if(isset($_GET['jobid']) && isset($_GET['a'])){
	$jobid=$_GET['jobid'];
	$action=$_GET['a'];
      if($action=='close'){
        mysqli_query($link,"update jobs set status='Closed', priority=0,updatedby='$mid' WHERE jobid='$jobid' and memberid='$mid'");
        //  echo $mid;
        $content="You have closed the job";
        $request=mysqli_query($link,"select * from request where jobid='$jobid'");

	while($row=mysqli_fetch_assoc($request)){
	    $rid=$row['recruiterid'];
	    $empid=$row['employerid'];
	    
			$q2=mysqli_query($link,"select a.jobtitle,d.name, e.email,e.reconsidernotification,e.firstname from members e, jobs a,companyprofile d where d.id=e.companyid and a.jobid ='$jobid' and e.memberid='$rid' ");
			
	$row2 = mysqli_fetch_array($q2);
	
		$q3=mysqli_query($link,"select a.jobtitle,d.name, e.email,e.reconsidernotification,e.firstname from members e, jobs a,companyprofile d where d.id=e.companyid and a.memberid=e.memberid and a.jobid ='$jobid' ");
			
	$row3 = mysqli_fetch_array($q3);
				
		//mail to agency
	$to = $row2['email'];
$companyname=$row3["name"];
$jobtitle=$row2["jobtitle"];
			$from = "noreply@recruitinghub.com";
			
			     $r=	getAccountManagerDetail($link,$empid);

			$subject = "RecruitingHub.com - $companyname has Closed the Job - $jobtitle";

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
                                         Dear '.$row2['firstname'].',<br>
                                          <br>
                                          Greetings from <a href="https://www.recruitinghub.com" target="_blank">www.recruitinghub.com </a><br>
                                          <br>
                                          <b>'.$companyname.'</b> Closed the Job ID <b>('.$jobid.')</b> - <b>'.$jobtitle.'</b>. <br><br>
                                          
                                          This means none of your candidates submitted (if you have submitted any) has been selected in the interview process. You will receive a separate FILLED notification if any one of your candidate (if you have submitted any) has filled the vacancy.<br><br>
                                          
                                         PLEASE STOP WORKING ON THIS ROLE. This job has now been moved to DISENGAGED/CLOSED folder which can be found in your Recruiter login. We will notify you when the job reopens so you can continue to submit candidates.<br>
                                          <br>
                                          Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">Recruiter Login</a></td>
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

			<td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2023 <br>

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
'subject'=>$subject,'message'=>$message,'cc2'=>'employers@recruitinghub.com','send'=>true];
  AsyncMail($params);
	}
        header('location: jobs'); exit;
        } 
      elseif($action=='inactive'){
        mysqli_query($link,"update jobs set status='Hold' ,priority=0,updatedby='$mid' WHERE jobid='$jobid' ");
        $content="You have changed the job status as 'On Hold'";
        $request=mysqli_query($link,"select * from request where jobid='$jobid'");

	while($row=mysqli_fetch_assoc($request)){
	    $rid=$row['recruiterid'];
	      $empid=$row['employerid'];

						$q2=mysqli_query($link,"select a.jobtitle,d.name, e.email,e.reconsidernotification,e.firstname from members e, jobs a,companyprofile d where d.id=e.companyid and a.jobid ='$jobid' and e.memberid='$rid' ");
			
	$row2 = mysqli_fetch_array($q2);
	
		$q3=mysqli_query($link,"select a.jobtitle,d.name, e.email,e.reconsidernotification,e.firstname from members e, jobs a,companyprofile d where d.id=e.companyid and a.memberid=e.memberid and a.jobid ='$jobid' ");
			
	$row3 = mysqli_fetch_array($q3);
				
		//mail to agency
	$to = $row2['email'];
$companyname=$row3["name"];
$jobtitle=$row2["jobtitle"];
			$from = "noreply@recruitinghub.com";
			
			  $r=	getAccountManagerDetail($link,$empid);

			$subject = "RecruitingHub.com - $companyname has put the Job on Temporary Hold - $jobid - $jobtitle";

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
                                         Dear '.$row2['firstname'].',<br>
                                          <br>
                                          Greetings from <a href="https://www.recruitinghub.com" target="_blank">www.recruitinghub.com </a><br>
                                          <br>
                                          <b>'.$companyname.'</b> has put the <b>'.$jobtitle.'</b> - Job ID <b>('.$jobid.')</b> that you engaged earlier on TEMPORARY HOLD. 
                                          
                                          <br><br>
                                         PLEASE STOP WORKING ON THIS ROLE. This job has now been moved to DISENGAGED/CLOSED folder which can be found in your Recruiter login. We will notify you when the job reopens so you can continue to submit candidates.<br>
                                          <br>
                                          Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">Recruiter Login</a></td>
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

			<td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2023 <br>

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
'subject'=>$subject,'message'=>$message,'cc2'=>'employers@recruitinghub.com','send'=>true];
  AsyncMail($params);
	}
        header('location: jobs'); exit;
        } 
      elseif($action=='filled'){
        mysqli_query($link,"update jobs set status='Filled',priority=0,updatedby='$mid' WHERE jobid='$jobid' ");  
        $content="You have changed the job status as 'Filled'";
        header('location: jobs'); exit;
      } 
     elseif($action=='reopen'){
        mysqli_query($link,"update jobs set status='Open',priority=1,updatedby='$mid',updatedate=now() WHERE jobid='$jobid' ");  
        $content="You have changed the job status to 'Open'";
         $request=mysqli_query($link,"select * from request where jobid='$jobid'");

	while($row=mysqli_fetch_assoc($request)){
	    $rid=$row['recruiterid'];
	      $empid=$row['employerid'];

					$q2=mysqli_query($link,"select a.jobtitle,d.name, e.email,e.reconsidernotification,e.firstname from members e, jobs a,companyprofile d where d.id=e.companyid and a.jobid ='$jobid' and e.memberid='$rid' ");
			
	$row2 = mysqli_fetch_array($q2);
	
		$q3=mysqli_query($link,"select a.jobtitle,d.name, e.email,e.reconsidernotification,e.firstname from members e, jobs a,companyprofile d where d.id=e.companyid and a.memberid=e.memberid and a.jobid ='$jobid' ");
			
	$row3 = mysqli_fetch_array($q3);
				
		//mail to agency
	$to = $row2['email'];
$companyname=$row3["name"];
$jobtitle=$row2["jobtitle"];
			$from = "noreply@recruitinghub.com";
			
			$r=	getAccountManagerDetail($link,$empid);

			$subject = "RecruitingHub.com - $companyname Reopened the Job $jobid - $jobtitle";

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
                                         Dear '.$row2['firstname'].',<br>
                                          <br>
                                          Greetings from <a href="https://www.recruitinghub.com" target="_blank">www.recruitinghub.com </a><br>
                                          <br>
                                          You have earlier worked on JOB ID <b>('.$jobid.')</b> - <b>'.$jobtitle.'</b> role from <b>'.$companyname.'</b> has now been RE-OPENED by the client . Please start reworking on this role and start submitting candidates <br>
                                          <br>
                                          Login here <a href="https://www.recruitinghub.com/recruiter/login" target="_blank">Recruiter Login</a></td>
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

			<td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2023 <br>

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
'subject'=>$subject,'message'=>$message,'cc2'=>'employers@recruitinghub.com','send'=>true];
  AsyncMail($params);
	}
        header('location: jobs'); exit;
        
      // var_dump($content);
      // header('location: jobs'); exit
      }
      else{
      $errormsg="Access denied";	
      header('location: login'); 
      }
}
else{
$notification='Please login to access the page';
$_SESSION['notification']=$notification;
header('location: login'); 
exit;
}
?>
