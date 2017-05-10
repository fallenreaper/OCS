<?php
	require ("connect.php");
	date_default_timezone_set("America/New_York");
	
	if (isset($_GET["user"]))
		{
		$dayOffset = isset($_GET["increment"]) ? $_GET["increment"]: 0;
		$today = date('D', strtotime("today"));
		if( $today === 'Sun') {
			$sunday = date ("Y-m-d", strtotime("today"));
		}else{
			$sunday = date ("Y-m-d", strtotime("last sunday"));
		}
		$sunday = \DateTime::createFromFormat("Y-m-d", $sunday);
		
		
		$tmp = abs($dayOffset);
		if ($dayOffset < 0){
			$week = $sunday->sub(new DateInterval("P".$tmp."D"));
		}else{
			$week = $sunday->add(new DateInterval("P".$tmp."D"));
		}
		$week = \DateTime::createFromFormat("Y-m-d", $week->format("Y-m-d"));
		
		
		if ( $today === "Sat"){
			$saturday =  date ("Y-m-d", strtotime("today"));
		}else{
			$saturday = date("Y-m-d",strtotime("this saturday"));
		}
		$saturday = \DateTime::createFromFormat("Y-m-d", $saturday);
		if ($dayOffset < 0){
			$sat = $saturday->sub(new DateInterval("P".$tmp."D"));
		}else{
			$sat = $saturday->add(new DateInterval("P".$tmp."D"));
		}
		$sat = \DateTime::createFromFormat("Y-m-d", $sat->format("Y-m-d"));
		
		
		$q = "select dotw, count, workout from pt where u_id = ".$_GET["user"]." and week between '".$week->format("Y-m-d")."' and '".$sat->format("Y-m-d")."';";
		$r = mysql_query($q) or die(mysql_error());
		header("Content-Type: application/json");
		$list = array();
		while ($row = mysql_fetch_assoc($r))
			{
			$list[] = $row;
			}
		
		$retVal["data"] = $list;
		$retVal["start"] = $week->format("m/d");
		$retVal["end"] = $sat->format("m/d");
		echo json_encode($retVal);
		return;
		}
	$user = $_POST["user"] or die("No User passed to script");
	
	if (! isset($_POST["pw"])){
		die ("Password was not entered.");
	}
	$pw = md5($_POST["pw"]);
	$chkPW = "select * from pw_list where u_id = ".$user." and pw = '".$pw."';";
	$chkRes = mysql_query($chkPW);
	if ( mysql_num_rows($chkRes) <= 0){
		//die("Wrong Password.");
		header("HTTP/1.0 400 Bad Request");
		echo "Wrong Password.";
		return;
	}

	$run = $_POST["run"] or array();
	$pushups = $_POST["pushups"] or array();
	$situps = $_POST["situps"] or array();
	$other = $_POST["other"] or array();

	$today = date('D', strtotime("today"));
	if( $today === 'Sun') {
		$week = date ("Y-m-d", strtotime("today"));
	}else{
		$week = date ("Y-m-d", strtotime("last sunday"));
	}
	$week = \DateTime::createFromFormat("Y-m-d", $week);
	$items = array();
	
	$dayOffset = isset($_POST["increment"])? $_POST["increment"]: 0;
	$tmp = abs($dayOffset);
	if ($dayOffset < 0){
		$week = $week->sub(new DateInterval("P".$tmp."D"));
	}else{
		$week = $week->add(new DateInterval("P".$tmp."D"));
	}
	$day = \DateTime::createFromFormat("Y-m-d", $week->format("Y-m-d"));
	foreach( $run as $key=>$value)
	{
		$num = $key + 1;
		$dayStr = $day->format('Y-m-d');
		$items[] = "($num, $user, $value, 'run', '$dayStr')";
		$day->modify('+1 day');
	}
	$day = \DateTime::createFromFormat("Y-m-d", $week->format("Y-m-d"));
	foreach( $pushups as $key=>$value)
	{
		$num = $key+1;
		$dayStr = $day->format('Y-m-d');
		$items[] = "($num, $user, $value, 'pushups', '$dayStr')";
		$day->modify('+1 day');
	}

	$day = \DateTime::createFromFormat("Y-m-d", $week->format("Y-m-d"));
	foreach( $situps as $key=>$value)
	{
		$num = $key+1;
		$dayStr = $day->format('Y-m-d');
		$items[] = "($num, $user, $value, 'situps', '$dayStr')";
		//echo "".$day;
		//$day ++;
		//$day = strtotime("+1 day", strtotime($day));
		$day->modify('+1 day');
	}

	$day = \DateTime::createFromFormat("Y-m-d", $week->format("Y-m-d"));
	foreach( $other as $key=>$value)
	{
		$num = $key+1;
		$dayStr = $day->format('Y-m-d');
		$items[] = "($num, $user, $value, 'other', '$dayStr')";
		//echo "".$day;
		//$day ++;
		//$day = strtotime("+1 day", strtotime($day));
		$day->modify('+1 day');
	}
	$subQuery = "insert into pt (dotw, u_id, count, workout, week) values".implode(",", $items)." on duplicate key update count=VALUES(count);";
	$result = mysql_query($subQuery) or die (mysql_error());

	header("Content-Type: application/json");
	echo json_encode(array());
?>
