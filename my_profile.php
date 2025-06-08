<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "he&she_coffee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    die("Unauthorized: Please log in.");
}

$sql_biodata = "SELECT name, email, phone, student_number, profile_image FROM user_profiles WHERE user_id = ?";
$stmt_biodata = $conn->prepare($sql_biodata);
$stmt_biodata->bind_param("i", $user_id);
$stmt_biodata->execute();
$stmt_biodata->bind_result($name, $email, $phone, $student_number, $profile_image);
$stmt_biodata->fetch();
$stmt_biodata->close();

$name = $name ?? 'Not provided';
$email = $email ?? 'Not provided';
$phone = $phone ?? 'Not provided';
$student_number = $student_number ?? 'Not provided';
$profile_image = $profile_image ?? '';

$sql_points = "SELECT points FROM user_profiles WHERE user_id = ?";
$stmt_points = $conn->prepare($sql_points);
$stmt_points->bind_param("i", $user_id);
$stmt_points->execute();
$stmt_points->bind_result($points);
$stmt_points->fetch();
$stmt_points->close();
$points = $points ?? 0;

$sql_user = "SELECT total_orders, badges_earned FROM user_profiles WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$stmt_user->bind_result($total_orders, $badges_earned_json);
$stmt_user->fetch();
$stmt_user->close();

$total_orders = $total_orders ?? 0;
$badges_earned_json = $badges_earned_json ?? '[]';
$badges_earned = json_decode($badges_earned_json, true) ?? [];

$sql_redeemed = "SELECT redeemable_items.name FROM redemption_history 
                 JOIN redeemable_items ON redemption_history.item_id = redeemable_items.id 
                 WHERE redemption_history.user_id = ?";
$stmt_redeemed = $conn->prepare($sql_redeemed);
$stmt_redeemed->bind_param("i", $user_id);
$stmt_redeemed->execute();
$result_redeemed = $stmt_redeemed->get_result();
$redeemed_rewards = $result_redeemed->fetch_all(MYSQLI_ASSOC);
$stmt_redeemed->close();

$sql_badges = "SELECT id, name, description, purchase_threshold, icon_url FROM badges";
$result_badges = $conn->query($sql_badges);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="my_profile.css">
</head>
<body>
<header class="navbar">
    <div class="nav-container">
        <div class="logo">HE&SHE COFFEE</div>
        <nav>
            <ul class="nav-links">
                <li><a href="main.php">The Brew Welcome</a></li>
                <li><a href="my_profile.php">My Profile</a></li>
                <li><a href="about.php">Our Story</a></li>
                <li><a href="product.php">The Coffee Bar</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="redeem.php">Redeem</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-btn">ADMIN</a>
                        <ul class="dropdown-content">
                            <li><a href="manage_product.php">Manage Product</a></li>
                            <li><a href="manage_order.php">Manage Orders</a></li>
							<li><a href="manage_reward.php">Manage Rewards</a></li>
                            <li><a href="manage_badge.php">Manage Badges</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <a class="logout-btn" href="index.php">Logout</a>
    </div>
</header>
    <main class="profile-container">
        <div class="profile-header">
            <h1>Welcome, <?= htmlspecialchars($name) ?></h1>
            <p>Member Since: <?= htmlspecialchars(date("F Y", strtotime("2025-01-01"))) ?></p>
        </div>

        <div class="points-section">
            <h2>Current Points</h2>
            <p class="points-count"><?= htmlspecialchars($points) ?></p>
        </div>

        <div class="profile-info">
            <div class="personal-info">
                <h3>Personal Information</h3>
                <?php if (!empty($profile_image)): ?>
                    <img src="<?= htmlspecialchars($profile_image) ?>" alt="Profile Image" class="profile-image">
                <?php else: ?>
                    <p><i>No profile image uploaded.</i></p>
                <?php endif; ?>
                <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
                <p><strong>Student Number:</strong> <?= htmlspecialchars($student_number) ?></p>
            </div>

            <div class="account-stats">
                <h3>Account Statistics</h3>
                <p><strong>Total Points:</strong> <?= htmlspecialchars($total_orders) ?></p>
                <p><strong>Redeemed Rewards:</strong></p>
                <ul>
                    <?php if (!empty($redeemed_rewards)): ?>
                        <?php foreach ($redeemed_rewards as $reward): ?>
                            <li><?= htmlspecialchars($reward['name']) ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No rewards redeemed yet.</p>
                    <?php endif; ?>
                </ul>
                <p><strong>Current Points:</strong> <?= htmlspecialchars($points) ?></p>
            </div>
        </div>

        <div class="badges-container">
            <h2>Your Badges</h2>
            <div class="badges-list">
                <?php while ($badge = $result_badges->fetch_assoc()): ?>
                    <div class="badge-card <?= in_array($badge['id'], $badges_earned) ? 'earned' : '' ?>">
                        <img src="<?= htmlspecialchars($badge['icon_url']) ?>" alt="<?= htmlspecialchars($badge['name']) ?>" class="badge-icon">
                        <h3><?= htmlspecialchars($badge['name']) ?></h3>
                        <p><?= htmlspecialchars($badge['description']) ?></p>
                        <progress value="<?= min($total_orders, $badge['purchase_threshold']) ?>" max="<?= $badge['purchase_threshold'] ?>"></progress>
                        <p><?= min($total_orders, $badge['purchase_threshold']) ?>/<?= $badge['purchase_threshold'] ?> purchases</p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
    </footer>
</body>
</html>
