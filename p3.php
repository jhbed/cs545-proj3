<?php
	#Jake Bedard
	#jadrn007
	#818121974
	$bad_chars = array('$','%','?','<','>','php', "'");
	function validate_data($params) {
	    $msg = " ";
	    if(strlen($params[0]) == 0)
			$msg .= "Please enter your first name<br />";  
		if(strlen($params[2]) == 0)
			$msg .= "Please enter your last name<br />";  
	    if(strlen($params[3]) == 0)
			$msg .= "Please enter the address<br />"; 
	    if(strlen($params[5]) == 0)
			$msg .= "Please enter the city<br />"; 
	    if(strlen($params[6]) == 0)
			$msg .= "Please enter the state<br />";
		elseif(!isValidState($params[6]))
			$msg .= "Please enter a valid 2 letter state abreviation.<br />";                        
	    if(strlen($params[7]) == 0)
			$msg .= "Please enter the zip code<br />";
			
	    elseif(!is_numeric($params[7])) 
			$msg .= "Zip code may contain only numeric digits<br />";
			
		if((strlen($params[8]) != 3) || (strlen($params[9]) != 3) || (strlen($params[10]) != 4))
			$msg .= "Please enter a valid 10 digit phone number<br />";
		elseif((!is_numeric($params[8])) || (!is_numeric($params[9])) || (!is_numeric($params[10])))
			$msg .= "Please enter a valid 10 digit phone number<br />";
		
	    if(strlen($params[11]) == 0)
			$msg .= "Please enter email<br />";
	    elseif(!filter_var($params[11], FILTER_VALIDATE_EMAIL))
			$msg .= "Your email appears to be invalid<br/>"; 
			
			
		#enter more rules here for dob	
		if(strlen($params[12]) == 0)
			$msg .= "Please enter your date of birth<br />"; 
			
		elseif(!isValidDate($params[12]))
			$msg .= "Please enter a valid date of birth<br />";
			
		if(strlen($params[13]) == 0)
			$msg .= "Please enter your experience level<br />"; 
			
		if(strlen($params[14]) == 0)
			$msg .= "Please enter your gender<br />";
		
		if(strlen($params[16]) == 0)
			$msg .= "Please upload a picture of yourself (Max size is 2 MB)<br />";
			
		if(strlen($params[17]) == 0)
			$msg .= "Please enter your age category<br />"; 
			      
	    if(strlen($msg) > 1) {
			write_form_error_page($msg);
			$fileMsg = "";
			$msg = "";
			exit;
	    }
	    
	    #from file_upload.php
    	$UPLOAD_DIR = 'pikachu/';
    	$COMPUTER_DIR = '/home/jadrn007/public_html/proj3/pikachu/';
    	$fname = $_FILES['user_pic']['name'];
    	$fileMsg = "";
    	$succMsg = "";
    
		if(strlen($_FILES['user_pic']['name']) != 0 && file_exists("$UPLOAD_DIR".$fname))  {
            $fileMsg .= "Error, the file $fname already exists on the server<br />\n";
    	}

    	if($_FILES['user_pic']['error'] > 0) {
    		$err = $_FILES['user_pic']['error'];	
        	$fileMsg .= "";
			if($err == 1)
				$fileMsg .= "The file was too big to upload, the limit is 2MB<br />";
    	} 
    	elseif(exif_imagetype($_FILES['user_pic']['tmp_name']) != IMAGETYPE_JPEG && exif_imagetype($_FILES['user_pic']['tmp_name']) != IMAGETYPE_PNG) {
        	$fileMsg .= "ERROR, not a jpg or png file<br />";   
    	}
## file is valid, copy from /tmp to your directory.        
    	else { 
        	move_uploaded_file($_FILES['user_pic']['tmp_name'], "$UPLOAD_DIR".$fname);
        	$succMsg .= "Success!</br >\n";
        	$succMsg .= "The filename is: ".$fname."<br />";
        	$succMsg .= "The type is: ".$_FILES['user_pic']['type']."<br />";
        	$succMsg .= "The size is: ".$_FILES['user_pic']['size']."<br />";
        	$succMsg .= "The tmp filename is: ".$_FILES['user_pic']['tmp_name']."<br />";  
        	$succMsg .= "The basename is: ".basename($fname)."<br />";  
    	} 
	    #end code from file_upload.php
	    
	    
	    
	    #include('file_upload.php');
	    if(strlen($fileMsg) > 1){
	    	write_form_error_page($fileMsg);
	    	$msg = "";
	    	$fileMsg = "";
			exit;
	    }
	    	
	}

	function process_parameters($params) {
	    global $bad_chars;
	    $params = array();
	    $params[] = trim(str_replace($bad_chars, "",$_POST['fname']));   //0    
	    $params[] = trim(str_replace($bad_chars, "",$_POST['mname']));      //1 
	    $params[] = trim(str_replace($bad_chars, "",$_POST['lname']));       //2
	    $params[] = trim(str_replace($bad_chars, "",$_POST['address1']));   //3
	    $params[] = trim(str_replace($bad_chars, "",$_POST['address2']));  //4
	    $params[] = trim(str_replace($bad_chars, "",$_POST['city']));//5
	    $params[] = trim(str_replace($bad_chars, "",$_POST['state']));//6
	    $params[] = trim(str_replace($bad_chars, "",$_POST['zip']));//7
	    $params[] = trim(str_replace($bad_chars, "",$_POST['phone1']));//8
	    $params[] = trim(str_replace($bad_chars, "",$_POST['phone2']));//9
	    $params[] = trim(str_replace($bad_chars, "",$_POST['phone3']));//10
	    $params[] = trim(str_replace($bad_chars, "",$_POST['email']));//11
	    $params[] = trim(str_replace($bad_chars, "",$_POST['dob']));//12
	    $params[] = trim(str_replace($bad_chars, "",$_POST['experience']));//13
	    $params[] = trim(str_replace($bad_chars, "",$_POST['gender']));//14
	    $params[] = trim(str_replace($bad_chars, "",$_POST['MedConditions']));//15
	    $params[] = trim(str_replace($bad_chars, "",$_FILES['user_pic']['name']));//16
	    $params[] = trim(str_replace($bad_chars, "",$_POST['age-category']));//17
	    return $params;
	}
	
	
	function write_form_error_page($msg) {
	    write_header();
	    write_form($msg);
	    write_footer();
	}  
	
	function formatRadios($val, $i){
		global $params;
		if(trim($params[$i]) == trim($val))
			return "checked";
	}
	


