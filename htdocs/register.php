<?php 
		//Required files
		require_once 'content.php';
		require_once 'database.php';
		require_once ("register_functions.php");

		//Make sure the user isn't logged in
		if (isset($_COOKIE['login_id']) && $_COOKIE['login_id'] > 0) {
			header('Location: index.php');
		}
		
		//If the password is already taken, retype in the current data
		$taken = false;
		$n = '';
		$e = '';
		$u = '';
		$p = '';
		
	if(isset($_POST['submitted'])) {
			
		//Make sure username is different
		if (UsernameExists($_POST['username'])) {
			$n = $_POST['name'];
			$e = $_POST['email'];
			$u = $_POST['username'];
			$p = $_POST['password'];
			$taken = true;
		} else {
			if(RegisterUser()) {
				header('Location: index.php');
			}
		}
	}

		//Draw the header information
		head('register');

?>

<!-- Form Code Start -->
<div id='fg_membersite'>
<form id='register' action='' method='post' accept-charset='UTF-8'>
	<fieldset >
	<legend>Register</legend>

	<input type='hidden' name='submitted' id='submitted' value='1'/>

	<div class='short_explanation'>* required fields</div>

	<div><span class='error'></span></div>
	<div class='container'>
		<label for='name' >Your Full Name*: </label><br/>
		<input type='text' name='name' id='name' value='<?php echo $n; ?>' maxlength="50" /><br/>
		<span id='register_name_errorloc' class='error'></span>
	</div>
	
	<div class='container'>
		<label for='email' >Email Address*:</label><br/>
		<input type='text' name='email' id='email' value='<?php echo $e; ?>' maxlength="50" /><br/>
		<span id='register_email_errorloc' class='error'></span>
	</div>

	<div class='container'>
		<label for='username' >UserName*:</label><br/>
		<input type='text' name='username' id='username' value='<?php echo $u; ?>' maxlength="50" /><br/>
		<span id='register_username_errorloc' class='error'><?php if ($taken == true) {echo 'That username is already taken.';}?></span>
	</div>

	<div class='container' style='height:80px;'>
		<label for='password' >Password*:</label><br/>
		<div class='pwdwidgetdiv' id='thepwddiv' ></div>
		<noscript>
			<input type='password' name='password' id='password' maxlength="50" value='<?php echo $p; ?>'/>
		</noscript>    
		<div id='register_password_errorloc' class='error' style='clear:both'></div>
		
	</div>

	<div class='container'>
		<input type='submit' name='Submit' value='Submit' />
	</div>

</fieldset>
</form>
</div>


<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->
<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('thepwddiv','password');
    pwdwidget.MakePWDWidget();
    
    var frmvalidator  = new Validator("register");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req","Please provide your name");

    frmvalidator.addValidation("email","req","Please provide your email address");

    frmvalidator.addValidation("email","email","Please provide a valid email address");

    frmvalidator.addValidation("username","req","Please provide a username");
    
    frmvalidator.addValidation("password","req","Please provide a password");

// ]]>
</script>


<?php
		
		
//End off with the footer information
foot();

?>
