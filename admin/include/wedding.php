<?php
session_start();
include('connect_to_db.php');
$groomname = $_POST['wedding-groom'];
$bridename = $_POST['wedding-bride'];
$priestname = $_POST['wedding-priest'];
$marriagemonth = $_POST['marriage-month'];
$marriageday = $_POST['marriage-day'];
$marriageyear = $_POST['marriage-year'];
$marriagehour = $_POST['marriage-hour'];
$marriageminute = $_POST['marriage-minute'];
$marriagemeridiem = $_POST['marriage-meridiem'];
$groomname = $con->real_escape_string($groomname);
$bridename = $con->real_escape_string($bridename);
$priestname = $con->real_escape_string($priestname);
$marriagemonth = $con->real_escape_string($marriagemonth);
$marriageday = $con->real_escape_string($marriageday);
$marriageyear = $con->real_escape_string($marriageyear);
$marriagehour = $con->real_escape_string($marriagehour);
$marriageminute = $con->real_escape_string($marriageminute);
$marriagemeridiem = $con->real_escape_string($marriagemeridiem);
if(isset($_SESSION['id'])){
$coordinate = $_SESSION['id'];
if($marriagemonth == 'Month' || $marriageday == 'Day' || $marriageyear == 'Year'){
	$_SESSION['dateerror'] = "Invalid wedding date!";
	header('location: ../home.php?v=' . $coordinate);
}else if($marriagemonth == 'February' AND ($marriageday == '30' OR $marriageday == '31')){
	$_SESSION['dateerror'] = "Invalid wedding date!";
	header('location: ../home.php?v=' . $coordinate);
}else{
$marriagedate = $marriagemonth . " " . $marriageday . ", " . $marriageyear;
$time = $marriagehour . ":" . $marriageminute . " " . $marriagemeridiem;
if(isset($_SESSION['username']) && isset($_SESSION['churchname'])){
	if(date('m') == '01'){
$month = 'January';
}else if(date('m') == '02'){
$month = 'February';
}else if(date('m') == '03'){
$month = 'March';
}else if(date('m') == '04'){
$month = 'April';
}else if(date('m') == '05'){
$month = 'May';
}else if(date('m') == '06'){
$month = 'June';
}else if(date('m') == '07'){
$month = 'July';
}else if(date('m') == '08'){
$month = 'August';
}else if(date('m') == '09'){
$month = 'September';
}else if(date('m') == '010'){
$month = 'October';
}else if(date('m') == '11'){
$month = 'November';
}else if(date('m') == '12'){
$month = 'December';
}
$now = $month . " " . date('d, Y H:i');
$username = $_SESSION['username'];
$church = $_SESSION['churchname'];
$insert = $con->query("INSERT INTO wedding (username, groomname, bridename, marriagedate, `time`, priestname,church,submitdate) VALUES ('$username','$groomname','$bridename','$marriagedate','$time','$priestname','$church','$now')");
echo $insert;
$_SESSION['dateerror'] = "Reservation Sent!";
header('location: ../home.php?v=' . $coordinate);
}
}
}
?>