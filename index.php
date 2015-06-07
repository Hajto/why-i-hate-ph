<?php

include 'mysql.php';
$current_location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Programista płakał jak pisał.</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
	<div class="content">
	<?php
		$result = $conn->query("SELECT images.album_id, images.image_id, images.image_name, images.url, albums.album_name FROM images INNER JOIN albums ON images.album_id = albums.album_id GROUP BY album_id");
		if ($result->num_rows > 0) while ($row = $result->fetch_assoc())
			echo "<div class='imgBox'><a href='album.php?". $row["album_id"] ."'><img src='". $row["url"] . "'' / ><h2>" . $row["album_name"] . "</h2></a></div>";
		 else echo "0 results"; ?>
	</div>
</body>
</html>