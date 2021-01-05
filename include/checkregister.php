<?php
session_start();
include('connect_to_db.php');
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$username = $con->real_escape_string($username);
$password = $con->real_escape_string($password);
$email = $con->real_escape_string($email);

$insert = $con->query("INSERT INTO account (username,password,email) VALUES ('$username', '$password', '$email')");
$result = $con->query("SELECT * FROM account WHERE username = '$username' AND password = '$password'");
if($result->num_rows > 0){
	while($rows = $result->fetch_array()){
		$_SESSION['islogin'] = 1;
		$_SESSION['id'] = $rows['id'];
		$_SESSION['success_reg'] = 'Success!';
		if (isset($_GET['v'])) {
		header("location: ../church.php?v=" . $_GET['v']);
		}else{
		header("location: ../index.php");
		}
	}
}
}
?>