<?php
session_start();

if (!isset($_SESSION['user_id'])) {
header("Location: index.php");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Story - HE & SHE Coffee</title>
<link rel="stylesheet" href="about.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
</head>
<body>

<header class="navbar">
<div class="nav-container">
<div class="logo">HE&SHE COFFEE</div>
<nav>
<ul class="nav-links">
<li><a href="main.php">The Brew Welcome</a></li>
<li><a href="my_profile.php">My Profile</a></li>
<li><a href="about.php" class="active">Our Story</a></li>
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
<div class="hero-content">
<h1>About Us</h1>
<p>Brewing connections, one cup at a time. Experience coffee like never before with HE & SHE Coffee.</p>
</div>
</section>

<section class="about-section">
<h2>Our Story</h2>
<p>
At <strong>HE & SHE Coffee</strong>, we are passionate about crafting the perfect coffee experience. 
Our journey began with the vision of creating a community of coffee lovers, where exceptional brews meet 
memorable moments. From ethically sourced beans to perfectly brewed cups, our mission is to connect people 
through the love of coffee.
</p>
<div class="images-row">
<img src="ok.jpg" alt="Team Image">
<img src="citt.jpg" alt="Collaboration">
<img src="collabration 1.png" alt="Coffee Chat">
</div>
</section>

<section class="values-section">
<h2>Our Values</h2>
<div class="value-cards">
<div class="card">
<img src="barista.jpg" alt="Professional Team">
<h3>Professional Team</h3>
<p>Our expert baristas and staff ensure every cup is crafted with precision.</p>
</div>
<div class="card">
<img src="team.jpg" alt="Target Oriented">
<h3>Target Oriented</h3>
<p>We strive to meet your coffee cravings with the finest flavors.</p>
</div>
<div class="card">
<img src="alumni.jpg" alt="Success Guarantee">
<h3>Success Guarantee</h3>
<p>Your satisfaction with our products and services is our priority.</p>
</div>
</div>
</section>

<footer>
<p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
</footer>
</body>
</html>
