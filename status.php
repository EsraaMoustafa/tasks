<?php
include_once('define.inc');
$conn = mysql_connect(HOSTNAME, DBUSER, DBPWD) or die('Could not connect: ' . mysql_error());
mysql_select_db(DBNAME, $conn) or die('Could not connect: ' . mysql_error());
include_once('lib.php');
?>

<style>

.circleBase {
    border-radius: 50%;
}

.circle_red {
    width: 30px;
    height: 30px;
    background-color: #bd0016 /*#bd0016*/

}
.circle_amber {
    width: 30px;
    height: 30px;
    background: #ffb533 /*amber*/

}
.circle_green {
    width: 30px;
    height: 30px;
    background: #0d7000 /*green*/

}
/* tutor personal details div*/
.tpd {
    width: 155px;
    height: 50px;
    padding: 10px;
    
}
/*tutor description div*/
.td {
    width: 148px;
    height: 50px;
    padding: 10px;
    
}
/*tutor availability div*/
.ta {
    width: 131px;
    height: 50px;
    padding: 10px;
    
}
/*CRB info div*/
.tc {
    width: 99px;
    height: 50px;
    padding: 10px;
    
}
/*image div*/
.ti {
    width: 117px;
    height: 50px;
    padding: 10px;
    
}
/*Qualification div*/
.tq {
    width: 115px;
    height: 50px;
    padding: 10px;
    
}
/*subject details div*/
.tsd {
    width: 125px;
    height: 50px;
    padding: 10px;
    
}
/*first row in table*/
.td1{
    
    height: 50px;
    padding: 10px;
    

}
.a{
font-family:sans-serif;
}

td:hover{
background-color:#f1f1f1;
}

</style>


