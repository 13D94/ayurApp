<?php require_once(__DIR__.'/../include/coreLibrary.php');
// Check the User Logged In Status, if not logged in redirect him to Manufacturer Login Page.
checkMfgLoggedInStatus("mfgDashboard");
//The parameter passed is the current page.
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=getHeadScriptTags('..');
      // load scripts and css from include/libs folder. Use . for previous directory
      ?>
    <!-- Site CSS -->
    <link rel="stylesheet" type="text/css" href="./style.css">
    <title>Your Dashboard</title>
  </head>
  <body>