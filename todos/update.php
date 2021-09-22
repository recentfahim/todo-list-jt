<?php
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/todo-list-jt/config/database.php';
    $db = new Database();
    $user_id = $_SESSION['user_id'];

    if(isset($_POST['todo_id'])){
        
        $data = $db->update_todo_status($_POST['todo_id'], $user_id);   
 
        if(!$data){
            echo false;
            exit;
        }

        echo $data;
        exit;
    }
    else{
        echo false;
        exit;
    }
?>