<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=he&she_coffee', 'root', '');

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    die("Error: Unauthorized access.");
}
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $stmt = $pdo->prepare("SELECT products.id, products.name, products.price, cart.quantity 
                           FROM cart 
                           JOIN products ON cart.product_id = products.id 
                           WHERE cart.user_id = ?");
    $stmt->execute([$user_id]);
    $_SESSION['cart'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (empty($_SESSION['cart'])) {
    die("Error: Your cart is empty.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $building_name = $_POST['building_name'];
    $notes = $_POST['notes'];
    $payment_method = $_POST['payment_method'];

    if (empty($name) || empty($phone) || empty($address) || empty($payment_method)) {
        die("Error: Missing required fields.");
    }

    $pdo->beginTransaction();
    try {
        foreach ($_SESSION['cart'] as $item) {
            $product_name = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $total_price = $price * $quantity;

            $stmt = $pdo->prepare("
                INSERT INTO orders (
                    user_id, name, phone, address, building_name, notes, payment_method, product_name, price, quantity, total_price
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $user_id, $name, $phone, $address, $building_name, $notes, $payment_method,
                $product_name, $price, $quantity, $total_price
            ]);
        }

        $pdo->commit();

        unset($_SESSION['cart']);

        echo "<script>alert('Your order has been successfully placed!'); window.location.href = 'product.php';</script>";
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}
?>
