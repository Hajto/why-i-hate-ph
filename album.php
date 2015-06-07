<?php
include 'mysql.php';

$current_location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$origin = substr($current_location, 0, strpos($current_location, "?"));
$album_id = substr($current_location, strpos($current_location, "?")+1, strlen($current_location));

$album_name = $conn->query("SELECT album_name FROM albums WHERE album_id=$album_id limit 1")->fetch_assoc()["album_name"];
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Magia kodów tesco</title>
	<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
	<header>
		<h1><a href="index.php">Albums</a> \ <a href="album.php?<?php echo $album_id ?>"><?php echo $album_name ?></a></h1>
	</header>
	<div class="content">
	<?php
		$result = $conn->query("SELECT album_id, image_id, image_name, url FROM images WHERE album_id = $album_id");
		if ($result->num_rows > 0) while ($row = $result->fetch_assoc()) echo "<div class='imgBox'><a href='".mb_substr($origin, 0, -9) . "image.php?".$row["album_id"]."%".$row["image_id"]."'><img src='".mb_substr($origin, 0, -9) . $row["url"] . " '><h2>" . $row["image_name"] . "</h2></a></div>";
	    else echo "0 results";
	?>
	</div>

</body>
</html>