<?php
require_once('../config/config.php');
require_once '../config/database.php';

session_start();
$db = new Database();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
    if($password == $confirm_password){
        $login = $db->register_user($name, $email, $password);
        if ($login) {
            header('location:'.'login.php');
        } else {
            echo 'This email is already associate with a account!!';
        }
    }
    else{
        echo "Password and Confirm password is not same!!";
    }
}
else{
    echo "Something wrong with the server!!";
}

    
