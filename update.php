<?php
	header('Location: admin.php');
	include 'mysql.php'; 
	
	$id = $_GET['id'];
	$newNamer = $_GET['name'];
	executeQuerry("UPDATE images SET image_name='$newNamer' WHERE image_id=$id", $conn);