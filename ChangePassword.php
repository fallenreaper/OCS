<?php
	require ("scripts/connect.php");
?>
<?php
function printHtml($error){
?>
<html>
	<head>

	</head>
	<body>
		<center>
			<form method="POST" action="ChangePassword.php">
			<title>Password Reset</title>
			<h1>Password Reset Tool</h1>
			<h3><?php echo $error; ?></h3>
			<h6>Passwords are safely stored via MD5 hashing, and not plain text.</h6>
			</br>
			<table>
				<?php
				$inRows = '<tr><td>New Password:</td><td><input type="password" id="new" name="new"</td></tr>
				<tr><td>Confirm New PW:</td><td><input type="password" id="confirm" name="confirm" /></td></tr>
				<tr><td></td><td><input type="submit" /></td></tr>';
				require( "scripts/UserPasswordDiv.php" );
				?>
			</table>
			</form>
		</center>
	</body>
</html>
<?php
}
?>

<?php
	if(isset($_POST["user"]) && isset($_POST["password"]) && isset($_POST["new"]) && isset($_POST["confirm"]) && $_POST["confirm"] == $_POST["new"]){
		$user = $_POST["user"];
		$pw = md5($_POST["password"]);

		$new= md5($_POST["new"]);

		$chkPW = "select * from pw_list where u_id = ".$user." and pw = '".$pw."';";
		$chkRes = mysql_query($chkPW);
		if ( mysql_num_rows($chkRes) <= 0)
		{
			//die("Wrong Password.");
			//header("HTTP/1.0 400 Bad Request");
			//echo "Wrong Password.";
			//return;
			$error = "Current Password incorrect.";
			printHtml($error);
			return;
		}
		
		$updatePW = "update pw_list set pw = '".$new."' where u_id = ".$user.";";
		$uPWRes = mysql_query($updatePW) or die (mysql_error());
		
		$success = "Password Updated!";
		printHtml($success);
		return;
	}
	else if ( isset($_POST["confirm"]) && isset($_POST["new"]) && $_POST["confirm"] != $_POST["new"]){
		$error = "New pass and confirmation do not match.";
		printHtml($error);
		return;
	}
	printHtml("");
?>

