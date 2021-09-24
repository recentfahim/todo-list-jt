<?php
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/todo-list-jt/config/database.php';
    $db = new Database();

    if(isset($_POST['user_id']) and isset($_POST['role_id'])){
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];
        $user_role = $db->assign_role($user_id, $role_id);

        if(!$user_role){
            echo 0;
            exit;
        }

        echo 1;
        exit;
    }
    else{
        echo 0;
        exit;
    }
?>
