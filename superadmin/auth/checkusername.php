<?php
if(isset($_POST["name2check"]) && $_POST["name2check"] != "" && isset($_POST["town"]) && $_POST["town"] != ""){
    include_once __DIR__ . '/../include/connect_to_db.php';
    $location = $_POST['town'];
    $username = preg_replace('#[^a-z0-9]#i', '', $_POST['name2check']);
    $sql_uname_check = $con->query("SELECT username FROM account WHERE username = '$username' LIMIT 1");
    $uname_check = $sql_uname_check->num_rows;
    if ($location === "Town") {
        echo 'Please choose town!';
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
?>

