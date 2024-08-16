<?php

$job='';

require_once '../config.php';

if(isset($_POST['EID']))

$jobid=$_POST['EID'];

$request='';
$request=array();
 $res=mysqli_query($link,"SELECT a.requestid,a.status,b.firstname as name,c.name as companyname,a.recruiterid FROM requestbench a,members b, companyprofile c WHERE jobid='$jobid' and b.memberid=a.recruiterid and b.companyid=c.id");

 

 $isexist = mysqli_num_rows($res);

if($isexist > 0){ 

    while($row = mysqli_fetch_array($res)){

			$request[]=$row;

				}

			}		

					

?>

<div id="job_title"> </div>

<?php if($isexist >0){echo'

 <table class="table table-striped jobs-list">

                  <thead>
                  
                  <div id="recruiter_name"><strong>COMMUNICATE WITH VENDORS</strong> </div>
                  
                  <form method="POST" id="form1">
        <div class="form-group">
        <div class="col-sm-6">
         <div class="checkbox"><label><input value="1" name="allcandi" type="checkbox" id="select-all">Select All</label></div>
         </div>
         <div class="col-sm-6">
         <div class="btn-group">
      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
        Action <span class="caret"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu--right" role="menu">
             	<!-- <li><a title="Disengage" class="submit-candidate" href="reject-request?requestid='.$r['requestid'].'">Reject</a></li> -->
			
			<li> <a title="Message Agency" id="select-all-submit" href="msg-agency?jobid='.$jobid.'&rids=<ids>">Message Agency</a></li>   
      </ul>
    </div>
    </div>
    </div>

                    <tr>

                      <th>

                       Status

                      </th>

                       <th>Agency Name</th>

  					 <th>Action</th>

                     

                    </tr>

                  </thead>

                  <tbody>';

  foreach($request as $r){   

  echo '

  <tr>

  

  <td><input type="checkbox" data-id="'.$jobid.'" class="messageCheckbox" value="'.$r['recruiterid'].'" name="allcheck"> '.$r['status'].' </td>

  <td>'.$r['name'].' / '.$r['companyname'].' </td>

  <td>

  

 

    <div class="btn-group">

      <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">

        Action <span class="caret"></span>

      </button>

      <ul class="dropdown-menu dropdown-menu--right" role="menu">';

	   if($r['status'] == 'Requested')

	  echo  '<li><a title="Approve" href="approve-request?requestid='.$r['requestid'].'">Approve</a></li>';

	  		echo '
	  		
	  		<li> <a title="Message Agency" id="select-all-submit" href="msg-agency?rid='.$r['recruiterid'].'&jobid='.$jobid.'">Message Agency</a></li>

	  		<li><a title="Disengage" class="submit-candidate" href="reject-request?requestid='.$r['requestid'].'">Reject</a></li>
			
			
      </ul>

    </div>

  </td>

</tr>';

} 

 

echo'</tbody>

 </table>';}else{  

 echo 'No Engaged Recruiters found'; 
 
 } ?>
 
 <script language='JavaScript'>
  $('#select-all-submit').click(function(event) {
// var voyageIds = $('input[name="allcheck[]"]:checked:enabled').map(function() {
// if(this.value != null){
// console.log( this.value)
// return this.value;
// }
//  }).get();


//              // alert(newArray )
// var url = $(this).attr("href");
// url = url.replace(",","")
// url = url.split("&")


// url[1] = "&rids="+voyageIds.join(",")
// $(this).attr("href",url)
// if(voyageIds.length > 0){
// return true;
// }

let checked = [];
 $('input[name="allcheck"]:checked').each(function() {
   checked.push(this.value)
   return this.value;
});

if(checked.length > 0){
let url = "msg-agencys?rids="+checked+"&jobid="+$('input[name="allcheck"]').attr("data-id")
 $(this).attr("href",url)
return true
}





return false;

  
  });

  
  $('#select-all').click(function(event) {
    if(this.checked) {
      // Iterate each checkbox
      $(':checkbox').each(function() {
        this.checked = true;
      });
    }
    else {
      // Iterate each checkbox
      $(':checkbox').each(function() {
        this.checked = false;
      });
    }
  });