<!DOCTYPE html>
<html>
    <head>
        <title>Todo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
                            <div><?php $_SESSION['name'] ?></div>
                    <?php
                        }
                        else{
                    ?>
                    
                    <a href="../users/login.php" class="btn">Login</a>
                    <a href="../users/register.php" class="btn">Register</a>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </nav>

        <h2>Login Form</h2>

<form action="login_action.php" method="post">

  <div class="container">
    <label for="email"><b>Email</b></label>
    <input type="email" class="form-control" placeholder="Enter Email" name="email" required>

    <label for="password"><b>Password</b></label>
    <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
        
    <button type="submit" class="btn btn-primary mt-2">Login</button>
  </div>

  <br>
  <div class="container">
    <a href="register.php">Create Account</a>
  </div>
</form>

