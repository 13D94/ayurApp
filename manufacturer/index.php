<?php require_once(__DIR__.'/../include/coreLibrary.php');
// Check the User Logged In Status, if logged in redirect him to Dashboard.
checkMfgLoggedInStatus("mfgLoginPage");
//The parameter passed is the name of the current page.
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
	    <title>Manufacturer Login</title>
  </head>
  <body>
  <div class="container">
  	<div class="row">
  		<div class="col-md-6 col-md-offset-3">
  			<div class="jumbotron">
			  
			</div>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-6 col-md-offset-3">
	  		<div class="roundbox">
			  	<form class="form-horizontal" action="../include/login.php" method="POST" data-parsley-validate>
			  		<div class="form-group">
			   			<label for="mfgUname" class="col-sm-2 control-label">Username</label>
			   				<div class="col-sm-10">
			    				<input type="text" class="form-control" id="mfgUname" name="mfgUname" placeholder="Your Username" data-parsley-error-message="please enter your username" required />
			  				</div>
			 		</div>
			  		<div class="form-group">
			    	<label for="mfgPass" class="col-sm-2 control-label">Password</label>
			   			<div class="col-sm-10">
			    			<input type="password" class="form-control" id="mfgPass" name="mfgPass" placeholder="Your Password" data-parsley-error-message="please enter your password" required />
			    		</div>
			  		</div>
				    <div class="form-group">
			    		<div class="col-sm-offset-2 col-sm-10">
			      			<button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Log in to my Dashboard">Log in</button>
			    		</div>
			 		</div>
			 		 <div class="form-group">
			    		<div class="col-sm-offset-2 col-sm-10">
			 				<?php 
			 				if(isset($_SESSION['MFG_LOGIN_FLAG'])){
			 						if($_SESSION['MFG_LOGIN_FLAG'] == 1){
			 							echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" id=\"invalid_cred_alert\">
			 							 <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
			 							 <strong>Invalid Credentials!</strong></div>";
			 						}
			 					} 
			 				unset($_SESSION['MFG_LOGIN_FLAG']);
			 				?>
			 			<input type="hidden" name="loginType" value="mfg" />
			 			</div>
			 		</div>
				</form>
			</div>
		</div>
  	</div>
  </div>

<!-- Site JS -->
<script type="text/javascript" src="./script.js"></script>
</body>
</html>
