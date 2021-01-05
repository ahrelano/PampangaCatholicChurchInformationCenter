<?php 
session_start();
include('connect_to_db.php');

if(isset($_GET['id']) && isset($_SESSION['username'])){
$id = $_GET['id'];
$username = $_SESSION['username'];
$query = $con->query("INSERT INTO report_post (id,username) VALUES ('$id','$username')");
$check = $con->query("SELECT report FROM post WHERE id = '$id'");
while ($add = $check->fetch_array()){
	$noReport = $add['report'] + 1;
	$query=$con->query("UPDATE post SET report = '$noReport' WHERE id = '$id'");
}
	header('location: ../forums.php');
}else{
	header('location: ../index.php');
}


?>