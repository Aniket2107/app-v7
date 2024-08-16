<?php
$job='';
require_once '../config.php';
$res=mysqli_query($link,"select sector,id from jobsectors");
if(mysqli_num_rows($res)){
	while($row=mysqli_fetch_assoc($res)){
		$sector[]=$row;
	}
}
if(isset($_POST['EID']))
$recruiterid=$_POST['EID'];
$candidateres = mysqli_query($link,"SELECT a.*,b.* from recruitment_agency a, companyprofile b where  a.id=b.registerid and b.registerid ='$recruiterid'");

$ispresent = mysqli_num_rows($candidateres);
if($ispresent > 0){ 
   $row = mysqli_fetch_array($candidateres);
  }
if($row){
?>

 <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="company_name"><?php echo $row['name'];?></h4>
          </div>
  <div class="modal-body" id="cover-modal-body">
<table class="table table-striped">
<thead></thead>
  <tbody>
      
      <tr>
      <td>Been on Recruiting Hub since:</td>
      <td><?php echo date("j F, Y",strtotime($row['registerdate']));  ?> </td>
    </tr>
  
  <!--  <tr>
      <td>Agency Website:</td>
      <td><?php echo $row['website'];?> </td>
    </tr> -->
    
     <tr>
      <td>Location:</td>
      <td><?php echo $row['city'];?>, <?php echo $row['country'];?> </td>
    </tr>
    

    <tr>
      <td>Specialist Sectors:</td>
      <td><?php $exp=explode(',',$row['sectors']);
foreach($sector as $s){
if((in_array($s['sector'], $exp))|| (in_array($s['id'], $exp)))  { $selected[]=$s['sector'];} } echo implode(', ',$selected)?> </td>
    </tr>
	
     <!--<tr>
      <td>Total Agency Experience:</td>
      <td><?php echo $row['experience'];?> Years</td>
    </tr>

	 <tr>
      <td>Number of Placements (last 12 months):</td>
      <td><?php echo $row['placements'];?> Placements</td>
    </tr>-->

	 <tr>
      <td>Agency Description:</td>
      <td><textarea rows="10" cols="480" class="form-control" readonly><?php echo $row['profile'];?></textarea></p> </td>
    </tr>
    
  </tbody>
</table>
</div>
 <div class="modal-footer">
 
<?php } ?>
 