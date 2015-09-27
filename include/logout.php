<?php
// To Find out the Caller of the Page
if($_POST['logMeOut'] == "mfg"){
	
	// Get the Session ID(token) of the logged in user.
	$userSID = $_REQUEST['token'];
	session_id($userSID);
	session_start();
	session_destroy();

	// Redirect to Manufacturer Login Page
	header("location: ../manufacturer/");
	exit();
}else if($_POST['logMeOut'] == "mer"){

	// Get the Session ID(token) of the logged in user.
	$userSID = $_REQUEST['token'];
	session_id($userSID);
	session_start();
	session_destroy();

	// Redirect to Manufacturer Login Page
	header("location: ../merchant/");
	exit();
}else{

	//if manually called this file (only then loginType will be null) then take him to main App Index page.
	header("location: ../");
	exit();
}
?>