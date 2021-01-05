<?php 
session_start();
include('connect_to_db.php');

if(isset($_GET['id']) && isset($_SESSION['username']) && isset($_GET['id2'])){
$id = $_GET['id'];
$id2 = $_GET['id2'];
$username = $_SESSION['username'];
$query = $con->query("INSERT INTO report_reply (id,idreply,username) VALUES ('$id','$id2','$username')");
$check = $con->query("SELECT report FROM reply WHERE id = '$id' AND idreply='$id2'");
while ($add = $check->fetch_array()){
	$noReport = $add['report'] + 1;
	$query=$con->query("UPDATE reply SET report = '$noReport' WHERE id = '$id' AND idreply='$id2'");
}
	header('location: ../forumsreply.php?id=' . $id);
}else{
	header('location: ../index.php');
}


?>