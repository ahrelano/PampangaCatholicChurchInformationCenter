<?php
session_start();
include ('connect_to_db.php');
if(isset($_GET['id'])){
$id = $_GET['id'];
$query = $con->query("DELETE FROM post WHERE id = '$id'");
$_SESSION['deletepost'] = 'yes';
header('location: ../index.php');
}
?>