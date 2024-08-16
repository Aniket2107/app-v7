<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<html>
<head>
<title>CCAvenue Payment</title>
</head>
<body>
<center>
 
<?php include('crypto.php'); 
	error_reporting(0);
	
	$merchant_data='';
	$working_key='94BA69C40F267809E7C3A113B18EF5CE';//Shared by CCAVENUES
	//$working_key='745DA5A0424DF903A8B44DA4B0D1D2FC';//Shared by CCAVENUES
	//$access_code='AVYK78FF49AO55KYOA';//Shared by CCAVENUES
	$access_code='AVYK78FF49AO55KYOA';
	
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.urlencode($value).'&';
	}
 
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
 
?>
<form method="post" name="redirect" id="nonseamless" action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo '<input type="hidden" name="encRequest" value="'.$encrypted_data.'">';
echo '<input type="hidden" name="access_code" value="'.$access_code.'">';
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>