<?php
session_start();
if (isset($_GET['id']) ) {
	include('connect_to_db.php');
	$id = $_GET['id'];
	$deletetitle = $con->query("UPDATE history SET title = '' WHERE id = '$id'");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>