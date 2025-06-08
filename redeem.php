<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'he&she_coffee');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    die("Unauthorized: Please log in.");
}

$sql_points = "SELECT points FROM user_profiles WHERE user_id = ?";
$stmt_points = $mysqli->prepare($sql_points);
$stmt_points->bind_param("i", $user_id);
$stmt_points->execute();
$stmt_points->bind_result($user_points);
$stmt_points->fetch();
$stmt_points->close();

$sql_items = "SELECT id, name, image_url, points_required FROM redeemable_items";
$result_items = $mysqli->query($sql_items);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'] ?? 0;

    $sql_item = "SELECT points_required FROM redeemable_items WHERE id = ?";
    $stmt_item = $mysqli->prepare($sql_item);
    $stmt_item->bind_param("i", $item_id);
    $stmt_item->execute();
    $stmt_item->bind_result($points_required);
    $stmt_item->fetch();
    $stmt_item->close();

    if ($user_points >= $points_required) {
        $update_points = "UPDATE user_profiles SET points = points - ? WHERE user_id = ?";
        $stmt_update = $mysqli->prepare($update_points);
        $stmt_update->bind_param("ii", $points_required, $user_id);
        $stmt_update->execute();
        $stmt_update->close();
	

        $insert_history = "INSERT INTO redemption_history (user_id, item_id, redeemed_at) VALUES (?, ?, NOW())";
        $stmt_history = $mysqli->prepare($insert_history);
        $stmt_history->bind_param("ii", $user_id, $item_id);
        $stmt_history->execute();
        $stmt_history->close();

        echo "<script>alert('Successfully redeemed!');</script>";
        header("Refresh:0");
    } else {
        echo "<script>alert('Not enough points to redeem this item.');</script>";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redeem Rewards</title>
    <link rel="stylesheet" href="redeem.css">
</head>
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
    <header>
        <h1>Points Balance: <?= $user_points ?? 0 ?></h1>
    </header>
    <main>
        <h2>Available Rewards</h2>
        <div class="rewards-container">
            <?php while ($item = $result_items->fetch_assoc()): ?>
                <div class="reward-card">
                    <img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>">
                    <h3><?= $item['name'] ?></h3>
                    <p><?= $item['points_required'] ?> Points</p>
                    <form method="post" action="">
                        <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                        <button type="submit" <?= $user_points < $item['points_required'] ? 'disabled' : '' ?>>
                            <?= $user_points < $item['points_required'] ? 'Not Enough Points' : 'Redeem' ?>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

	    <footer>
        <p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
    </footer>
</body>
</html>
</body>
</html>
