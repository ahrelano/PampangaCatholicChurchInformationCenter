<?php
if(isset($_POST["password"]) && $_POST["password"] != "" && isset($_POST["retypepassword"]) && $_POST["retypepassword"] != ""){
    include_once __DIR__ . '/../include/connect_to_db.php';
    $password = $_POST['password'];
    $retypepassword = $_POST['retypepassword'];
    if ($password <> $retypepassword) {
        echo "Password not match!";
    }else{
        echo 'ok';
        exit();
    }
}
?>

