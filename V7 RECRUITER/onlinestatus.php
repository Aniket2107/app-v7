<?php

header('Content-Type: application/json');
$array = array();

require_once "../config.php";

$res = mysql_query("SELECT * FROM `members` WHERE status=1");
if(mysql_num_rows($res) > 0){
    while($row = mysql_fetch_assoc($res)){  
        $array[] = $row['memberid'];  // this adds each online user id to the array         
    }
}
echo json_encode($array);

?>