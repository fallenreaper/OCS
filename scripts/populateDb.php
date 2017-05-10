<?php
require("connect.php");
// users, gear, gearAccountability
if(isset($_POST["dbTable"]))
{
//die("ITS SET");
$q = "";
if ($_POST["dbTable"] == "gear")
		{
		$q = "insert into gear (name, itemCount, showItem) values ('".$_POST['name']."',".$_POST['itemCount'].",".$_POST['showItem'].");";
		$r = mysql_query($q) or die('failed to insert');
		}
	elseif ($_POST["dbTable"] == "users")
		{
		$q = "insert into users (f_name, l_name, email, dropped) values ('".$_POST['f_name']."','".$_POST['l_name']."','".$_POST['email']."',".$_POST['dropped'].");";
		$r = mysql_query($q) or die ('Failed to Insert');
		}
	elseif ($_POST["dbTable"] == "gearAccountability")
		{

		}
}
?>
<html>
 <head>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script type="text/javascript">
	$(function(){
			$("select#dbTable").on("change", function(){
				$("div.wrap").hide();
				$("div.wrap#"+$(this).val()).show();
				});
			$("select#dbTable").change();

			$("a.updateEntry").on("click", function()
				{

				var rowId = $(this).closest("tr").children("td").first().find("input").val();
				var rowName = $(this).closest("tr").parent().children().first().children().first().text();

				var opts = {
						url: "tableManipulation.php",
						data: {
							type:"update",
							id: {
								name: rowName, 
								id:rowId
							},
							updates: {

							}},
						dataType: "json",
						error: function(){ /*Add some sort of flash or identifier here*/ },
						type: "POST"
					};
				console.log("Data Obj:", opts);
				$.ajax(opts);
				});
			$("a.removeEntry").on("click", function()
				{
					
				});
	});	

	</script>
	<style type="text/css">
		table, tr, td, th{
			border: solid 1px black;
		}
		tr:nth-child(even) {
			background-color: lightgray;
		}
		tr:nth-child(odd){
			background-color: grey;
		}
	</style>
 </head>
 <body>
 <form method="POST" action="populateDb.php">
	<select id="dbTable" name="dbTable">
		<option value="gear">Gear</option>
		<option value="users">Users</option>
		<option value="gearAccountability">Gear Accountability</option>
	</select>
	<br />
	<div id="users" class="wrap">
		First Name: <input name="f_name"/><br />
		Last Name:  <input name="l_name"/><br />
		Email:      <input name="email"/><br />
		<span style="display:none;">Dropped:    <select name="dropped"><option value="false">No</option><option value="true">Yes</option></select></span>
	</div>
	<div id="gear" class="wrap">
		Name: <input name="name"/><br />
		Required Number: <input name="itemCount"/><br />
		<span style="display:none;">Show: <select name="showItem"><option value="true">Yes</option><option value="false">No</option></select></span>
	</div>
	<div id="gearAccountability" class="wrap">
	
	</div>
	<button type="submit" value="Add" text="Add">Add</button>
	</form>

<?php
	//loop over the columns to build headers
if (isset($_POST['dbTable'])){
	$q = "select * from ".$_POST['dbTable'];
	if ($_POST['dbTable']=='gear') {
		$q = $q." where showItem = true;";
	}elseif($_POST['dbTable']=='users'){
		$q = $q." where dropped = false;";
	}
	$result = mysql_query($q);
	echo "<table><tr>";
	for($i = 0; $i < mysql_num_fields($result); $i++) {
	  $field_info = mysql_fetch_field($result, $i);
		echo "<th>{$field_info->name}</th>";
	}
	echo "</tr>";

	while($row = mysql_fetch_row($result)) {
		echo "<tr>";
		foreach($row as $_column) {
			echo "<td><input type='text' value='{$_column}'/></td>";
    }	
		echo "<td><a class='updateEntry'>Update</a><a class='removeEntry'>remove</a></td></tr>";
	}
	echo "</table>";
}
?>
 </body>
</html>
