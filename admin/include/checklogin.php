<?php
session_start();
include('connect_to_db.php');
$username = $_POST['username'];
$password = $_POST['password'];
$username = $con->real_escape_string($username);
$password = $con->real_escape_string($password);
$result = $con->query("SELECT * FROM account WHERE (username = '$username' AND password = '$password' AND type = 'client')");
$resultadmin = $con->query("SELECT * FROM account WHERE (username = '$username' AND password = '$password' AND type = 'admin')");
if($result->num_rows > 0){
	while($rows = $result->fetch_array()){
		$_SESSION['islogin'] = 1;
		$_SESSION['id'] = $rows['id'];
		if (isset($_GET['v'])) {
		header("location: ../church.php?v=" . $_GET['v']);
		}else{
		header("location: ../index.php");
		}
	}
}else if($resultadmin->num_rows > 0){
	while($rows = $resultadmin->fetch_array()){
		$_SESSION['islogin'] = 2;
		$_SESSION['id'] = $rows['id'];
		header("location: ../admin/home.php");
	}
}else{
	$_SESSION['invalid'] = 'Invalid input account!';
	header("location: ../index.php");
}
?>