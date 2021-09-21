<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/todo-list-jt/config/database.php';
    $db = new Database();
    $user_id = $_SESSION['user_id'];

    if(isset($_POST['todo_title'])){
        $title = $_POST['todo_title'];
        $data_create = $db->create_todo($title, '',  $user_id);
        if(!$data_create){
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
