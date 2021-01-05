<?php
session_start();
session_destroy();
if (isset($_GET['id'])) {
include('connect_to_db.php');
$id = $_GET['id'];
if (isset($_GET['v'])) {
$query = $con->query("UPDATE account SET active = '0' WHERE username='$id'");
header("location: ../church.php?v=" . $_GET['v']);
}else{
$query = $con->query("UPDATE account SET active = '0' WHERE username='$id'");
header("location: ../index.php");
}}
?>