<?php
	$host		= "mysql13.000webhost.com";
	$user		= "a2669250_db";
	$pass		= "c4m1l0";
	$dbname		= "a2669250_db";
	//$connection = mysqli_connect($host,$user,$pass,$dbname);
	$connection = mysql_connect($host,$user,$pass,$dbname);
	/*if ($connection) {
            mysql_select_db($mysql_database);
			}
	else {
		die('Could not connect: ' . mysql_error());		
	}*/	
?>
