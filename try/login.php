<?php
//This script will handle login

require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username and password";
        echo $err;
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


    if(empty($err))
    {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;

        // Try to execute this statement
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)
            {
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password,$role);
                if(mysqli_stmt_fetch($stmt))
                {
                    if(password_verify($password, $hashed_password))
                    {
                        // this means the password is correct. Allow user to login
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;



                        if($role=="owner"){
                            header("location: mainpage_owner.php");
                        }else{   //Redirect user to welcome page
                            header("location:mainpage_tenant.php");}
                    }
                }

            }

        }
    }


}


?>

<!doctype html>
<html lang="en">
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login Form</title>
</head>
<style>
    input[type="username"]{
        border-bottom-left-radius: 0px;;
        border-bottom-right-radius:0px;;
    }
    input[type="password"] {
        border-bottom-left-radius: 0px;;
        border-bottom-right-radius: 0px;;
        border-top: 0px;
    }
</style>


</head>
<body>




<div class="container mt-4">
    <div class="text-center mt-5">
        <img class="mt-5 mb-4" src="1.png" height="72" alt="logo">
        <h1 class="h3 mb-3 font-weight-normal">Please log in</h1>

        <hr>

        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" placeholder="Enter Username">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter Password">



            <button class="btn btn-lg btn-primary btn-block" type="submit" >Login </button>
            <div class="checkbox mt-3">
                <small> New here?<a href="register.php"> Sign up </a> </small>
            </div>
            <br>
            <label>

                <input type="checkbox" value="remember me">Remember me
            </label>

        </form>

    </div>
</body>
</html>