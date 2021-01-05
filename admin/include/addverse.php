<?php
session_start();
include("connect_to_db.php");
if (isset($_POST['dayverse']) && isset($_POST['monthverse']) && isset($_POST['versecoordinate'])) {
	 $dayverse = $_POST['dayverse']; 
	 $monthverse = $_POST['monthverse'];
	 $coordinate = $_POST['versecoordinate'];
	 $titleverse = $_POST['titleverse'];
	 $bodyverse = $_POST['bodyverse'];
	 $year = date('Y');
	 $currentmonth = date('F');
	 if (($currentmonth === 'December') && ($monthverse === 'January')) {
        $year = date('Y') + 1;
    }
    $full = $monthverse . " " . $dayverse . ", " . $year;

    $insertverse = $con->query("INSERT INTO dailyverse (verse, `text`, `date`, coordinate) VALUES ('$titleverse','$bodyverse','$full', '$coordinate')");
    $_SESSION['update'] = 'yes';
    header('location: ../index.php');
	}
?>