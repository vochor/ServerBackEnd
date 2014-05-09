<?
session_start();
require("lib.php");
require("api.php");

header("Content-Type: application/json");

//Server API
switch ($_POST['command']) {

	/* To facilitate the activity log and bugs, it is desirable to be inserted at the end 
	 * of the new features and is assigned a unique identifier functions, consistent with 
	 * the registered database.
	 * Is very important that you do not modify the identifiers lightly.
	 * -----------------------------------------------------------------------
	 * para facilitar el registro de actividad y bugs, es conveniente que se inserten 
	 * al final las nuevas funciones y se le asigne un identificador unico de funcion, 
	 * que concuerde con el registrado en la base de datos.
	 * Es muy importante que no se modifique los identificadores a la ligera.
	 * */
	
	//1
	case "login":
		login($_POST['username'], $_POST['password']); 
		//**grant a user access to the aplication 
		// ::> returns a message | return JSON configuration
		break;
		
	//1
	case "login2":
		login2($_POST['username'], $_POST['password']);
		//**grant a user access to the aplication
		// ::> returns a message | return JSON configuration
		break;
		
	//2
    case "lostpass":
		lostpass($_POST['username']); 
		//**send an email to the email of the username
		// ::> returns a message | send an email to the user with the new password
		break;	
		
//-------------------------------------------------------------------------------------------------
	//3
    case "createuser":
		createuser($_POST['username'],$_POST['password'],$_POST['email'],$_POST['hint']); 
		//**create a new user account
		// ::> returns a message
		break;
		
	//3
	case "createuser2":
		createuser2($_POST['username'],$_POST['password'],$_POST['email'],$_POST['hint']);
		//**create a new user account
		// ::> returns a message | send a confirm email to the user
		break;
		
	//4
	case "deleteuser":
		deleteuser($_POST['username'],$_POST['password']);
		//**delete a existing user
		// ::> returns a message
		break;
		
	//4
	case "deleteuser2":
		deleteuser2($_POST['username'],$_POST['password']);
		//**delete a existing user
		// ::> returns a message | send a good bye email to the user
		break;
		
	//5	
	case "modifyuser":
		modifyuser($_POST['username'],$_POST['password'],$_POST['n_username'],$_POST['n_password'],$_POST['n_email'],$_POST['n_hint']);
		//**modify all fields
		// ::> returns a message
		break;
		
	//5
	case "modifyuser2":
		modifyuser2($_POST['username'],$_POST['password'],$_POST['n_username'],$_POST['n_password'],$_POST['n_email'],$_POST['n_hint'],$_POST['image']);
		//**modify all fields
		// ::> returns a message
		break;
		
//-------------------------------------------------------------------------------------------------
	//6
	case "doaction":
		doaction($_POST['username'],$_POST['housename'],$_POST['roomname'],$_POST['servicename'],$_POST['actionname'],$_POST['data']); 
		//**send an action to the arduino to be done
		// ::> returns a message
		break;
		
	//8
	case "ipcheck":
		ipcheck();
		//**ask for the IP address of a host conection
		// ::> returns real client IP
		break;		
		
	//10
	case "getweather":
		getweather($_POST['city'],$_POST['country'],$_POST['language']);
		//**ask the weather of a city, country, in a lenguage
		// ::> returns the weather of a specific city and country
		break;	
			
//-------------------------------------------------------------------------------------------------
	//7
	case "createhouse":
		createhouse($_POST['username'],$_POST['housename'],$_POST['city'],$_POST['country']);
		//**create a new house with an existing user
		// ::> returns a message
		break;
		
	//9
	case "deletehouse":
		deletehouse($_POST['username'],$_POST['password'],$_POST['housename']);
		//**delete a existing house by an administrator user
		// ::> returns a message
		break;
		
	//20
	case "modifyhouse":
		modifyhouse($_POST['username'],$_POST['housename'],$_POST['n_housename'],$_POST['image'],$_POST['city'],$_POST['country']);
		//**
		// ::>
		break;
		
//-------------------------------------------------------------------------------------------------
	//14
	case "createprogramaction":
		createprogramaction( $_POST['programname'],$_POST['username'],$_POST['housename'],$_POST['roomname'],$_POST['servicename'],$_POST['actionname'],$_POST['data'],$_POST['start']);
		//**
		// ::>
		break;
		
	//15
	case "deleteprogramaction":
		deleteprogramaction( $_POST['username'],$_POST['programname']);
		//**
		// ::>
		break;
		
//-------------------------------------------------------------------------------------------------
	//11
	case "createtask":
		createtask( $_POST['username'],$_POST['taskname'],$_POST['description'],$_POST['frequency']);
		//**
		// ::>
		break;
		
	//12
	case "deletetask":
		deletetask( $_POST['username'],$_POST['taskname']);
		//**
		// ::>
		break;
		
//-------------------------------------------------------------------------------------------------
	//21
	case "addtaskprogram":
		addtaskprogram( $_POST['username'],$_POST['taskname'],$_POST['idaction']);
		//**
		// ::>
		break;
		
	//22
	case "removetaskprogram":
		removetaskprogram( $_POST['username'],$_POST['taskname'],$_POST['idaction']);
		//**
		// ::>
		break;
		
//-------------------------------------------------------------------------------------------------
	//
	case "addcommandprogram":
		addcommandprogram( $_POST['username'],$_POST['commandname'],$_POST['idaction'], $_POST['number']);
		//**
		// ::>
		break;
		
	//
	case "removecommandprogram":
		removecommandprogram( $_POST['username'],$_POST['commandname'],$_POST['idaction'], $_POST['number']);
		//**
		// ::>
		break;
		
//-------------------------------------------------------------------------------------------------
	//
	case "createcommand":
		createcommand( $_POST['username'],$_POST['commandname']);
		//**
		// ::>
		break;
		
	//
	case "deletecommand":
		deletecommand( $_POST['username'],$_POST['commandname']);
		//**
		// ::>
		break;
		
//-------------------------------------------------------------------------------------------------
	//23
	case "schedulehouse":
		schedulehouse( $_POST['housename']);
		//**
		// ::>
		break;
		
//-------------------------------------------------------------------------------------------------		
	case "createroom":
		createroom($_POST['username'],$_POST['housename'],$_POST['roomname']);
		//**create a new room with an existing user
		// ::> returns a message | returns the result of the operation
		break;
		
	//
	case "deleteroom":
		deleteroom($_POST['username'],$_POST['password'],$_POST['housename'],$_POST['roomname']);
		//**delete a existing room by an administrator user
		// ::> returns a message | returns the result of the operation
		break;
		
	//
	/*case "modifyroom":
		modifyroom($_POST['username'],$_POST['password'],$_POST['roomname']);
		//**modify setings of an existing the room
		// ::> returns a message | returns the result of the operation
		break;*/
//-------------------------------------------------------------------------------------------------
	//
	case "createaccesshouse":
		createaccesshouse($_POST['username'],$_POST['housename'],$_POST['n_username'],$_POST['number']);
		//**
		// ::>
		break;
		
	//
	case "deleteaccesshouse":
		deleteaccesshouse($_POST['username'],$_POST['housename'],$_POST['n_username']);
		//**
		// ::>
		break;
		
//-------------------------------------------------------------------------------------------------

	case "image":
		image($_POST['idimage']);
		//**
		// ::>
		break;
		
	case "subir":
		subir2();
		
	break;
//-------------------------------------------------------------------------------------------------
		
    case "linkserviceroom":
		linkserviceroom($_POST['idservice'],$_POST['idroom']); 
		//**
		// ::>
		break;
		
    case "unlinkserviceroom":
		unlinkserviceroom($_POST['idservice']); 
		//**
		// ::>
		break;
//-------------------------------------------------------------------------------------------------
    case "modifyservicetype":
		modifyservicetype($_POST['username'], $_POST['iddevice'],$_POST['servicename'], $_POST['type']); 
		//**
		// ::>
		break;
		
    case "createpermissionservice":
		createpermissionservice($_POST['username'],$_POST['housename'],$_POST['roomname'],$_POST['servicename'],$_POST['n_username'],$_POST['number']); 
		//**
		// ::>
		break;
		
    case "deletepermissionservice":
		deletepermissionservice($_POST['username'],$_POST['housename'],$_POST['roomname'],$_POST['servicename'],$_POST['n_username']); 
		//**
		// ::>
		break;
//-------------------------------------------------------------------------------------------------
    case "createdevice":
		createdevice($_POST['username'],$_POST['ipaddress'],$_POST['serial'],$_POST['devicename']); 
		//**
		// ::>
		break;
		
    case "deletedevice":
		deletedevice($_POST['username'],$_POST['password'],$_POST['iddevice']); 
		//**
		// ::>
		break;

//-------------------------------------------------------------------------------------------------
    default:
		$message = query(	"SELECT ERRORCODE AS ERROR, ENGLISH, SPANISH
					FROM ERRORS
					WHERE ERRORCODE= 38 LIMIT 1 ");
		$json['error'] = $message['result'][0];
		print json_encode($json);
}

exit();
?>
