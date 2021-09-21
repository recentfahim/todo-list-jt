<?php
    require_once('config/database.php');
    $db = new Database();
    $user_id = $_SESSION['user_id'];

    if(isset($_GET['todo_id'])){
        $id= $_GET['todo_id'];
        $data_delete = $db->delete_todo($id, $user_id);
    }
?>
