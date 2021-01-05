<?php
session_start();
include_once __DIR__ . '/../include/connect_to_db.php';
if (isset($_POST['weddingUsername']) && isset($_GET['v']) && isset($_GET['town'])) {
	$coordinate = $_GET['v'];
	$churchtown = $_GET['town'];
	$email = $_POST['weddingEmail'];
	$church = $_POST['weddingChurch'];
	$username = $_POST['weddingUsername'];
	$gfirst = $_POST['wedding-gfirst'];
	$gsur = $_POST['wedding-gsur'];
	$gage = $_POST['wedding-gage'];
	$goccupation = $_POST['wedding-goccupation'];
	$gffirst = $_POST['wedding-gffirst'];
	$gfsur = $_POST['wedding-gfsur'];
	$gfoccupation = $_POST['wedding-gfoccupation'];
	$bfirst = $_POST['wedding-bfirst'];
	$bsur = $_POST['wedding-bsur'];
	$bage = $_POST['wedding-bage'];
	$boccupation = $_POST['wedding-boccupation'];
	$bffirst = $_POST['wedding-bffirst'];
	$bfsur = $_POST['wedding-bfsur'];
	$bfoccupation = $_POST['wedding-bfoccupation'];
	$date = $_POST['demoWedding'];
	$type = $_POST['typeWedding'];
	$contact = $_POST['weddingContact'];
	$now = date('M d, Y g:i:s A');

	$dayuntil = date('d') + 15;
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

	$querywedding = $con->query("INSERT INTO wedding (groomfirstname, groomsurname, groomage, church, goccupation, gffirstname, gfsurname, gfoccupation, bridefirstname, bridesurname, brideage, bffirstname, bfsurname, bfoccupation, `date`, submitdate, username, town, until, contact,email) VALUES ('$gfirst','$gsur','$gage','$church','$goccupation','$gffirst','$gfsur','$gfoccupation','$bfirst','$bsur','$bage','$bffirst','$bfsur','$bfoccupation','$date','$now','$username','$churchtown','$until', $contact, '$email')");
	$queryreservation = $con->query("INSERT INTO reservation (type, `date`, until) VALUES ('$type','$date', '$until')");
	$_SESSION['reservation-sent'] = 'Yes';
	header('location: ../church.php?v=' . $coordinate);
}

?>