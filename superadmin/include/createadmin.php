<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['church'])) {
$coordinate = $_POST['church'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$coordinate	= $con->real_escape_string($coordinate);
$username = $con->real_escape_string($username);
$password = $con->real_escape_string($password);
$email = $con->real_escape_string($email);

$townchurch = $con->query("SELECT * FROM church WHERE coordinate = '$coordinate' LIMIT 1");
if ($townchurch->num_rows > 0) {
	while ($rowtownchurch = $townchurch->fetch_array()) {
		$town = $rowtownchurch['town'];
		$church = $rowtownchurch['churchname'];
		$insert = $con->query("INSERT INTO account (username,password,email,town,churchname,coordinate,type) VALUES ('$username', '$password', '$email','$town','$church', '$coordinate', 'admin')");
		$insertrestrict = $con->query("INSERT INTO `restrict` (username) VALUES ('$username')");
		$_SESSION['create_admin'] = 'success';
		header('location: ../index.php');
	}
}
}
?>