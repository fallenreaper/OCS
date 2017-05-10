<?php
require("connect.php");

echo "Calling DB Create\n";
$string = file_get_contents("db.sql");
$r = mysql_query($string);
if(!$r) 
{
	echo "Output: ".mysql_error();
}
else{
	echo "DB Created\n";
}
?>
