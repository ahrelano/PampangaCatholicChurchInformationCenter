<?php
session_start();
include_once __DIR__ . '/../include/connect_to_db.php';
if (isset($_GET['wakeid'])) {
	$id = $_GET['wakeid'];
	$until = $_GET['deleteUntil'];
	$deletewake = $con->query("DELETE FROM wake WHERE id = '$id'");
	$deletebook = $con->query("DELETE FROM reservation WHERE until = '$until'");
	$_SESSION['delete-reservation'] = "Yes";
	header('location: ../index.php');
}

?>