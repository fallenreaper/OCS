<?php
require("scripts/connect.php");
date_default_timezone_set("America/New_York");

$today = date('D', strtotime("today"));
if( $today === 'Sun') {
	$sunday = date ("Y-m-d", strtotime("today"));
}else{
	$sunday = date ("Y-m-d", strtotime("last sunday"));
}

if ( $today === "Sat"){
	$saturday =  date ("Y-m-d", strtotime("today"));
}else{
	$saturday = date("Y-m-d",strtotime("this saturday"));
}

$startOfWeek = $sunday;
$endOfWeek = $saturday;
$startOfMonth = date ("Y-m-d", strtotime("first day of this month"));
$endOfMonth = date ("Y-m-d", strtotime("last day of this month"));

// sum of {workout} for the week/month.
$SumOfWorkoutsWQuery = "select workout, sum(`count`) as sum from pt where week between '".$startOfWeek."' and '".$endOfWeek."' group by workout order by sum(`count`) desc;";
$SumOfWorkoutsMQuery = "select workout, sum(`count`) as sum from pt where week between '".$startOfMonth."' and '".$endOfMonth."' group by workout order by sum(`count`) desc;";
// person with most {workout} for week/month
$PersonWQuery = "select u.u_id, u.l_name, u.f_name, p.workout, sum(p.`count`) as sum from users u join pt p on u.u_id = p.u_id where u.dropped is not true and p.week between '".$startOfWeek."' and '".$endOfWeek."' group by u.u_id, p.workout order by sum(p.`count`)";
$PersonMQuery = "select u.u_id, u.l_name, u.f_name, p.workout, sum(p.`count`) as sum from users u join pt p on u.u_id = p.u_id where u.dropped is not true and p.week between '".$startOfMonth."' and '".$endOfMonth."' group by u.u_id, p.workout order by sum(p.`count`)";

$PersonWithMostWQuery = $PersonWQuery." asc;";
$PersonWithMostMQuery = $PersonMQuery." asc;";
// person with least {} for week/month
$PersonWithLeastWQuery = $PersonWQuery." desc;";
$PersonWithLeastMQuery = $PersonMQuery." desc;";

$notfilledoutQuery = "select a.* from users a where a.u_id not in (select u.u_id from pt p join users u on p.u_id = u.u_id where p.week between '".$startOfWeek."' and '".$endOfWeek."' group by u.u_id) and a.dropped is not true;";

/*
echo $SumOfWorkoutsWQuery;
echo "<br />".$SumOfWorkoutsMQuery;
echo "<br />".$PersonWithMostWQuery;
echo "<br />".$PersonWithMostMQuery;
echo "<br />".$PersonWithLeastWQuery;
echo "<br />".$PersonWithLeastMQuery;
return;
*/

$sowwRes = mysql_query($SumOfWorkoutsWQuery) or die("query error");
$sowmRes = mysql_query($SumOfWorkoutsMQuery);
$pwmwRes = mysql_query($PersonWithMostWQuery);
$pwmmRes = mysql_query($PersonWithMostMQuery);
$pwlwRes = mysql_query($PersonWithLeastWQuery);
$pwlmRes = mysql_query($PersonWithLeastMQuery);

$nofillweek = mysql_query($notfilledoutQuery);

$arrWSum = array();
while ($row = mysql_fetch_assoc($sowwRes))
{
	$arrWSum[$row["workout"]] = $row["sum"];
}
$arrMSum = array();
while ($row = mysql_fetch_assoc($sowmRes))
{
	$arrMSum[$row["workout"]] = $row["sum"];
}
$arrWTop = array();
while ($row = mysql_fetch_assoc($pwmwRes))
{
	$arrWTop[$row["workout"]] = $row;
}
$arrMTop = array();
while ($row = mysql_fetch_assoc($pwmmRes))
{
	$arrMTop[$row["workout"]] = $row;
}
$arrWBottom = array();
while ($row = mysql_fetch_assoc($pwlwRes))
{
	$arrWBottom[$row["workout"]] = $row;
}
$arrMBottom = array();
while ($row = mysql_fetch_assoc($pwlmRes))
{
	$arrMBottom[$row["workout"]] = $row;
}

$arrNoFill = array();
while ($row = mysql_fetch_assoc($nofillweek)){
	$arrNoFill[] = $row;
}

?>

