<?php
$mysqli = new mysqli('localhost', 'root', '', 'he&she_coffee');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// untuk validate product input
function validate_product_input($product_id, $quantity) {
    return isset($product_id, $quantity) && is_numeric($product_id) && $product_id > 0 && is_numeric($quantity) && $quantity > 0;
}

session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

// tambah product dalam cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (isset($_POST['product_id'], $_POST['quantity'])) {
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        // untuk validate product ada dalam database
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id); // "i" indicates integer
        $stmt->execute();
        $stmt->bind_result($product_exists);
        $stmt->fetch();
        $stmt->close();

        if (!$product_exists) {
            die("Invalid product.");
        }

        // add or update product dalam cart cart
        $stmt = $mysqli->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) 
                                  ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Invalid input.");
    }
}

// update cart kuantiti
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    if (isset($_POST['quantities']) && is_array($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $product_id => $quantity) {
            $quantity = max(1, (int)$quantity);
            $stmt = $mysqli->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            $stmt->bind_param("iii", $quantity, $user_id, $product_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// remove a product
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $product_id = (int)$_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->close();
}

// query untuk cart items
$stmt = $mysqli->prepare("SELECT products.id, products.name, products.price, cart.quantity 
                          FROM cart 
                          JOIN products ON cart.product_id = products.id 
                          WHERE cart.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// store cart data
$_SESSION['cart'] = $cart_items;

$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$delivery_fee = 2.50;
$total = $subtotal + $delivery_fee;

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="cart.css">
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
    <div class="cart-container">
        <h1>Your Order Cart</h1>
        <form method="post" action="cart.php">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>RM <?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <input type="number" name="quantities[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
                            </td>
                            <td>RM <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <a href="cart.php?delete=<?php echo $item['id']; ?>" class="delete-button">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="update_cart">Update Cart</button>
        </form>
        <div class="cart-summary">
            <p>Subtotal: RM <?php echo number_format($subtotal, 2); ?></p>
            <p>Delivery Fee: RM <?php echo number_format($delivery_fee, 2); ?></p>
            <p>Total: RM <?php echo number_format($total, 2); ?></p>
        </div>
        <div class="cart-buttons">
            <a href="product.php" class="continue-shopping">Continue Shopping</a>
            <a href="checkout.php" class="checkout-link">Proceed to Checkout</a>
        </div>
    </div>
	
    <footer>
        <p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
    </footer>
</body>
</html>
