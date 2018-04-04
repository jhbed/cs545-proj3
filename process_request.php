<?php
	#Jake Bedard
	#jadrn007
	#818121974
include('helpers.php');
include('p3.php');


isPost();
$params = process_parameters();
include('file_upload.php');
validate_data($params);


store_data_in_db($params);

include('confirmation.php');
?>    
