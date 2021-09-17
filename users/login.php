<?php
require_once '../config/database_connection.php';
session_start();

class User{
    function __construct()
    {
        $db = new DatabaseConnection();
    }

    public function login($email, $password){
        $query = mysql_query("SELECT * FROM users WHERE email='".$email."' AND password='".md5($password)."'");
        $user = mysql_fetch_array($query);
        
        $no_of_rows = mysql_no_rows($user);

        if($no_of_rows == 1){
            $_SESSION['login'] = true;
            $_SESSION['uid'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            return true;
        }
        else{
            return false;
        }
    }

    public function logout(){
        session_unset();
    }

}
?>