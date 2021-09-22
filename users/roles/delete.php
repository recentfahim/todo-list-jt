<?php
    session_start();
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/todo-list-jt/config/database.php';
    $db = new Database();

    if(isset($_POST['role_id'])){
        $id= $_POST['role_id'];
        $data_delete = $db->delete_role($id);
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
