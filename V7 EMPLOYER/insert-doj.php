<?php

require '../Smtp/index.php';
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data, ENT_QUOTES, "UTF-8");
  return $data;
}
 
$doj=test_input($_POST['doj']);


$q=mysqli_query($link,"insert into  candidates(doj) values('$doj')");

$id = mysqli_insert_id($link);

$content="<h4>DOJ Updated </h4>";
	

	$result = mysqli_query($link,$sql);

	while($row = mysqli_fetch_assoc($result)){

  
		}
	
