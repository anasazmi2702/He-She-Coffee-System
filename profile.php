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

$user_id = intval($_SESSION['user_id']); // Ensure user_id is an integer
$query = "SELECT * FROM user_profiles WHERE user_id = ? LIMIT 1";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$biodata = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);
mysqli_close($con);


if (!$biodata) {
header("Location: biodata.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <link rel="stylesheet" href="profile.css"> 
</head>
<body>

<div class="container">
<h1>Your Biodata</h1>
<?php if (!empty($biodata['profile_image'])): ?>
<img src="<?= htmlspecialchars($biodata['profile_image']); ?>" alt="Profile Image" class="profile-image">
<?php else: ?>
<p><i>No profile image uploaded.</i></p>
<?php endif; ?>

<p><strong>Name:</strong> <?= htmlspecialchars($biodata['name']); ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($biodata['email']); ?></p>
<p><strong>Gender:</strong> <?= htmlspecialchars($biodata['gender']); ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($biodata['phone']); ?></p>
<p><strong>Address:</strong> <?= nl2br(htmlspecialchars($biodata['address'])); ?></p>
<p><strong>Coffee Preference:</strong> <?= htmlspecialchars($biodata['coffee_preference']); ?></p>
<p><strong>Student Number:</strong> <?= htmlspecialchars($biodata['student_number']); ?></p>
<p><strong>Semester:</strong> <?= htmlspecialchars($biodata['semester']); ?></p>
<p><strong>Course:</strong> <?= htmlspecialchars($biodata['course']); ?></p>
<br>
<a href="update_biodata.php" class="btn">Update Biodata</a>
<a href="main.php" class="btn">Back to Main</a>
    </div>
	
<footer>
<p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
</footer>

</body>
</html>
</body>
</html>
