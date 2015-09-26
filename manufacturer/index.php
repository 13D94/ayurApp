<?php require_once(__DIR__.'/../include/coreLibrary.php');?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?=getHeadScriptTags('..');
    // load scripts and css from include/libs folder. Use . for previous directory
    ?>
  <title>Manufacturer Login</title>
  <style type="text/css">
    .roundbox {
        position: relative;
		padding: 15px;
		background-color: white;
		border: 1px solid #DDD;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
    }
  body{
  	padding-top: 15px;
  }
   input.parsley-error,
   select.parsley-error,
   textarea.parsley-error {
        color: #B94A48;
        background-color: #F2DEDE;
        border: 1px solid #EED3D7;
  }
  .parsley-errors-list {
  		//text-transform: uppercase;
        list-style-type: none;
        padding: 0px;
       //font-weight :bold;
        //font-size: 0.8em;
        color: red;
        font-variant: small-caps;
    }

    </style>
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
			      			<button type="submit" class="btn btn-success">Sign in</button>
			    		</div>
			 		</div>
			 		 <div class="form-group">
			    		<div class="col-sm-offset-2 col-sm-10">
			 				<?php 
			 				session_start();
			 				if(!is_null($_SESSION['MFG_LOGIN_FLAG'])){
			 						if($_SESSION['MFG_LOGIN_FLAG'] == 1){
			 							echo "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" id=\"invalid_cred_alert\">
			 							 <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
			 							 <strong>Invalid Credentials!</strong></div>";
			 						}
			 					} 
			 				?>
			 			<input type="hidden" name="loginType" value="mfg" />
			 			</div>
			 		</div>
				</form>
			</div>
		</div>
  	</div>
  </div>

  <script type="text/javascript">
  	$(function(){
		   $("#invalid_cred_alert").fadeTo(2000, 500).slideUp(500, function(){
		  	  $("#invalid_cred_alert").alert('close');
			});
	});
  </script>
</body>
</html>
