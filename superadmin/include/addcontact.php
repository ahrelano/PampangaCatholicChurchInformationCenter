<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['contact']) && isset($_GET['v'])) {
	$contact = $_POST['contact'];
	$coordinate = $_GET['v'];
	$addcontact = $con->query("INSERT INTO contact (contact, coordinate) VALUES ('$contact','$coordinate')");
$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>