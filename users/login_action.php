<?php
require_once('../config/config.php');
require_once '../config/database.php';

session_start();
$db = new Database();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
    $login = $db->login_user($email, $password);
    if ($login) {
        header('location:'.'../'.'index.php');
    } else {
        echo 'Wrong email or password';
    }
}
else{
    echo "Something wrong with the server!!";
}

    
