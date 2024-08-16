<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<html>
<head>
<title>Razorpay Payment</title>
</head>
<body>
<center>
 
<?php include('crypto.php'); 
	error_reporting(0);
	
	$merchant_data='';
	$working_key='rzp_live_JmIotm0AxxkFdC';//Shared by RAZORPAY
	//$working_key='rzp_live_JmIotm0AxxkFdC';//Shared by RAZORPAY
	//$access_code='dGUThklcjTQXN5nizu3fASAI';//Shared by RAZORPAY
	$access_code='dGUThklcjTQXN5nizu3fASAI';
	
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.urlencode($value).'&';
	}
 
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
 
?>
<form method="post" name="redirect" id="nonseamless" action="https://rzp.io/i/lBweZEn3G2"> 
<?php
echo '<input type="hidden" name="encRequest" value="'.$encrypted_data.'">';
echo '<input type="hidden" name="access_code" value="'.$access_code.'">';
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>