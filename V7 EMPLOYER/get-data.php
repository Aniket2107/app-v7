

<?php



require_once "../config.php";



if(isset($_POST['country'])){

	$country=$_POST['country'];





$res =mysqli_query($link,"SELECT city FROM citybycountry WHERE country='$country' ORDER BY city");

//$res =mysqli_query("SELECT jobtitle FROM jobs WHERE jobtitle LIKE '".$_REQUEST['term']."%' ORDER BY jobtitle");

$data = array();

while ($row = mysqli_fetch_assoc($res)) {

   // $data[] =$row['jobtitle']." - ".$row['employer'];

   $data[] =$row['city'];

   

}

if($country=='US'||$country=='UK'||$country=='Europe'){

		echo '<select class="form-control"  name="joblocation">';

		foreach($data as $city){

		echo '<option value='.$city.'>'.$city.'</option>';

		}

		echo'</select>';

}

else{



echo'<input class="form-control"  name="joblocation" type="text">';



}

}

?>