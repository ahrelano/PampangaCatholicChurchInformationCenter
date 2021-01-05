<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['ratings']) AND isset($_SESSION['coordinate']) AND isset($_SESSION['username'])) {
	$ratings = $_POST['ratings'];
	$username = $_SESSION['username'];
	$coordinate = $_SESSION['coordinate'];
$queryratings = $con->query("SELECT ratings FROM church WHERE coordinate = '$coordinate'");
if ($queryratings->num_rows > 0) {
	while ($rowratings = $queryratings->fetch_array()) {
		$saveratings = $rowratings['ratings'];
	}
}
$check_user_rate_already = $con->query("SELECT * FROM checkrate WHERE coordinate = '$coordinate' and username = '$username'");
if ($check_user_rate_already > 0) {
	$_SESSION['ratings-save'] = "NO";
}else{
	$insertuser = $con->query("INSERT INTO checkrate (username,coordinate,rate) VALUES ('$username','$coordinate','$ratings')");
	$ratings = $ratings + $saveratings;
	$updateratings = $con->query("UPDATE church SET ratings = '$ratings' WHERE coordinate = '$coordinate'");
	$_SESSION['ratings-save'] = "YES";
}
}
header('location: ../church.php?v=' . $coordinate);
?>
