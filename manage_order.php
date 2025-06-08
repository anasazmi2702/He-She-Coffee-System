<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "he&she_coffee";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$search_query = '';
$search_by = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search_query'], $_GET['search_by'])) {
    $search_query = $_GET['search_query'];
    $search_by = $_GET['search_by'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $order_id = $_POST['order_id'];

    $delete_query = "DELETE FROM orders WHERE id = $order_id";
    if (!mysqli_query($conn, $delete_query)) {
        echo "Error deleting order: " . mysqli_error($conn);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE orders SET status = '$status' WHERE id = $order_id";
    if (!mysqli_query($conn, $update_query)) {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

$sql = "SELECT id, user_id, name, phone, address, building_name, notes, product_name, price, quantity, total_price, payment_method, created_at, status FROM orders";
if (!empty($search_query) && !empty($search_by)) {
    $search_column = match ($search_by) {
        'order_id' => 'id',
        'user_id' => 'user_id',
        'customer_name' => 'name',
        default => ''
    };
    if ($search_column) {
        $sql .= " WHERE $search_column LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%'";
    }
}
$sql .= " ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="manage_order.css">
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
        <a class="logout-btn" href="logout.php">Logout</a>
    </div>
</header>

<main>
    <h1>View Orders</h1>

    <div class="search-container">
        <form method="GET" action="">
            <select name="search_by">
                <option value="order_id" <?php echo $search_by === 'order_id' ? 'selected' : ''; ?>>Order ID</option>
                <option value="user_id" <?php echo $search_by === 'user_id' ? 'selected' : ''; ?>>User ID</option>
                <option value="customer_name" <?php echo $search_by === 'customer_name' ? 'selected' : ''; ?>>Customer Name</option>
            </select>
            <input type="text" name="search_query" placeholder="Enter search term" value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Building</th>
                <th>Notes</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Payment Method</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['building_name']}</td>
                        <td>{$row['notes']}</td>
                        <td>{$row['product_name']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['total_price']}</td>
                        <td>{$row['payment_method']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <form method='POST' action=''>
                                <input type='hidden' name='order_id' value='{$row['id']}'>
                                <select name='status' onchange='this.form.submit()'>
                                    <option value='Not Paid' " . ($row['status'] === 'Not Paid' ? 'selected' : '') . ">Not Paid</option>
                                    <option value='Paid' " . ($row['status'] === 'Paid' ? 'selected' : '') . ">Paid</option>
                                    <option value='Canceled' " . ($row['status'] === 'Canceled' ? 'selected' : '') . ">Canceled</option>
                                </select>
                                <input type='hidden' name='update_status' value='1'>
                            </form>
                        </td>
                        <td>
                            <form method='POST' action=''>
                                <input type='hidden' name='order_id' value='{$row['id']}'>
                                <button type='submit' name='delete_order'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='15'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<footer>
    <p>&copy; 2025 He&She Coffee. All Rights Reserved.</p>
</footer>
</body>
</html>
<?php mysqli_close($conn); ?>
