<?php
/**
* This file contains common functions and classes used throughout the application.
*
* @package   ayurAppCoreLibrary
* @author    pTk,..
*/

/** 
* The Development,Production flag.
* Uncomment the below line to enable development mode (Localhost)
*/
define("DEVELOPMENT", true);


//-------------------- Be careful before touching anything below from here --------------------------

if (defined("DEVELOPMENT")) {
	// Hostname of the Database
	define("DB_HOSTNAME","localhost");
	// Name of the MYSQL Database
	define("DB_NAME","db_ayurapp"); 
}else{
	// Hostname/IP Address of the of the Database hosting server
	define("DB_HOSTNAME","");
	// Name of the MYSQL Database
	define("DB_NAME","db_ayurapp"); 
}


/**
 * Loads all the libs from include/libs to the calling page
 *
 * @param string $currentPath the current path of the page which is calling this function
 * @return all the <script> and css files to calling page
 */
function getHeadScriptTags($currentPath){
  echo <<<SCRIPT
  <!-- jQuery 1.11.3 -->
  <script type="text/javascript" src ="$currentPath/include/libs/jquery-1.11.3.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="$currentPath/include/libs/bootstrap/bootstrap-3.3.5/css/bootstrap.min.css">
  <!-- Latest compiled Bootstrap JavaScript -->
  <script type="text/javascript" src="$currentPath/include/libs/bootstrap/bootstrap-3.3.5/js/bootstrap.min.js"></script>
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="$currentPath/include/libs/bootstrap/bootstrapForIE9/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="$currentPath/include/libs/bootstrap/bootstrapForIE9/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <!-- font-Awesome 4.4.0 -->
  <link rel="stylesheet" href="$currentPath/include/libs/font-awesome-4.4.0/css/font-awesome.min.css">
  <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
SCRIPT;
}

/**
 * Global Error Handler
 *
 * @param string $errorCode the error code defined in the switch statement of this function
 * @param string $errorMsg the error message given by the error thrown function
 * @return return nothing.
 */
function errorHandler($errorCode,$errorMsg){
	switch($errorCode){
		case 'DB_MFG_CONNECT_ERROR' : echo "Unable to connect to the database : ".$errorMsg;
				break;
		case 'DB_MFG_INSERT_PRODUCT_ERROR' : echo "Unable to insert product into Manufacturers database! : ".$errorMsg;
				break;
		default: echo "Unknown Error !";
	}


}
?>