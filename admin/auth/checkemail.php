<?php
if(isset($_POST["email2check"]) && $_POST["email2check"] != ""){
    include_once __DIR__ . '/../include/connect_to_db.php';
    $email = $_POST["email2check"];
    $sql_uname_check = $con->query("SELECT email FROM account WHERE email = '$email' LIMIT 1");
    $uname_check = $sql_uname_check->num_rows;
    if ($uname_check < 1){
        
    }else{
        echo 'Email already taken!';
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Invalid email format!';
    }else{
        echo 'ok';
    }
}