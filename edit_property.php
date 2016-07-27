<?php include('ncode/template_header.php'); ?>
<?php include_once('ncode/lib.php'); ?>


<!-- ==========ADD PROPERTY CSS AND JS ========== -->
<link rel="stylesheet" href="css/addProperty.css" type="text/css">
<script type="text/javascript" href="js/addProperty.js"></script> 

<!-- ============ DROPEZONE.JS InCLUDES ====== -->
<link rel="stylesheet" type="text/css" href="drag-drop-file-upload-dropzone-php/css/dropzone.css"/>
<script type="text/javascript" src="drag-drop-file-upload-dropzone-php/js/dropzone.js"></script>
<!--accordion -->
<script src="js/jquery-1.11.0.min.js"></script>
<script type = "text/javascript" src = "//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js" ></script>
<link rel="stylesheet" href="css/onoffswitch.css">
<link href="css/woco-accordion.css" rel="stylesheet">
<script src="js/woco.accordion.min.js"></script>

<script>
$(document).ready(function(){
	var G_edit = "<?php echo $_GET['edit']; ?>";
	if(G_edit != "") {
		Dropzone.options.previews1 = {
			url: 'addproperty.php',
			previewsContainer: ".previews",
			addRemoveLinks: true,
			removedfile: function(file) {
				var name = file.name;
				var img_id = file.img_id;	
				$.ajax({
					type: 'POST',
					url: 'delete_propertly_images.php',
					data: {"img_name" : name,"img_id" : img_id},
					dataType: 'html'
				});
				var _ref;
				return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
			
			init: function() {
			thisDropzone = this;
					$.get('get_item_images.php',{ id : "<?php echo $_GET['edit']; ?>" }, function(data) {
						$.each(data, function(key,value){
						var mockFile = {img_id:value.img_id, name: value.name, size: value.size };
						console.log(mockFile);
						thisDropzone.options.addedfile.call(thisDropzone, mockFile);
						thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "uploads/"+value.name);
						console.log("uploads/"+value.name);
					});
				});
			}
		};
	 } else { 
		Dropzone.options.previews1 = {
			url: 'addproperty.php',
			previewsContainer: ".previews"
		};	
	 } 

});
</script>



<?php 

