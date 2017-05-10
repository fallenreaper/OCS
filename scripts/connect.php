<?php
//connect to the database for querying
$server = 'localhost';
$user = 'root';
$password = 'afx97gzre49k'; //not needed
$db = 'OCS';

$conn = mysql_connect($server,$user,$password);
if ( !$conn ){
	die('Could not connect to Database: '.mysql_error());
}
mysql_select_db($db);

//$connected_db = mysql_select_db($db,$resource);
//if ( !$connected_db ){
//	die('Not Connected: '.mysql_error());
//}


?>
