<?php
session_start();
include('connect_to_db.php');
if (isset($_GET['v'])) {
	$id = $_GET['v'];

	$updatewake = $con->query("UPDATE wake SET `show` = 'yes' WHERE id = '$id'");
	$_SESSION['update'] = 'yes'; 
	header('location: ../index.php');
}
?>