<?php
$code = $_GET ['code'];
?>
<html>
<head>
<title>Confirm register</title>
</head>
<body>
<?php
require ("lib.php");
require ("api.php");

//relative address active-server
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

//search the equals confirm code
$sqlregistration = query ( "SELECT * FROM REGISTRATIONS WHERE CODECONFIRM = '%s' limit 1;", $code );


if (count ( $sqlregistration ['result'] ) == 1) {
	/*if exit that confirm code*/
	
	// move user to the USERS table
	query ( "DELETE FROM REGISTRATIONS WHERE CODECONFIRM = '%s' LIMIT 1;", $code );
	query ( "INSERT INTO `USERS` (`IDUSER`, `USERNAME`, `PASSWORD`, `EMAIL`, `HINT`, `IDIMAGE`, `DATEBEGIN`) VALUES
									(NULL, '%s', '%s', '%s', '%s', NULL, '%s');", 
										$sqlregistration ['result'][0]['USERNAME'],
										$sqlregistration ['result'][0]['PASSWORD'],
										$sqlregistration ['result'][0]['EMAIL'],
										$sqlregistration ['result'][0]['HINT'],
										$sqlregistration ['result'][0]['DATEBEGIN']);
	//send welcome mail
	welcome_mail($sqlregistration ['result'][0]['EMAIL'], $sqlregistration ['result'][0]['USERNAME']);
	
	//view html confirm message
	echo '<div style="margin-left: -300px;" dir="ltr" align="center">
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<img src="http://'.$host.$uri.'/images/logo.png" alt="" width="200" height="200" />
		<div style="position: relative; left: 310px; top: -140px; width: 400px; height: 200px; text-align: left;"><span style="color: #0000ff; font-family: arial,helvetica,sans-serif; font-size: xx-large;">You have successfully confirmed your account.</span></div>
		</div>';
} else {
	/* if the confirm code does not exists*/
	
	//view html code not found message
	echo '<div style="margin-left: -400px;" dir="ltr" align="center">
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<img src="http://'.$host.$uri.'/images/logo.png" alt="" width="200" height="200" />
		<div style="position: relative; left: 360px; top: -180px; width: 500px; height: 200px; text-align: left;">
		<p><span style="color: #ff0000; font-family: arial,helvetica,sans-serif; font-size: xx-large;">The verification code is not valid.</span></p>
		<p><span style="color: #ff0000; font-family: arial,helvetica,sans-serif; font-size: xx-large;"><span id="result_box" class="short_text" lang="en"><span class="hps">Perhaps the</span> <span class="hps">user is</span> <span class="hps">already activated</span><span>.</span></span></span></p>
		</div>
		</div>';
}
?>
</body>
</html>