<?php
$qry= mysql_query("SELECT title FROM t_profile_types",$conn);
if($rslt = mysql_fetch_array($qry)){
	if ($rslt['title'] == "Premium Agency Account" ||
	 $rslt['title'] == "Local Agency Account" ||
	 $rslt['title'] == "Premium Tuition Centre Account" ||
	 $rslt['title'] == "Local Tuition Centre" ||
	 $rslt['title'] == "premium agency account" ||
	 $rslt['title'] == "local agency account" ||
	 $rslt['title'] == "premium tuition centre account" ||
	 $rslt['title'] == "local tuition centre")
	 { //echo mysql_error(); ?>
	
<div class="container table-responsive">
	<table class="table-bordered">  
            <thead>
		<tr class="info" >
                      	<td class="td1">
                                <a><font size="3">Section</font></a>
                          
                        </td>
                      	<td onClick="this.style.background='#737373'" onMouseUp="this.style.background='white'" class="td1">
                           
                                <a href="index.php?action=editProfileInfo"><font size="3">Tutor Personal Details</font></a>
                           
                         </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                            
                                <a href="index.php?action=editProfileInfo"><font size="3">Tutoring description</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                           
                                <a href="#Tutoravailability"><font size="3">Tutor availability</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                            
                                <a href="#CRBinfo"><font size="3">CRB info</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
			   
                                <a href="index.php?action=editProfileInfo##profileimage"><font size="3">Profile image</font></a>
                        </td>
                      
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                          
                                <a href="#Subjectdetails"><font size="3">Subject details</font></a>
                        </td>
                      
		</tr>
        </thead>
		
		<tr> 

                      	<td class="td1">
			
                                <a><font size="3">Status</font></a>
                            
                        </td>


<?php
$flag="false";
$user_id = getCurrentUserId($conn);
//tutor personal details
$query7 = mysql_query("SELECT U.first_name, U.last_name, U.username, U.email, P.tutor_sex, P.house, P.address, P.location, P.tutors_pincode, P.CountryName, P.landline, P.mobile  FROM t_users U INNER JOIN t_user_profiles P ON U.id=P.user_id WHERE U.id=$user_id",$conn);
if($result7 = mysql_fetch_array($query7)){
	if($result7['first_name'] == NULL && $result7['last_name'] == NULL &&
	    $result7['username'] == NULL && $result7['email'] == NULL && $result7['tutor_sex'] == NULL &&
	    $result7['house'] == NULL && $result7['address'] == NULL && $result7['location'] == NULL && 
	    $result7['tutors_pincode'] == NULL && $result7['CountryName'] == NULL &&
	    $result7['landline'] == NULL && 
	    $result7['mobile'] == NULL){ 
		echo '<td><div class="tpd" align="center"><div class="circleBase circle_red"></div></div></td>';
		$flag="false";
	}elseif($result7['first_name'] == NULL || $result7['last_name'] == NULL ||
	    $result7['username'] == NULL || $result7['email'] == NULL || $result7['tutor_sex'] == NULL || 
	    $result7['house'] == NULL || $result7['address'] == NULL ||
            $result7['location'] == NULL || $result7['tutors_pincode'] == NULL || 
            $result7['CountryName'] == NULL || $result7['landline'] == NULL ||
	    $result7['mobile'] == NULL){
		echo '<td><div class="tpd" align="center"><div class="circleBase circle_amber"></div></div></td>';
		
	}else{
		echo '<td><div class="tpd" align="center"><div class="circleBase circle_green"></div></div></td>';
		$flag="true";
	}
	
}

//Tutoring description
$query = mysql_query("SELECT tutor_experience, tutor_approch, tutor_decs, tutor_language FROM t_user_profiles where user_id=$user_id",$conn);
if($result =mysql_fetch_array($query)){
	if ($result['tutor_experience'] == NULL && $result['tutor_approch'] == NULL &&
	    $result['tutor_decs'] == NULL && $result['tutor_language'] == NULL ) { 
		echo '<td><div class="td" align="center"><div class="circleBase circle_red"></div></div></td>';
	}elseif($result['tutor_experience'] == NULL || $result['tutor_approch'] == NULL ||
	    $result['tutor_decs'] == NULL || $result['tutor_language'] == NULL ){
		echo '<td><div class="td" align="center"><div class="circleBase circle_amber"></div></div></td>';
		
	}else{
		echo '<td><div class="td" align="center"><div class="circleBase circle_green"></div></div></td>';
	}
	
}
$query1 = mysql_query("SELECT tutor_day, tutor_distance, tutor_from, tutor_online FROM t_user_profiles where user_id=$user_id",$conn);
//Tutor availability
if($result1 = mysql_fetch_array($query1)){
	if ($result1['tutor_day'] == NULL && $result1['tutor_distance'] == NULL &&
	    $result1['tutor_from'] == NULL && $result1['tutor_online'] == NULL ) { 
		echo '<td><div class="ta" align="center"><div class="circleBase circle_red"></div></div></td>';
	}elseif($result1['tutor_day'] == NULL || $result1['tutor_distance'] == NULL ||
	    $result1['tutor_from'] == NULL || $result1['tutor_online'] == NULL ){
		echo '<td><div class="ta" align="center"><div class="circleBase circle_amber"></div></div></td>';
		
	}else{
		echo '<td><div class="ta" align="center"><div class="circleBase circle_green"></div></div></td>';
	}
	
}
$query2 = mysql_query("SELECT tutor_crb_chk, tutor_crb, tutor_upload_crb FROM t_user_profiles where user_id=$user_id",$conn);
//CRB info
if($result2 = mysql_fetch_array($query2)){
	if ($result2['tutor_crb_chk'] == NULL && $result2['tutor_crb'] == NULL &&
	    $result2['tutor_upload_crb'] == NULL) { 
		echo '<td><div class="tc" align="center"><div class="circleBase circle_red"></div></div></td>';
	}elseif($result2['tutor_crb_chk'] == NULL || $result2['tutor_crb'] == NULL ||
	    $result2['tutor_upload_crb'] == NULL ){
		echo '<td><div class="tc" align="center"><div class="circleBase circle_amber"></div></div></td>';
		
	}else{
		echo '<td><div class="tc" align="center"><div class="circleBase circle_green"></div></div></td>';
	}
	
}

$query3 = mysql_query("SELECT avatar FROM t_user_profiles where user_id=$user_id",$conn);
//profile image
if($result3 = mysql_fetch_array($query3)){
	if ($result3['avatar'] == NULL) { 
		echo '<td><div class="ti" align="center"><div class="circleBase circle_red"></div></div></td>';
	}else{
		echo '<td><div class="ti" align="center"><div class="circleBase circle_green"></div></div></td>';
	}
	
}


$query5 = mysql_query("SELECT subject , cost , level FROM t_user_profile_subject_cost where user_id=$user_id",$conn);
//subject Details
 if($result5 = mysql_fetch_array($query5)){
      echo '<td><div class="tsd" align="center"><div class="circleBase circle_green"></div></div></td>';
      if($flag=="false"){
	$flag="false";
      }else{$flag="true";}
} else {
   	echo '<td><div class="tsd" align="center"><div class="circleBase circle_red"></div></div></td>';
	$flag="false";
}



if($flag=="true"){
mysql_query(" update t_users set profile_status='yes' where id=$user_id",$conn);	
}else{
mysql_query(" update t_users set profile_status='no' where id=$user_id",$conn);
}

?>	
                            

		</tr>
	</table>
</div>

<?php
	}else{
?>
<div class="container table-responsive">
	<table class="table-bordered">  
            <thead>
		<tr class="info" >
                      	<td class="td1">
                                <a><font size="3">Section</font></a>
                          
                        </td>
                      	<td onClick="this.style.background='#737373'" onMouseUp="this.style.background='white'" class="td1">
                           
                                <a href="#Tutorpersonaldetails"><font size="3">Tutor Personal Details</font></a>
                           
                         </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                            
                                <a href="#Tutoringdescription"><font size="3">Tutoring description</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                           
                                <a href="#Tutoravailability"><font size="3">Tutor availability</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                            
                                <a href="#CRBinfo"><font size="3">CRB info</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
			   
                                <a href="#Profileimage"><font size="3">Profile image</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                         
                                <a href="#Qualification"><font size="3">Qualification</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
                          
                                <a href="#Subjectdetails"><font size="3">Subject details</font></a>
                        </td>
                      	<td onClick="this.style.background='#5f5f5f'" onMouseUp="this.style.background='white'" class="td1">
			    
                                <a href="#Security"><font size="3">Security</font></a>
                        </td>
		</tr>
	</thead>
		<tr> 

                      	<td class="td1">
			
                                <a><font size="3">Status</font></a>
                            
                        </td>


<?php
$flag="false";
$user_id = getCurrentUserId($conn);
//tutor personal details
$query7 = mysql_query("SELECT U.first_name, U.last_name, U.username, U.email, P.tutor_sex, P.house, P.address, P.location, P.tutors_pincode, P.CountryName, P.landline, P.mobile  FROM t_users U INNER JOIN t_user_profiles P ON U.id=P.user_id WHERE U.id=$user_id",$conn);
if($result7 = mysql_fetch_array($query7)){
	if($result7['first_name'] == NULL && $result7['last_name'] == NULL &&
	    $result7['username'] == NULL && $result7['email'] == NULL && $result7['tutor_sex'] == NULL &&
	    $result7['house'] == NULL && $result7['address'] == NULL && $result7['location'] == NULL && 
	    $result7['tutors_pincode'] == NULL && $result7['CountryName'] == NULL &&
	    $result7['landline'] == NULL && 
	    $result7['mobile'] == NULL){ 
		echo '<td><div class="tpd" align="center"><div class="circleBase circle_red"></div></div></td>';
		$flag="false";
	}elseif($result7['first_name'] == NULL || $result7['last_name'] == NULL ||
	    $result7['username'] == NULL || $result7['email'] == NULL || $result7['tutor_sex'] == NULL || 
	    $result7['house'] == NULL || $result7['address'] == NULL ||
            $result7['location'] == NULL || $result7['tutors_pincode'] == NULL || 
            $result7['CountryName'] == NULL || $result7['landline'] == NULL ||
	    $result7['mobile'] == NULL){
		echo '<td><div class="tpd" align="center"><div class="circleBase circle_amber"></div></div></td>';
		
	}else{
		echo '<td><div class="tpd" align="center"><div class="circleBase circle_green"></div></div></td>';
		$flag="true";
	}
	
}

//Tutoring description
$query = mysql_query("SELECT tutor_experience, tutor_approch, tutor_decs, tutor_language FROM t_user_profiles where user_id=$user_id",$conn);
if($result =mysql_fetch_array($query)){
	if ($result['tutor_experience'] == NULL && $result['tutor_approch'] == NULL &&
	    $result['tutor_decs'] == NULL && $result['tutor_language'] == NULL ) { 
		echo '<td><div class="td" align="center"><div class="circleBase circle_red"></div></div></td>';
	}elseif($result['tutor_experience'] == NULL || $result['tutor_approch'] == NULL ||
	    $result['tutor_decs'] == NULL || $result['tutor_language'] == NULL ){
		echo '<td><div class="td" align="center"><div class="circleBase circle_amber"></div></div></td>';
		
	}else{
		echo '<td><div class="td" align="center"><div class="circleBase circle_green"></div></div></td>';
	}
	
}
$query1 = mysql_query("SELECT tutor_day, tutor_distance, tutor_from, tutor_online FROM t_user_profiles where user_id=$user_id",$conn);
//Tutor availability
if($result1 = mysql_fetch_array($query1)){
	if ($result1['tutor_day'] == NULL && $result1['tutor_distance'] == NULL &&
	    $result1['tutor_from'] == NULL && $result1['tutor_online'] == NULL ) { 
		echo '<td><div class="ta" align="center"><div class="circleBase circle_red"></div></div></td>';
	}elseif($result1['tutor_day'] == NULL || $result1['tutor_distance'] == NULL ||
	    $result1['tutor_from'] == NULL || $result1['tutor_online'] == NULL ){
		echo '<td><div class="ta" align="center"><div class="circleBase circle_amber"></div></div></td>';
		
	}else{
		echo '<td><div class="ta" align="center"><div class="circleBase circle_green"></div></div></td>';
	}
	
}
$query2 = mysql_query("SELECT tutor_crb_chk, tutor_crb, tutor_upload_crb FROM t_user_profiles where user_id=$user_id",$conn);
//CRB info
if($result2 = mysql_fetch_array($query2)){
	if ($result2['tutor_crb_chk'] == NULL && $result2['tutor_crb'] == NULL &&
	    $result2['tutor_upload_crb'] == NULL) { 
		echo '<td><div class="tc" align="center"><div class="circleBase circle_red"></div></div></td>';
	}elseif($result2['tutor_crb_chk'] == NULL || $result2['tutor_crb'] == NULL ||
	    $result2['tutor_upload_crb'] == NULL ){
		echo '<td><div class="tc" align="center"><div class="circleBase circle_amber"></div></div></td>';
		
	}else{
		echo '<td><div class="tc" align="center"><div class="circleBase circle_green"></div></div></td>';
	}
	
}

$query3 = mysql_query("SELECT avatar FROM t_user_profiles where user_id=$user_id",$conn);
//profile image
if($result3 = mysql_fetch_array($query3)){
	if ($result3['avatar'] == NULL) { 
		echo '<td><div class="ti" align="center"><div class="circleBase circle_red"></div></div></td>';
	}else{
		echo '<td><div class="ti" align="center"><div class="circleBase circle_green"></div></div></td>';
	}
	
}

$query4 = mysql_query("SELECT qualification FROM t_user_qualification where user_id=$user_id",$conn);
//qualification
 if($result4 = mysql_fetch_array($query4)){
      echo '<td><div class="tq" align="center"><div class="circleBase circle_green"></div></div></td>';
} else {
   	echo '<td><div class="tq" align="center"><div class="circleBase circle_red"></div></div></td>';
}

$query5 = mysql_query("SELECT subject , cost , level FROM t_user_profile_subject_cost where user_id=$user_id",$conn);
//subject Details
 if($result5 = mysql_fetch_array($query5)){
      echo '<td><div class="tsd" align="center"><div class="circleBase circle_green"></div></div></td>';
      if($flag=="false"){
	$flag="false";
      }else{$flag="true";}
} else {
   	echo '<td><div class="tsd" align="center"><div class="circleBase circle_red"></div></div></td>';
	$flag="false";
}



/*
$query6 = mysql_query("SELECT status FROM t_user_referees where user_id=$user_id",$conn);
//security
while($result6 = mysql_fetch_array($query6)){
	if ($result5['status'] == NULL) { 
		$flag2='1';
	}else{
		$flag2='2';
	}
	
}

if($flag2=='1'){
	echo '<td><div class="circleBase circle_red"></div></td>';
}else{
	echo '<td><div class="circleBase circle_green"></div></td>';
	if($flag=="false"){
		$flag="false";
        }else{
		$flag="true"
	}
}*/
if($flag=="true"){
mysql_query(" update t_users set profile_status='yes' where id=$user_id",$conn);	
}else{
mysql_query(" update t_users set profile_status='no' where id=$user_id",$conn);
}

?>	
                            <td><div></div></td>

		</tr>
	</table>
</div>
	
<?php 
	}
}
?>


