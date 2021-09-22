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
        .done-todo{
            text-decoration: line-through;
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
<div class="container">
    <div>
        <h4>Task List</h4>
    </div>
    <div>
        <div class="mb-3 row">
            <label for="todo-title" class="col-sm-12 col-form-label">Todo Add</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="todo-title" placeholder="Enter todo">
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-primary" id="todo-add">Add</button>
            </div>
        </div>
    </div>
</div>
<?php
    require_once('config/database.php');
    $db = new Database();
    $user_id = $_SESSION['user_id'];
    $todos = $db->get_todos($user_id);
?>
<div class="container">
    <div class="list-group" id="todo-items">
        <?php
        foreach($todos as $todo):
            ?>
            <div class="d-flex list-group-item list-group-item-action mb-2 border-top todo-item" id="<?php echo $todo['id']; ?>"> 
                <div class="form-check w-100">
                <input class="form-check-input" type="checkbox" id="flexCheckChecked<?php echo $todo['id']; ?>" <?php if($todo['is_done']){ echo 'checked';} else{echo '';} ?>>
                <label class="form-check-label w-100" for="flexCheckChecked<?php echo $todo['id']; ?>">
                    <div class="w-75 <?php if($todo['is_done']){ echo 'done-todo';} ?>"><?php echo $todo['title'] ?></div>
                </label>
                </div>
                
                <div class="d-flex float-right">
                    <div>
                        <a href="#" id="<?php echo $todo['id'] ?>" class="todo-delete me-4">
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
    function todo_list_template(todo){
        var checked = '';
        var is_done = '';
        if(todo.is_done){
            checked = 'checked';
            is_done = 'done-todo';
        }
        var template =  '<div class="d-flex list-group-item list-group-item-action mb-2 border-top todo-item" id="'+todo.id+'">'+
                    '<div class="form-check w-100">'+
                    '<input class="form-check-input" type="checkbox" id="flexCheckChecked'+todo.id+'"'+checked+'>'+
                    '<label class="form-check-label w-100" for="flexCheckChecked'+todo.id+'">'+
                    '    <div class="w-75 '+is_done+'">'+todo.title+'</div>'+
                    '</label>'+
                    '</div>'+
                    '<div class="d-flex float-right">'+
                    '    <div>'+
                    '        <a href="#" id="'+todo.id+'" class="todo-delete me-4">'+
                    '            <span class="text-danger">'+
                    '                <i class="far fa-trash-alt"></i>'+
                    '            </span>'+
                    '        </a>'+
                    '    </div>'+
                    '    <div>'+
                    '        <a href="#" id="'+todo.id+'" class="todo-edit">'+
                    '           <span class="text-info">'+
                    '                <i class="far fa-edit"></i>'+
                    '            </span>'+
                    '        </a>'+
                    '   </div>'+
                    '</div></div>';
        return template;

    }
    $(function(){
        $('.todo-item').click(function(){
            var todo_id = $(this).attr('id');
            var todo_items = [];
            $.ajax({
                type: "POST",
                url: 'todos/update.php',
                data: {todo_id: todo_id},
                success: function(response){  
                    todo_items = JSON.parse(response)
                    var todos = '';
                    todo_items.forEach(todo => {
                        var template = todo_list_template(todo);
                        todos += template;
                    });

                    $('#todo-items').empty();
                    $('#todo-items').append(todos);

                },
                error: function(response){
                    console.log("Something wrong with the server");
                }
            })
        })
    })
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

    function create_todo(title) {
        $.ajax({
            type: "POST",
            url: 'todos/create.php',
            data: {todo_title: title},
            success: function(response){
                if(response == 1){
                    console.log("Created Successfully!!");
                }
                else{
                    console.log("Can't add the todo");
                }
            }
        })
    }

    $(document).ready(function() {
        $('#todo-title').keyup(function(event){
            if(event.which === 13){
                create_todo($('#todo-title').val());
                $('#todo-title').val('');
            }
        })
    });

    $(function(){
        $('#todo-add').click(function(){
            create_todo($('#todo-title').val());
            $('#todo-title').val('');
        })
    })
</script>
</html>

