<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "he&she_coffee");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    die("Unauthorized: Please log in.");
}

$query_most_orders = "SELECT name, total_orders FROM user_profiles ORDER BY total_orders DESC LIMIT 10";

$result_most_orders = mysqli_query($con, $query_most_orders);

if (!$result_most_orders) {
    die("Error fetching leaderboard: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="leaderboard.css"> <!-- Link to external CSS -->
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
                            <li><a href="manage_product.php">Manage Products</a></li>
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

    <div class="container">
        <h1>Leaderboard</h1>
        <table class="leaderboard-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Total Points</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rank = 1;
                while ($row = mysqli_fetch_assoc($result_most_orders)) {
                    echo "<tr>
                        <td>{$rank}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['total_orders']}</td>
                    </tr>";
                    $rank++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
