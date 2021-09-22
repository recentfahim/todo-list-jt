<?php
    session_start();
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/todo-list-jt/config/database.php';
    $db = new Database();
    $user_id = $_SESSION['user_id'];

    if(isset($_POST['todo_id'])){
        $id= $_POST['todo_id'];
        $data_delete = $db->delete_todo($id, $user_id);
        if(!$data_delete){
            echo 0;
            exit;
        }

        echo $data_delete;
        exit;
    }
    else{
        echo 0;
        exit;
    }
?>
