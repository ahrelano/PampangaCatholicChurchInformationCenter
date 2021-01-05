<?php
session_start();
include('connect_to_db.php');
if (isset($_GET['v'])) {
	$id = $_GET['v'];

	$updatewake = $con->query("UPDATE christening SET `show` = 'no' WHERE id = '$id'");
	$_SESSION['itemremove'] = 'yes'; 
	header('location: ../index.php');
}
?>