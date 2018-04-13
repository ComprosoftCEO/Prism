	<?php 
		//Required files
		require_once 'content.php';
		require_once 'database.php';
	?>

	<?php 
		//Draw the header information
		head('index');
	
	db_open();

	//Find the 5 most recent articles, making sure they aren't hidden
$query='SELECT blogentries.EntryID, blogentries.Title, blogentries.Date, blogentries.Content, users.Name
FROM blogentries
INNER JOIN users
ON blogentries.AuthorID = users.ID
WHERE Hidden=0
ORDER BY Date DESC LIMIT 5;';


$result = mysqli_query($conn, $query);

if ($result->num_rows > 0) {
	
    //Output each article on the home page
    while($row = $result->fetch_assoc()) {
        print_article($row["Title"],$row["Name"],$row["Date"],$row["Content"],$row["EntryID"]);
    }
} else {
    echo "0 results";
}
$conn->close();



//End off with the footer information
foot();

?>