<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript">
			var data = {};
			data["weeklySum"] = <?php echo json_encode($arrWSum); ?>;
			data["monthlySum"] = <?php echo json_encode($arrMSum); ?>;
			data["weeklyTop"] = <?php echo json_encode($arrWTop); ?>;
			data["monthlyTop"] = <?php echo json_encode($arrMTop); ?>;
			data["weeklyBottom"] = <?php echo json_encode($arrWBottom); ?>;
			data["monthlyBottom"] = <?php echo json_encode($arrMBottom); ?>;
			data["notFilledOut"] = <?php echo json_encode($arrNoFill);?>;
			
			function getPerson(obj){
				if (!obj || obj === undefined) return;
				return obj["l_name"] + ", " + obj["f_name"];
			}
			function getPersonWithCount (obj){
				if (!obj || obj === undefined) return;
				return getPerson(obj) + ": " + obj["sum"];
			}

			$(function(){
				$("#wpu").empty().append(data["weeklySum"]["pushups"] || 0);
				$("#wsu").empty().append(data["weeklySum"]["situps"] || 0);
				$("#wrun").empty().append(data["weeklySum"]["run"] || 0);
				$("#mpu").empty().append(data["monthlySum"]["pushups"] || 0);
				$("#msu").empty().append(data["monthlySum"]["situps"] || 0);
				$("#mrun").empty().append(data["monthlySum"]["run"] || 0);
				
				$("#twpu").empty().append(getPersonWithCount(data["weeklyTop"]["pushups"]));
				$("#twsu").empty().append(getPersonWithCount(data["weeklyTop"]["situps"]));
				$("#twru").empty().append(getPersonWithCount(data["weeklyTop"]["run"]));
				$("#twot").empty().append(getPersonWithCount(data["weeklyTop"]["other"]));
				
				$("#tmpu").empty().append(getPersonWithCount(data["monthlyTop"]["pushups"]));
				$("#tmsu").empty().append(getPersonWithCount(data["monthlyTop"]["situps"]));
				$("#tmru").empty().append(getPersonWithCount(data["monthlyTop"]["run"]));
				$("#tmot").empty().append(getPersonWithCount(data["monthlyTop"]["other"]));
				
				$("#bwpu").empty().append(getPersonWithCount(data["weeklyBottom"]["pushups"]));
				$("#bwsu").empty().append(getPersonWithCount(data["weeklyBottom"]["situps"]));
				$("#bwru").empty().append(getPersonWithCount(data["weeklyBottom"]["run"]));
				$("#bwot").empty().append(getPersonWithCount(data["weeklyBottom"]["other"]));
				
				$("#bmpu").empty().append(getPersonWithCount(data["monthlyBottom"]["pushups"]));
				$("#bmsu").empty().append(getPersonWithCount(data["monthlyBottom"]["situps"]));
				$("#bmru").empty().append(getPersonWithCount(data["monthlyBottom"]["run"]));
				$("#bmot").empty().append(getPersonWithCount(data["monthlyBottom"]["other"]));

				var $ul = $("<ul />");
				var $li = $("<li />");
				for ( var i = 0; i < data["notFilledOut"].length; i++){
					var row = data["notFilledOut"][i];
					$ul.append($li.clone().append(getPerson(row)));
				}
				$("div#no-entries-list").empty().append($ul);
			});
		</script>
		<style type="text/css">
			div#content {
				width:30%;
				margin-left: auto;
				margin-right: auto;
			}
			span{
				font-weight: bold;
			}
			div#title{
				text-align: center;
			}
			div#content{
				margin-top: 30px;
				background-color: #5da8b3;
				padding: 10px;
			}
			body{
				background-color: #1f7d8a;
			}
			div#content > div{
				margin-bottom: 10px;
				border: solid 2px black;
				padding: 5px;
			}
			#title{
				font-size: 24pt;
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<div id="title">Analytics for PLT</div>
		
		<div id="content">
			<div id="group">
				Weekly Total Number of Pushups is: <span id="wpu"></span><br />
				Weekly Total Number of Situps is:  <span id="wsu"></span><br />
				Weekly Total Number of Miles is:  <span id="wrun"></span><br />
				<br />
				Monthly Total Number of Pushups is:  <span id="mpu"></span><br />
				Monthly Total Number of Situps is:  <span id="msu"></span><br />
				Monthly Total Number of Miles is:  <span id="mrun"></span><br />
			</div>
			<div id="tops">
				Top Leaderboards:
				<br/><br/>
				Weekly:<br />
					Pushups: <span id="twpu"></span><br/>
					Situps:  <span id="twsu"></span><br/>
					Run Distance: <span id="twru"></span><br/>
					Minutes (other): <span id="twot"></span><br/>
				<br />
				Monthly:<br/>
					Pushups: <span id="tmpu"></span><br/>
					Situps:  <span id="tmsu"></span><br/>
					Run Distance: <span id="tmru"></span><br/>
					Minutes (other): <span id="tmot"></span><br/>
			</div>
			<div id="bottoms">
				Bottom Leaderboards:
				<br/><br/>
				Weekly:<br />
					Pushups: <span id="bwpu"></span><br/>
					Situps:  <span id="bwsu"></span><br/>
					Run Distance: <span id="bwru"></span><br/>
					Minutes (other): <span id="bwot"></span><br/>
				<br />
				Monthly:<br/>
					Pushups: <span id="bmpu"></span><br/>
					Situps:  <span id="bmsu"></span><br/>
					Run Distance: <span id="bmru"></span><br/>
					Minutes (other): <span id="bmot"></span><br/>
			
			</div>
			<div id="no-entries">
				<div id="no-entries-tag">People without entries <i>so far</i> this week.</div>
				<div id="no-entries-list"></div>
			</div>
			<div id="charts">
				[Possibly place graphs]
			</div>
		</div>
	</body>
</html>
