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

$user_id = $_SESSION['user_id'];
$query = "SELECT id FROM user_profiles WHERE id = '$user_id'";
$result = mysqli_query($con, $query);
$has_biodata = mysqli_num_rows($result) > 0;

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>HE & SHE COFFEE</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="main.css">
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

<section class="hero">
<img src="logo 2.png" alt="Coffee Cup">
<h1>HE & SHE COFFEE</h1>
<p>"Good ideas start with brainstorming, Great ideas start with coffee."</p>

<?php if ($has_biodata): ?>
<a href="profile.php">
<button class="hero-button">Let Us Know About You!</button>
</a>

<?php else: ?>
<a href="biodata.php">
<button class="hero-button">Let Us Know About You!</button>
</a>
<?php endif; ?>
</section>

<section class="malaysia-time-map">
<div class="time-container">
<h2>Current Time in Machang</h2>
<iframe scrolling="no" frameborder="no" clocktype="html5" style="overflow:hidden;border:0;margin:0;padding:0;width:444px;height:224px;"src="https://www.clocklink.com/html5embed.php?clock=042&timezone=Malaysia_KualaLumpur&color=red&size=444&Title=&Message=&Target=&From=2025,1,1,0,0,0&Color=red"></iframe>
</div>

<div class="map-container">
<h2>Visit Us</h2>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3969.6814368545847!2d102.2748385!3d5.758906500000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31b68fba0294fb57%3A0x3ac600bd29428b1a!2sHe%20%26%20She%20Coffee%20UiTM%20Machang!5e0!3m2!1sen!2smy!4v1736565962357!5m2!1sen!2smy" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
</section>

<footer>
<p>&copy; 2024 HE & SHE Coffee. All rights reserved.</p>
</footer>
</body>
</html>
