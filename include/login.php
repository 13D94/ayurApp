<?php
	require_once(__DIR__."/classes/manufacturerClass.php");
	//require_once('./classes/doctorClass.php');
	//require_once('./classes/merchantClass.php');

	if($_POST['loginType'] == "mfg"){
		$mfgUname = $_POST['mfgUname'];
		$mfgPass = $_POST['mfgPass'];
		echo $mfgUname;echo "<br>";echo $mfgPass;echo "<br>";
		$mfgObj = new manufacturerClass;
		$mfgRegStatus = $mfgObj->checkMfgAccountRegistration($mfgUname,$mfgPass);
		echo $mfgRegStatus;
		if($mfgRegStatus == "MFG_USER_REGISTERED"){

			//Redirect him to his main acccounts page
		}else if($mfgRegStatus == "MFG_USER_INCORRECT_CREDENTIALS"){
			//Redirect him to login page. and tell him to check his credentials
		}else if($mfgRegStatus == "MFG_USER_UNREGISTERED"){

			//tell him he has a no account!
		}else{
			errorHandler('DB_MFG_LOGIN_CREDENTIALS_CHECK_ERROR',"checkMfgAccountRegistration returned something unexpected!");
		}


	}else if (($_POST['loginType'] == "doc")){





	}else if(($_POST['loginType'] == "mer")){




	}else{

		//Catch Error for unknown user login type
	}
?>