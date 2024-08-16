<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	}
	require_once '../config.php';
$mid=$name=$email=$iam='';
if(isset($_SESSION['mid'])){
$mid=$_SESSION['mid'];
$name=$_SESSION['name'];
$email=$_SESSION['email'];
$iam=$_SESSION['iam'];
$cid=$_SESSION['cid'];
$rcountry=$_SESSION['country'];

$notification='';
}
else{
$notification='Please login to access the page';
$_SESSION['notification']=$notification;
header('location: login'); 
exit;
}
if(isset($_POST['EID']))
 $feedbackid=$_POST['EID'];
 $cname=$_POST['cname'];
 $content='';
$feedback=array();
$sql=mysqli_query($link,"select * from recruiterrating where ratedto='$feedbackid'");
if(mysqli_num_rows($sql)){ 
	while($row = mysqli_fetch_assoc($sql)){
	$feedback=$row;
	}
	}

?>
<style>
.rating {
    float:left;
}

/* :not(:checked) is a filter, so that browsers that don’t support :checked don’t 
   follow these rules. Every browser that supports :checked also supports :not(), so
   it doesn’t make the test unnecessarily selective */
.rating:not(:checked) > input {
    position:absolute;
    top:-9999px;
    clip:rect(0,0,0,0);
}

.rating:not(:checked) > label {
    float:right;
    width:1em;
    padding:0 .1em;
    overflow:hidden;
    white-space:nowrap;
    cursor:pointer;
    font-size:200%;
    line-height:1.2;
    color:#ddd;
    text-shadow:1px 1px #bbb, 2px 2px #666, .1em .1em .2em rgba(0,0,0,.5);
}

.rating:not(:checked) > label:before {
    content: '★ ';
}

.rating > input:checked ~ label {
    color: #f70;
    text-shadow:1px 1px #c60, 2px 2px #940, .1em .1em .2em rgba(0,0,0,.5);
}

.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
    color: gold;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > input:checked + label:hover,
.rating > input:checked + label:hover ~ label,
.rating > input:checked ~ label:hover,
.rating > input:checked ~ label:hover ~ label,
.rating > label:hover ~ input:checked ~ label {
    color: #ea0;
    text-shadow:1px 1px goldenrod, 2px 2px #B57340, .1em .1em .2em rgba(0,0,0,.5);
}

.rating > label:active {
    position:relative;
    top:2px;
    left:2px;
}

/* end of Lea's code */

/*
 * Clearfix from html5 boilerplate
 */

.clearfix:before,
.clearfix:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}

.clearfix:after {
    clear: both;
}

/*
 * For IE 6/7 only
 * Include this rule to trigger hasLayout and contain floats.
 */

.clearfix {
    *zoom: 1;
}

/* my stuff */
#status, button {
    margin: 20px 0;
}

</style>
 <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">How much will you rate for <b><?php echo $cname ;?></b>  ?</h4>
          </div>
           <div class="modal-body" > 
           <div> 
                   <form action="feedback-update" method="post" id="feedback">
     			   <input type="hidden" name="feedbackid" value="<?php echo $feedbackid ?> " />
                   <input type="hidden" name="companyid" value="<?php echo $cid ?> " />
                    <input type="hidden" name="memberid" value="<?php echo $mid ?> " />
                    <input type="hidden" name="name" value="<?php echo $name ?> " />
                    <div class="form-group  ">
    <fieldset class="rating">
      
        <input type="radio" id="star5" name="rating" value="5"/><label for="star5" title="Rocks!">5 stars</label>
       
        <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good" >4 stars</label>
          
        <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh" >3 stars</label>
          
         <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
           
        <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
       
    </fieldset>
    
                </div>
                <div class="form-group">
				<input type="text" class="form-control"  name="feedback" id="feedback" placeholder="Feedback">
                   </div>
                   <div class="form-group">
                   <button type="submit" class="btn btn-default-new-form" name="submit">Submit</button>
                    </div>
                    
    				</form>
                    </div>
                    
			 </div>
          
