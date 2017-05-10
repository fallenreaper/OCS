<?php
	require("connect.php");
	
	$data = array_keys($_GET);
	$params = $_GET;

	//var_dump($data);
	header('Content-type: application/json');
	//echo $_POST["user"]." ".$_POST["gear"];

	$user = $params["user"];
	$gear_updates = $params["gear"] or array();


	foreach ( $gear_updates as $row ){
		$count = $row["value"];
		$id = $row["id"];
		$query = "insert into gearAccountability (g_id, u_id, itemCount) values ($id, $user, $count) on duplicate key update itemCount = $count;";		
		$resource = mysql_query($query);
	}

	echo json_encode($params)
?>

