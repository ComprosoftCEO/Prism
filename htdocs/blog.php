	<?php 
		//Required files
		require_once 'content.php';
		require_once 'database.php';
	?>
	
	<?php
		validate_ID($_GET["id"]);

		//Draw the header information
		head('');

	//Open the database
	db_open();

	$query = 'SELECT blogentries.EntryID, blogentries.Title, blogentries.Date, blogentries.Content, blogentries.AuthorID, users.Name
	FROM blogentries
	INNER JOIN users
	ON blogentries.AuthorID = users.ID
	WHERE EntryID='.$_GET["id"].' AND (Hidden=0 OR Hidden=1 OR (AuthorID='.$_COOKIE['login_id'].' AND Hidden=2));';
	
	//Display the whole blog entry
	$result = mysqli_query($conn, $query);

	if ($result->num_rows > 0) {
		// output data of each row
		echo '<div class="blogpost">';
		$row = $result->fetch_assoc()
		?>
		<h1 <?php echo getcolor(); ?>><?php echo htmlspecialchars($row["Title"]); ?></h1>
		<?php $para = getcolor(); ?>
		
		<p <?php echo $para; ?> >By
		<a href="author.php?id=<?php echo $row["AuthorID"]; ?>" <?php echo $para; ?>> <?php echo htmlspecialchars($row['Name']); ?></a><br/> <?php echo $row["Date"]; ?></p>
		
		
		<p <?php echo getcolor(); ?>> <?php echo nl2br(htmlspecialchars($row["Content"])); ?> </p><br/>
		<?php
		
		echo '</div>';
		
		if (isset($_COOKIE['login_id']) and ($row['AuthorID'] == $_COOKIE['login_id'])) {
			echo '<a href="editblog.php?id='.$row['EntryID'].'" style="color:#b3b3ff;">Edit</a>';
		} 
	} else {
		echo "Unknown Article!";
	}


	
	?>

</body>
</html>
