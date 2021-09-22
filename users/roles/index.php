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
    <h2>Create Role</h2>
    <div>
        <div class="mb-3 row">
            <label for="role-name" class="col-sm-12 col-form-label">Add Role</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="role-name" placeholder="Enter Role Name">
            </div>
            <div class="col-sm-4">
                <button type="button" class="btn btn-primary" id="role-add">Add</button>
            </div>
        </div>
    </div>
</div>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/todo-list-jt/config/database.php';
    $db = new Database();
    $roles = $db->get_roles();
?>
<div class="container">
    <div class="list-group" id="role-items">
        <?php
        foreach($roles as $role):
            ?>
            <div class="d-flex list-group-item list-group-item-action mb-2 border-top role-item" id="<?php echo $role['id']; ?>"> 
                <div class="w-100">
                    <div class="w-75"><?php echo $role['name'] ?></div>
                </div>
                
                <div class="d-flex float-right">
                    <div>
                        <a href="#" id="<?php echo $role['id'] ?>" class="role-delete me-4">
                            <span class="text-danger">
                                <i class="far fa-trash-alt"></i>
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

    function role_list_template(role){
        var template =  '<div class="d-flex list-group-item list-group-item-action mb-2 border-top role-item" id="'+role.id+'">'+
                    '<div class="w-100">'+
                    '    <div class="w-75">'+role.name+'</div>'+
                    '</div>'+
                    '<div class="d-flex float-right">'+
                    '    <div>'+
                    '        <a href="#" id="'+role.id+'" class="role-delete me-4">'+
                    '            <span class="text-danger">'+
                    '                <i class="far fa-trash-alt"></i>'+
                    '            </span>'+
                    '        </a>'+
                    '    </div>'+
                    '</div></div>';
        return template;

    }
    $(function(){
        $('.role-delete').click(function(){
            var del_id= $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "delete.php",
                data: {role_id: del_id},
                success: function(response){
                    if (response !== 0){
                        console.log("Deleted Successfully!!");
                        var role_items = JSON.parse(response);
                        var roles = '';
                        role_items.forEach(role => {
                            var template = role_list_template(role);
                            roles += template;
                        });

                        $('#role-items').empty();
                        $('#role-items').append(roles);
                    }
                    else{
                        console.log("Can't delete the role");
                    }
                },
                error: function(response){
                    console.log("Something wrong with delete function");
                }
            });
        })
    })

    function create_role(name) {
        // var role_items = [];
        $.ajax({
            type: "POST",
            url: 'create.php',
            data: {role_name: name},
            success: function(response){
                if (response !== 0){
                    console.log("Deleted Successfully!!");
                    var role_items = JSON.parse(response);
                    var roles = '';
                    role_items.forEach(role => {
                        var template = role_list_template(role);
                        roles += template;
                    });

                    $('#role-items').empty();
                    $('#role-items').append(roles);
                }
                else{
                    console.log("Can't delete the role");
                }
            }
        })
    }

    $(document).ready(function() {
        $('#role-name').keyup(function(event){
            if(event.which === 13){ // if enter key is pressed then entry should be done
                create_role($('#role-name').val());
                $('#role-name').val('');
            }
        })
    });

    $(function(){
        $('#role-add').click(function(){
            create_role($('#role-name').val());
            $('#role-name').val('');
        })
    })
</script>
</html>

