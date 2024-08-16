

<?php



require_once "../config.php";



if(isset($_POST['EID'])){

	$country=$_POST['EID'];





$res =mysqli_query($link,"SELECT city FROM citybycountry WHERE country='$country' ORDER BY city");

//$res =mysqli_query("SELECT jobtitle FROM jobs WHERE jobtitle LIKE '".$_REQUEST['term']."%' ORDER BY jobtitle");



if(mysqli_num_rows($res)>0){



$data = array();

while ($row = mysqli_fetch_assoc($res)) {

   // $data[] =$row['jobtitle']." - ".$row['employer'];

   $data[] =$row['city'];

   
}
echo'<div class="city-checkbox" id="location-filter">

<ul>';

foreach($data as $city){ ?>



<li style="list-style:none">

<div class="checkbox"><label><input  name="joblocation[]" value="<?php echo $city; ?>" type="checkbox"><?php echo $city; ?></label></div>

</li>

<?php }

echo '</div></ul>';

echo'</select>';}

else{



echo'<input class="form-control"  name="joblocation" type="text">';

}

}





?>