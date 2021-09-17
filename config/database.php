<?php
class DatabaseConnection{
    function __construct(){
        require_once('config.php');
        $conntection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
        mysql_select_db(DB_DATABASE, $conntection);
        echo "Connected Successfully!!";

        if(!$connection){
            die("Can't connect to the database!!");
        }

        return $connection;
    }

    public function close(){
        mysql_close();
    }
}

?>
