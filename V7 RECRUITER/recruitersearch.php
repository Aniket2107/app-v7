
<?php
if(!isset($_REQUEST['term']))
exit();

require_once "../config.php";


$res =mysqli_query($link,"SELECT firstname FROM members WHERE name LIKE '".$_REQUEST['term']."%' and iam='Recruiter' ORDER BY name");
//$res =mysqli_query($link,"SELECT jobtitle FROM jobs WHERE jobtitle LIKE '".$_REQUEST['term']."%' ORDER BY jobtitle");
$data = array();
while ($row = mysqli_fetch_assoc($res)) {
   // $data[] =$row['jobtitle']." - ".$row['employer'];
   $data[] =$row['name'];
}
echo json_encode($data);

?>