
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SDSU Marathon</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="form-styles.css">
    <link rel="stylesheet" type="text/css" href="images/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <!-- <script src="/jquery/jquery.js"></script> -->
    <!-- <script src="scripts.js"></script> -->
</head>
<!-- Jake Bedard -->
<!-- jadrn007 -->
<!-- Red ID 818121974 -->
<body>
	<nav class="navbar navbar-dark bg-dark">
		<a class="navbar-brand" href="index.html"><span class="red">SDSU</span> Marathon</a>

		<a class="btn btn-outline-danger" href="signup.html">Sign up now!</a>
		
	</nav>

<?php

function write_row($fname, $lname, $age, $experience, $file, $ageCat){
print <<<ENDBLOCK
<div class="row runner">
	<div class="col-lg-4">
		<img src="pikachu/$file" width="200px" alt="test">
	</div>
	<div class="col-lg-4 desc">
		<h2>$lname, $fname</h2>
		<p>Age: $age</p>
		<p>Experience: $experience</p>
		<p>Age Category: $ageCat</p>
	</div>
	<div class="col-lg-4">		
	</div>
</div>
ENDBLOCK;
}

function write_report(){
$server = 'opatija.sdsu.edu:3306';
$user = 'jadrn007';
$password = 'floor';
$database = 'jadrn007';
if(!($db = mysqli_connect($server,$user,$password,$database)))
    echo "ERROR in connection ".mysqli_error($db);
else {
    $sql = "select * from runners order by ageCat, lname;";    
    $result = mysqli_query($db, $sql);
    if(!$result)
        echo "ERROR in query".mysqli_error($db);
    while($row=mysqli_fetch_row($result)) {
		$fname = $row[1];
		$lname = $row[3];
		$age = $row[10];
		$experience = $row[12];
		$ageCat = $row[15];
		$file = $row[16];
		write_row($fname, $lname, $age, $experience, $file, $ageCat);
    }
    mysqli_close($db);
}#end else
}#end func
$pass = $_POST['pass'];
$valid = false;

$raw = file_get_contents('passwords.dat');
$data = explode("\n",$raw);
foreach($data as $item) {
    if(crypt($pass,$item) === $item) 
            $valid = true;            
    }  #end foreach
    
if($valid){
	write_report();

}	
else
    echo "Login Unsuccessful.";     
?>
</body>
</html>
