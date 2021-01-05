<?php
	$server = "mydb.pampangachurches.com";
	$username = "pampangachad";
	$password = "Idratherg0!";
	$db = "pampangachdb";

$con = 	new mysqli($server,$username,$password,$db);

date_default_timezone_set("Asia/Singapore");
$dateuntil = date('m/d/Y g:i:s A');
// DELETE Expired WEDDING
$untilwedding = $con->query("SELECT * FROM wedding WHERE until = '$dateuntil' AND approve = 'no'");
if ($untilwedding->num_rows > 0) {
	$deletewedding = $con->query("DELETE FROM wedding WHERE until = '$dateuntil' AND approve = 'no'");
	$deletebook = $con->query("DELETE FROM reservation WHERE until = '$dateuntil'");
}
// DELETE Expired Wake
$untilwake = $con->query("SELECT * FROM wake WHERE until = '$dateuntil' AND approve = 'no'");
if ($untilwake->num_rows > 0) {
	$deletewake = $con->query("DELETE FROM wake WHERE until = '$dateuntil' AND approve = 'no'");
	$deletebook = $con->query("DELETE FROM reservation WHERE until = '$dateuntil'");
}
// DELETE Expired Christening
$untilchristening = $con->query("SELECT * FROM christening WHERE until = '$dateuntil' AND approve = 'no'");
if ($untilchristening->num_rows > 0) {
	$deletechristening = $con->query("DELETE FROM christening WHERE until = '$dateuntil' AND approve = 'no'");
	$deletebook = $con->query("DELETE FROM reservation WHERE until = '$dateuntil'");
}
?>