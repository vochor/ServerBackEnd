<?
//API implementation to come here

function errorJson($msg){
	print json_encode(array('error'=>$msg));
	exit();
}

//--------------------------------------------------------------------------------------
function login($user, $pass) {
/* make de server conexion*/

	$SQLuser = query("SELECT * FROM USERS WHERE USERNAME='%s' limit 2", $user);
	$iduser  = $SQLuser['result'][0]['IdUser'];
	$num	 = count($SQLuser['result']);
	
	switch ($num){
		case 0:	$error = 3;	break;
		case 2:	$error = 4;	break;
	}

	//** TEST correct password **
	if ($SQLuser['result'][0]['PASSWORD'] = $pass){
		//correct pass, authorized
		$_SESSION['IdUser'] = $SQLuser['result'][0]['IdUser'];
		$error = 1;
	}
	else{
		//incorrect pass. hint password
		$error = 2;
	}
	
	//insert information about result of login.
	$sql = query("INSERT INTO HISTORYACCESS
						(IDHISTORY, IDUSER, IDHOUSE, ACCESSRESULT, DATESTAMP        )
				VALUES  (     NULL,   '%s',    NULL,         '%s', CURRENT_TIMESTAMP)"
			, $iduser, $error);
	// take de error message
	$message = query(	"SELECT ENGLISH, SPANISH
						FROM ERRORS
						WHERE ERRORCODE='%s' LIMIT 1 ", $error);
	// return error
	if ($error = 1) {
		print json_encode($message);
		exit();
	}
	
	//successful function
	print json_encode($SQLuser);
}

//--------------------------------------------------------------------------------------
function lostpass($user){
/* envia un email al usuario que ha olvidado el password*/

	$result = query("SELECT * FROM USERS WHERE USERNAME='%s' limit 1", $user);
	
	if (count($result['result'])>0) {
	//existe al menos un usuario con ese nombre
		//ENVIAR CORREO AL USUARIO
		print json_encode($result['result'][0]['EMAIL']);
		
	} 
	else {
	//usuario incorrecto
		errorJson('The user does not exist.');
	}
}

//--------------------------------------------------------------------------------------
function pulsadoMando($idUser,$idMando,$estado) {
    $tiempo = date("Y-m-d H:i:s");
    $result = query("UPDATE items SET status='%s' WHERE idTable='%s'",$estado,$idMando);
    
     if ($result == TRUE) {
        //authorized
        //	 $_SESSION['IdUser'] = $result['result'][0]['IdUser'];
        print json_encode($result);
    } else {
        //not authorized
        errorJson('Actualization failed');
    }
}

//--------------------------------------------------------------------------------------
function doaction($user,$service,$action,$data) {
/* a user send a specific action aobut a service with or without data*/
	$error = 0;
	$SQLuser = query("SELECT * FROM USERS WHERE USERNAME='%s' limit 2", $user);
	$iduser  = $SQLuser['result'][0]['IdUser'];
	$num	 = count($SQLuser['result']);
	$idaction =  query("SELECT  `FCODE` 
					    FROM    `ACTIONS` 
					    WHERE   `ACTIONNAME`='%s'", $action);
	switch ($num){
		case 0:	$error = 3;	break;
		case 2:	$error = 4;	break;
	}
	
	$code = query("SELECT  `FCODE` 
				   FROM    `ACTIONS` 
				   WHERE   `ACTIONNAME`='%s' AND 
						   `IDSERVICE` IN 
							(SELECT `IDSERVICE` 
							 FROM   `SERVICES` 
							 WHERE  `SERVICENAME` = '%s') limit 2", $action, $service);
	$num	 = count($code['result']);
	switch ($num){
		case 0:	$error = 5;	break;
		case 2:	$error = 4;	break;
	}
	
	//return
	if ($error <> 0) {
		$sql = query("INSERT INTO HISTORYACCESS
						(IDHISTORY, IDUSER, IDHOUSE, ACCESSRESULT, DATESTAMP        )
				VALUES  (     NULL,   '%s',    NULL,         '%s', CURRENT_TIMESTAMP)"
				, $iduser, $error);
		$message = query(	"SELECT ENGLISH, SPANISH
						FROM ERRORS
						WHERE ERRORCODE='%s' LIMIT 1 ", $error);
		print json_encode(array('EXIT'=>$error).concat($message));
		exit();
	}
	

	//ENVIAR ACCION AL ARDUINO 
	//** print json_encode($code.concat(array('DATA'=>$data)));
	
	//ESPERAR RESPUESTA DEL ARDUINO.
	$returncode = "0X000001";	
	
	//COTEJAR RESPUESTA ARDUINO
	$sql = query("INSERT INTO HISTORYACCESS
						(`ID`, `IDACTION`, `IDPROGRAM`, `IDUSER`, `RETURNCODE`, `DATESTAMP`)
				VALUES  (NULL,   '%s',      NULL,         '%s',    '%s',  CURRENT_TIMESTAMP)"
			, $idaction, $returncode, $iduser);	
	//ENVIAR MENSAJE AL MOVIL.
	$result = query("SELECT `EXIT`,ENGLISH`,`SPANISH` 
					  FROM `ACTIONMESSAGES` 
					  WHERE `IDACTION`='%s' AND `RETURNCODE` = '%s'",  $idaction, $returncode);
	print json_encode($result);
	
}

?>
