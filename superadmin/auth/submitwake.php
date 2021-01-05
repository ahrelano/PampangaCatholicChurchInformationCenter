<?php
session_start();
include_once __DIR__ . '/../include/connect_to_db.php';
if (isset($_POST['wakeUsername']) && isset($_GET['v']) && isset($_GET['town'])) {
	$coordinate = $_GET['v'];
	$churchtown = $_GET['town'];

	$email = $_POST['wakeEmail'];
	$name = $_POST['wakeName'];
	$age = $_POST['wakeAge'];
	$date = $_POST['demoWake'];
	$type = $_POST['typeWake'];
	$church = $_POST['wakeChurch'];
	$username = $_POST['wakeUsername'];
	$contact = $_POST['wakeContact'];
	$now = date('M d, Y g:i:s A');
	
	$dayuntil = date('d') + 3;
	$monthuntil = date('m');
	$yearuntil = date('Y');
	if($monthuntil == 2 AND $dayuntil > 29){
		$dayuntil = $dayuntil - 29;
		$monthuntil = $monthuntil + 1;
	}else if($dayuntil > 30){
		$dayuntil = $dayuntil - 30;
		$monthuntil = $monthuntil + 1;
	}
	if ($monthuntil > 12) {
		$monthuntil = $monthuntil - 12;
		$yearuntil = $yearuntil + 1;
	}

	if ($dayuntil < 10) {
		$dayuntil = '0' . $dayuntil;
	}
	$until = $monthuntil . "/" . $dayuntil . "/" . $yearuntil . " " . date('g:i:s A');


	$querywake = $con->query("INSERT INTO wake (name, age, username, church, submitdate, `date`, town, until, contact, email) VALUES ('$name','$age','$username','$church','$now','$date','$churchtown','$until', '$contact', '$email')");
	$queryreservation = $con->query("INSERT INTO reservation (type, `date`, until) VALUES ('$type','$date', '$until')");
	$_SESSION['reservation-sent'] = "Yes";
	header('location: ../church.php?v=' . $coordinate);
}
?>