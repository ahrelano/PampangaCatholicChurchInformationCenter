<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['titleverse']) && isset($_POST['bodyverse']) && isset($_POST['verseid'])) {
$title = $_POST['titleverse'];
$body = $_POST['bodyverse'];
$id = $_POST['verseid']; 
$updateverse = $con->query("UPDATE dailyverse SET verse = '$title', `text` = '$body' WHERE id='$id'");
$_SESSION['update'] = 'yes';
header('location: ../index.php');
}
?>