<?php

if (session_status() == PHP_SESSION_NONE) {

    session_start();

}

$mid=$name=$email=$iam='';

if(isset($_SESSION['id'])){

$mid=$_SESSION['id'];

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

require_once 'config.php';
$erows=array();
$sql=mysqli_query($link,"select * from companyprofile ");
while($erow=mysqli_fetch_array($sql)){
	$erows[]=$erow;
}

?>			

<!doctype html>

<html>

<head>

     <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

     <title>Franchisee Links | Recruiter Hub</title>

    <meta name="application-name" content="Recruiting-hub" />

	<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet" type="text/css">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/fonts/css/font-awesome.min.css" media="screen, projection">

 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="js/bootstrap.min.js"></script>



         

</head>

<body>



<div class="header-inner">

<div class="header-top">

<a class="navbar-brand" href="#"><img src="images/logo.png"></a>

</div>

</div>



<div class="summary-wrapper">

<div class="col-sm-12 account-summary no-padding">



<div class="col-sm-2 no-padding">

<div class="account-navi">

<div class="sidebar-user">

			<div class="category-content">

				<div class="media">

					<a href="index.htm#" class="media-left"><img src="images/user.png" class="img-circle img-sm" alt=""></a>

					<div class="media-body">

						<span class="media-heading text-semibold">Admin</span>

						<div class="text-size-mini text-muted">

							Account manager

						</div>

					</div>



					

				</div>

			</div>

		</div>   		<?php include('side-menu.php'); ?>


</div>

</div>



<div class="col-sm-10">

<div class="account-navi-content">

  <div class="tab-content">

  <div role="tabpanel" class="tab-pane active" id="account.php">

          <div class="dashboard">

        <div class="dashboard-head"><h2><i class="fa fa-th-large"></i> Franchisee Employer Sign Up Links</h2>

          <ul class="breadcrumb">

				<li><a href="#"><i class="fa fa-home"></i>Home</a></li>

				<li class="active">Franchisees List</li>

			</ul>

          </div>



  <div class="row">

    <div class="col-xs-12">

      <div class="panel panel-default">

        <div class="panel-body">

<div class="table-responsive">


            <table class="table table-striped">

              <thead>

                <tr>

                <th>Franchise Partner </th>

                <th>Unique Link</th>
                
                <th>QR Code</th>


                </tr>

              </thead>              

              

              <tbody>

              <?php 

			  foreach($erows as $erow1){

			 ?>

			  <tr>

			  <td><?php echo $erow1['name']; ?></td>

			  <td><?php echo 'https://www.recruitinghub.com/fp-employers?cp='.strtolower(str_replace(' ','-',$erow1['name'])).'_'.$erow1['id'].' '; ?></td>
			  
			  <td><?php echo $erow1['qrcode']; ?></td>

			  
			</tr>

			  <?php 

			  }

			  ?>

  </tbody>

   </table>


</div>

      </div>

      </div>

    </div>

  </div>

</div>

</div>

    

      

      

      

      

     </div>

     </div>

     </div>

<div class="clearfix"></div>

</div>

</div>









 </body>

</html>

