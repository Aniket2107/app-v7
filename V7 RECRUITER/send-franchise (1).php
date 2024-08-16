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

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
  $data = str_replace("`","",$data);
  return $data;
}

$sql=mysqli_query($link,"insert into franchisee(name,cname,email,mobile,city,country,linkedin,message,through,postdate)values('$name','$cname','$email','$mobile','$city','$country','$linkedin','$message','Agency Login',now())");

if($sql)
{
//send_message($mobile);
echo "<div class='msg-sent'><p style = 'font-size: 16px;
            color: #21a05e;'><b>Your interest to become our franchise partner has been received successfully!</b> Click following link for next steps <a href='https://www.recruitinghub.com/recruiter/franchisepaymentpage' ><b>Franchise Payment Page</b></a></p> <br> <p style = 'font-size: 16px;
            color: #a02121;'><b>What happens next?</b></p> Click following link for next steps <a href='https://www.recruitinghub.com/recruiter/franchisepaymentpage' ><b>Franchise Payment Page</b></a> <br><br>
            <p style = 'font-size: 16px;
            color: #21a05e;'>Check your email <b>($email)</b>.</p> You should have received an automated email with all details and you can click the online calendar link in the email to book a call with us. <br><br>Alternatively, you could also use the live chat button at bottom right corner of this page to speak to a member of staff.</div> ";
            
//mail to our onboarding team
			$to = "franchisee@recruitinghub.com";

			//$from = $email;

			$subject = 'New Franchisee Application via Agency Login from '.$name.' - '.$city.','.$country.'';

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
		  <div style="boder:0"><a href="https://www.recruitinghub.com/admin"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div>
		  </td>
		  
		  
		   </tr>
		  <tr>
			<td style="padding:0px 14px">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
			  <tbody>
					   <tr>
						<td style="padding-top:5px;color:#313131"><br>
						Hello Recruiting Hub Franchisee On-boarding Team, you have received a new franchise application via Agency login as below
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
			
 $params = ['from'=>'noreply@recruitinghub.com','name'=>'RecruitingHub Franchise','to'=>$to,'cc2'=>'apeksha@recruitinghub.com','subject'=>$subject,'message'=>$message1,'send'=>true];
   AsyncMail($params);
   
   //mail to franchise applicant
   	$to = $email;

			$from = "noreply@recruitinghub.com";

			$subject = 'Re:RecruitingHub.com - '.$name.', Thank you for applying to become our franchise partner via Agency Login from '.$city.','.$country.'';

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
		  <div style="boder:0"><a href="https://www.recruitinghub.com/franchise"><img src="https://www.recruitinghub.com/image/color-logo.png" alt="www.recruitinghub.com"></a></div>
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
						  We have received your application showing your interest to become our Franchisee and we hope that you have already read our faqs. If not you can read from this link now, we have attempted to explain the ROI, revenue model etc through this link -> <a href="https://www.recruitinghub.com/franchise" target="_blank"><b>Franchise FAQs</b></a> 
						  <br><br>
						  Download our Franchise Brochure from this link -> <a href="https://www.recruitinghub.com/Franchise Brochure - RecruitingHub.pdf" target="_blank"><b>DOWNLOAD FRANCHISE BROCHURE</b></a> 
						  <br><br>
						  As a Franchisee of RecruitingHub.com, you will be investing into the future of the Recruitment Agencies industry. RecruitingHub.com is a B2B aggregator that stands as an online medium between the Employers (Corporates) and 1000s of Recruitment Agencies (Consultancies). Imagine UBER or Amazon or Rightmove for Recruitment Agency industry.
						  <br><br>
						 
<b>It will cost an ONE OFF franchise setup fee of</b><br><br>
. <b>UK Franchise Fee</b>: <b>GBP 25,000</b> + 20% VAT (we are looking to cover 48 counties in England, 33 in Scotland, 13 in Wales and 6 in N.Ireland)<br>
(We can introduce you to our partners that can assist with government backed startup funding)<br>

(The market size, measured by revenue, of the Employment Placement Agencies industry was £17.7bn in 2022) <br><br>

. <b>India Franchise Fee</b>: <b>Rs.5 lakhs</b> + 18% GST for Tier1 Cities in India or <b>Rs.3 lakhs</b> + GST for Tier2 Cities. (We are looking to cover 300 cities in India)<br>
 (The Indian staffing market is currently a $10 billion industry, growing at 28% percent YoY and poised to become one of the largest by 2030)<br><br>
 
 . <b>ROW (Rest of the World)</b>: <b>Equivalent to GBP 10,000</b> (we are looking for franchisees from EU, Australia, New Zealand, Singapore, Malaysia, Middle East, Africa, US, South America & Canada)<br><br>

plus your own usual monthly working capital<br><br>

<a href="https://www.recruitinghub.com/franchisepaymentpage" target="_blank"><b>Pay for Franchise</b></a><br><br>

<b>What are you paying this one off fee for?</b><br><br>

. Software licensing Cost<br>
. Employer leads/New Client Acquisition<br>
. Access to over 4000 registered recruitment vendors on our platform worldwide who can supply candidates 2x faster to clients we onboard for you from within your territory or new clients you bring to the platform using your unique employer sign up link (we will provide you this link upon onboarding as our franchise partner)<br>
. Ownership of Clients originally signed up by you<br>
. Admin/CRM Portal access, RH email account, Live Chat facility etc<br>
. Product Training<br>
. Marketing Assistance<br>
. Accounts, Collection assistance<br><br>

You can view the standard agreement for Franchisee from this link - <a href="https://www.recruitinghub.com/Franchise%20Agreement%20-%20draft%20-%20RecruitingHub.pdf" target="_blank"><b>Franchise Agreement</b></a>

<br><br>We look forward speaking to you.

<br><br>
A comprehensive franchise business plan will be sent post our initial phone/zoom call. <br><br>


						<b>  What information we have received from you are as below</b>
						  
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
			
 $params = ['from'=>$from,'name'=>'RecruitingHub Franchise','to'=>$to,'cc2'=>'apeksha@recruitinghub.com','cc4'=>'franchisee@recruitinghub.com','subject'=>$subject,'message'=>$message2,'send'=>true, 'attachment'=>"https://www.recruitinghub.com/FranchiseBrochureRecruitingHub.pdf"];
   AsyncMail($params);
   
}else{
echo "<div class='msg-sent'><p style='
            font-size: 14px;
            color: #a02121;
        '><b>Message not sent. Remove any special character in the form and apply again or use the live chat to talk to us.</b></div>";
}

?>
