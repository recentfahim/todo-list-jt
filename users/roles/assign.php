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

<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/todo-list-jt/config/database.php';
    $db = new Database();
    $roles = $db->get_roles();
    $users = $db->get_users();
?>

<div class="container">
    <h2>Assign Role</h2>
    <div>
        <div class="mb-3 row">
            <label for="user-id" class="col-sm-12 col-form-label">User</label>
            <div class="col-sm-12">
                <select class="form-select" id="user-id" required>
                    <option selected disabled>----- Select User -----</option>
                    <?php
                        foreach($users as $user):
                    ?>
                        <option value="<?php echo $user['id'] ?>"><?php echo $user['email'] ?></option>
                    <?php
                        endforeach
                    ?>
                </select>
            </div>
            <label for="role-id" class="col-sm-12 col-form-label">Role</label>
            <div class="col-sm-12">
                <select class="form-select" id="role-id" required>
                    <option selected disabled>----- Select Role -----</option>
                    <?php
                        foreach($roles as $role):
                    ?>
                        <option value="<?php echo $role['id'] ?>"><?php echo $role['name'] ?></option>
                    <?php
                        endforeach
                    ?>
                </select>
            </div>
            <div class="col-sm-12 mt-3">
                <button type="button" class="btn btn-primary" id="role-assign">Assign</button>
            </div>
        </div>
    </div>
</div>

</body>
<script type="application/javascript">
    function assign_role(user_id, role_id) {
        // var role_items = [];
        $.ajax({
            type: "POST",
            url: 'assign_action.php',
            data: {user_id: user_id, role_id: role_id},
            success: function(response){
                if(response !== 0){
                    console.log("Role assigned successfully!!");
                }
                else{
                    console.log("Data can't be inserted!!");
                }
            }
        })
    }

    $(function(){
        $('#role-assign').click(function(){
            assign_role($('#user-id').val(), $('#role-id').val());
            location.reload();
        })
    })
</script>
</html>

