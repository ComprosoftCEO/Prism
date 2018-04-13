	<?php 
		//Required files
		require_once 'content.php';
		require_once 'database.php';
	?>

	<?php
		
		validate_login(); 
		
		//Draw the header information
		head('entries');
	
		$found = false;
		
		db_open();
			
		$query = 'SELECT blogentries.EntryID, blogentries.Title, blogentries.Date, blogentries.Content, users.Name
		FROM blogentries
		INNER JOIN users
		ON blogentries.AuthorID = users.ID
		WHERE blogentries.AuthorID = '.$_COOKIE['login_id'].'
		ORDER BY Date DESC;';
			
		//Search for authors
		$result = mysqli_query($conn, $query);
		if ($result->num_rows > 0) {
			$found = true;
			?><h1 style="text-align: center">Entries by <?php echo get_name($_COOKIE['login_id']);?></h1><hr/><ol><?php	
			
			// output data of each row
			while($row = $result->fetch_assoc()) {
					
				//Draw the hyperlink
				?> 
					<a href="blog.php?id=<?php echo $row["EntryID"]; ?>" style='font-size: 16pt; color:#b3b3ff;'> <?php echo $row["Title"]; ?> by <?php echo $row['Name']; ?> - <?php echo $row['Date']; ?></a><br/>
				<?php
			}
			?></ol><?php
		}

		if ($found == false) {echo "No entries to display...";}
			
		//End the database connection
		$conn->close();		
	
?>

</body>
</html>
