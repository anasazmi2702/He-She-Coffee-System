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

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
$stmt = $mysqli->prepare("SELECT products.id, products.name, products.price, cart.quantity 
                         FROM cart 
                         JOIN products ON cart.product_id = products.id 
                         WHERE cart.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$_SESSION['cart'] = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
}

if (empty($_SESSION['cart'])) {
die("Error: Your cart is empty.");
}

$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$delivery_fee = 2.50;
$total = $subtotal + $delivery_fee;

$update_points_query = "UPDATE user_profiles SET points = points + 1 WHERE user_id = ?";
$stmt_points = $mysqli->prepare($update_points_query);
$stmt_points->bind_param("i", $user_id);
$stmt_points->execute();
$stmt_points->close();

$increment_orders_query = "UPDATE user_profiles SET total_orders = total_orders + 1 WHERE user_id = ?";
$stmt_orders = $mysqli->prepare($increment_orders_query);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$stmt_orders->close();

$sql_user = "SELECT total_orders, badges_earned FROM user_profiles WHERE user_id = ?";
$stmt_user = $mysqli->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$stmt_user->bind_result($total_orders, $badges_earned_json);
$stmt_user->fetch();
$stmt_user->close();

$badges_earned_json = $badges_earned_json ?? '[]'; // Set default if NULL
$badges_earned = json_decode($badges_earned_json, true);



$sql_badges = "SELECT id, name, purchase_threshold FROM badges";
$result_badges = $mysqli->query($sql_badges);


while ($badge = $result_badges->fetch_assoc()) {
if ($total_orders >= $badge['purchase_threshold'] && !in_array($badge['id'], $badges_earned)) {
        
$badges_earned[] = $badge['id'];
$badges_earned_json = json_encode($badges_earned);

$update_badges_query = "UPDATE user_profiles SET badges_earned = ? WHERE user_id = ?";
$stmt_badges = $mysqli->prepare($update_badges_query);
$stmt_badges->bind_param("si", $badges_earned_json, $user_id);
$stmt_badges->execute();
$stmt_badges->close();

echo "<script>alert('Congratulations! You earned the {$badge['name']} badge!');</script>";
    }
}

$mysqli->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<link rel="stylesheet" href="checkout.css">
</head>
<body>
<div class="checkout-container">
<h1>Checkout</h1>
<p class="total-price">Total: RM <?php echo number_format($total, 2); ?></p>
<form method="post" action="process_payment.php">
<h2>Payment Options</h2>
<div class="payment-options">
<label>
<input type="radio" name="payment_method" value="online" required> Pay Online
</label>
<label>
<input type="radio" name="payment_method" value="cash" required> Pay with Cash
</label>
</div>

<h2>Delivery Information</h2>
<div class="delivery-info">
<label for="name">Name:</label>
<input type="text" name="name" id="name" placeholder="Enter your full name" required>

<label for="phone">Phone Number:</label>
<input type="text" name="phone" id="phone" placeholder="Enter your phone number" required>

<label for="address">Delivery Address:</label>
<input type="text" name="address" id="address" placeholder="Enter your full address" required>

<label for="building_name">Place or Building Name:</label>
<input type="text" name="building_name" id="building_name" placeholder="E.g., Apartment, Office, etc." required>

<label for="notes">Additional Notes:</label>
<textarea name="notes" id="notes" placeholder="Any specific instructions for delivery (optional)" rows="4"></textarea>
</div>

<button type="submit">Next</button>
</form>

<a href="cart.php" class="back-to-cart">Back to Cart</a>
</div>
</body>
</html>
