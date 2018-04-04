<?php
	#Jake Bedard
	#jadrn007
	#818121974
$bad_chars = array('$','%','?','<','>','php', "'");

function isPost(){
	if(!$_POST){
		write_error_page("Must use post (called from a form)");
		exit;
	}
}

function write_error_page($msg) {
    #write_header();
    echo "<h2>Sorry, an error occurred<br />",
    $msg,"</h2>";
    #write_footer();
}


function get_db_handle() {
    ########################################################
    # DO NOT USE jadrn000, DO NOT MODIFY jadnr000 DATABASE!
    ########################################################            
    $server = 'opatija.sdsu.edu:3306';
    $user = 'jadrn007';
    $password = 'floor';
    $database = 'jadrn007';   
    ########################################################
        
    if(!($db = mysqli_connect($server, $user, $password, $database))) {
        write_error_page('SQL ERROR: Connection failed: '.mysqli_error($db));
        }
    return $db;
    }        
       
function close_connector($db) {
    mysqli_close($db);
    }



?>
       
    

