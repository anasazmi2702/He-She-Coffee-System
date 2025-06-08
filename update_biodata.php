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
$query = "SELECT * FROM user_profiles WHERE user_id = $user_id";
$result = mysqli_query($con, $query);
$biodata = mysqli_fetch_assoc($result);

if (!$biodata) {
die("Error: No biodata found for this user.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$gender = mysqli_real_escape_string($con, $_POST['gender']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$coffee_preference = mysqli_real_escape_string($con, $_POST['coffee_preference']);
$student_number = mysqli_real_escape_string($con, $_POST['student_number']);
$semester = mysqli_real_escape_string($con, $_POST['semester']);
$course = mysqli_real_escape_string($con, $_POST['course']);
$upload_dir = 'uploads/';
$profile_image_path = $biodata['profile_image'];


if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
$filename = basename($_FILES['profile_image']['name']);
$target_path = $upload_dir . time() . '_' . $filename;

$allowed_types = ['image/jpeg','image/jpg', 'image/png', 'image/gif'];
if (in_array($_FILES['profile_image']['type'], $allowed_types)) {

if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_path)) {
$profile_image_path = $target_path;
} else {
echo "<script>alert('Failed to upload image. Please try again.');</script>";
}
} else {
echo "<script>alert('Invalid file type. Please upload JPG, PNG, or GIF.');</script>";
}
}

$query = "UPDATE user_profiles SET 
name = ?, email = ?, gender = ?, phone = ?, address = ?, 
coffee_preference = ?, student_number = ?, semester = ?, course = ?, 
profile_image = ?
WHERE user_id = ?";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "ssssssssssi", $name, $email, $gender, $phone, $address, 
$coffee_preference, $student_number, $semester, $course, $profile_image_path, $user_id);

if (mysqli_stmt_execute($stmt)) {
header("Location: my_profile.php");
exit;
} else {
echo "Error updating profile: " . mysqli_error($con);
}

mysqli_stmt_close($stmt);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Your Biodata</title>
<link rel="stylesheet" href="update_biodata.css">
</head>
<body>

<header>
<h1>Update Your Biodata</h1>
</header>

<div class="container">
<form action="update_biodata.php" method="POST" enctype="multipart/form-data">
<label for="name">Name:</label>
<input type="text" id="name" name="name" value="<?php echo htmlspecialchars($biodata['name']); ?>" required>

<label for="email">Email:</label>
<input type="email" id="email" name="email" value="<?php echo htmlspecialchars($biodata['email']); ?>" required>

<label for="gender">Gender:</label>
<select id="gender" name="gender" required>
<option value="Male" <?php echo ($biodata['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
<option value="Female" <?php echo ($biodata['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
<option value="Other" <?php echo ($biodata['gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
</select>

<label for="phone">Phone:</label>
<input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($biodata['phone']); ?>" required>

<label for="address">Address:</label>
<textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($biodata['address']); ?></textarea>

<label for="coffee_preference">Coffee Preference:</label>
<input type="text" id="coffee_preference" name="coffee_preference" value="<?php echo htmlspecialchars($biodata['coffee_preference']); ?>" required>

<label for="student_number">Student Number:</label>
<input type="text" id="student_number" name="student_number" value="<?php echo htmlspecialchars($biodata['student_number']); ?>" required>

<label for="semester">Semester:</label>
<input type="text" id="semester" name="semester" value="<?php echo htmlspecialchars($biodata['semester']); ?>" required>

<label for="course">Course:</label>
<input type="text" id="course" name="course" value="<?php echo htmlspecialchars($biodata['course']); ?>" required>

<label for="profile_image">Profile Image:</label>
<?php if (!empty($biodata['profile_image'])): ?>
<img src="<?php echo htmlspecialchars($biodata['profile_image']); ?>" alt="Profile Image" style="max-width: 150px; display: block; margin-bottom: 10px;">
<?php endif; ?>
<input type="file" id="profile_image" name="profile_image" accept="image/*">

<button type="submit">Save Changes</button>
</form>
</div>

<footer>
        &copy; 2024 He & She Coffee. All Rights Reserved.
</footer>
	
</body>
</html>
