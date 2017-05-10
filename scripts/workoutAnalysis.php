<?php
	require("connect.php");
	date_default_timezone_set("America/New_York");
	
	$today = date('D', strtotime("today"));
	if( $today === 'Sun') {
		$sunday = date ("Y-m-d", strtotime("today"));
	}else{
		$sunday = date ("Y-m-d", strtotime("last sunday"));
	}
	$week = $sunday;
	$thatSat = $week + 6;

	$topPlayers = "select workout, sum(count), u_id from pt group by workout, order by sum(count) desc limit 3;	";
	$bottomPlayers = "select workout, sum(count), u_id from pt group by workout, order by sum(count desc limit 3;";
	$allPlayersByCount = "select workout, sum(count), u_id from pt group by workout, order by sum(count) desc;";
	$allPlayersByName = "select l_name, f_name, workout, sum(count) from pt join users on pt.u_id = users.u_id where week between '$week' and '$thatSat' group by workout order by l_name desc, f_name desc;";
	
	$targetMonth = "";
	$start = "";
	$nend = "";
	$topPByMonth = "select workout, sum(count), u_id from pt where week between '$start' and '$end' group by workout, order by sum(count) desc limit 1;";
	$bottomPByMonth = "select workout, sum(count), u_id from pt where week between '$start' and '$end' group by workout, order by sum(count) asc limit 1;";

	$queryList = array();
	$queryList["weektop3"] = $topPlayers;
	$queryList["weekbottom3"] = $bottomPlayers;
	$queryList["allByName"] = $allPlayersByName;
	$queryList["allByCount"] = $allPlayersByCount;
	$queryList["monthtop1"] = $topPByMonth;
	$queryList["monthbottom1"] = $bottomPByMonth;

	function getDatasetArray ($str){
		//[in]:  key name found in querylist
		//[out]: json encoded array of rows.
		if ( ! isset($queryList[$str]) ) { 
			echo "[]";
			return false;
		}

		$q = $queryList[$str];
		$r = mysql_query($q);
		if ( mysql_num_rows($r) === 0 ){
			echo "[]";
			return false;
		}
		$rslt = array();
		while ($row = mysql_fetch_assoc($r)){
			$rslt[] = $row;
		}
		return json_encode($rslt);
	}

	function getEncodedArray($str)
	{
		$var = getDataSetArray($str);
		if ($var === false) return false;
		return json_encode($var);
	}


?>
