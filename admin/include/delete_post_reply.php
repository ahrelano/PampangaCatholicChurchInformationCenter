<?php
session_start();
include ('connect_to_db.php');
if(isset($_GET['id'])){
$id = $_GET['id'];
$query = $con->query("DELETE FROM post WHERE id = '$id'");
$query2 = $con->query("DELETE FROM reply WHERE id = '$id'");
header('location: ../forums.php');
}else{
	header('location: ../index.php');
}
?>