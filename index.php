<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .btn{
            margin-right: 10px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Todo</a>
        <div class="d-flex">
            <?php
            if($_SESSION['email']){
                ?>
                <div><?php echo $_SESSION['name'] ?></div>
                <?php
            }
            else{
                ?>

                <a href="users/login.php" class="btn">Login</a>
                <a href="users/register.php" class="btn">Register</a>
                <?php
            }
            ?>
        </div>
    </div>
</nav>
<h4>Task List</h4>
<?php
    require_once('config/database.php');
    $db = new Database();
    $user_id = $_SESSION['user_id'];
    $todos = $db->get_todos($user_id);
?>
<div class="containter">
    <div class="list-group">
        <?php
        foreach($todos as $todo):
            ?>
            <div class="d-flex" class="list-group-item">
                <div><?php echo $todo['title'] ?></div>
                <div class="d-flex">
                    <div>
                        <a href="#" id="<?php echo $todo['id'] ?>" class="todo-delete">
                            <span class="text-danger">
                                <i class="far fa-trash-alt"></i>
                            </span>
                        </a>
                    </div>
                    <div>
                        <a href="#" id="<?php echo $todo['id'] ?>" class="todo-edit">
                            <span class="text-info">
                                <i class="far fa-edit"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        <?php
        endforeach
        ?>
    </div>
</div>
</body>
<script type="application/javascript">
    $(function(){
        $('.todo-delete').click(function(){
            var del_id= $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "todos/delete.php",
                data: {todo_id: del_id},
                success: function(response){
                    console.log(response);
                    if (response == 1){
                        console.log("Deleted Successfully!!");
                    }
                    else{
                        console.log("Can't delete the todo");
                    }
                },
                error: function(response){
                    console.log("Something wrong with delete function");
                    console.log(response);
                }
            });
        })
    })
</script>
</html>

