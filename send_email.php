<?php

#Jake Bedard
#jadn007
#818121974

//database info
$server = 'opatija.sdsu.edu:3306';
$user = 'jadrn007';
$password = 'floor';
$database = 'jadrn007';
//end database info

if(!($db = mysqli_connect($server,$user,$password,$database)))
    echo "ERROR in connection ".mysqli_error($db);
$email = $_POST['email'];
$sql = "select * from runners where email='$email';";
mysqli_query($db, $sql);
$how_many = mysqli_affected_rows($db);
mysqli_close($db);
if($how_many > 0)
    echo "dup";
else if($how_many == 0)
    echo "OK";
else
    echo "ERROR, failure ".$how_many;
?>


