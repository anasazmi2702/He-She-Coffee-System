<!doctype HTML>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="index.css">
</head>
<body>
<div class="container">
<div class="form-section">
<h1>Welcome Back</h1>
<p>Enter your account credentials to log in</p>
<form name="login" method="post" action="index.php">
<input type="email" name="email" id="email" placeholder="Email" required>
<input type="password" name="password" id="password" placeholder="Password" required>
<button type="submit" class="btn">Log In</button>
</form>
<p><a href="forgot_password.php">Forgot Password?</a></p>
<p>Don’t have an account? <a href="signup.php">Sign Up</a></p>
</div>
</div>
</body>
</html>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$email = $_POST['email'];
$password = $_POST['password'];

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
$user = mysqli_fetch_assoc($result);

if ($password === $user['password']) {
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];

header("Location: main.php");
exit;
} else {
$error_message = "Invalid password!";
}
} else {
$error_message = "No account found with this email.";
}

mysqli_stmt_close($stmt);
mysqli_close($con);
}
?>


