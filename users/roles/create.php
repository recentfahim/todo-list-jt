<?php
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/todo-list-jt/config/database.php';
    $db = new Database();

    if(isset($_POST['role_name'])){
        $name = $_POST['role_name'];
        $role = $db->create_roles($name);
        if(!$role){
            echo 0;
            exit;
        }

        echo $role;
        exit;
    }
    else{
        echo 0;
        exit;
    }
?>
