<?php
if(isset($_POST["name"]) && $_POST["name"] != ""){
    include_once __DIR__ . '/../include/connect_to_db.php';
    $age = $_POST['age'];
    $date = $_POST['date'];
    $contact = $_POST['contact'];
    $now = date('m/d/Y');
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
    $until = $monthuntil . "/" . $dayuntil . "/" . $yearuntil;

    $query = $con->query("SELECT * FROM reservation WHERE `date` = '$date'");
    if (is_numeric($age) == false){
        echo 'Age must be a number!';
         exit();
    }else if (is_numeric($contact) == false){
        echo 'Contact must be a number!';
         exit();
    }else if($date == ""){
        echo "Please choose date.";
    }else if($date <= $now){
        echo "Please choose future date.";
    }else if($date < $until){
        echo "Please choose day that 3 days after from this day.";
    }else if($query->num_rows == 2){
        echo "This date is already booked.";
    }else{
        echo "ok";
    }

}else{
    echo "Please enter a name.";
}