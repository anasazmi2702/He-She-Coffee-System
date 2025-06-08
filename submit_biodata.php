<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "he&she_coffee");
if (!$con) {
die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];
$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$gender = mysqli_real_escape_string($con, $_POST['gender']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$coffee_preference = mysqli_real_escape_string($con, $_POST['coffee_preference']);
$student_number = mysqli_real_escape_string($con, $_POST['student_number']);
$semester = mysqli_real_escape_string($con, $_POST['semester']);
$course = mysqli_real_escape_string($con, $_POST['course']);

// Handle file upload
$profile_image = NULL;
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
$file_tmp = $_FILES['profile_image']['tmp_name'];
$file_name = time() . "_" . basename($_FILES['profile_image']['name']);
$upload_dir = "uploads/";
$target_file = $upload_dir . $file_name;

if (move_uploaded_file($file_tmp, $target_file)) {
$profile_image = $target_file;
}
}

$query = "INSERT INTO user_profiles (user_id, name, email, gender, phone, address, coffee_preference, student_number, semester, course, profile_image) 
VALUES ('$user_id', '$name', '$email', '$gender', '$phone', '$address', '$coffee_preference', '$student_number', '$semester', '$course', '$profile_image')";

if (mysqli_query($con, $query)) {
header("Location: profile.php");
exit;
} else {
echo "Error: " . mysqli_error($con);
}

mysqli_close($con);
?>
