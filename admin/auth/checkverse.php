<?php
if(isset($_POST["dayverse"]) && isset($_POST["monthverse"]) && isset($_POST["coordinate"])){
    include_once __DIR__ . '/../include/connect_to_db.php';
    $coordinate = $_POST["coordinate"];
    $dayverse = $_POST["dayverse"];
    $monthverse = $_POST["monthverse"];
    $year = date('Y');
    $currentmonth = date('F');
    if (($currentmonth === 'December') && ($monthverse === 'January')) {
        $year = date('Y') + 1;
    }
    $full = $monthverse . " " . $dayverse . ", " . $year;
    $datecheck = $con->query("SELECT * FROM dailyverse WHERE `date` = '$full' AND coordinate = '$coordinate'"); 
    $date_check = $datecheck->num_rows;
    if (($monthverse == "February" AND $dayverse == "31" ) || ($monthverse == "February" AND $dayverse == "30" )) {
        echo 'Invalid input date!';
        exit();
    }
    if ($date_check < 1){
        echo 'ok';
        exit();
    }else{
        echo 'You already input on this date!';
        exit();
    }
}