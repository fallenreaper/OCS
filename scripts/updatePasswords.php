<?php
	require("connect.php");

	//$list = $_POST["pw_request"];

	//$list = array("45");
	$list = array();
	if(isset($_GET["id"])){
		$list = array($_GET["id"]);
	}

	if(isset($_GET["master_passwords"])){
		$master = "select u_id from users";
		$rez = mysql_query($master);
		while($row = mysql_fetch_array($rez)){
			$list[] = $row["u_id"];
		}
	}
	$min = 1000;
	$max = 9999;

	foreach ( $list as $id ){
		
		$q = "select l_name, email from users where u_id = $id limit 1;";
		$r = mysql_query($q);
		
		while($row = mysql_fetch_array($r)){
			
			$new_pw = substr($row["l_name"],0,3).rand($min, $max);
			$enc = md5($new_pw);
			$q = "insert into pw_list (u_id, pw) values ($id, '$enc') on duplicate key update pw = '$enc';";
			$pw_res = mysql_query($q);

			//utilize mail call.
			$to = $row["email"];
			$headers = "From: DoNotReply@PAARNGOCS.com" ."\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8";
			$subject = "Your Password.";
			$message = "Hello OC ".$row['l_name'].",<br /><br />To submit changes to your account, you will need to utilize this password:  <b>".$new_pw."</b>";
			$message .= "<br /><br />The website to access will be: <a href='www.fallenreaper.com/OCS/'>Fallenreaper.com/OCS</a> and more will be added later on for us leverage.";
			$message .= "<br /><br />Sincerely,<br /> OC Francis<br />PAARNG OCS Candidate / Chief Technology Officer<br /><br/><small>This email is generated for the PAARNG OCS program, to assist with accountability IAW Student Leadership.<br />You are getting this email because a Email Reset was requested.<br />Questions/Comments/Concerts, contact OC Francis at: <b>wllm.francis@gmail.com</b></small>";
			echo mail($to, $subject, $message, $headers) ? "Sent": "Not Sent";
			
		}


	}
?>
