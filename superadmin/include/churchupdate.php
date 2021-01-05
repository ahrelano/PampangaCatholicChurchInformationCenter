<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['churchupdate'])) {
	$coordinate = $_POST['churchupdate'];
	$_SESSION['coordinate'] = $_POST['churchupdate'];
	$query = $con->query("SELECT * FROM church WHERE coordinate = '$coordinate' LIMIT 1");
	if ($query->num_rows > 0) {
		while ($rows = $query->fetch_array()) {
	$_SESSION['willupdate'] = "You chose the " . $rows['churchname'] . " of town of " . $rows['town'] . " !";
	$_SESSION['youarein'] = "You are in " . $rows['churchname'] . " of town of " . $rows['town'] . " features!";
	header('location: ../index.php');
		}
	}
}else{
	$_SESSION['willupdate'] = "Please choose correct town and church!";
	header('location: ../index.php');
}
?>