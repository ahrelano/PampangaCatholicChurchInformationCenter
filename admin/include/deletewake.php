<?php
session_start();
include('connect_to_db.php');
if (isset($_GET['v'])) {
	$id = $_GET['v'];

	$updatewake = $con->query("UPDATE wake SET `show` = 'no' WHERE id = '$id'");
	$_SESSION['itemremove'] = 'yes'; 
	header('location: ../index.php');
}
?>