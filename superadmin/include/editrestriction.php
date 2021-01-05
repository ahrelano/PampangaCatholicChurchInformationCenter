<?php
session_start();
include('connect_to_db.php');
if (isset($_GET['restrictid']) && isset($_GET['adminid'])) {
	$restrictid = $_GET['restrictid'];
	$adminid = $_GET['adminid'];
	$active = $_POST['username'];
	$history = $_POST['history'];
	$galleries = $_POST['galleries'];
	$mass = $_POST['mass'];
	$forum = $_POST['forum'];
	$contact = $_POST['contact'];
	$chat = $_POST['chat'];
	$header = $_POST['header'];
	$useradmin = $_POST['useradmin'];
	$passadmin = $_POST['passadmin'];
	$emailadmin = $_POST['emailadmin'];

	if ($active == "") {
		$active = '2';
	}else if($active == "1"){
		$active = '1';
	}else{
		$active = '0';
	}

	if ($history == "") {
		$history = 'no';
	}

	if ($galleries == "") {
		$galleries = 'no';
	}	

	if ($mass == "") {
		$mass = 'no';
	}

	if ($forum == "") {
		$forum = 'no';
	}

	if ($contact == "") {
		$contact = 'no';
	}

	if ($chat == "") {
		$chat = 'no';
	}

	if ($header == "") {
		$header = 'no';
	}

	$queryaccount = $con->query("UPDATE account SET active = '$active', username = '$useradmin', password = '$passadmin', email = '$emailadmin' WHERE id='$adminid'");
	$queryrestriction = $con->query("UPDATE `restrict` SET username = '$useradmin', history = '$history', galleries = '$galleries', mass = '$mass', forum = '$forum', contact = '$contact', chat='$chat', header = '$header' WHERE id='$restrictid'");
	$_SESSION['update'] = "success";
	header('location: ../index.php');
}
?>