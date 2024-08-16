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
$admin=$_SESSION['admin'];
$ecountry=$_SESSION['country'];
$cid=$_SESSION['cid'];
}
include "../config.php";
if($adminrights){
$sql="SELECT  b.fname as candidatename,c.candidateid as candidateid,e.name as agency,c.recruiterid as recruiterid ,a.jobtitle as jobtitle,a.jobid,c.submitdate,b.contactnumber as Mobile,b.email,b.notice as noticeperiod ,b.currentemployer,b.currentjobtitle,b.location as CurrentLocation,b.minex as Experience,b.currentsalary as CurrentCTC,b.desiredsalary as ExpectedCTC,b.additionalinfo as additionalinfo,c.status as CandidateStatus,b.cv as Cv FROM submitted_candidates c,jobs a,candidates b,companyprofile e,members d,members f  WHERE a.memberid=f.memberid and f.companyid='$cid' and a.jobid=c.jobid and b.id=c.candidateid and c.status='Offered' and c.recruiterid= d.memberid and d.companyid=e.id and submitdate >= CURDATE()-INTERVAL 6 MONTH order by submitdate desc";
}else{
  $sql="SELECT  b.fname as candidatename,c.candidateid as candidateid,e.name as agency,c.recruiterid as recruiterid ,a.jobtitle as jobtitle,a.jobid,c.submitdate,b.contactnumber as Mobile,b.email,b.notice as noticeperiod ,b.currentemployer,b.currentjobtitle,b.location as CurrentLocation,b.minex as Experience,b.currentsalary as CurrentCTC,b.desiredsalary as ExpectedCTC,b.additionalinfo as additionalinfo,c.status as CandidateStatus,b.cv as Cv FROM submitted_candidates c,jobs a,candidates b,companyprofile e,members d  WHERE a.memberid='$mid' and a.jobid=c.jobid and b.id=c.candidateid and c.status='Offered' and c.recruiterid= d.memberid and d.companyid=e.id and submitdate >= CURDATE()-INTERVAL 6 MONTH order by submitdate desc";  
} 


$result = @mysqli_query($link,$sql) or die("Couldn't execute query:<br>" . mysqli_error($link). "<br>" . mysqli_errno($link));    
//$result = @mysqli_query($sql) ;
$file_ending = "xls";

header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=Offercandidates.xls");  
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
