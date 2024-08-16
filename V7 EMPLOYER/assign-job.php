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
require '../Smtp/index.php';

require '../helpers/general.php';

$emid=$cmname='';
$page=1;
if(isset($_GET['employerid'])){
	$emid=$_GET['employerid'];
}
if(isset($_GET['cmname'])){
	$cmname=$_GET['cmname'];
}
if(isset($_GET['page'])){
	$page=$_GET['page'];
}



$sqlx=mysqli_query($link,"update employers set clientmanager='$cmname', client_manager_assigned=1,approvedby='$mid',assignedby=$mid,movedate=now() where id='$emid'");


$sql= "select * from employers e where  e.id='$emid'";


$arr = mysqli_fetch_assoc(mysqli_query($link,$sql));

$r = getAccountManagerDetailEmployers($link,$emid);

//mail to AM

$message_temlt = '<html>
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
                                                     Dear '.$r["cmanager"].'<br>
                            <p></p>
                                                    
                                        <p>An Employer that registered directly on our Portal has been assigned to you -> <b>'.$arr['companyname'].'</b> </p>
                                                     
                                                    You can find this client in your ADMIN -> EMPLOYERS -> Registered </p>
                                        
                                        Please note that all monetary benefits of managing this client as an account manager will start from this date only (<b>'.$arr['movedate'].'</b>). CVs (if any) submitted earlier to this date will not be considered for  monetization.             
                                                    
                                                    </td>
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
        <td width="272" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2023 <br>
          </p></td>
        <td width="346" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px">Worlds No.1 Online Recruitment Marketplace<br>
          </p></td>
      </tr>
</tbody>
</table>
</div>
</body>
    </html>';
  

	$subject = "We have Assigned a New Client to you - ".$arr['companyname'];
  
  $params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$r['email'],'subject'=>$subject,'message'=>$message_temlt,'cc'=>'employers@recruitinghub.com','send'=>true];
  AsyncMail($params);


//mail to Client

$message_client = '<html>
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
                                                     Dear '.$arr["name"].'<br>
                            <p></p>
                            
                             Login here <a href="https://www.recruitinghub.com/employer/login" target="_blank">Employer Login</a><br>
                                                    
                                        <p>You have been assigned an Account Manager from Recruiting Hub -> <b>'.$r["cmanager"].'</b> </p>
                                                     
                                                    Your Account Manager from Recruiting Hub will contact you shortly to schedule a demo </p>
                                        
                                        Contact Info of the Account Manager is as below:<br><br>
                                        
                                       Phone -> <b> '.$r['mobilenumber'].'</b><br>
                                       Email -> <b> '.$r['email'].'</b>
                                                    
                                                    </td>
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
        <td width="272" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2023 <br>
          </p></td>
        <td width="346" bgcolor="#792785" style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px"><p style="margin:0px;padding:0px">Worlds No.1 Online Recruitment Marketplace<br>
          </p></td>
      </tr>
</tbody>
</table>
</div>
</body>
    </html>';
  

	$subject = "Your Account Manager from Recruiting Hub - ".$r['cmanager'];
  
  $params = ['from'=>'noreply@recruitinghub.com','name'=>'Recruiting Hub','to'=>$arr['email'],'subject'=>$subject,'message'=>$message_client,'cc'=>'employers@recruitinghub.com','cc2'=>$r['email'],'send'=>true];
  AsyncMail($params);



//add email 

//$sql=mysqli_query($link,"update employers set clientmanager='$cmname' , client_manager_assigned=1 ,approvedby=$mid , assignedby=$mid where id=$emid");

if(mysqli_affected_rows($link)){
	header('location: jobs.php?page='.$page.'&'); 
	exit;
}else{
	header('location: jobs.php?page='.$page.'&'); 
	exit;
}
?>
             
    