$user_id = getCurrentloggedUserId($conn);
if (isset($user_id)) { 	
	
		if(isset($_GET['edit']) && !empty($_GET)) { 
			$query1=mysqli_query($conn,"SELECT * FROM t_user_properties WHERE user_property_id = '".$_GET['edit']."'");
			$row=mysqli_fetch_assoc($query1);
			
			$queryProperty=mysqli_query($conn,"SELECT * FROM t_room_info WHERE user_property_id = '".$_GET['edit']."'");
			$rowArr=array();
			while($rowQ=mysqli_fetch_array($queryProperty)){
				$rowArr[]=$rowQ;
			}
		
			//echo "<pre>"; print_r($row); die;
		}
		
	
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
					
					//insert file information into db table
					$sqlInsert= "INSERT INTO t_user_properties_images(t_user_properties_images_name, user_property_id, caption) 
					VALUES ('".$_FILES['file']['name']."','".($rowLatency11['user_property_id'])."','NULL')";
					echo "<pre>";
				print_r($rowLatency11['user_property_id']);
				echo "</pre>";

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
				<li><a href="addproperty.php">Add New Property</a></li>
			</ul> 
		</div>
	</div>
	
	
	<div class="content"> 

	<?php 
	
	if(isset($_GET['edit']) && !empty($_GET)) {  ?>
		<form enctype="multipart/form-data" method="post" action="property_view_update.php"  name="add_property" id="previews1"  class="dropzone" novalidate>
		<input type="hidden" name="property_user_id" value="<?php echo $_GET['edit']; ?>">
	<?php } ?>
	
	<section class="contact"> 
	<div class="container"> 
		<div class="accordion">
			<h1 style="color: red;font-size: 24px;">1.Property / Room Details</h1>
			<div>
				<div class="row">
					<div class="col-md-5">
						Flat or House Number (kept private)
					</div>
					
					<div class="col-md-5">
					   <input type="text" value="<?php echo $row['txtaddress1']; ?>"  class="form-control input-sm" name="txtaddress1" id="txtaddress1" data-toggle="tooltip" readOnly>
					</div>
				</div>	
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						First Line of Address
					</div>
					
					<div class="col-md-5">
					    <input type="text" value="<?php echo $row['txtaddress2']; ?>" class="form-control input-sm" name="txtaddress2" id="txtaddress2" data-toggle="tooltip" readOnly>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Address Line 2 (optional)
					</div>
					
					<div class="col-md-5">
					    <input type="text" value="<?php echo $row['txtaddress3']; ?>" class="form-control input-sm" name="txtaddress3" id="txtaddress3" data-toggle="tooltip" readOnly>
					</div>
				</div>
				<br/>
				
				
				<div class="row">
					<div class="col-md-5">
						Town
					</div>
					
					<div class="col-md-5">
					    <input type="text" value="<?php echo $row['txttown']; ?>" class="form-control input-sm" name="txttown" id="txttown" data-toggle="tooltip" readOnly>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						PostCode
					</div>
					
					<div class="col-md-5">
					    <input type="text" value="<?php echo $row['txtpostcode']; ?>" class="form-control input-sm" name="txtpostcode" id="pCode1" data-toggle="tooltip" readOnly>
                                                 
						
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Property & Rental Type
					</div>
					
					<div class="col-md-5">
					    <select id="PropertyType" name="PropertyType">
                 <option value="">Please Select -&gt;</option>
                 <option>--- Room in Shared Property ---</option>
                 <option value="Room in a Shared House" <?php if($row['PropertyType']=="Room in a Shared House") { echo "selected"; } ?>>Room in a Shared House</option>
                 <option value="Room in a Shared Flat" <?php if($row['PropertyType']=="Room in a Shared Flat") { echo "selected"; } ?>>Room in a Shared Flat</option>
                 <option>--- Entire Property ---</option>
                 <option value="Detached House" <?php if($row['PropertyType']=="Detached House") { echo "selected"; } ?>>Detached House</option>
                 <option value="Semi-Detached House" <?php if($row['PropertyType']=="Semi-Detached House") { echo "selected"; } ?>>Semi-Detached House</option>
                 <option value="Terraced House" <?php if($row['PropertyType']=="Terraced House") { echo "selected"; } ?>>Terraced House</option>          <option value="End Terrace" <?php if($row['PropertyType']=="End Terrace") { echo "selected"; } ?>>End Terrace</option>
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
					    <input type="number" value="<?php echo $row['txtbedrooms']; ?>" onkeyup="getUnits();" class="form-control input-sm validate[required]" name="txtbedrooms" id="txtbedrooms" data-toggle="tooltip" title="Add Number of BedRooms in Properties">
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
						<?php foreach($rowArr as $key){ ?>
							pausecontent.push(<?php echo $key; ?>);
						<?php } ?>
						 
						
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

						$row_value = $row['upload_epc'] ;
$V=substr($row_value,8);
						if(strpos($row_value , '.') != false )
						{ 
						if(strpos($row_value , '.tif') != false || strpos($row_value , '.tiff') != false || strpos($row_value , '.gif') != false || strpos($row_value , '.jpeg') != false || strpos($row_value , '.jpg') != false || strpos($row_value , '.jif') != false || strpos($row_value , '.jfif') != false || strpos($row_value , '.jp2') != false || strpos($row_value , '.jpx') != false || strpos($row_value , '.j2k') != false || strpos($row_value , '.j2c') != false || strpos($row_value , '.png') != false || strpos($row_value , '.fpx') != false || strpos($row_value , '.pcd') != false) { echo $V;
						?>

							
<button name="btnShowUpload1" class="btn lounch" id="btnShowUpload1" onClick="docUpload(this,'upload_epc');return false;closeLoader();">Upload New Document</button>&nbsp;
							<input type="file" name="upload_epc" class="btn" style="background: red; display:none;margin-bottom:10px;" id="upload_epc" value="<?php echo $row['upload_epc'];?>">
							<a href="http://directpropertylandlord.co.uk/<?php echo rawurlencode($V);?>" target="_blank">
                                                            <?php 
?>
                                                            		<img src="../<?php echo $row['upload_epc'];?>" width="40px" height="40px" alt="Image">
                                                        </a>
						<?php
						          }else {?>
							<a href="http://directpropertylandlord.co.uk/<?php echo urlencode($row['upload_epc']);?>" target="_blank"></a>
&nbsp;
<button name="btnShowUpload1" class="btn lounch" id="btnShowUpload1" onClick="docUpload(this,'upload_epc');return false;closeLoader();">Upload New Document</button>
						<?php 
						}}else
						{ 
						?>
						<input type="file" name="upload_epc" id="upload_epc" class="btn" style="background: red;" >
						
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
					$row_value1 = $row['gas_certificate'] ;
						if(strpos($row_value1 , '.') != false)
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
						<input type="file" name="gas_certificate " id="gas_certificate" class="btn" style="background: red;">
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
					$row_value2 = $row['electricity_certificate'];
						if(strpos($row_value2 , '.') != false)
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
						<input type="file" name="electricity_certificate " id="electricity_certificate" class="btn" style="background: red;">
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
					$row_value3 = $row['HMO_licence_document'];
						if(strpos($row_value3 , '.') != false)
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
			<input type="file" name="HMO_licence_document " id="HMO_licence_document" class="btn" style="background: red;">
					<?php
						}
					?>
					</div>
				</div>
				<br/>
				
				
				<div class="row">
					<div class="col-md-5">
						Description
					</div>
					<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
				<style>
				#mceu_22{
					display:none;
				}
				#mceu_39{
					display:none;
				}
				#mceu_13{
					display:none;
				}
				#mceu_14{
					display:none;
				}
				#mceu_20{
					display:none;
				}
				</style>
			  <script type="text/javascript">

				tinymce.init({

				    selector: "#txtdesc",

				    theme: "modern",

				    plugins: [

				        "advlist autolink lists link image charmap print preview hr anchor pagebreak",

				        "searchreplace wordcount visualblocks visualchars code fullscreen",

				        "insertdatetime media nonbreaking save table contextmenu directionality",

				        "emoticons template paste textcolor colorpicker textpattern imagetools"

				    ],

				    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",

				    toolbar2: "print preview media | forecolor backcolor emoticons",

				    image_advtab: true,

				    templates: [

				        {title: 'Test template 1', content: 'Test 1'},

				        {title: 'Test template 2', content: 'Test 2'}

				    ]

				});

				</script>
					<div class="col-md-5">
						 <textarea id="txtdesc" style="width: 100%;" class="validate[required]" name="txtdesc">
								<?php echo $row['txtdesc']; ?>
						</textarea>
					    <!--<textarea class="form-control input-sm validate[required]" value="<?php echo $row['txtdesc']; ?>" name="txtdesc" id="txtdesc"></textarea>-->
					</div>
				</div>
				<br/>
				
				
				
			</div>
			<h1 style="color: red;font-size: 24px;">2. Tenancy Details, Restrictions & Features:</h1>
			<div>
				<div id="appendbadrooms"></div>
				
				
			
				
				
				<div class="row">
					<div class="col-md-12">
						<strong>Please tell us about any additional exclusions / additions to be placed on your advert.</strong>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Restrict Student Enquiries
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch">
							<input type="checkbox" name="restrict_student_enq" class="onoffswitch-checkbox" id="myonoffswitch" <?php if($row['restrict_student_enq']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label" for="myonoffswitch" tabindex="0">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
			
				
				
				<div class="row">
					<div class="col-md-5">
						Only Students Accepted
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch1">
							<input type="checkbox" name="onlystudent_accepted" class="onoffswitch-checkbox1" id="myonoffswitch1" <?php if($row['onlystudent_accepted']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label1" for="myonoffswitch1" tabindex="0">
								<span class="onoffswitch-inner1"></span>
								<span class="onoffswitch-switch1"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
				
				
				<div class="row">
					<div class="col-md-5">
						Restrict DSS (Housing Benefits) Enquiries

					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch2">
							<input type="checkbox" name="restrict_dss" class="onoffswitch-checkbox2" id="myonoffswitch2"  <?php if($row['restrict_dss']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label2" for="myonoffswitch2" tabindex="0">
								<span class="onoffswitch-inner2"></span>
								<span class="onoffswitch-switch2"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
				
				
				<div class="row">
					<div class="col-md-5">
						Restrict Tenants with Pets
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch3">
							<input type="checkbox" name="restrict_tenants" class="onoffswitch-checkbox3" id="myonoffswitch3"  <?php if($row['restrict_tenants']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label3" for="myonoffswitch3" tabindex="0">
								<span class="onoffswitch-inner3"></span>
								<span class="onoffswitch-switch3"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
				
				
				<div class="row">
					<div class="col-md-5">
						Restrict Children / Families
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch4">
							<input type="checkbox" name="restrict_children" class="onoffswitch-checkbox4" id="myonoffswitch4"  <?php if($row['restrict_children']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label4" for="myonoffswitch4" tabindex="0">
								<span class="onoffswitch-inner4"></span>
								<span class="onoffswitch-switch4"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Restrict Smokers
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch5">
							<input type="checkbox" name="restrict_smokers" class="onoffswitch-checkbox5" id="myonoffswitch5"  <?php if($row['restrict_smokers']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label5" for="myonoffswitch5" tabindex="0">
								<span class="onoffswitch-inner5"></span>
								<span class="onoffswitch-switch5"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Bills Included In The Rent
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch6">
							<input type="checkbox" name="bills_Included_Rent" class="onoffswitch-checkbox6" id="myonoffswitch6"  <?php if($row['bills_Included_Rent']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label6" for="myonoffswitch6" tabindex="0">
								<span class="onoffswitch-inner6"></span>
								<span class="onoffswitch-switch6"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Has Garden Access
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch7">
							<input type="checkbox" name="has_garden_access" class="onoffswitch-checkbox7" id="myonoffswitch7"  <?php if($row['has_garden_access']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label7" for="myonoffswitch7" tabindex="0">
								<span class="onoffswitch-inner7"></span>
								<span class="onoffswitch-switch7"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Has Parking
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch8">
							<input type="checkbox" name="has_parking" class="onoffswitch-checkbox8" id="myonoffswitch8"  <?php if($row['has_parking']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label8" for="myonoffswitch8" tabindex="0">
								<span class="onoffswitch-inner8"></span>
								<span class="onoffswitch-switch8"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
				
				<div class="row">
					<div class="col-md-5">
						Has Fireplace
					</div>
					
					<div class="col-md-1">
						<div class="onoffswitch9">
							<input type="checkbox" name="has_fireplace" class="onoffswitch-checkbox9" id="myonoffswitch9"  <?php if($row['has_fireplace']=="on"){echo "checked"; } ?>>
							<label class="onoffswitch-label9" for="myonoffswitch9" tabindex="0">
								<span class="onoffswitch-inner9"></span>
								<span class="onoffswitch-switch9"></span>
							</label>
						</div>
					</div>
				</div>
				<br/>
			</div>
			
			<h1 style="color: red;font-size: 24px;">3. Availability for Viewings (Optional):</h1>
			<div>
				<div>
				<div class="row">
					In order to help tenants know when viewings are possible, you can describe your availability below.
				</div>
				<br/>
					
				<div class="row">
					<textarea class="form-control input-sm" name="AvailabilityForViewings" id="AvailabilityForViewings"><?php echo $row['AvailabilityForViewings']; ?></textarea>
				</div>
				</div>
			</div>
		
			<h1 style="color: red;font-size: 24px;">4. Photos, Videos and Other Media:</h1>
<!--<?php
			$query10=mysqli_query($conn,"SELECT * FROM t_user_properties_images WHERE user_property_id = '".$_GET['edit']."'");
			$row_img=mysqli_fetch_assoc($query10); 
			if(!empty($row_img['t_user_properties_images'])){?>


<?php }else{?>-->
			<div>
				<div class="row">
					Properties with good quality photos tend get better response.
				</div>
				<br/>
				<div class="row">
					<div class="image_upload_div"></div> 	
				</div>
				
				<div class="dz-default dz-message">
					<div class="previews"></div>
						<span>Click to upload</span>
				</div>
			</div>
<!--<?php }?>-->
</div>
	</div>
		
		<div class="container">
			<div class="row">
				<p>Tick Here To Agree To The DirectPropertyLandlord Terms</p>
				<p><input type="checkbox" title="Agree To The OpenRent Terms" class="validate[required]" name="">
				I confirm that I am the landlord of this property and have the right to offer it for rental, and I agree to the DirectPropertyLandlord Terms and Conditions and Privacy Policy.
				</p>
			</div>
			<br/>
			
			<div class="row">	
				<input type="submit" name="submit" value="Save"  class="btn lounch" id="btn_submit">
			</div>
			<br/>
		</div>
			
		<script>
			$(".accordion").accordion();
		</script>
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


