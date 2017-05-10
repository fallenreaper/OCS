<?php 
 require ("scripts/connect.php");
 
 date_default_timezone_set("America/New_York");

 $leadership = isset($_GET["leadership"]);
?>

<html>
	<head>
		<style type="text/css">
			body{
				
				background-color: #1f7d8a;
				color:white;
			}
			input {
				width:60px;
			}
			div.container {
				/*
				margin-left: auto;
				margin-right: auto;
				*/
			}
			a{
				background-color:#02505A;
				color:#378a96;
				height: 150px;
				border: solid 1px black;
				cursor: pointer;
				border-radius: 5px;
				padding: 10px;
			}
			a:hover{
				color: #5da8b3;
				background-color:#0e6672;
			}
			a#update{
				
			}
			a#update:hover{
			}
			input#password{
				margin-bottom: 5px;
			}
			#saved{
				width: 30px;
				height: 30px;
				background-color: cyan;
				display: none;
			}
			
			#failed{
				width: 30px;
				height: 30px;
				display: none;
				border-radius: 5px;
				background-color: black;
			}
			#back, #next{
				padding: 10px;
				margin-left: 10px;
				margin-right: 10px;
			}
			.disabled{
				opacity: 0.3;
				background-color: grey;
				color: black;
			}
			.disabled :hover{
				opacity: 0.3;
				background-color: light-grey;
				color:black;
			}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				//these are arrays of size 7.
				var run,pu,su,other;
				var increment = 0
				
				function getWorkoutWeek (increment){
					var opts = {
						url:"scripts/editWorkout.php",
						method:"GET",
						dataType:"json",
						data: {user: $("select#user").val()},
						success: function(e)
							{
							var data = e.data;
							$("table input").val("0.00");
							for (var i = 0; i < data.length; i++)
							{
								//dotw, count, u_id, workout
								var row = data[i]
								$("tr."+row["workout"]+" > td > input."+row["dotw"]).val(row["count"]);
							}
							$("table input").change();
							
							$("#init").text(e.start);
							$("#end").text(e.end);
							},
						error: function(){}
					};
					if (increment) 
						opts.data.increment = increment;
					$.ajax(opts);
				}
				function postWorkoutWeek(increment){
					//send update or insert data.
					var mRun = $("tr.run > td > input").map(function(){ return $(this).val() || 0;}).toArray();
					var mPu = $("tr.pushups > td > input").map(function(){ return $(this).val() || 0;}).toArray();
					var mSu = $("tr.situps > td > input").map(function(){ return $(this).val() || 0;}).toArray();
					var mOther = $("tr.other > td > input").map(function(){ return $(this).val() || 0;}).toArray();
					var user = $("select#user").val();
					var pass = $("#password").val();
					if (pass.length == 0) {
						alert("Need to Enter a Password");
						return;
					}
					var data = {
						run: mRun, 
						pushups: mPu, 
						situps: mSu, 
						other: mOther, 
						user: user,
						pw: pass
						};
					if(increment) data.increment = increment;
					var opts = {
						url: "scripts/editWorkout.php",
						method: "POST",
						dataType: "json",
						data: data,
						success: function(){
							console.log("success");
							$("#saved").show().fadeOut(2000);
						},
						error: function(error){
							$("#failed").show().fadeOut(2000);
							alert(error.responseText);
							}
						};
					console.log(opts);
					$.ajax(opts);
				}
				
				$("#back").on("click", function(){
					$("#next").removeClass("disabled");
					increment -= 7;
					getWorkoutWeek(increment);
				});
				$("#next").on("click", function(){
					if(increment >= 0) {
						$("#next").addClass("disabled");
						return;
					}
					$("#next").removeClass("disabled");
					increment += 7;
					getWorkoutWeek(increment);
					if(increment >= 0) {
						$("#next").addClass("disabled");
						return;
					}
					$("#next").removeClass("disabled");
				});
				
				$("a#update").on("click", function(){
					postWorkoutWeek(increment);
				});
					
				$("select#user").on("change", function(){
					increment = 0;
					getWorkoutWeek();
				});
				$("select#user").change();
				$("table input").on("change", function(){
					var $tr = $(this).closest("tr");
					var mapArray = $tr.find("td > input").map(function(){ return $(this).val() || 0;}).toArray();
					var sum = mapArray.reduce(function(previousValue, currentValue){ return Number(previousValue) + Number(currentValue);});
					$tr.find("th > span").empty().append(sum);
					
				});
				$("#help").on("click", function(){
					var message = "To carry out any updates, click on the Drop down to select your name.  After you select your name, your data will load for the week.  From there, you will make whatever changes you want, then enter your password and click update.  It should update without a fuss.  You can always check by reloading the page, and reselecting your name.";
					alert(message);
					});
			});
		</script>
	</head>
	<body>
