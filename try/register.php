<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                    echo $username_err;
                } else {
                    $username = trim($_POST['username']);
                }

            } else {
                echo "Something went wrong";
            }

        }
    }

    mysqli_stmt_close($stmt);


// Check for password
    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

// Check for confirm password field
    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $password_err = "Passwords should match";
    }

    $role = $_POST['role'];
    echo $role;

// If there were no errors, go ahead and insert into the database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_role);

            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_role= $role;
            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: sucess.php");
            } else {
                echo mysqli_error($conn);
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}

?>

<!doctype html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Sign up</title>
</head>
<body>
<style>
    input[type="email"]{
        border-bottom-left-radius: 0px;;
        border-bottom-right-radius:0px;;
    }
    input[type="password"] {
        border-bottom-left-radius: 0px;;
        border-bottom-right-radius: 0px;;
    }
    input[type="confirm_password"] {
        border-bottom-left-radius: 0px;;
        border-bottom-right-radius: 0px;;
        border-top: 0px;
    }
</style>
<br>



    <div class="text-center mt-5">

        <img class="mt-5 mb-4" src="1.png" height="72" alt="logo">
        <h1 class="h3 mb-3 font-weight-normal">Please Sign up</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="smth@mail.com">
<br><br>


        <label for="password">Password:</label>
        <input type="password"  name="password" id="password" placeholder="Password">
        <br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password"  name="confirm_password" id="confirm_password"
               placeholder="Confirm Password">
<br><br>
        <label >Role:</label>
        <select name="role">
            <option value="">--SELECT--</option>
            <option value="owner">OWNER</option>
            <option value="tenant">TENANT</option>
        </select>
        <input type="submit" name="insert" value="INSERT DATA"/>
        <br><br>
        <button class="btn btn-lg btn-primary btn-block"  type="submit" >Sign up</button>
        <br><small> Already have an account<a href="login.php">Login</a>
    </form>
</div>
</body>
</html>