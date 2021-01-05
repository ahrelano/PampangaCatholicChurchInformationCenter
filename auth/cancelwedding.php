<?php
session_start();
include_once __DIR__ . '/../include/connect_to_db.php';
if (isset($_GET['weddingid'])) {
	$id = $_GET['weddingid'];
	$until = $_GET['removeUntil'];
	$deletewake = $con->query("DELETE FROM wedding WHERE id = '$id'");
	$deletebook = $con->query("DELETE FROM reservation WHERE until = '$until'");
	$_SESSION['delete-reservation'] = "Yes";
	header('location: ../index.php');
}

?>