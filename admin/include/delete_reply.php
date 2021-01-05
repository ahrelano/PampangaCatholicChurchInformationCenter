<?php
session_start();
include ('connect_to_db.php');
if(isset($_GET['id']) && isset($_GET['id2'])){
$id = $_GET['id'];
$id2 = $_GET['id2'];
$query = $con->query("DELETE FROM reply WHERE id = '$id' AND idreply = '$id2'");
$_SESSION['deletepost'] = 'yes';
header('location: ../index.php');
}
?>