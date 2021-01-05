<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['adminpass']) && isset($_GET['v'])) {
$adminpass = $_POST['adminpass'];
$adminid = $_GET['v'];

$updateadmin = $con->query("UPDATE account SET password = '$adminpass' WHERE id = '$adminid'");
$_SESSION['update'] = 'yes';
header('location: ../index.php');
}

?>