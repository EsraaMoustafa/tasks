<?php include('ncode/template_header.php'); 
$id=getCurrentUserId($conn);?>
<?php include_once('ncode/lib.php'); ?>


<!-- ==========ADD PROPERTY CSS AND JS ========== -->
<link rel="stylesheet" href="css/addProperty.css" type="text/css">
<script type="text/javascript" href="js/addProperty.js"></script> 






<?php 

$user_id = getCurrentloggedUserId($conn);
if (isset($user_id)) { 
	
		if(empty($_GET) && !isset($_POST['submit'])) {
			$sqllatR="SELECT user_property_id FROM t_user_properties ORDER BY user_property_id DESC LIMIT 1";
			$queryResults11R= mysqli_query($conn,$sqllatR);
			$rowLatency11R = mysqli_fetch_assoc($queryResults11R);
			$rowTL=$rowLatency11R['user_property_id']+1;
			$sqllatIP="SELECT * FROM  t_user_properties_images WHERE user_property_id='".$rowTL."'";
			$queryResults11IP= mysqli_query($conn,$sqllatIP);
			while($fetchIP=mysqli_fetch_array($queryResults11IP)){
				$queryDlt=mysqli_query($conn,"DELETE FROM t_user_properties_images WHERE t_user_properties_images_id = '".$fetchIP['t_user_properties_images_id']."'");	
			}
		}	
	
		/*if(isset($_GET['edit']) && !empty($_GET)) { 
			$query1=mysqli_query($conn,"SELECT * FROM t_user_properties WHERE user_property_id = '".$_GET['edit']."'");
			$row=mysqli_fetch_assoc($query1);
			
			$queryProperty=mysqli_query($conn,"SELECT * FROM t_room_info WHERE user_property_id = '".$_GET['edit']."'");
			$rowArr=array();
			while($rowQ=mysqli_fetch_array($queryProperty)){
				$rowArr[]=$rowQ;
			}
		
			//echo "<pre>"; print_r($row); die;
		}*/
		
	
		if( !empty($_POST) && isset($_POST['submit'])){
			if(!empty($_FILES)){
				$targetDir = "uploads/";
				$fileName = $_FILES['file']['name'];
				$targetFile = $targetDir.$fileName;
				//join here
				$sqllat="SELECT user_property_id FROM t_user_properties ORDER BY user_property_id DESC LIMIT 1";
				$queryResults11= mysqli_query($conn,$sqllat);
				$rowLatency11 = mysqli_fetch_assoc($queryResults11);
				/*echo "<pre>";
				print_r($rowLatency11);
				echo "</pre>";*/
				if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)){
					
					/*//insert file information into db table
					$sqlInsert= "INSERT INTO t_user_properties_images(t_user_properties_images_name, user_property_id, caption) 
					VALUES ('".$_FILES['file']['name']."','".($rowLatency11['user_property_id'])."','NULL')";
					echo "<pre>";
				print_r($rowLatency11['user_property_id']);
				echo "</pre>";*/

					$queryResultsInsert= mysqli_query($conn,$sqlInsert);
					if($queryResultsInsert){
						echo "INSERTED";
					}else{
						echo "NOT INSERTED";
					}
				
				}
			}	
	
			
		}
	?>
	
	<div class="sub-banner">
		<div class="container">
			<h2>Add New Property</h2>
			<ul class="links">
				<li><a href="profile.php">Profile</a>/</li>
				<li><a href="#.">Add New Property</a></li>
			</ul> 
		</div>
	</div>
	
	
	<div class="content"> 
	<!--<form  enctype="multipart/form-data" method="post" action="mylisting.php" id="previews1"  class="dropzone">-->
	
	<?php 
	
	if(isset($_GET['edit']) && !empty($_GET)) {  ?>
		<form enctype="multipart/form-data" method="post" action="property_view_update.php"  name="add_property" id="previews1"  class="dropzone" novalidate>
		<input type="hidden" name="property_user_id" value="<?php echo $_GET['edit']; ?>">
		
	<?php } else { ?>
		<form  enctype="multipart/form-data" method="post" action="property_view.php" id="previews1"  class="dropzone" novalidate>
	<?php } ?>
	
	<section class="contact"> 
	<div class="container"> 
		<!--<div class="accordion">-->
			<h1 style="color: red;font-size: 24px;">1.Property / Room Details</h1>
			<div>
				<div class="row">
					<div class="col-md-5">
						Property Name
					</div>
					
					<div class="col-md-5">
					   <select id="PropertyType" name="PropertyType">
                        <option value="">Please Select -&gt;</option>
              <?php $qGet   = "SELECT * FROM t_user_properties  WHERE  user_id='".$id."' and publish=1";

					$queryResults11= mysqli_query($conn,$qGet);
					
				
					while($rowF = mysqli_fetch_array($queryResults11)) {?>
                    <option value="<?php echo $rowF['user_property_id']?>"><?php echo $rowF['txtaddress1']?></option>
					
					
					<?php }
					
					?>
                        </select>
					</div>
				</div>	
				<br/>
                <div class="row">
					<div class="col-md-5">
						Flat or House Number (kept private)
					</div>
					
					<div class="col-md-5">
					   <input type="text" value="<?php echo $row['txtaddress1']; ?>"  class="form-control input-sm validate[required]" name="txtaddress1" id="txtaddress1" placeholder="Flat or House Number (kept private)" data-toggle="tooltip" title="Please enter the full first line of your address including house number. We won't publish the property number itself. For example you enter: '12 Imaginary Lane'.Will appear to tenants as: 'Imaginary Lane'.If this is a flat, please enter Flat 12, or 345 Nelson Mandela House for example. This will all be kept private."
					   <?php 
						if(isset($_GET['edit']) && !empty($_GET)) {  ?> readOnly <?php } ?>>
					</div>
				</div>	
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						First Line of Address
					</div>
					
					<div class="col-md-5">
					    <input type="text" value="<?php echo $row['txtaddress2']; ?>" class="form-control input-sm validate[required]" name="txtaddress2" id="txtaddress2" placeholder="First Line of Address" data-toggle="tooltip" title="Add Address Line 2"
					    <?php 
						if(isset($_GET['edit']) && !empty($_GET)) {  ?> readOnly <?php } ?>>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Address Line 2 (optional)
					</div>
					
					<div class="col-md-5">
					    <input type="text" value="<?php echo $row['txtaddress3']; ?>" class="form-control input-sm" name="txtaddress3" id="txtaddress3" placeholder="Address Line 2 (optional)" data-toggle="tooltip" title="Add Address Line 3"
					    <?php 
						if(isset($_GET['edit']) && !empty($_GET)) {  ?> readOnly <?php } ?>>
					</div>
				</div>
				<br/>
				
				
				<div class="row">
					<div class="col-md-5">
						Town
					</div>
					
					<div class="col-md-5">
					    <input type="text" value="<?php echo $row['txttown']; ?>" class="form-control input-sm validate[required]" name="txttown" id="txttown" placeholder="Add Town" data-toggle="tooltip" title="Add Town"
					    <?php 
						if(isset($_GET['edit']) && !empty($_GET)) {  ?> readOnly <?php } ?>>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						PostCode
					</div>
					
					<div class="col-md-5">
					    <input type="text" value="<?php echo $row['txtpostcode']; ?>" class="form-control input-sm validate[required]" name="txtpostcode" id="pCode1" placeholder="Add Post Code" data-toggle="tooltip" title="Add Post Code"
					    <?php 
						if(isset($_GET['edit']) && !empty($_GET)) {  ?> readOnly <?php } ?>>
						<input  value="<?php echo $row['latitude']; ?>" type="text" class="form-control" name="google_address" id="google_address" 
							placeholder="Google Address" data-toggle="tooltip" title="Google Address" style="display:none;"
							>
                                                 

                                        <?php if(isset($_GET['edit'])){ ?>
                                                <input  class="btn btn-default form-control" style="display: none; position: absolute; padding: inherit; background: red; margin: -32px 200px; width: 40%;" id="pasar" type="button" value="Find!" onclick="codeAddress(5);"
                                        <?php } else { ?>
                                             <input  class="btn btn-default form-control" style="position: absolute; padding: inherit; background: red; margin: -32px 200px; width: 40%;" id="pasar" type="button" value="Find!" onclick="codeAddress(5);"
                                        <?php } ?>
                                                    <?php 
						if(isset($_GET['edit']) && !empty($_GET)) {  ?> disabled="true" <?php } ?>
						
						<input type="hidden"  class="form-control "  name="cb_latitude" id="cb_latitude" placeholder="Geo Latitude"
							data-toggle="tooltip" title="Geo Latitude is required" value="<?php echo $row['latitude'];?>">
					
						<input type="hidden" class="form-control " name="cb_longitude" id="cb_longitude" placeholder="Geo Longitude"
							data-toggle="tooltip" title="Geo Longitude is required" value="<?php echo $row['longitute'];?>">
					</div>
				</div>
				<br/>
				
				<!--<div class="row">
				
					<div class="col-md-3"></div>
					<div class="col-md-2">
						
					</div>
					<div class="col-md-2">	
						
					</div>		
				</div>
				<br/>-->
				
				
                    
				
				<div class="row">
					<div class="col-md-5">
						Property & Rental Type
					</div>
					
					<div class="col-md-5">
					    <select id="PropertyType" name="PropertyType">
                        <option value="">Please Select -&gt;</option>
                        <option>--- Room in Shared Property ---</option>
                        <option value="Room in a Shared House" <?php if($row['PropertyType']=="Room in a Shared House") { echo "selected"; } ?>>Room in a Shared House</option>
                        <option value="Room in a Shared Flat" <?php if($row['PropertyType']=="Room in a Shared House") { echo "selected"; } ?>>Room in a Shared Flat</option>
                        <option>--- Entire Property ---</option>
                        <option value="Detached House" <?php if($row['PropertyType']=="Detached House") { echo "selected"; } ?>>Detached House</option>
                        <option value="Semi-Detached House" <?php if($row['PropertyType']=="Semi-Detached House") { echo "selected"; } ?>>Semi-Detached House</option>
                        <option value="Terraced House" <?php if($row['PropertyType']=="Terraced House") { echo "selected"; } ?>>Terraced House</option>
                        <option value="End Terrace" <?php if($row['PropertyType']=="End Terrace") { echo "selected"; } ?>>End Terrace</option>
                        <option value="Bungalow" <?php if($row['PropertyType']=="Bungalow") { echo "selected"; } ?>>Bungalow</option>
                        <option value="Flat" <?php if($row['PropertyType']=="Flat") { echo "selected"; } ?>>Flat</option>
                        <option value="Penthouse" <?php if($row['PropertyType']=="Penthouse") { echo "selected"; } ?> >Penthouse</option>
                        <option value="Studio Flat" <?php if($row['PropertyType']=="Studio Flat") { echo "selected"; } ?>>Studio Flat</option>
                        <option value="Maisonette" <?php if($row['PropertyType']=="Maisonette") { echo "selected"; } ?>>Maisonette</option>
                        <option value="Bedsit" <?php if($row['PropertyType']=="Bedsit") { echo "selected"; } ?>>Bedsit</option>
                        <option value="Mobile Home" <?php if($row['PropertyType']=="Mobile Home") { echo "selected"; } ?>>Mobile Home</option>
                        <option value="House Boat" <?php if($row['PropertyType']=="House Boat") { echo "selected"; } ?>>House Boat</option>
                        </select>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Number of bedrooms in property
					</div>
					
					<div class="col-md-5">
					    <input type="number" value="<?php echo $row['txtbedrooms']; ?>" onkeyup="getUnits();" class="form-control input-sm validate[required]" name="txtbedrooms" id="txtbedrooms" placeholder="Add Number of BedRooms in Properties" data-toggle="tooltip" title="Add Number of BedRooms in Properties">
					</div>
				</div>
				<br/>
				
				<script>
				
				
					$("#PropertyType").change(function() {
						getUnits();
					});
					
					$("#txtbedrooms").change(function() {
						getUnits();
					});
					
					function getUnits() {
						var units = $("#txtbedrooms").val();
						
						
//						getdatep();
						var ptype=$('#PropertyType').val(); 
						//alert(ptype);
						$('#appendbadrooms').html('');
						if(ptype=="Room in a Shared Flat" || ptype=="Room in a Shared House"){
							var units = $("#txtbedrooms").val();
							for (var count = 1; count <= units; count++) {
								$("<div class='row' style='color:red;'>BedRoom"+count+"</div><div class='row'><div class='col-md-5'>Earliest Move In Date:</div><div class='col-md-5'><input type='text' class='datepicker' id=datepicker_"+count+" name='earliest_move_date[]'></div></div><br/><div class='row'><div class='col-md-5'>Monthly Rent For Entire Property (&#163;)</div><div class='col-md-5'><input type='number' onkeyup='changebyrend("+count+");' type='text' class='form-control input-sm validate[required]' name='RentPerMonth[]' id='RentPerMonth"+count+"'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Weekly Rent For Entire Property (&#163;)</div><div class='col-md-5'><input type='text' onkeyup='changebymonth("+count+");' class='form-control input-sm validate[required]' name='RentPerWeek[]' id='RentPerWeek"+count+"'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Deposit Amount</div><div class='col-md-5'><input type='text' class='form-control input-sm validate[required]' name='DepositAmount[]' id='DepositAmount'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Minimum Tenancy Length (Months)</div><div class='col-md-5'><input type='text' class='form-control input-sm validate[required]' name='MinimumTenancy[]' id='MinimumTenancy'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Maximum Number of Tenants</div><div class='col-md-5'><input type='text' class='form-control input-sm validate[required]' name='MaximumTenancy[]' id='MaximumTenancy'  data-toggle='tooltip'></div></div><br/>").appendTo("#appendbadrooms");
							}
						}else{
							$("<div class='row' style='color:red;'></div><div class='row'><div class='col-md-5'>Earliest Move In Date:</div><div class='col-md-5'><input type='text' class='datepicker' id=datepicker_1 name='earliest_move_date[]'></div></div><br/><div class='row'><div class='col-md-5'>Monthly Rent For Entire Property (&#163;)</div><div class='col-md-5'><input type='number' onkeyup='changebyrend(1);' type='text' class='form-control input-sm validate[required]' name='RentPerMonth[]' id='RentPerMonth1'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Weekly Rent For Entire Property (&#163;)</div><div class='col-md-5'><input type='text' onkeyup='changebymonth(1);' class='form-control input-sm validate[required]' name='RentPerWeek[]' id='RentPerWeek1'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Deposit Amount</div><div class='col-md-5'><input type='text' class='form-control input-sm validate[required]' name='DepositAmount[]' id='DepositAmount'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Minimum Tenancy Length (Months)</div><div class='col-md-5'><input type='text' class='form-control input-sm validate[required]' name='MinimumTenancy[]' id='MinimumTenancy'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Maximum Number of Tenants</div><div class='col-md-5'><input type='text' class='form-control input-sm validate[required]' name='MaximumTenancy[]' id='MaximumTenancy'  data-toggle='tooltip'></div></div><br/>").appendTo("#appendbadrooms");
							
							$("#datepicker_1").click(function() {
								$(this).datepicker({ dateFormat: 'dd-mm-yy' }).datepicker( "show" )
							});
						}
						
						for (var count = 1; count <= units; count++) {
							$("#datepicker_"+count).click(function() {
								$(this).datepicker({ dateFormat: 'dd-mm-yy' }).datepicker( "show" )
							});
						}	
						
					}
					
				<?php if(isset($_GET['edit']) && !empty($_GET)) { ?>

					$(document).ready(function() {
						var pausecontent = new Array();
						var pausecontent = <?php echo json_encode($rowArr); ?>
						/* <?php foreach($rowArr as $key){ ?>
							pausecontent.push('<?php echo $key; ?>');
						<?php } ?>
						 */
						
						$('#appendbadrooms').html('');
						var units = $("#txtbedrooms").val();
						<?php // $iCount=0; ?>
						console.log(pausecontent[0]['earliest_move_date']);
						for (var count = 1; count <= units; count++) {
						
						$("<div class='row' style='color:red;'>BedRoom"+count+"</div><div class='row'><div class='col-md-5'>Earliest Move In Date:</div><div class='col-md-5'><input type='text' class='datepicker' value="+ pausecontent[count-1]['earliest_move_date'] +" id=datepicker_"+count+" name='earliest_move_date[]'></div></div><br/><div class='row'><div class='col-md-5'>Monthly Rent For Entire Property (&#163;)</div><div class='col-md-5'><input type='number' value="+pausecontent[count-1]['RentPerMonth']+" onkeyup='changebyrend("+count+");' type='text' class='form-control input-sm validate[required]' name='RentPerMonth[]' id='RentPerMonth"+count+"'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Weekly Rent For Entire Property (&#163;)</div><div class='col-md-5'><input type='text' onkeyup='changebymonth("+count+");' class='form-control input-sm validate[required]' value="+pausecontent[count-1]['RentPerWeek']+" name='RentPerWeek[]' id='RentPerWeek"+count+"'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Deposit Amount</div><div class='col-md-5'><input type='text' class='form-control input-sm validate[required]' value="+pausecontent[count-1]['DepositAmount']+" name='DepositAmount[]' id='DepositAmount'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Minimum Tenancy Length (Months)</div><div class='col-md-5'><input type='text' class='form-control input-sm validate[required]'  value="+pausecontent[count-1]['MinimumTenancy']+" name='MinimumTenancy[]' id='MinimumTenancy'  data-toggle='tooltip'></div></div><br/><div class='row'><div class='col-md-5'>Maximum Number of Tenants</div><div class='col-md-5'><input type='text' value="+pausecontent[count-1]['MaximumTenancy']+" class='form-control input-sm validate[required]' name='MaximumTenancy[]' id='MaximumTenancy'  data-toggle='tooltip'></div></div><br/>").appendTo("#appendbadrooms");
							
							$("#datepicker_"+count).click(function() {
								$(this).datepicker().datepicker( "show" )
							});
						
						}
					});	
				<?php } ?>	
					
				</script>
				
		
				
				<div class="row">
					<div class="col-md-5">
						Number of bathrooms in property
					</div>
					
					<div class="col-md-5">
					    <input type="number" value="<?php echo $row['txtbathrooms']; ?>" class="form-control input-sm validate[required]" name="txtbathrooms" id="txtbathrooms" placeholder="Add Number of BathRooms in Properties" data-toggle="tooltip" title="Add Number of BathRooms in Properties">
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Furnishing Options
					</div>
					
					<div class="col-md-5">
						<select id="Furnished" name="Furnished">
                        <option value="">Please Select -&gt;</option>
                        <option value="Furnished" <?php if($row['Furnished']=="Furnished") { echo "selected"; } ?>>Furnished</option>
                        <option value="Unfurnished" <?php if($row['Furnished']=="Unfurnished") { echo "selected"; } ?>>Unfurnished</option>
                        <option value="Furnishing at tenant choice" <?php if($row['Furnished']=="Furnishing at tenant choice") { echo "selected"; } ?>>Furnishing at tenant choice</option>
                        </select>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						EPC Rating
					</div>
					
					<div class="col-md-5">
					    <select id="EPCRating" name="EPCRating">
                        <option value="">Please Select -&gt;</option>
                        <option value="A" <?php if($row['EPCRating']=="A") { echo "selected"; } ?>>A</option>
                        <option value="B" <?php if($row['EPCRating']=="B") { echo "selected"; } ?>>B</option>
                        <option value="C" <?php if($row['EPCRating']=="C") { echo "selected"; } ?>>C</option>
                        <option value="D" <?php if($row['EPCRating']=="D") { echo "selected"; } ?>>D</option>
                        <option value="E" <?php if($row['EPCRating']=="E") { echo "selected"; } ?>>E</option>
                        <option value="F" <?php if($row['EPCRating']=="F") { echo "selected"; } ?>>F</option>
                        <option value="G" <?php if($row['EPCRating']=="G") { echo "selected"; } ?>>G</option>
                        <option value="Currently Being Obtained" <?php if($row['EPCRating']=="Currently Being Obtained") { echo "selected"; } ?>>Currently Being Obtained</option>
                        </select>
					</div>
				</div>
				<br/>
				
				
				<div class="row">
					<div class="col-md-5">
						Upload EPC
					</div>
					
					<div class="col-md-5">
						<?php
						if(!empty($row['upload_epc']))
						{
						?>
							<input type="file" name="upload_epc" class="btn" style="background: red; display:none;margin-bottom:10px;" id="upload_epc" value="<?php echo $row['upload_epc'];?>">
							<a href="http://directpropertylandlord.co.uk/<?php echo urlencode($row['upload_epc']);?>" target="_blank">
                                                            <?php //echo substr($row['upload_epc'],strrpos($row['upload_epc'], "/")+1);?>
                                                            <img src="../<?php echo $row['upload_epc'];?>" width="40px" height="40px" alt="Image">
                                                        </a>
							&nbsp;<button name="btnShowUpload1" class="btn lounch" id="btnShowUpload1" onClick="docUpload(this,'upload_epc');return false;closeLoader();">Upload New Document</button>
						<?php
						}
						else
						{
						?>
						<input type="file" name="upload_epc" class="btn" style="background: red;" id="upload_epc" value="<?php echo $row['upload_epc'];?>">
						
						<?php
						}
						?>
						<!-- <input type="button" name="btnUpload" id="btnUpload" value="Upload New Document"> -->
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Gas Certificate
					</div>
					<div class="col-md-5">
					<?php
						if(!empty($row['gas_certificate']))
						{
					?>
                                        <input type="file" name="gas_certificate " class="btn" style="background: red; display:none;margin-bottom:10px;" id="gas_certificate" value="<?php echo $row['gas_certificate'];?>">
                                        <a href="http://directpropertylandlord.co.uk/<?php echo urlencode($row['gas_certificate']);?>" target="_blank">
                                            <?php //echo substr($row['gas_certificate'],strrpos($row['gas_certificate'], "/")+1);?>
                                            <img src="../<?php echo $row['gas_certificate'];?>" width="40px" height="40px" alt="Image">
                                        </a>
                                        &nbsp;<button name="btnShowUpload2" class="btn lounch" id="btnShowUpload2" onclick="docUpload(this,'gas_certificate');return false;closeLoader();">Upload New Document</button>
					<?php
						}
						else
						{
					?>
						<input type="file" name="gas_certificate " class="btn" style="background: red;">
					<?php
						}
					?>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Electricity Certificate
					</div>
					
					<div class="col-md-5">
					<?php
						if(!empty($row['electricity_certificate']))
						{
					?>
							<input type="file" name="electricity_certificate " class="btn" style="background: red; display:none;margin-bottom:10px;" id="electricity_certificate" value="<?php echo $row['electricity_certificate'];?>" onLoad="closeLoader();">
							<a href="http://directpropertylandlord.co.uk/<?php echo urlencode($row['electricity_certificate']);?>" target="_blank">
                                                            <?php //echo substr($row['electricity_certificate'],strrpos($row['electricity_certificate'], "/")+1);?>
                                                            <img src="../<?php echo $row['electricity_certificate'];?>" width="40px" height="40px" alt="Image">
                                                        </a>
							&nbsp;<button name="btnShowUpload3" class="btn lounch" id="btnShowUpload3" onClick="docUpload(this,'electricity_certificate');return false;closeLoader();">Upload New Document</button>
					<?php
						}
						else
						{
					?>
						<input type="file" name="electricity_certificate " class="btn" style="background: red;">
					<?php
						}
					?>
						</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						HMO Licence document
					</div>
					
					<div class="col-md-5">
					<?php
						if(!empty($row['HMO_licence_document']))
						{
					?>
							<input type="file" name="HMO_licence_document " class="btn" style="background: red; display:none;margin-bottom:10px;" id="HMO_licence_document" value="<?php echo $row['HMO_licence_document'];?>">
							<a href="http://directpropertylandlord.co.uk/<?php echo urlencode($row['HMO_licence_document']);?>" target="_blank">
                                                            <?php //echo substr($row['HMO_licence_document'],strrpos($row['HMO_licence_document'], "/")+1);?>
                                                            <img src="../<?php echo $row['HMO_licence_document'];?>" width="40px" height="40px" alt="Image">
                                                        </a>
							&nbsp;<button name="btnShowUpload4" class="btn lounch" id="btnShowUpload4" onClick="docUpload(this,'HMO_licence_document');return false;closeLoader();">Upload New Document</button>
					<?php
						}
						else
						{
					?>
						<input type="file" name="HMO_licence_document " class="btn" style="background: red;">
					<?php
						}
					?>
					</div>
				</div>
				
				<br/>
				
			</div>
	</div>
		
		<div class="container">
			<div class="row">	
				<input type="submit" name="submit" value="Save"  class="btn lounch" id="btn_submit">
			</div>
			<br/>
		</div>
		 </div>
	</section>
	</form>
<?php 
} else {
    		echo "<script>alert('You must login first');</script>";
} 
?>	


<?php include('ncode/map_popup.php'); ?>	
<?php include('ncode/template_footer.php'); ?>


