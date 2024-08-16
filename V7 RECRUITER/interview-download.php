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

$content='';

if(isset($_POST['jobtitle']) && ($_POST['jobtitle']!='')  && isset($_POST['employer']) && ($_POST['employer']!='') && isset($_POST['candidate']) && ($_POST['candidate']!='')){

	$jobtitle=$_POST['jobtitle'];

	$employer=$_POST['employer'];

	$candidate=$_POST['candidate'];

	$sql = "

	SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid, b.id,d.name as employername, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,c.viewnotes,c.submitdate,c.candidateid as candidateid

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and c.status='Shortlisted' and a.jobtitle like '%$jobtitle%' and e.memberid=a.memberid and 

		d.id=e.companyid and d.name = '$employer' and submitdate >= CURDATE()-INTERVAL 6 MONTH and b.fname like '%$candidate%' and c.recruiterid='$mid' 

	ORDER BY 

		submitdate desc

		"; 

	}

elseif(isset($_POST['jobtitle']) && ($_POST['jobtitle']!='')  && isset($_POST['employer']) && ($_POST['employer']!='') && isset($_POST['candidate']) && ($_POST['candidate']=='')){

	$jobtitle=$_POST['jobtitle'];

	$employer=$_POST['employer'];

	$sql = "

	SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid,d.name as employername, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,c.viewnotes,c.submitdate,c.candidateid as candidateid

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and c.status='Shortlisted' and a.jobtitle like '%$jobtitle%' and e.memberid=a.memberid and 

		d.id=e.companyid and d.name = '$employer'  and c.recruiterid='$mid' and submitdate >= CURDATE()-INTERVAL 6 MONTH

	ORDER BY 

		submitdate desc

		"; 

	}

elseif(isset($_POST['jobtitle']) && ($_POST['jobtitle']!='')  && isset($_POST['employer']) && ($_POST['employer']=='')&& isset($_POST['candidate']) && ($_POST['candidate']!='')){

	$jobtitle=$_POST['jobtitle'];

	$candidate=$_POST['candidate'];

	$sql = "

	SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid,d.name as employername, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,c.viewnotes,c.submitdate,c.candidateid as candidateid

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and c.status='Shortlisted' and a.jobtitle like '%$jobtitle%' and e.memberid=a.memberid and 

		d.id=e.companyid and  b.fname like '%$candidate%' and c.recruiterid='$mid' and submitdate >= CURDATE()-INTERVAL 6 MONTH

	ORDER BY 

		submitdate desc

		"; 

	}

elseif(isset($_POST['jobtitle']) && ($_POST['jobtitle']=='')  && isset($_POST['employer']) && ($_POST['employer']!='') && isset($_POST['candidate'])&& ($_POST['candidate']!='')){

	

	$employer=$_POST['employer'];

	$candidate=$_POST['candidate'];

	$sql = "

	SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid,d.name as employername, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,c.viewnotes,c.submitdate,c.candidateid as candidateid

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and c.status='Shortlisted'  and e.memberid=a.memberid and 

		d.id=e.companyid and d.name = '$employer' and b.fname like '%$candidate%' and c.recruiterid='$mid' and submitdate >= CURDATE()-INTERVAL 6 MONTH

	ORDER BY 

		submitdate desc

		"; 

	}

elseif(isset($_POST['jobtitle']) && ($_POST['jobtitle']!='')  && isset($_POST['employer']) && ($_POST['employer']=='') && isset($_POST['candidate']) && ($_POST['candidate']=='')){

	$jobtitle=$_POST['jobtitle'];

	

	$sql = "

	SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid,d.name as employername, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,c.viewnotes,c.submitdate,c.candidateid as candidateid

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and c.status='Shortlisted' and a.jobtitle like '%$jobtitle%' and e.memberid=a.memberid and 

		d.id=e.companyid   and c.recruiterid='$mid' and submitdate >= CURDATE()-INTERVAL 6 MONTH

	ORDER BY 

		submitdate desc

		"; 

	}

elseif(isset($_POST['jobtitle']) && ($_POST['jobtitle']=='')  && isset($_POST['employer']) && ($_POST['employer']!='') && isset($_POST['candidate'])&&($_POST['candidate']=='')){

	

	$employer=$_POST['employer'];

	

	$sql = "

	SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid,d.name as employername, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,c.viewnotes,c.submitdate,c.candidateid as candidateid

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and c.status='Shortlisted'  and e.memberid=a.memberid and 

		d.id=e.companyid and d.name = '$employer'  and c.recruiterid='$mid' and submitdate >= CURDATE()-INTERVAL 6 MONTH

	ORDER BY 

		submitdate desc

		"; 

	}

elseif(isset($_POST['jobtitle']) && ($_POST['jobtitle']=='')  && isset($_POST['employer']) && ($_POST['employer']=='') && isset($_POST['candidate']) && ($_POST['candidate']!='')){

	

	$candidate=$_POST['candidate'];

	$sql = "

	SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid,d.name as employername, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,c.viewnotes,c.submitdate,c.candidateid as candidateid

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and c.status='Shortlisted' and  e.memberid=a.memberid and 

		d.id=e.companyid  and b.fname like '%$candidate%' and c.recruiterid='$mid' and submitdate >= CURDATE()-INTERVAL 6 MONTH

	ORDER BY 

		submitdate desc

		"; 

	}	

else{

	$sql = "

	SELECT 

		a.jobid,a.jobtitle as jobtitle,	a.memberid,d.name as employername, b.id, b.fname as fname, b.contactnumber,b.cv as cv,b.desiredsalary,b.currentsalary,b.currentcurrency as currency,b.notice as noticeperiod,b.currentjobtitle,c.status as candidatestatus,

		c.viewnotes,c.submitdate,c.candidateid as candidateid

	FROM 

		submitted_candidates c,	jobs a,	candidates b, companyprofile d, members e 

	WHERE 

		a.jobid=c.jobid and b.id=c.candidateid and c.status='Shortlisted' and e.memberid=a.memberid and 

		d.id=e.companyid  and c.recruiterid='$mid' and submitdate >= CURDATE()-INTERVAL 6 MONTH

	ORDER BY 

		submitdate desc

		"; 

	}



$result = @mysqli_query($link,$sql) or die("Couldn't execute query:<br>" . mysqli_error($link). "<br>" . mysqli_errno($link));    

$file_ending = "xls";



header("Content-Type: application/xls");    

header("Content-Disposition: attachment; filename=interviewcandidates.xls");  

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

