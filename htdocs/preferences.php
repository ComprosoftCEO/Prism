	<?php 
		//Required files
		require_once 'config.php';
		require_once 'content.php';
		require_once 'database.php';
	
		//Test for user entered
		validate_login();
		
		//Start with database connection
		$conn = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);
	
		//Do the updating
		if (isset($_POST['update'])) {
			
			//Filter for the database
			$name = mysqli_real_escape_string($conn, $_POST['uname']);
			$email = mysqli_real_escape_string($conn, $_POST['uemail']);
			$age = mysqli_real_escape_string($conn, $_POST['uage']);
			$bio = mysqli_real_escape_string($conn, $_POST['ubiography']);
			
			//Update the database
			$query = "UPDATE users 
			SET Name='$name', Email='$email', Age='$age', Biography='$bio'
			WHERE ID=".$_COOKIE['login_id'].";";
			
			mysqli_query($conn, $query);
		}
		
		//Previously typed data if the password does not match, or other error
		//  If the password had an error, don;t force the user to retype everything
		$curpas = '';
		$firstnew = '';
		$secondnew = '';
		$error = '';		//Various password errors
		
		//See if the change password button was clicked
		if (isset($_POST['changepass'])) {
			
			//Get the password data
			$curpas = $_POST['oldpassword'];
			$firstnew = $_POST['newpassword'];
			$secondnew = $_POST['retypepassword'];
				
			//Verify the password data	
			$query = 'SELECT Password FROM users WHERE ID='.$_COOKIE['login_id'].';';
			$result = mysqli_query($conn, $query);
			
			if ($result->num_rows > 0) {
			
			//Get the first row in the database
			$row = $result->fetch_assoc();
			
				//Test the password, and set the various errors
				if (password_verify($curpas, $row['Password'])) {
					if ($firstnew == $secondnew) {
						
						//Run the update code
						$query = "UPDATE users
						SET Password='".password_hash(mysqli_real_escape_string($conn, $_POST['newpassword']), PASSWORD_DEFAULT)."'
						WHERE ID=".$_COOKIE['login_id'].";";
						
						mysqli_query($conn, $query);
						
						//Reset the entered data
						$curpas = '';
						$firstnew = '';
						$secondnew = '';
						
					} else {
						$error = 'The two passwords do not match!';
					}
				} else {
					$error = 'Current password incorrect!';
				}
			
			}
		}
			
		//Delete your account
		if (isset($_POST['reset'])) {
			
			//Delete the user
			$query = 'DELETE FROM users
			WHERE ID='.$_COOKIE['login_id'].';';
			
			mysqli_query($conn, $query);
			
			//Delete the blog entries
			$query = 'DELETE FROM blogentries
			WHERE AuthorID='.$_COOKIE['login_id'].';';
			mysqli_query($conn, $query);
			
			//Remove the cookie
			setcookie('login_id', 0);
			
			$conn->close();
			
			//And redirect back home
			header('Location: index.php');
			
			exit;
		}
		
		$query = 'SELECT * FROM users WHERE ID='.$_COOKIE['login_id'].';';

		$result = mysqli_query($conn, $query);
		if ($result->num_rows > 0) {
			
			//Get the first row in the database to display the User's preferences
			$row = $result->fetch_assoc();
			$conn->close();
		} else {
			$conn->close();
			//Jump back to home page (For whatever reason) if the account does not exist
			header('Location: index.php');
		}
		
		
		
	
		head('');
	?>

<form action="" method='post' id='prefs'>
		<div class = "box">
		<h2 style="text-align: center;">Edit Preferences</h2>
		Full Name
		<input type="text" name="uname" id='uname' value="<?php echo $row['Name']; ?>"><br/>
		<br>
		Email:
		<input type="text" name="uemail" id='uemail' value="<?php echo $row['Email']; ?>">
		<br><br>
		Age:
		<input type="number" min="0" max="150" name="uage" id='uage' value="<?php echo $row['Age']; ?>">
		<br><br>
		Biography:
		<textarea name="ubiography" rows="4" cols="50"><?php echo $row['Biography']; ?></textarea>
		<br/><br/>
		<input type="submit" name="update" value="Update" class="formBut">
	</div>
<br><br>
</form>

<form action="" method='post'>
<div class = "box">
	<h2 style="text-align: center;">Change Password</h2>
  Old Password:
  <input type="password" name="oldpassword" value="<?php echo $curpas;?>">
  <br><br>
  New Password:
  <input type="password" name="newpassword" value="<?php echo $firstnew; ?>">
  <br><br>
  Retype Password:
  <input type="password" name="retypepassword" value="<?php echo $secondnew; ?>">
  <br>
  <p style="color: red;"><?php echo $error; ?></p>
  <br>
  <input type="submit" name="changepass" value="Change Password" class="formBut">
</div>
<br><br>
</form>

<form action="" method='post'>
	<div class = "box">
	<input type="submit" name="reset" value="Delete Account" class="formBut">
	</div>
</form>


</body>
</html>
