<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    $con = mysqli_connect("localhost", "root", "", "he&she_coffee");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $update_query = "UPDATE users SET password = ? WHERE email = ?";
        $update_stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($update_stmt, "ss", $new_password, $email);

        if (mysqli_stmt_execute($update_stmt)) {
            echo "Password reset successfully! <a href='index.php'>Log In</a>";
        } else {
            echo "Error resetting password.";
        }
        mysqli_stmt_close($update_stmt);
    } else {
        echo "No account found with this email.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
<!doctype HTML>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Your Password</h1>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <input type="password" name="new_password" placeholder="Enter a new password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
