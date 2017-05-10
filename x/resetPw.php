<?php
	require("../scripts/connect.php");


	if (isset($_GET["l_name"])){
		$lname = mysql_escape_string( $_GET["l_name"] );

		$q = "select u_id, l_name, email from users where l_name like '$lname';";
		$r = mysql_query($q);

		while($row = mysql_fetch_array($r)){
			$u_id = $row["u_id"];
			$lname= $row["l_name"];
			$email = $row["email"];


			//set the variables i need in that script beforehand.
			//this file takes an 'id' with the id of the user.
			$_GET["id"] = $u_id;
			include ("../scripts/updatePasswords.php");
			echo "Email Resent to: $lname,<br />at: $email";
		}
		return;
	}
?>

<?php

?>

<html>
<body>
<form method="GET" action="resetPw.php">
Last Name: <input type="text" name="l_name" />
<input type="submit" />
</form>
</body>
</html>
