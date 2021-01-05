<?php
session_start();
include_once __DIR__ . '/../include/connect_to_db.php';
if (isset($_GET['christeningid'])) {
	$id = $_GET['christeningid'];
	$until = $_GET['banishUntil'];
	$deletewake = $con->query("DELETE FROM christening WHERE id = '$id'");
	$deletebook = $con->query("DELETE FROM reservation WHERE until = '$until'");
	$_SESSION['delete-reservation'] = "Yes";
	header('location: ../index.php');
}

?>