<?php
session_start();
require ("scripts/connect.php");

if (isset($_POST["user"]) && isset($_POST["password"])){
	//check to see if the log in is right.  If yes, set session.
	$pw = md5($_POST["password"]);
	$user = $_POST["user"];
	$chkPW = "select * from pw_list where u_id = ".$user." and pw = '".$pw."';";
	$chkRes = mysql_query($chkPW);
	if ( mysql_num_rows($chkRes) <= 0)
	{
		//die("Wrong Password.");
		//header("HTTP/1.0 400 Bad Request");
		echo "Wrong Password.";
		return;
	}
	else
	{
		$_SESSION["logged_in"] = true;
		$_SESSION["u_id"] = $_POST["user"];
	}
}
if (isset($_SESSION["logged_in"])){
	//show the PDFs you can download.
	$ppts = scandir("ppt");
	$rslt = "";
	if( $ppts )
	{
		$rslt = "<ul>";
		foreach ($ppts as $key=>$value)
		{
			if ($value == "." || $value == "..") continue;
			$rslt .= "<li><a href='ppt/$value'>$value</a></li>";
		}
		
		$rslt .= "</ul";
	}
	
	?>
<html>
	<head>
	<style>
		#docs > div {
			background-color: grey;
		}
		#docs > ul {
			background-color: lightgray;
		}
	</style>
	</head>
	<body>
		<div id="docs">
			<div>PPT files</div>
			<ul>
			<?php echo $rslt; ?>
			</ul>
		</div>
	</body>
</html>
<?php
}else{
	//create a log in for the users
?>
<html>
	<head></head>
	<body>
		<center>
		<div>
			<form method="POST" action="PDFList.php" >
				<?php require("scripts/UserPasswordDiv.php"); ?>
				<input type="submit" />
			</form>
		</div>
		</center>
	</body>
</html>
<?php
}
?>
