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
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['email'] = $user_data['email'];
            $_SESSION['name'] = $user_data['name'];
            return true;
        }
        else{
            return false;
        }
    }

    public function register_user($name, $email, $password){
        $query="SELECT * FROM users WHERE email='".$email."'";
        $email_check = $this->db->query($query) ;
        $rows = $email_check->num_rows;
        if ($rows == 0){
            $password = md5($password);
            $query = "INSERT INTO users (name, email, password) values ('".$name."','".$email."', '".$password."')";
            $result = mysqli_query($this->db, $query) or die(mysqli_connect_errno()."Data cannot inserted");
            return $result;
        }
        else{
            return false;
        }
    }

    public function create_todo($title, $description=null, $user_id){
        $query = "INSERT INTO todos (title, description, user_id) VALUES ('".$title."', '".$description."', '".$user_id."')";
        $result = mysqli_query($this->db, $query) or die(mysqli_connect_errno()."Data cannot inserted");
        $todos = $this->get_todos($user_id);
        return $user_id;

    }

    public function get_todos($user_id){
        $query = "SELECT * FROM todos WHERE user_id='".$user_id."'";
        $result = mysqli_query($this->db, $query);
        // $todos = mysqli_fetch_array($result);

        $rows = array();
        while($row = mysqli_fetch_array($result)){
            $temp = array();
            $temp['id'] = $row['id'];
            $temp['title'] = $row['title'];
            $temp['description'] = $row['description'];
            $temp['is_done'] = $row['is_done'];
            $rows[] = $temp;
        }

        return $rows;
    }

    public function delete_todo($todo_id, $user_id){
        $query = "DELETE from todos WHERE id='".$todo_id."' and user_id='".$user_id."'";
        $result = mysqli_query($this->db, $query);
        if($result){
            return true;
        }else{
            return false;
        }
    }
    /*
        Check todo status and update to the reverse
        If the todo was is_done false then make it is_done true
        this will also apply for reverse
    */

    public function update_todo_status($todo_id, $user_id){
        $query="SELECT * FROM todos WHERE id='".$todo_id."' and user_id='".$user_id."'";
        $todo_check = $this->db->query($query) ;
        $rows = $todo_check->num_rows;
        $todo_data = mysqli_fetch_array($todo_check);

        if ($rows == 1){
            $query="UPDATE todos SET is_done=1 WHERE id='".$todo_id."' and user_id='".$user_id."'";
            $update = mysqli_query($this->db, $query) or die(mysqli_connect_errno()."Data can't be udpated");
            
            $todos = $this->get_todos($user_id);

            return json_encode($todos);
        }
        else{
            return false;
        }
    }
}

?>
