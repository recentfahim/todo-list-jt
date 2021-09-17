<?php
class Database{
    public $db;
    function __construct(){
        require_once('config.php');
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


        if(mysqli_connect_errno()){
            echo "Can't connect to the database!!";
            exit();
        }
    }

    public function login_user($email, $password){
        $password = md5($password);
        $query="SELECT * FROM users WHERE email='".$email."' and password='".$password."'";
        $result = mysqli_query($this->db, $query);
        $user_data = mysqli_fetch_array($result);
        $rows = $result->num_rows;

        if ($rows == 1) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $user_data['id'];
            $_SESSION['email'] = $user_data['email'];
            $_SESSION['name'] = $user_data['name'];
            return true;
        }
        else{
            return false;
        }
    }

    public function register_user($name, $email, $password){

    }

    public function create_todo($title, $description, $user_id){

    }
}

?>
