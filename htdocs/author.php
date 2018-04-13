	<?php 
		//Required files
		require_once 'content.php';
		require_once 'database.php';
	?>

	<?php 
		//Test the ID for invalid number
		validate_ID($_GET["id"]);
		
		//Draw the header information
		head('');
	
	if (isset($_GET["id"])) {
	
	//Open the database
	db_open();

	//Display information about the authors
	$result = mysqli_query($conn, 'SELECT Name, Email, Age, Biography FROM users WHERE ID='.$_GET["id"].';');

	if ($result->num_rows > 0) {
	
		//There should only be one row here
		$row = $result->fetch_assoc();
	
		//Display age and email
		echo '<table style="width: 75%; margin-left: auto; margin-right: auto; border: 3px solid #'.random_color().';"><tr><td style="text-align: center; width: 60%;">';
		echo '<h1 '.getcolor().'>'.$row["Name"].'</h1>';
		echo '<p style="font-size: 16pt;">Age '.$row["Age"].'<br/>';
		echo '<a href="mailto:'.$row["Email"].'">'.$row["Email"].'</a></p>';
		
		//Display biography
		echo '<p '.getcolor().'>'.$row["Biography"].'</p></br>';
		
		echo '</td><td style="text-align: center; vertical-align: top; width: 40%;"><br/><br/>';
		
		//And list their blog entries
		echo '<h3>Blog Entries</h3>';
		$result2 = mysqli_query($conn, 'SELECT EntryID, Title, Date FROM blogentries WHERE AuthorID='.$_GET["id"].' AND (Hidden=0 OR (AuthorID='.$_COOKIE['login_id'].' AND (Hidden=1 OR Hidden=2))) ORDER BY Date DESC;');
	
		//Test if there are any articles
		if ($result2->num_rows > 0) {
			echo '<ul>';
			
			// output data of each row
			while($row = $result2->fetch_assoc()) {
				
				//Draw the entry title as a hyperlink
				echo '<li><a href="blog.php?id='.$row["EntryID"].'" style="color:#b3b3ff;">'.htmlspecialchars($row["Title"]).' - '.$row["Date"].'</a></li>';
			}
			echo '</ul>';
		} else {
			echo "<p>No blog entries to display...</p>";
		}
		echo '</td></tr></table>';
		$conn->close();		
	
	} else {
		echo "Unknown Author!";
	}
	}
?>

</body>
</html>
