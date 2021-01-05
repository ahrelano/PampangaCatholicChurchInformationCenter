<?php
if(isset($_POST["bage"]) && isset($_POST["gage"])){
    include_once __DIR__ . '/../include/connect_to_db.php';
    $bage = $_POST['bage'];
    $gage = $_POST['gage'];
    $wake = $_POST['wake'];
    $contact = $_POST['contact'];
    $now = date('m/d/Y');
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
    $query = $con->query("SELECT * FROM reservation WHERE `date` = '$wake'");
    if (is_numeric($contact) == false){
        echo 'Contact must be a number!';
         exit(); 
    }else if (is_numeric($gage) == false){
        echo 'Groom Age must be a number!';
         exit(); 
    }else if(is_numeric($bage) == false){
        echo "Bride age must be a number!";
        exit();
    }else if($wake == ""){
        echo "Please choose date.";
        exit();
    }else if($wake <= $now){
        echo "Please choose future date.";
    }else if($wake < $until){
        echo "Please choose day that 15 days after from this day.";
    }else if($query->num_rows == 2){
        echo "This date is already booked.";
        exit();
    }else{
        echo "ok";
        exit();
    }
}   