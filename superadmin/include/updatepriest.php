<?php
session_start();
if (isset($_GET['v']) && isset($_POST['priest']) ) {
	include('connect_to_db.php');
	$priest = $_POST['priest'];
	$coordinate = $_GET['v'];
	$updatepriest = $con->query("UPDATE history SET priest = '$priest' WHERE coordinate = '$coordinate'");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>