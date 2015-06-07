<?php
$servername = "cronline.pl";
$username   = "slick";
$password   = "slick";
$dbname     = "haito_stadnik_galeria";
$date       = date("Y-m-d");

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error)
	die("Connection failed: " . $conn->connect_error);

function executeQuerry($queryString, $connection){
	if (!$connection->query($queryString) === TRUE) echo "Error: " . $queryString . "<br>" . $connection->error;
}

function deLink($querryString, $connection){
	$result = $connection->query($querryString);
	if ($result->num_rows > 0) while ($row = $result->fetch_assoc()) unlink($row["url"]);
}

?>