function write_form($msg) {
	global $params;
	global $bad_chars;
	$male = formatRadios('Male', '14');
	$female = formatRadios('Female', '14');
	$novice = formatRadios('Novice', '13');
	$experienced = formatRadios('Experienced', '13');
	$expert = formatRadios('Expert', '13');
	$teen = formatRadios('Teen', '17');
	$adult = formatRadios('Adult', '17');
	$senior = formatRadios('Senior', '17');
    print <<<ENDBLOCK


	<nav class="navbar navbar-dark bg-dark">
		<a class="navbar-brand" href="index.html"><span class="red">SDSU</span> Marathon</a>

		<a class="btn btn-outline-danger" href="signup.html">Sign up now!</a>
		
	</nav>

	<div class="container">
		<h1 id="form-title">Sign Up Here:</h1>

		<!-- Start Form -->
		<form action="process_request.php" method="post" name="signup-form" enctype="multipart/form-data">

			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="fname">First Name</label>
					<input type="text" id="fname" class="form-control form-control-sm" name="fname" value="$params[0]">
				</div>

				<div class="form-group col-md-4">
					<label for="mname">Middle Name</label>
					<input type="text" id="mname" class="form-control form-control-sm" name="mname" value="$params[1]" placeholder="Optional">
				</div>

				<div class="form-group col-md-4">
					<label for="lname">Last Name</label>
					<input type="text" id="lname" class="form-control form-control-sm" name="lname" value="$params[2]">
				</div>

			</div>

			<div class="form-group">
				<label for="address">Address</label>
				<input type="text" id="address" class="form-control form-control-sm" placeholder="Enter your address and street here" name="address1" value="$params[3]">
			</div>
			<div class="form-group">
				<label for="address2">Address 2 (Optional)</label>
				<input type="text" id="address2" class="form-control form-control-sm" placeholder="Apartment #, floor, etc." name="address2" value="$params[4]">
			</div>
			
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="city">City</label>
					<input type="text" id="city" class="form-control form-control-sm" name="city" value="$params[5]">
				</div>
				<div class="form-group col-md-2">
					<label for="state">State</label>
					<input type="text" id="state" class="form-control form-control-sm" placeholder="CA" name="state" maxlength="2" value="$params[6]">
				</div>
				<div class="form-group col-md-4">
					<label for="zip">Zip Code</label>
					<input type="text" id="zip" class="form-control form-control-sm" name="zip" maxlength="5" value="$params[7]">
				</div>
			</div>
			
			<div id="phone-email-labels" class="form-row">
				<div class="form-group col-md-4">
					<label for="phone1">Phone Number</label>
				</div>
				<div class="form-group col-md-8">
					
				</div>
			</div>
			<div id="phone-email" class="form-row">
				
				
				<div class="form-group col-md-1">
					<input type="text" id="phone1" class="form-control form-control-sm text-center" placeholder="(999)" name="phone1" maxlength="3" value="$params[8]">
				</div>
				
				<div class="form-group col-md-1">
					<input type="text" id="phone2" class="form-control form-control-sm text-center" placeholder="999" name="phone2" maxlength="3" value="$params[9]">
				</div>
				
				<div class="form-group col-md-2">
					<input type="text" id="phone3" class="form-control form-control-sm text-center" placeholder="9999" name="phone3" maxlength="4" value="$params[10]">
				</div>

				<div class="col-md-8">
					
				</div>
				
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="email">Email</label>
					<input type="email" id="email" class="form-control form-control-sm" placeholder="email@example.com" name="email" value="$params[11]">
				</div>
				<div class="col-md-8">
					
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="dob">Date of Birth</label>
					<input type="text" id="dob" class="form-control form-control-sm"  placeholder="MM/DD/YYYY" name="dob" maxlength="10" value="$params[12]">
				</div>
				<div class="form-group col-md-6">

					<label class="radio-title">Experience Level</label>

					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input $expert class="form-check-input" name="experience" type="radio" id="inlineradio1" value="Expert"> Expert
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input $experienced class="form-check-input" name="experience" type="radio" id="inlineradio2" value="Experienced"> Experienced
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input $novice class="form-check-input" name="experience" type="radio" id="inlineradio3" value="Novice"> Novice
						</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="radio-title">Gender</label>
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input $male class="form-check-input" name="gender" type="radio" id="inlineradio2" value="Male"> Male
					</label>
				</div>
				<div class="form-check form-check-inline">
					<label class="form-check-label">
						<input $female class="form-check-input" name="gender" type="radio" id="inlineradio3" value="Female"> Female
					</label>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-12">
					<label for="medical-conditions">Medical Conditions (Optional)</label>
					<textarea id="medical-conditions" class="form-control form-control-sm" rows="2" name="MedConditions">$params[15]</textarea>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="user-pic">Photo of Yourself (1 MB Max)</label>
    				<input type="file" class="form-control-file" id="user-pic" name="user_pic" >
				</div>
				<div class="form-group col-md-6">

					<label class="radio-title">Age Category</label>

					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input $teen class="form-check-input" name="age-category" type="radio" id="age-category1" value="Teen"> Teen
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input $adult class="form-check-input" name="age-category" type="radio" id="age-category2" value="Adult"> Adult
						</label>
					</div>
					<div class="form-check form-check-inline">
						<label class="form-check-label">
							<input $senior class="form-check-input" name="age-category" type="radio" id="age-category3" value="Senior"> Senior
						</label>
					</div>
					
				</div>
			</div>

			
			<p id="error">$msg</p>
			

			<div class="text-center submit">
				<input type="submit" id="submit-button" class="btn btn-lg btn-danger" value="Submit">
			</div>

		</form>
	</div>

ENDBLOCK;
}                        


