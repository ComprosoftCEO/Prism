<html>

	<?php 
		//Required files
		require_once 'content.php';
		require_once 'database.php';
	?>

	<?php
		//Reroute back to homepage if there is no search query
		if (!isset($_GET["search_text"])) {
			header('Location: index.php');
		}
		
		//Draw the header information
		head('');

		//Was any data found???	
		$found = false;
		
		db_open();
		
		//Filter the search input for SQL injection
		$search_input = db_filter($_GET['search_text'],$conn);
			
		$query = "SELECT ID, Name 
				FROM users
				WHERE Name LIKE '%$search_input%';";
			
		//Search for authors
		$result = mysqli_query($conn, $query);
		if ($result->num_rows > 0) {
			echo '<h2 style="text-align: center">Authors:</h2><hr><br/>';
			$found = true;
			?><ol><?php	
			
			// output each author in the query returned
			while($row = $result->fetch_assoc()) {
					
				//Draw the hyperlink
				?> 
				<li><div class="blogpost">
				<a href="author.php?id=<?php echo $row['ID']; ?>" style="font-size: 16pt; color:#b3b3ff;"><?php echo htmlspecialchars($row['Name']); ?></a><br/>
				</div></li>
				<?php
			}
			?></ol><br/><br/><?php
		}
			
		//Execute a query to display article titles
		//  Search for text where content contains search entry or title contains search entry
		//  Make sure the article is NOT hidden
		$query = "SELECT blogentries.EntryID, blogentries.Title, blogentries.Date, blogentries.Content, users.Name, blogentries.AuthorID
			FROM blogentries
			INNER JOIN users
			ON blogentries.AuthorID = users.ID
			WHERE (Title LIKE '%$search_input%' OR Content LIKE '%$search_input%') AND (Hidden=0);";
			
		$result = mysqli_query($conn, $query);
			
		if ($result->num_rows > 0) {
			echo '<h2 style="text-align: center">Articles</h2><hr/><br/>';
			$found = true;
			
			//Output the data of each article in the query
			while($row = $result->fetch_assoc()) {
					
				//Draw the hyperlink
				?>
					<div class="blogpost">
						<a href="blog.php?id=<?php echo $row["EntryID"]; ?>" style='font-size: 16pt; color:#b3b3ff;'> <?php echo htmlspecialchars($row["Title"]); ?></a><br/>
						<p>By <?php echo htmlspecialchars($row['Name']); ?><br/>
						<?php echo $row['Date']; ?></p>
						<p><?php echo nl2br(htmlspecialchars(substr($row["Content"],0,100))); ?>...</p><br/>
						<hr>
					</div>
				<?php
			}
		}
		
		//In the event that no results  are found, let the user know...
		if ($found == false) {echo "No results found...";}
			
		//End the database connection
		$conn->close();		
	
?>

</body>
</html>
