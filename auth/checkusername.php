<?php
if(isset($_POST["name2check"]) && $_POST["name2check"] != ""){
    include_once __DIR__ . '/../include/connect_to_db.php';
    $username = preg_replace('#[^a-z0-9]#i', '', $_POST['name2check']);
    $sql_uname_check = $con->query("SELECT username FROM account WHERE username = '$username' LIMIT 1");
    $uname_check = $sql_uname_check->num_rows;
    if (strlen($username) < 8 ){
        echo '8 - 16 characters please!';
    exit();
    }
    if (is_numeric($username[0])){
        echo 'First character must be a letter!';
        exit();
    }
    if ($uname_check < 1){
        echo 'ok';
        exit();
    }else{
        echo '<strong>' . $username . '</strong>  is taken!';
        exit();
    }
}