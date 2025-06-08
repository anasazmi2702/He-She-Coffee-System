<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "he&she_coffee");
if (!$con) {
die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>The Coffee Bar</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="product.css">
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

<div class="main-content">
<section class="product-section">
<h2>Our Special Coffee</h2>
<div class="product-grid">
<?php foreach ($products as $product): ?>
<div class="product-card">
<img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
<h3><?php echo htmlspecialchars($product['name']); ?></h3>
<p><?php echo htmlspecialchars($product['description']); ?></p>
<p class="price">RM <?php echo number_format($product['price'], 2); ?></p>
<form method="post" action="cart.php">
<input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
<label for="quantity">Quantity:</label>
<input type="number" name="quantity" value="1" min="1">
<button type="submit" name="add_to_cart" class="order-btn">Add to Cart</button>
</form>
</div>
<?php endforeach; ?>
</div>
</section>
</div>

<footer>
    <p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
</footer>
	
</body>
</html>
