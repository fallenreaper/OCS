<?php
	/*
	[IN] inRows:    Optional input to add additional rows to the input.  String of <tr></tr> elements
	*/

	require ("connect.php");
	$q = "select * from users where dropped is not true order by l_name asc, f_name asc;";
	$users = mysql_query($q);
	$options = "";
	while ($row = mysql_fetch_array($users))
	{
		$options .= "<option value='{$row["u_id"]}'>{$row["l_name"]}, {$row["f_name"]}</option>";
	}
	$optionalRows="";
	if (isset($inRows)){
		$optionalRows = $inRows;
	}
 ?>
 <table>
	<tr><td>User:</td><td><select name="user" id="user" ><?php echo $options; ?></select></td></tr>
	<tr><td>Password:</td><td><input name="password" type="password" id="password" /></td></tr>
	<?php echo $optionalRows; ?>
 </table>