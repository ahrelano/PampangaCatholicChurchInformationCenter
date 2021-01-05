<?php
session_start();
if (isset($_POST['year']) && isset($_POST['info']) && isset($_GET['v']) ) {
	include('connect_to_db.php');
	$year = $_POST['year'];
	$info = $_POST['info'];
	$coordinate = $_GET['v'];
	$addhistory = $con->query("INSERT INTO history (coordinate, title, info) VALUES ('$coordinate','$year','$info')");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>