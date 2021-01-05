<?php
session_start();
if (isset($_POST['date']) && isset($_POST['time']) && isset($_POST['type']) && isset($_GET['v']) ) {
	include('connect_to_db.php');
	$date = $_POST['date'];
	$time = $_POST['time'];
	$type = $_POST['type'];
	$coordinate = $_GET['v'];
	$addmass = $con->query("INSERT INTO mass (coordinate, `date`, time, type) VALUES ('$coordinate','$date','$time', '$type')");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>