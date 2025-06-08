<?php
session_start();

if (!isset($_SESSION['user_id'])) {
header("Location: index.php");
exit;
}

$con = mysqli_connect("localhost", "root", "", "he&she_coffee");
if (!$con) {
die("Connection failed: " . mysqli_connect_error());
}


$user_id = intval($_SESSION['user_id']);
$query = "SELECT * FROM user_profiles WHERE user_id = ? LIMIT 1";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {

header("Location: profile.php");
exit;
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fill Your Biodata</title>
<link rel="stylesheet" href="biodata.css">
</head>
<body>

<div class="container">
<h1>Fill Your Biodata</h1>
<form action="submit_biodata.php" method="POST" enctype="multipart/form-data">

<label for="name">Name:</label>
<input type="text" id="name" name="name" required>
            
<label for="email">Email:</label>
<input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['email'] ?? ''); ?>" required>

<label for="gender">Gender:</label>
<select id="gender" name="gender" required>
<option value="Male">Male</option>
<option value="Female">Female</option>
<option value="Other">Other</option>
</select>

<label for="phone">Phone:</label>
<input type="text" id="phone" name="phone" required>

<label for="address">Address:</label>
<textarea id="address" name="address" rows="4" required></textarea>

<label for="coffee_preference">Coffee Preference:</label>
<input type="text" id="coffee_preference" name="coffee_preference" required>

<label for="student_number">Student Number:</label>
<input type="text" id="student_number" name="student_number" required>

<label for="semester">Semester:</label>
<input type="text" id="semester" name="semester" required>

<label for="course">Course:</label>
<input type="text" id="course" name="course" required>

<label for="profile_image">Profile Image:</label>
<input type="file" id="profile_image" name="profile_image">

<button type="submit">Save Biodata</button>
</form>
</div>
	
<footer>
<p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
</footer>

</body>
</html>
</body>
</html>
