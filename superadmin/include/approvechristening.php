<?php
session_start();
if (isset($_GET['id']) ) {
	include('connect_to_db.php');
	$contact = $_POST['contact'];
	$id = $_GET['id'];
	$updatewake = $con->query("UPDATE christening SET approve = 'yes' WHERE id = '$id'");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>