<?php
session_start();
include_once __DIR__ . '/../include/connect_to_db.php';
if (isset($_POST['wakeid']) && isset($_SESSION['coordinate'])) {
	$id = $_POST['wakeid'];
	$until = $_POST['deleteUntil'];
	$coordinate = $_SESSION['coordinate'];
	$deletewake = $con->query("DELETE FROM wake WHERE id = '$id'");
	$deletebook = $con->query("DELETE FROM reservation WHERE until = '$until'");
	$_SESSION['delete-reservation'] = "Yes";
	header('location: ../home.php?v=' . $coordinate);
}

?>