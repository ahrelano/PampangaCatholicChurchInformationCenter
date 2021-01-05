<?php
session_start();
if (isset($_POST['year']) && isset($_GET['yearid']) && isset($_GET['v']) ) {
	include('connect_to_db.php');
	$year = $_POST['year'];
	$id = $_GET['yearid'];
	$coordinate = $_GET['v'];
	$updateyear = $con->query("UPDATE history SET title = '$year' WHERE coordinate = '$coordinate' AND id = '$id'");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>