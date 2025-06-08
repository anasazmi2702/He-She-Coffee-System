<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - HE & SHE</title>
<link rel="stylesheet" href="signup.css">
</head>
<body>

<div class="container">
<div class="form-section">
<h1>Create Account</h1>
<form action="signup.php" method="POST">
<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button type="submit" class="btn">Sign Up</button>
</form>

<p>Already have an account? <a href="index.php">Log In</a></p>

<div class="message">
<?php
if (!empty($error_message)) {
echo "<p style='color:red;'><strong>$error_message</strong></p>";
}
?>
</div>
</div>
</div>
</div>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "he&she_coffee";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];


$email_check_query = "SELECT * FROM users WHERE email = '$email'";
$email_check_result = mysqli_query($conn, $email_check_query);

if (mysqli_num_rows($email_check_result) > 0) {
$error_message = "This email is already registered!";
} else {
$insert_query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if (mysqli_query($conn, $insert_query)) {
header("Location: index.php");
exit;
} else {
$error_message = "Error creating account. Please try again.";
}
}

mysqli_free_result($email_check_result);
}

mysqli_close($conn);
?>

