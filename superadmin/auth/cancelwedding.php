<?php
session_start();
include_once __DIR__ . '/../include/connect_to_db.php';
if (isset($_POST['weddingid']) && isset($_SESSION['coordinate'])) {
	$id = $_POST['weddingid'];
	$until = $_POST['removeUntil'];
	$coordinate = $_SESSION['coordinate'];
	$deletewake = $con->query("DELETE FROM wedding WHERE id = '$id'");
	$deletebook = $con->query("DELETE FROM reservation WHERE until = '$until'");
	$_SESSION['delete-reservation'] = "Yes";
	header('location: ../home.php?v=' . $coordinate);
}

?>