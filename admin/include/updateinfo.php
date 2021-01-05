<?php
session_start();
if (isset($_POST['info']) && isset($_GET['infoid']) && isset($_GET['v']) ) {
	include('connect_to_db.php');
	$info = $_POST['info'];
	$id = $_GET['infoid'];
	$coordinate = $_GET['v'];
	$updateyear = $con->query("UPDATE history SET info = '$info' WHERE coordinate = '$coordinate' AND id = '$id'");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>