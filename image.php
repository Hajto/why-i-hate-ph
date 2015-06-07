<?php
include 'mysql.php';
$current_location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$origin = substr($current_location, 0, strpos($current_location, "?"));
$image_id = substr($current_location, strpos($current_location, "%") + 1, strlen($current_location));
$album_id = substr($current_location, strpos($current_location, "?") + 1, -strlen($image_id) - 1);

$sql = "SELECT image_name, url FROM images WHERE image_id=$image_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$image_name = $row["image_name"];
$image_url = $row["url"];

$album_name = $conn->query("SELECT album_name FROM albums WHERE album_id=$album_id")->fetch_assoc()["album_name"];

$image_next_id = $conn->query("SELECT image_id, album_id FROM images WHERE album_id = $album_id AND image_id>$image_id LIMIT 1")->fetch_assoc()["image_id"];

$image_prev_id = $conn->query("SELECT image_id, album_id FROM images WHERE album_id = $album_id AND image_id<$image_id ORDER BY image_id DESC LIMIT 1")->fetch_assoc()["image_id"];
?>

<html>
<head>
    <title> Łaaaaaa!!</title>
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
</head>
<body>
<header>
    <h1><a href="index.php">Albums</a> \ <a href="album.php?<?php echo $album_id ?>"><?php echo $album_name ?></a>
        \ <?php echo $image_name ?></h1>
</header>
<div class="content">
    <div class="imgFull"><img src='<?php echo mb_substr($origin, 0, -9) . $image_url ?>'>

        <h2>
            <?php
            if ($image_prev_id != NULL) echo '<span class="imgNav"><a href="image.php?' . $album_id . "%" . $image_prev_id . '"> <i class="fa fa-arrow-left"></i> </a></span>';
            echo $image_name;
            if ($image_next_id != NULL) echo '<span class="imgNav"><a href="image.php?' . $album_id . '%' . $image_next_id . '"> <i class="fa fa-arrow-right"></i></a></span>'; ?>
        </h2>
    </div>

</div>
</body>
</html>