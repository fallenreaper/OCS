<?php
require("scripts/connect.php");

$user = "45";
$gearList = "select g.name, g.itemCount, ga.itemCount from gear g join gearAccountability ga on g.g_id = ga.g_id where g.showItem is true and ga.u_id = ".$user;

$gear = "select g.g_id, g.name, g.itemCount, gt.name from gear g join gearType gt on gt.id = g.type_id  order by gt.id asc, g.name asc;";

$users = "select * from users where dropped is false order by l_name asc, f_name asc;";
?>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$("#save").on("click", function(){
					var usr = $("select#user > option:selected").val();
					var values = $("#gear > table > tbody > tr td > input").map(function(){ if (this.value == "" ) return; return { id: this.name.split("_")[1], value: this.value}; }).toArray();
					var opts = {
						data: {user: usr, gear: values},
						dataType: "json",
						method: "GET",
						url: "scripts/updateGear.php",
						success: function(){ },
						error: function(){ alert("Error saving Data."); }
						}
						console.log(opts);
					$.ajax(opts);
					});

        var usr = $("select#user > option:selected").val();
				$("select#user").on("change", function(){
					usr = $(this).val();
					
					var opts = {
					data: {id: usr},
					dataType: "json",
					method: "GET",
					url: "scripts/GetGear.php",
					success: function(results){
						$("div#gear > table input").each(function(){
							$(this).val(0);
							});
						for (var i = 0; i < results.length; i++)
							{
							$("input[name='gear_"+results[i]["g_id"]+"'").val(results[i]["itemCount"]);
							}
					},
					error: function(){
						alert("Error populating your saved Data.");		
					}
					};

					$.ajax(opts);
				});
				$("select#user").change();
			});
		</script>
		<style type="text/css">
			table, tr, td, th {
				border: solid 1px black;
			}
			tr:nth-child(even){
				background-color: lightgrey;
			}
			tr:nth-child(odd){
				background-color: grey;
			}
			input {
				text-align: center;
			}
		</style>
	</head>
	<body style="margin-left:auto; margin-right:auto;width:800px;">
		<select id="user">
		<?php
		$result = mysql_query($users);
		while($row = mysql_fetch_array($result))
			{
			echo "<option value='{$row["u_id"]}'>{$row["l_name"]}, {$row["f_name"]}</option>";
			}
		?>
		</select>
		<br />
		<div id="loadout">
			<a id="edit"href="#">Edit</a>
			<div id="gear">
				<table>
<?php
$result = mysql_query($gear);
echo "<tr>";
/*
for ($i = 0; $i < mysql_num_fields($result); $i++)
{
	$field_info = mysql_fetch_field($result, $i);
	echo "<th>{$field_info->name}</th>";
}
*/
echo "<th>Gear Name</th>";#.mysql_fetch_field($result, 0)->name."</th>";
echo "<th>Your Count</th>";
echo "<th># Required</th>";#.mysql_fetch_field($result,1)->name."</th>";
echo "<th>Section</th>";#.mysql_fetch_field($result,2)->name."</th>";
echo "</tr>";

while ($row = mysql_fetch_row($result))
{
	echo "<tr>";
	/*
	foreach($row as $_column)
	{
		echo "<td>{$_column}</td>";
	}
	*/
	/*
	$countQuery="select itemCount from gearAccountability where u_id=$user and g_id=".$row[0];
	$res = mysql_query($countQuery);
	$item = mysql_fetch_array($res);
	echo "HERE: ".$countQuery;
	*/

	echo "<td>$row[1]</td><td><input type='number' name='gear_$row[0]' /></td><td style='text-align: center;'>$row[2]</td><td>$row[3]</td>";
	echo "</tr>";
}
//  Name, current, required

?>
				</table>
			</div>
			<a id="save" href="#">Save</a>
		</div>
	</body>
</html>
