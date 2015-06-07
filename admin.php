<?php
include 'mysql.php';

$current_location = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (isset($_POST['submitAlbum'])) executeQuerry("INSERT INTO albums (album_name, created) VALUES ('$_POST[album_name]', '$date') ", $conn);
if (isset($_REQUEST['removeAlbum'])) {
    deLink("SELECT url FROM images WHERE album_id='$_POST[removeAlbum]';", $conn);
    executeQuerry("DELETE albums, images FROM albums INNER JOIN images WHERE albums.album_id = images.album_id AND albums.album_id='$_POST[removeAlbum]';", $conn);
    executeQuerry("DELETE FROM albums WHERE album_id='$_POST[removeAlbum]';", $conn);
}
if (isset($_REQUEST['removeImage'])) {
    deLink("SELECT url FROM images WHERE image_id='$_POST[removeImage]';", $conn);
    executeQuerry("DELETE FROM images WHERE image_id='$_POST[removeImage]';", $conn);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <title></title>
    <script>
        function update(event) {
            console.log(event.value);
            var newValue = prompt("Podaj nową nazwę.");
            if (newValue.length > 0)
                document.location = "update.php?id=" + event.value + "&name=" + newValue;
            //alert(event.target.value)
        }
    </script>
</head>
<body>
<header>
    <h1>Zamulator 9001</h1>
</header>
<div class="content">
    <h2>Add new album</h2>

    <form action="admin.php" method="post">
         <label>Album name:
            <input type="text" name="album_name">
        </label> <input type="Submit" name="submitAlbum" value="Add album">
    </form>
    <h2>Albums</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Creation date</td>
            <td>Delete</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT album_id, album_name, created FROM albums");
        if ($result->num_rows > 0) while ($row = $result->fetch_assoc())
            echo "<tr><td>" . $row["album_id"] . "</td><td>" . $row["album_name"] . "</td><td>" . $row["created"] . "</td><td><form method='post' ><button type='submit' name='removeAlbum' value='" . $row["album_id"] . "'>Delete</button></form></td></tr>";
        else echo "Brak rekordów"; ?>
        </tbody>
    </table>
    <h2>Images</h2>
    <table class="table table-striped table-hover table-condensed">
        <thead>
        <tr>
            <td>ID</td>
            <td>Album ID</td>
            <td>Name</td>
            <td>Link</td>
            <td>Added date</td>
            <td>&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT images.image_id, images.album_id, images.image_name, images.url, images.added, albums.album_name FROM images INNER JOIN albums ON images.album_id = albums.album_id");
        if ($result->num_rows > 0) while ($row = $result->fetch_assoc())
            echo "<tr><td>" . $row["image_id"] . "</td><td>" . $row["album_name"] . "</td><td>" . $row["image_name"] . "</td><td><a href='" . mb_substr($current_location, 0, -9) . $row["url"] . "'>Show</a></td><td>" . $row["added"] . "</td><td><form method='post' ><button type='submit' name='removeImage' value='" . $row["image_id"] . "'>Delete</button></form><button onclick=" . '"update(this)"' . " value='" . $row["image_id"] . "'>Update</button></td></tr>";
        else echo "Brak rekordów";
        ?>
        </tbody>
    </table>
    <h2>Upload images</h2>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload" style="display:inline;">
        <label>Category:
        <select name="album">
            <?php
            $result = $conn->query("SELECT album_id, album_name FROM albums");
            if ($result->num_rows > 0) while ($row = $result->fetch_assoc())
                echo "<option value=" . $row["album_id"] . ">" . $row["album_id"] . " - " . $row["album_name"] . "</option>";
            else echo "Brak rekordów"; ?>
        </select></label>
        <label> Nazwa zdjęcia:
            <input type="text" name="name"/>
        </label>
        <input type="submit" value="Upload Image" name="submit">
    </form>
</div>
<footer>
    <a class="toGallery" href="index.php" style="text-align: center; margin: 0 auto; display: block;">Go to
        gallery</a>
</footer>
</body>
</html>