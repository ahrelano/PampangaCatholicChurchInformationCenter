<?php
session_start();
if (isset($_POST['date']) && isset($_POST['time']) && isset($_POST['type']) && isset($_GET['massid']) ) {
	include('connect_to_db.php');
	$date = $_POST['date'];
	$time = $_POST['time'];
	$type = $_POST['type'];
	$id = $_GET['massid'];
	$updatemass = $con->query("UPDATE mass SET `date` = '$date', time = '$time', type = '$type' WHERE id = '$id'");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>