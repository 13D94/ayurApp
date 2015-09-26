<?php
/**
* This file is the common login process for Manufacturers, Doctors and Merchants.
*
* @package   ayurAppCoreLogin
* @author    pTk,..
*
* The caller is identified by the loginType value.
* POST @param (string) loginType [mfg|doc|mer] if null redirect to ayurApp Index.
* 	
* Caller : Manufacturer (mfg)
* ---------------------------
* POST @param (string) mfgUname The username of the manufacturer.
* POST @param (string) mfgPass The password of the manufacturer.
*
* SESSION @param (integer) MFG_LOGIN_FLAG
*	1 = Incorrect Login Credentials 
*	2 = Correct Login Credentials -> Registered User
* If the MFG_LOGIN_FLAG is set to 1 he is redirected back to the Manufacturer Login page.
* If the MFG_LOGIN_FLAG is set to 2 he is redirected to the main.php file of the Manufactuer.
*
* Caller : Doctor (doc)
* ---------------------
*/

require_once(__DIR__."/classes/manufacturerClass.php");
//require_once('./classes/doctorClass.php');
//require_once('./classes/merchantClass.php');

session_start();

if($_POST['loginType'] == "mfg"){

	// Now check if Manufacturer Username or Password was empty, If so redirect to Manufacturer Login Page
	if($_POST['mfgUname'] == NULL || $_POST['mfgPass'] == NULL) {

		// Set Session MFG_LOGIN_FLAG to 1, which means incorrect Login Credentials!
		$_SESSION['MFG_LOGIN_FLAG'] = 1;
		session_write_close();

		// Redirect to Manufacturer Login Page
		header("location: ../manufacturer/");
		exit();
	}	

	// Unprocessed POST Values.
	$mfgUname = $_POST['mfgUname'];
	$mfgPass = $_POST['mfgPass'];

	$mfgObj = new manufacturerClass;

	// The POST values are cleaned inside the checkMfgAccountRegistration(), so need of cleaning before passing.
	$mfgRegStatus = $mfgObj->checkMfgAccountRegistration($mfgUname,$mfgPass);
	echo $mfgRegStatus;
	
	if($mfgRegStatus == "MFG_USER_REGISTERED"){

		// Set Session MFG_LOGIN_FLAG to 2, which means his account is authenticated.
		$_SESSION['MFG_LOGIN_FLAG'] = 2;

		// Save MFG_ID to session, We need it in other pages.
		$_SESSION['MFG_ID']  = $mfgObj->getMfgIdFromMfgUname(trim($mfgUname));
		session_write_close();

		// Redirect him to manufacturer main.php.
		header("location: ../manufacturer/dashboard.php");
		exit();
	}else if($mfgRegStatus == "MFG_USER_INCORRECT_CREDENTIALS"){

		// Set Session MFG_LOGIN_FLAG to 1, which means incorrect Login Credentials!
		$_SESSION['MFG_LOGIN_FLAG'] = 1;
		session_write_close();

		// Redirect to Manufacturer Login Page
		header("location: ../manufacturer/");
		exit();
	}else if($mfgRegStatus == "MFG_USER_UNREGISTERED"){

		// [TODO] : Actually his account doesn't exist, we could redirect him to registration page.
		// For now redirect him to Manufacturer Login Page saying that his credentials are Invalid. ;-)
		// Set Session MFG_LOGIN_FLAG to 1, which means incorrect Login Credentials!
		$_SESSION['MFG_LOGIN_FLAG'] = 1;
		session_write_close();

		// Redirect to Manufacturer Login Page
		header("location: ../manufacturer/");
		exit();
	}else{

		//checkMfgAccountRegistration returned something weird, shouldn't happen actually.
		errorHandler('DB_MFG_LOGIN_CREDENTIALS_CHECK_ERROR',"checkMfgAccountRegistration returned something unexpected!");
	}


}else if (($_POST['loginType'] == "doc")){





}else if(($_POST['loginType'] == "mer")){




}else{

	//if manually called this file (only then loginType will be null) then take him to main App Index page.
	header("location: ../");
	exit();
}
?>