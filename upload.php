<?php
include 'mysql.php';
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if (isset($_POST['name']))
    $target_name = $_POST['name'];
else
    $target_name = basename($_FILES["fileToUpload"]["name"]);
$fileHasUploaded = 1;

$albumId = $_POST["album"];
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $fileHasUploaded = 1;
    } else {
        echo "File is not an image.";
        echo $_FILES['fileToUpload']['error'];
        $fileHasUploaded = 0;
    }
}
if (file_exists($target_file)) {
    echo "File already exists.";
    $fileHasUploaded = 0;
}

if ($_FILES["fileToUpload"]["size"] > 99000000) {
    echo "File is too large.";
    $fileHasUploaded = 0;
}

if (array_search($imageFileType, array(0 => 'png', 1 => 'jpg', 2 => 'jpeg', 3 => 'PNG', 4 => 'JPEG' , 5 => "JPG")) > 0) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $fileHasUploaded = 0;
}

if($fileHasUploaded == 1) {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        $sql = "INSERT INTO images (album_id, image_name, url, added) VALUES ('$albumId','$target_name', '$target_file', '$date') ";

        if ($conn->query($sql) === TRUE) {
            echo "<br>Image added successfully";
            header("Location: admin.php");
        } else echo "Error: " . $sql . "<br />" . $conn->error;
    } else echo "Sorry, there was an error uploading your file.";
}