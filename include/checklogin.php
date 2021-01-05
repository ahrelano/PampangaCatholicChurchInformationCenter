<?php
session_start();
include('connect_to_db.php');
$username = $_POST['username'];
$password = $_POST['password'];
$username = $con->real_escape_string($username);
$password = $con->real_escape_string($password);
$result = $con->query("SELECT * FROM account WHERE (username = '$username' AND password = '$password' AND type = 'client')");
$resultadmin = $con->query("SELECT * FROM account WHERE (username = '$username' AND password = '$password' AND type = 'admin' AND active='0')");
$resultsuper = $con->query("SELECT * FROM account WHERE (username = '$username' AND password = '$password' AND type = 'superadmin' AND active='0')");
$adminactive = $con->query("SELECT * FROM account WHERE (username = '$username' AND password = '$password' AND type = 'admin' AND active='1')");
$superactive = $con->query("SELECT * FROM account WHERE (username = '$username' AND password = '$password' AND type = 'superadmin' AND active='1')");
$adminbanned = $con->query("SELECT * FROM account WHERE (username = '$username' AND password = '$password' AND type = 'admin' AND active='2')");
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
	exit();
}
if($resultadmin->num_rows > 0){
	while($rows = $resultadmin->fetch_array()){
		$_SESSION['islogin'] = 2;
		$_SESSION['id'] = $rows['id'];
		$active = $con->query("UPDATE account SET active='1' WHERE username = '$username'");
		header("location: ../admin/index.php");
	}
	exit();
}else if($adminactive->num_rows > 0){
	$_SESSION['active'] = 'is login';
	if (isset($_GET['v'])) {
		header("location: ../church.php?v=" . $_GET['v']);
		exit();
		}else{
		header("location: ../index.php");
		exit();
		}
}else if($adminbanned->num_rows > 0){
	$_SESSION['banned'] = 'is banned';
	if (isset($_GET['v'])) {
		header("location: ../church.php?v=" . $_GET['v']);
		exit();
		}else{
		header("location: ../index.php");
		exit();
		}
}
	if($resultsuper->num_rows > 0){
	while($rows = $resultsuper->fetch_array()){
		$_SESSION['islogin'] = 3;
		$_SESSION['id'] = $rows['id'];
		$active = $con->query("UPDATE account SET active='1' WHERE username = '$username'");
		header("location: ../superadmin/index.php");
	}
	exit();
	}else if($superactive->num_rows > 0){
	$_SESSION['active'] = 'is login';
	if (isset($_GET['v'])) {
		header("location: ../church.php?v=" . $_GET['v']);
		exit();
		}else{
		header("location: ../index.php");
		exit();
		}
	}

	if (isset($_GET['v'])) {
		$_SESSION['invalid'] = 'Invalid input account!';
		header("location: ../church.php?v=" . $_GET['v']);
		exit();
		}else{
		$_SESSION['invalid'] = 'Invalid input account!';
		header("location: ../index.php");
		exit();
		}
?>