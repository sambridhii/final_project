<?php

session_start();

require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT * FROM users WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $_SESSION['id'];
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($result);
            if (password_verify($_POST['currentPassword'], $row['password'])) {
                $sql = "UPDATE users set password=? WHERE id=?";
                if ($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
                    $param_password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
                    $param_id = $_SESSION['id'];

                    if (mysqli_stmt_execute($stmt)) {
                        header("location: login.php");
                    }
                }
            } else {
                echo "Password not changed.";
            }
        }
    }
}

?>
<html>
<head>
    <title> Change password</title>
</head>

<body>
<h3> CHANGE PASSWORD</h3>
<form method="post" action="">
    Current Password:<br>
    <input type="password" name="currentPassword">
    <br>
    New Password:<br>
    <input type="password" name="newPassword">
    <br>
    Confirm Password:<br>
    <input type="password" name="confirmPassword">
    <br>
    <input type="submit">


</form>

</body>
</html>