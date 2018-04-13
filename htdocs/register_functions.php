<?php

	require_once 'config.php';

	//Every username must be unique
	function UsernameExists($input) {
		
		//Connect to the database
		$conn = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);
		
		//Search for the name
		$input = mysqli_real_escape_string($conn,$input);
		$query = "SELECT Username
		FROM users
		WHERE Username='$input'";
		
		$result = mysqli_query($conn, $query);
	
		//There should be no entries
		if ($result->num_rows > 0) {
			$conn->close();
			return true;
		} else {
			$conn->close();
			return false;
		}
		
	}

	
	
	
	
    function RegisterUser()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        
		//Connect to the database
		$conn = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);
		
		//Filter for the database
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		
		//Be sure to hash the passsord
		$password = password_hash (mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
		
		//Insert the data into database
		$query = "INSERT INTO users (Name, Email, Username, Password)
		VALUES ('$name', '$email', '$username', '$password');";
		
		if (mysqli_query($conn, $query)) {
			$conn->close();
			return true;
		} else {
			echo mysqli_error($conn);
			$conn->close();
			return false;
		}
        
    }

?>