<?php 
if (! $leadership)
{
	// PLT block
	$today = date('D', strtotime("today"));
	if( $today === 'Sun') {
		$sunday = date ("m/d", strtotime("today"));
	}else{
		$sunday = date ("m/d", strtotime("last sunday"));
	}
	
	if ( $today === "Sat"){
		$saturday =  date ("m/d", strtotime("today"));
	}else{
		$saturday = date("m/d",strtotime("this saturday"));
	}
	
?>
<center>
 <div class="container">
	<?php
	require ("scripts/UserPasswordDiv.php");
	?>
	<br/>
	<a id="help"href="#">Im Lost, Help me?</a>
	<br />
	<br />
	<div>
	<a id="back"><<</a><div style="display:inline;">Date Range: <span id="init"><?php echo "$sunday"; ?></span> to <span id='end'><?php echo "$saturday"; ?></span></div><a id="next" class="disabled">>></a>
	</div>
	<br />
	<table>
		<tr>
			<th>Topic</th>
			<th>Su</th>
			<th>M</th>
			<th>Tu</th>
			<th>W</th>
			<th>Th</th>
			<th>F</th>
			<th>Sa</th>
			<th><u><b>Sum</b></u></th>
		</tr>
		<tr class="run">
			<td >Run (Miles)</td>
			<td><input class="SUNDAY" type="number" min="0" name="Run_Su" /></td>
			<td><input class="MONDAY" type="number" min="0" name="Run_M" /></td>
			<td><input class="TUESDAY" type="number" min="0" name="Run_Tu" /></td>
			<td><input class="WEDNESDAY" type="number" min="0" name="Run_W" /></td>
			<td><input class="THURSDAY" type="number" min="0" name="Run_Th" /></td>
			<td><input class="FRIDAY" type="number" min="0" name="Run_F" /></td>
			<td><input class="SATURDAY" type="number" min="0" name="Run_Sa" /></td>
			<th><span class="sum"></span></th>
		</tr>
		<tr class="pushups">
			<td >Push Ups (Count)</td>
			<td><input class="SUNDAY" type="number" min="0" name="PU_Su" /></td>
			<td><input class="MONDAY" type="number" min="0" name="PU_M" /></td>
			<td><input class="TUESDAY" type="number" min="0" name="PU_Tu" /></td>
			<td><input class="WEDNESDAY" type="number" min="0" name="PU_W" /></td>
			<td><input class="THURSDAY" type="number" min="0" name="PU_Th" /></td>
			<td><input class="FRIDAY" type="number" min="0" name="PU_F" /></td>
			<td><input class="SATURDAY" type="number" min="0" name="PU_Sa" /></td>
			<th><span class="sum"></span></th>
		</tr>
		<tr class="situps">
			<td>Sit Ups (Count)</td>
			<td><input class="SUNDAY" type="number" min="0" name="SU_Su" /></td>
			<td><input class="MONDAY" type="number" min="0" name="SU_M" /></td>
			<td><input class="TUESDAY" type="number" min="0" name="SU_Tu" /></td>
			<td><input class="WEDNESDAY" type="number" min="0" name="SU_W" /></td>
			<td><input class="THURSDAY" type="number" min="0" name="SU_Th" /></td>
			<td><input class="FRIDAY" type="number" min="0" name="SU_F" /></td>
			<td><input class="SATURDAY" type="number" min="0" name="SU_Sa" /></td>
			<th><span class="sum"></span></th>
		</tr>
		<tr class="other">
			<td>Other (Time, in Minutes)</td>
			<td><input class="SUNDAY" type="number" min="0" name="Other_Su" /></td>
			<td><input class="MONDAY" type="number" min="0" name="Other_M" /></td>
			<td><input class="TUESDAY" type="number" min="0" name="Other_Tu" /></td>
			<td><input class="WEDNESDAY" type="number" min="0" name="Other_W" /></td>
			<td><input class="THURSDAY" type="number" min="0" name="Other_Th" /></td>
			<td><input class="FRIDAY" type="number" min="0" name="Other_F" /></td>
			<td><input class="SATURDAY" type="number" min="0" name="Other_Sa" /></td>
			<th><span class="sum"></span></th>
		</tr>
	</table>
	<br />
	<a id="update">Update</a>
	<br />
	<br />
	<img id="saved" src="img/checkbox.png" />
	<img id="failed" src="img/redX.png" />
 </div>
 </center>
<?php 
} else {
	//leadership
?>
<center>
	<div id="leadership" class="container">
		<div class="title" id="weektop3"></div>
		<div></div>
		<div class="title" id="weekbottom3"></div>
		<div></div>
		<div class="title" id="all"></div>
		<div></div>
		<div class="title" id="monthtop1"></div>
		<div></div>
		<div class="title" id="monthbottom1"></div>
		<div></div>
		<!--
		<div class="title"></div>
		<div></div>
		<div class="title"></div>
		<div></div>
		<div class="title"></div>
		<div></div>
		-->
	</div>
</center>

<?php


}
?>
	</body>
</html>
