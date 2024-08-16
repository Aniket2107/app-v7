<?php

if (session_status() == PHP_SESSION_NONE) {

    session_start();

}

$mid=$name=$email=$iam='';

if(isset($_SESSION['mid'])){

$mid=$_SESSION['mid'];

$name=$_SESSION['name'];

$email=$_SESSION['email'];

$iam=$_SESSION['iam'];

$adminrights=$_SESSION['adminrights'];

$cid=$_SESSION['cid'];

$admin=$_SESSION['admin'];

$rcountry=$_SESSION['country'];

}

include "../config.php";

$candidatearray=array();

//jobs posted recently

$candidatemsg='';

//$ci=0;

$jfilter=$efilter=$sfilter=$cfilter='';



if(isset($_GET['jobtitle']) && ($_GET['jobtitle']!='')){

	$jobtitle=$_GET['jobtitle'];

	$jfilter="and a.jobtitle like '%$jobtitle%'";

}

if(isset($_GET['employer']) && ($_GET['employer']!='')){

	$employer=$_GET['employer'];

	$efilter="and d.name = '$employer'";

}



if(isset($_GET['candidate']) && ($_GET['candidate']!='')){

	$candidate=$_GET['candidate'];

	$cfilter="and b.fname like '%$candidate%'";

}



if(isset($_GET['status']) && ($_GET['status']!='')){

	$status=$_GET['status'];

	if($status=='CV Rejected')

	$sfilter="and c.prestatus='submitted'";

	elseif($status=='Interview Rejected')

	$sfilter="and c.prestatus='Shortlisted'";

	else

	$sfilter="and c.prestatus='Offered'";

}



$sql="SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,c.prestatus,c.viewnotes,c.comment,c.submitdate,c.candidateid as candidateid,d.name as employer

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and e.memberid=a.memberid and 

		d.id=e.companyid and c.recruiterid='$mid' and c.status='Rejected' and submitdate>=CURDATE()-INTERVAL 6 MONTH $jfilter $efilter $cfilter $sfilter

	ORDER BY 

		submitdate desc";



$result = @mysqli_query($link,$sql) or die("Couldn't execute query:<br>" . mysqli_error($link). "<br>" . mysqli_errno($link));    

$file_ending = "xls";



header("Content-Type: application/xls");    

header("Content-Disposition: attachment; filename=rejectedcandidates.xls");  

header("Pragma: no-cache"); 

header("Expires: 0");



$sep = "\t"; 

for ($i = 0; $i < mysqli_num_fields($result); $i++) {

echo mysqli_fetch_field_direct($result, $i)->name ."\t";

}

print("\n");    



    while($row = mysqli_fetch_row($result))

    {

        $schema_insert = "";

        for($j=0; $j<mysqli_num_fields($result);$j++)

        {

            if(!isset($row[$j]))

                $schema_insert .= "NULL".$sep;

            elseif ($row[$j] != "")

                $schema_insert .= "$row[$j]".$sep;

            else

                $schema_insert .= "".$sep;

        }

        $schema_insert = str_replace($sep."$", "", $schema_insert);

        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);

        $schema_insert .= "\t";

        print(trim($schema_insert));

        print "\n";

    }   

?>

