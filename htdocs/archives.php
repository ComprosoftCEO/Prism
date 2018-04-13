	<?php 
		//Required files
		require_once 'content.php';
		require_once 'database.php';
	?>

	<?php
		
		//Draw the header information
		head('archives');

		?><h1 style="text-align: center">Archives</h1><hr/><br/>
		<table style="width: 75%; margin-left: auto; margin-right: auto;">
			<tr  style="vertical-align: top;"><td>
			<h2 style="text-align: center">Blog Entries</h2>
		<?php	
		
		
		db_open();
	
		//First query gets all blog entries that are NOT hidden
		
		$query = 'SELECT blogentries.EntryID, blogentries.Title, blogentries.Date, blogentries.Content, users.Name
		FROM blogentries
		INNER JOIN users
		ON blogentries.AuthorID = users.ID
		WHERE Hidden=0
		ORDER BY Date DESC;';
		
		$result = mysqli_query($conn, $query);
	
		if ($result->num_rows > 0) {
			
			// output each title as a hyperlink to the blog page
			while($row = $result->fetch_assoc()) {

				?> 
					<a href="blog.php?id=<?php echo $row["EntryID"]; ?>" style='font-size: 16pt;color:b3b3ff;'> <?php echo htmlspecialchars($row["Title"]); ?> by <?php echo htmlspecialchars($row['Name']); ?> - <?php echo $row['Date']; ?></a><br/>
				<?php
			}
		} else {echo "No Blog Entries...";}

		?></td><td>
		<h2 style="text-align: center">Authors</h2><?php 
			
		
		//Next, search for authors
		$query = 'SELECT Name, ID
		FROM users
		ORDER BY Name ASC;';
		
		$result = mysqli_query($conn, $query);
		if ($result->num_rows > 0) {
			
			// output each author as a link to the Authors page
			while($row = $result->fetch_assoc()) {
				?> 
					<a href="author.php?id=<?php echo $row["ID"]; ?>" style='font-size: 16pt;color:#b3b3ff;'> <?php echo htmlspecialchars($row["Name"]); ?></a><br/>
				<?php
			}
		} else {echo "No Authors...";}

		?></td></tr></table><?php 
			
		//End the database connection
		$conn->close();		
	
?>

</body>
</html>
