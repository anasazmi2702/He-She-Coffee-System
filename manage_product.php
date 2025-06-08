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

//add product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $image = mysqli_real_escape_string($con, $_POST['image']);

    $query = "INSERT INTO products (name, price, description, image) VALUES ('$name', '$price', '$description', '$image')";
    mysqli_query($con, $query);

    header("Location: manage_product.php");
    exit;
}

//update product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $product_id = intval($_POST['product_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $price = floatval($_POST['price']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $image = mysqli_real_escape_string($con, $_POST['image']);

    $update_query = "UPDATE products SET name = '$name', price = '$price', description = '$description', image = '$image' WHERE id = $product_id";
    mysqli_query($con, $update_query);

    header("Location: manage_product.php");
    exit;
}

//delete product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
    $product_id = intval($_POST['product_id']);
    $delete_product_query = "DELETE FROM products WHERE id = $product_id";
    $delete_cart_query = "DELETE FROM cart WHERE product_id = $product_id";

    mysqli_query($con, $delete_cart_query);
    mysqli_query($con, $delete_product_query);

    header("Location: manage_product.php");
    exit;
}

// recall all products
$query = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="manage_product.css">
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
<div class="add-product-container">
    <h2>Add Product</h2>
    <form action="manage_product.php" method="POST" class="add-product-form">
        <div class="form-group">
            <input type="text" name="name" placeholder="Product Name" required>
        </div>
        <div class="form-group">
            <input type="number" name="price" placeholder="Price (RM)" step="0.01" required>
        </div>
        <div class="form-group">
            <textarea name="description" placeholder="Product Description" required></textarea>
        </div>
        <div class="form-group">
            <input type="text" name="image" placeholder="Image URL" required>
        </div>
        <button type="submit" name="add_product">Add Product</button>
    </form>
</div>


    <div class="product-list-container">
        <h2>Product List</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price (RM)</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <form action="manage_product.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <td>
                                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image" class="product-image">
                                    <input type="text" name="image" value="<?php echo htmlspecialchars($row['image']); ?>">
                                </td>
                                <td><input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required></td>
                                <td><input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($row['price']); ?>" required></td>
                                <td><textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea></td>
                                <td>
                                    <button type="submit" name="update_product" class="update-btn">Update</button>
                                    <button type="submit" name="delete_product" class="delete-btn">Delete</button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
	
    <footer>
        <p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
    </footer>
</body>
</html>
<?php mysqli_close($con); ?>
