<?php
	
	require_once "config.php";

	//Make sure the ID supplied is valid
	function validate_ID($id) {
		
		//Reroute back to homepage if invalid
		if (!isset($id) or !is_numeric($id)) {
			header('Location: index.php');
		}
	}
	
	
	function validate_login() {	
		//Reroute back to homepage if login is invalid
		if (!isset($_COOKIE['login_id']) || $_COOKIE['login_id'] == 0) {
			header('Location: index.php');
		}
	}
	
	
	//Generic functions to open and close database
	function db_open() {
		
		// Create connection
		global $conn;
		$conn = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);

		// Check connection
		return $conn->connect_error; 
	}


	
	function db_close() {
		$conn->close();		
	}
	
	
	
	
	
	//Filter database query
	function db_filter($input, $conn) {
		return mysqli_real_escape_string($conn,$input);
	}
	
	
	


	//Get the name associated with a numeric ID
	function get_name($id) {

		if (!isset($id)) {
			return 0;
		}
	
		//Create a connection to the database
		$c = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);
	
		//Get the query
		$query = 'SELECT Name
		FROM users
		WHERE ID='.$id.';';
	
		$result = mysqli_query($c, $query);
	
		//Return the first name
		if ($result->num_rows > 0) {
		
			$row = $result->fetch_assoc();
			
			$c->close();	
			return $row['Name'];
		
		} else {
			//Close connection
			$c->close();	
			
			return "Unknown Name";
		}
	}
	
	
	
	//Login to the database and set the key
	function Login() {

		//Do nothing if not logged in
		if (!isset($_POST['username']) || !isset($_POST['password'])) {
			return 0;
		}

		//Create a connection to the database
		$conn = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);
	
		//Filter login information
		$username = db_filter($_POST['username'],$conn);
		$password = db_filter($_POST['password'],$conn);
	
		//Get the query
		$query = 'SELECT ID, Username, Password
		FROM users';
	
		$result = mysqli_query($conn, $query);
	
		//Loop through all of the rows
		if ($result->num_rows > 0) {
			//Test each of the rows for username/password
			while($row = $result->fetch_assoc()) {
				if ($row['Username'] == $username && password_verify($password, $row['Password'])) {
					setcookie('login_id', $row['ID']);
					?><html><head><meta http-equiv="refresh" content="0"></head></html><?php
				}
			}
		}
	
		//Close connection
		$conn->close();		
		
	}


	function Logout() {

		if (isset($_POST['logout']) && $_POST['logout'] == 1) {
				setcookie('login_id',0);
				?><html><head><meta http-equiv="refresh" content="0"></head></html><?php
		}
	}
?>

