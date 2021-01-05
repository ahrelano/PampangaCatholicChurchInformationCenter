<?php
session_start();
include('connect_to_db.php');
if (isset($_GET['v'])) {
	$id = $_GET['v'];
	$deleteverse = $con->query("DELETE FROM dailyverse WHERE id = '$id'");
	$_SESSION['versedelete'] = 'yes';
	header('location: ../index.php');
}
?>