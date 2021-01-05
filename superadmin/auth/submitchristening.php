<?php
session_start();
include_once __DIR__ . '/../include/connect_to_db.php';
if (isset($_POST['christeningUsername']) && isset($_GET['v']) && isset($_GET['town'])) {
	$coordinate = $_GET['v'];
	$churchtown = $_GET['town'];
	$email = $_POST['christeningEmail'];
	$contact = $_POST['christeningContact'];
	$church = $_POST['christeningChurch'];
	$username = $_POST['christeningUsername'];
	$firstname = $_POST['christening-first'];
	$surname = $_POST['christening-sur'];
	$fname = $_POST['christening-fname'];
	$mname = $_POST['christening-mname'];
	$occupation = $_POST['christening-occupation'];
	$place = $_POST['christening-birth'];
	$month = $_POST['christening-month'];
	$day = $_POST['christening-day'];
	$year = $_POST['christening-year'];
	$date = $_POST['demoChristening'];
	$type = $_POST['typeChristening'];
	$now = date('M d, Y g:i:s A');
	$dateofbirth = $month . " " . $day . "," . $year;

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
	
	$querywake = $con->query("INSERT INTO christening (username, church, town, `date`, firstname, surname, fname, mname, foccupation, placeofbirth, submitdate, dateofbirth,until,contact,email) VALUES ('$username','$church','$churchtown','$date','$firstname','$surname','$fname','$mname','$occupation','$place','$now','$dateofbirth', '$until', '$contact', '$email')");
	$queryreservation = $con->query("INSERT INTO reservation (type, `date`, until) VALUES ('$type','$date', '$until')");
	$_SESSION['reservation-sent'] = "Yes";
	header('location: ../church.php?v=' . $coordinate);
}
?>