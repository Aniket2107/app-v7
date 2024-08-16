<?php

require '../Smtp/index.php';
require_once '../config.php';

$name=$_POST['name'];
$cname=$_POST['cname'];
$email=$_POST['email'];
$mobile=$_POST['mobile'];
$city=$_POST['city'];
$country=$_POST['country'];
$linkedin=$_POST['linkedin'];
$message=$_POST['message'];

$sql=mysqli_query($link,"insert into subsidiary(name,cname,email,mobile,city,country,linkedin,message,postdate)values('$name','$cname','$email','$mobile','$city','$country','$linkedin','$message',now())");

if($sql)
{
//send_message($mobile);
echo "<div class='msg-sent'><p style = 'font-size: 16px;
            color: #21a05e;'>Your interest to become our foreign subsidiary has been received successfully!</p> <br> <p style = 'font-size: 16px;
            color: #a02121;'> <b>What happens next?</b></p> <br> <p style = 'font-size: 16px;
            color: #21a05e;'>Check your email <b>($email)</b>.</p> You should have received an automated email with all details and you can click the online calendar link in the email to book a call with us. <br><br>Alternatively, you could also use the live chat button at bottom right corner of this page to speak to a member of staff.</div>";
//mail to our onboarding team
			$to = "subsidiary@recruitinghub.com";

			//$from = $email;

			$subject = 'New Foreign Subsidiary Application from '.$name.' - '.$city.','.$country.'';

			$message1 = '<html>
			<body bgcolor="#FFFFFF">
				<div>
	<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
	  <tbody>
	  <tr>
		<td style="padding:12px 12px 0px 12px">
		<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody>
		  <tr>
		  <td colspan="3" style="padding-left:14px">
		  <div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div>
		  </td>
		   </tr>
		  <tr>
			<td style="padding:0px 14px">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
					   <tr>
						<td style="padding-top:5px;color:#313131"><br>
						Hello Recruiting Hub Foreign Subsidiary On-boarding Team, you have received a new foreign subsidiary application as below
						  <br>
						  <p>Name: '.$name.'</p>
						  <p>Company Name: '.$cname.'</p>
						  <p>Contact: '.$mobile.'</p>
						  <p>Email: '.$email.'</p>
						  <p>City: '.$city.'</p>
						  <p>Country: '.$country.'</p>
						  <p>Linkedin URL: '.$linkedin.'</p>
						  <p>Message: '.$message.'</p>
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
			<td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>
			  </p></td>
		  </tr>
	</tbody></table>
	</div>
	</body>
			</html>';
			
 $params = ['from'=>'noreply@recruitinghub.com','name'=>'RecruitingHub','to'=>$to,'cc2'=>'apeksha@recruitinghub.com','subject'=>$subject,'message'=>$message1,'send'=>true];
   AsyncMail($params);
   
   //mail to subsidiary applicant
   	$to = $email;

			$from = "subsidiary@recruitinghub.com";

			$subject = 'Re:RecruitingHub.com - Thank you for applying to become our foreign subsidiary - '.$name.' - '.$city.','.$country.'';

			$message2 = '<html>
			<body bgcolor="#FFFFFF">
				<div>
	<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000" align="center" bgcolor="#792785" border="0" cellpadding="0" cellspacing="0" width="620">
	  <tbody>
	  <tr>
		<td style="padding:12px 12px 0px 12px">
		<table style="border-right:1px solid #d5d8d9;border-left:1px solid #d5d8d9" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
		  <tbody>
		  <tr>
		  <td colspan="3" style="padding-left:14px">
		  <div style="boder:0"><a href="https://www.recruitinghub.com/"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div>
		  </td>
		   </tr>
		  <tr>
			<td style="padding:0px 14px">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
					   <tr>
						<td style="padding-top:5px;color:#313131"><br>
						Dear '.$name.', 
						<br><br>
						We can setup a video call on zoom to discuss this further and you can book your meeting with us using this link -> <a href="https://calendly.com/rechubfranchisee/30min" target="_blank"><b>Book a Demo</b></a>
						  <br><br>
						  We have received your application showing your interest to become our Foreign Subsidiary and we hope that you have already read our faqs. If not you can read from this link now, we have attempted to explain the ROI, revenue model etc through this link -> <a href="https://www.recruitinghub.com/subsidiary" target="_blank"><b>Subsidiary FAQs</b></a> 
						  <br><br>
						  You are investing in to the future of the Recruitment Agencies industry. RecruitingHub.com is a B2B aggregator that stands as an online medium between the Employers (Corporates) and 1000s of Recruitment Agencies (Consultancies). Imagine UBER or Amazon or Rightmove for Recruitment Agency industry.
						  <br><br>
						  You dont need Sales or Recruiters to make money in Recruitment, multiple revenues in recruitment business using our platform. Our Foreign Subsidiary owner requires full time commitment to the business and require to pay us the share price while forming the company. On signing of the Shareholding Agreement the Foreign Subsidiary local shareholder will pay to Recruiting Hub Parent Company the sum of £xxxxx as share price towards purchase of x% of shares in the foreign Subsidiary. This sum is based on amount of shares he/she wants to purchase in the foreign subsidiary based on our valuation in the local market which can be discussed on our 1st Zoom meeting. We will together form a Company in your Country (e.g Recruiting Hub South Africa Ltd) as a foreign subsidiary to Recruiting Hub International Ltd with a % amount of shares owned by you along with the parent company of Recruiting Hub appointing a person nominated by you to represent as Director in your country. You will need capital to pay towards company formation, bank account opening, pay one time share price to the parent company plus monthly operating expenses like office space, staff salaries, bills and other day to day expenses with a potential to earn in Millions.

<br><br>We look forward speaking to you.
<br><br>
A comprehensive franchise business plan will be sent post our initial phone/zoom call. <br><br>
						  What we have received from you as below
						  
						  <p>Name: '.$name.'</p>
						  <p>Company Name: '.$cname.'</p>
						  <p>Contact: '.$mobile.'</p>
						  <p>Email: '.$email.'</p>
						  <p>City: '.$city.'</p>
						  <p>Country: '.$country.'</p>
						  <p>Linkedin URL: '.$linkedin.'</p>
						  <p>Message: '.$message.'</p>
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
			<td style="font-size:11px;color:#ffffff;padding:9px 0 10px 18px;line-height:16px" bgcolor="#792785"><p style="margin:0px;padding:0px"> All Rights Reserved. &copy; Copyright 2024 <br>
			  </p></td>
		  </tr>
	</tbody></table>
	</div>
	</body>
			</html>';
			
 $params = ['from'=>$from,'name'=>'RecruitingHub','to'=>$to,'cc2'=>'apeksha@recruitinghub.com','cc4'=>'subsidiary@recruitinghub.com','subject'=>$subject,'message'=>$message2,'send'=>true];
   AsyncMail($params);
   
}else{
echo "<div class='msg-sent'>Message not sent.</div>";
}

?>
