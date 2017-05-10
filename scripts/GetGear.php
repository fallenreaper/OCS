<?php
require("connect.php");
header("Content-type: application/json");
$user=$_GET["id"];

$q = "select * from gearAccountability where u_id=$user;";
$r = mysql_query($q);
$ar = array();
while($row = mysql_fetch_assoc($r))
	{
	$ar[] = $row;	
	}
echo json_encode($ar);

?>
