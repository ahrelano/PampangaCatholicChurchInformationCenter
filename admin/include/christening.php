<?php
session_start();
include('connect_to_db.php');
$childname = $_POST['christening-child'];
$godfather = $_POST['christening-godfather'];
$godmother = $_POST['christening-godmother'];
$father = $_POST['christening-father'];
$mother = $_POST['christening-mother'];
$childmonth = $_POST['child-month'];
$childday = $_POST['child-day'];
$childyear = $_POST['child-year'];
$childname = $con->real_escape_string($childname);
$godfather = $con->real_escape_string($godfather);
$godmother = $con->real_escape_string($godmother);
$father = $con->real_escape_string($father);
$mother = $con->real_escape_string($mother);
$childmonth = $con->real_escape_string($childmonth);
$childday = $con->real_escape_string($childday);
$childyear = $con->real_escape_string($childyear);
if(isset($_SESSION['id'])){
$coordinate = $_SESSION['id'];
if($childmonth == 'Month' || $childday == 'Day' || $childyear == 'Year'){
	$_SESSION['dateerror'] = "Invalid child date of birth!";
	header('location: ../home.php?v=' . $coordinate);
}else if($childmonth == 'February' AND ($childday == '30' OR $childday == '31')){
	$_SESSION['dateerror'] = "Invalid child date of birth!";
	header('location: ../home.php?v=' . $coordinate);
}else{
$childdate = $childmonth . " " . $childday . ", " . $childyear;
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
$insert = $con->query("INSERT INTO christening (username, nameofchild, godfather, godmother, father, mother, dateofbirth , church,submitdate) VALUES ('$username','$childname','$godfather','$godmother','$father','$mother','$childdate','$church','$now')");
echo $insert;
$_SESSION['dateerror'] = "Reservation Sent!";
header('location: ../home.php?v=' . $coordinate);
}
}
}
?>