function write_header() {
print <<<ENDBLOCK
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SDSU Marathon</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" type="text/css" href="images/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <script type="text/javascript" src="/jquery/jquery.js"></script>
    <!-- <script src="/jquery/jquery.js"></script> -->
    <script src="javascript/scripts.js"></script>
	<!-- <script src="javascript/check_dups.js"></script> -->
</head>
	<!-- Jake Bedard -->
	<!-- jadrn007 -->
	<!-- Red ID 818121974 -->
<body>
ENDBLOCK;
}

function write_footer() {
    echo "</body></html>";
}

function isValidState($param) {                                
    $stateList = array("AK","AL","AR","AZ","CA","CO","CT","DC",
    "DE","FL","GA","GU","HI","IA","ID","IL","IN","KS","KY","LA","MA",
    "MD","ME","MH","MI","MN","MO","MS","MT","NC","ND","NE","NH","NJ",
    "NM","NV","NY","OH","OK","OR","PA","PR","RI","SC","SD","TN","TX",
    "UT","VA","VT","WA","WI","WV","WY");
    foreach($stateList as $state){
        if($state == trim($param))
            return true;
    }
    return false;
} 

#dob handling
function isValidDate($param){
    $month = substr($param, 0,2);
    $day = substr($param, 3, 2);
    $year = substr($param, 6);
	return checkDate($month, $day, $year);
        
}

function store_data_in_db($params) {
	$month = substr($params[12], 0,2);
    $day = substr($params[12], 3, 2);
    $year = substr($params[12], 6);
    $dobString = $year.'-'.$month.'-'.$day;
	$diff = date_diff(date_create($dobString), date_create('today'));
	$age = $diff->y;	
	
	$phoneNum = $params[8].$params[9].$params[10];
    # get a database connection
    $db = get_db_handle();  ## method in helpers.php
    ##############################################################
    $sql = "SELECT * FROM runners WHERE ".
	"email = '$params[11]';";
##echo "The SQL statement is ",$sql;    
    $result = mysqli_query($db, $sql);
    if(mysqli_num_rows($result) > 0) {
        write_form_error_page('This record appears to be a duplicate');
        exit;
        }
##OK, duplicate check passed, now insert
    $sql = "INSERT INTO runners(id, fname, mname, lname, address, address2, city,state,zip, phone, age, email, experience, gender, MedConditions, ageCat, picture) ".
    "VALUES(0,'$params[0]','$params[1]','$params[2]','$params[3]','$params[4]','$params[5]','$params[6]','$params[7]','$phoneNum','$age', '$params[11]', '$params[13]', '$params[14]', '$params[15]', '$params[17]', '$params[16]');";
##echo "The SQL statement is ",$sql;    
    mysqli_query($db,$sql);
    $how_many = mysqli_affected_rows($db);
    close_connector($db);
    } 
	
?>
	
