	<?php 
		//Required files
		require_once 'config.php';
		require_once 'content.php';
		require_once 'database.php';
	
		//Test for user entered and valid id
		validate_login();
		validate_ID($_GET["id"]);
	
	
		//Delete Code
		if (isset($_POST['delete'])) {
			//Start with database connection
			$conn = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);
		
			$query = "DELETE FROM blogentries
			WHERE EntryID=".$_GET['id'].";";
			
			mysqli_query($conn, $query);
			$conn->close();
			
			//And go back to home page
			header('Location: index.php');
			exit;
		}
	
		//Do code on post
		if (isset($_POST['update'])) {
			
			//Start with database connection
			$conn = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);
			
			//Filter the information
			$AuthorID = $_COOKIE['login_id'];
			$Title = mysqli_real_escape_string($conn, $_POST['btitle']);
			$Date = mysqli_real_escape_string($conn, $_POST['bdate']);
			$Content = mysqli_real_escape_string($conn, $_POST['bcontent']);
			$Hidden =  mysqli_real_escape_string($conn, $_POST['bvisibility']);
			
			//Which article ID to jump to???
			$returnID = $_GET["id"];
			
			//NEW ENTRY
			if ($_GET['id'] == 0) {
				
				$query = "INSERT INTO blogentries (AuthorID, Title, Date, Content, Hidden)
				VALUES ('$AuthorID', '$Title', '$Date', '$Content', '$Hidden');";
				
			} else {
				
				$query = "UPDATE blogentries
				SET Title='$Title', Date='$Date', Content='$Content', Hidden='$Hidden'
				WHERE EntryID='".$_GET['id']."' AND AuthorID='$AuthorID';";
				
			}
			
			mysqli_query($conn, $query);
			
			//Only get the new ID if it is a new entry
			if ($_GET['id'] == 0) {
				//find the last modified row
				$query = 'SELECT EntryID FROM blogentries ORDER BY lastmodified DESC LIMIT 1';
				$result = mysqli_query($conn, $query);
			
				echo mysqli_error($conn);
			
				//Get the data to redirect to the updated article
				$row = $result->fetch_assoc();
				$returnID = $row['EntryID'];
			}
			
			$conn->close();
			
			//Redirect to the updated article
			header('Location: blog.php?id='.$returnID);
			exit;
		}
	
	
		//If ID=0, then do new entry
		if ($_GET['id'] == 0) {
			$title = '';
			$date = date("Y-m-d");
			$selected=0;
			$content='';
		} else {
	
		//Start with database connection
		$conn = new mysqli(HOSTNAME, DB_USERNAME, DB_PASSWORD, PRISM_DATABASE);
		
		$query = 'SELECT * FROM blogentries
		WHERE EntryID='.$_GET['id'].' AND AuthorID='.$_COOKIE['login_id'].';';
	
		$result = mysqli_query($conn, $query);
		if ($result->num_rows > 0) {
				
			//Get the first row in the database
			$row = $result->fetch_assoc();
			$conn->close();
		
			//And set all of the variables
			$title = $row['Title'];
			$date = $row['Date'];
			$selected=$row['Hidden'];
			$content=$row['Content'];
		
		} else {
			$conn->close();
			//Jump back to home page if the article does not exist
			header('Location: index.php');
			exit;
		}
		}
		
		
		//Verity the selection for the drop down menu
		function test_sel($input, $num) {
			if ($input == $num) {return 'selected="selected"';} else {return '';}
		}
		
	
		head('new');
	?>

	
<?php if ($_GET['id']==0) {
	?> <h1 style="text-align: center">New Blog Entry</h1> <?php
	} else {
		?> <h1 style="text-align: center">Edit Blog Entry</h1> <?php
	}?>
<form action="" method='post' id='prefs'>
		<div class = "box">
		Title:
		<input type="text" name="btitle" id='btitle' value="<?php echo $title;?>"><br/>
		<br><br/>
		Date:
		<input type="date" name="bdate" id='bbdate' value="<?php echo $date; ?>">
		<br><br>
		Visibility:
		<select name="bvisibility">
			<option value="0" <?php echo test_sel($selected, 0); ?>>Public</option>
			<option value="1" <?php echo test_sel($selected, 1); ?>>Only Visible with Link</option>
			<option value="2" <?php echo test_sel($selected, 2); ?>>Private</option>
		</select>
		<br/><br/>
		
		Blog Entry Content:
		<textarea name="bcontent" rows="15" cols="60"><?php echo htmlspecialchars($content); ?></textarea>
		<br/><br/>
		<input type="submit" name="update" value="Submit" class="formBut">
	</div>
</form>

<form action="" method="post">
	<div class = "box">
	<input type="submit" name="delete" value="Delete Entry" class="formBut">
	</div>
</form>


</body>
</html>
