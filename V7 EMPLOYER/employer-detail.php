<?php
$job='';
require_once '../config.php';

if(isset($_POST['EID']))
$companyid=$_POST['EID'];

$candidateres = mysqli_query($link,"SELECT a.registerdate,a.companyaddress,b.logo as logo,a.replacementperiod,b.sectors,b.*,c.firstname from employers a,companyprofile b,members c where b.id='$companyid' and a.id=b.registerid and b.id=c.companyid"); 


$ispresent = mysqli_num_rows($candidateres);
if($ispresent > 0){ 
   $row = mysqli_fetch_array($candidateres);
   function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}
?>

 <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="company_name"><b><?php echo $row['name'];?></b></h4>
         
  <div class="modal-body" >
<table class="table table-striped">
  <tbody>
      
   <tr>
             
               <td>      <?php 
					 $companyprofile= htmlspecialchars_decode($row['companyprofile'],ENT_QUOTES);
					  if($row['logo'])
					 echo'
					 <img src="../employer/logo/'.$row['id'].'/'.$row['logo'].'" width="100px"  height="100px"/><br>
					 '; ?>
                     
                  </td>
    </tr> 
    
     <tr>
      <td>Been on Recruiting Hub Since:</td>
      <td><?php echo date("j F, Y",strtotime($row['registerdate']));  ?> </td>
    </tr>
  
    <tr>
      <td>Client Website:</td>
      <td><?php echo '<a  target=\"_blank\" href="'.addhttp($row['website']).'">'.$row['website'].'</a>' ?> </td>
    </tr>
    
    <tr>
      <td>Industry Type:</td>
      <td><?php echo $row['sectors'];?> </td>
    </tr>
    
   <tr>
   <td>Contact Person Name:</td>
   <td><?php echo $row['firstname'];?></td>
   </tr>
    
	 <tr>
      <td>Company Description:</td>
       <td><textarea rows="10" cols="480" class="form-control" readonly><?php echo $row['profile'];?></textarea></p> </td>
      
    </tr>
    
    <!--<tr>
      <td>Payment & Replacement Terms:</td>
      <td><?php echo $row['replacementperiod'];?> </td>
    </tr>-->
    
  </tbody>
</table>
</div>
  <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
<?php } ?>
 