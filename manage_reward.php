<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'he&she_coffee');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized: Admin access only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $image_url = $_POST['image_url'] ?? '';
    $points_required = $_POST['points_required'] ?? 0;

    if ($action === 'add') {
        $sql_add = "INSERT INTO redeemable_items (name, image_url, points_required) VALUES (?, ?, ?)";
        $stmt_add = $mysqli->prepare($sql_add);
        $stmt_add->bind_param("ssi", $name, $image_url, $points_required);
        if ($stmt_add->execute()) {
            $_SESSION['message'] = "Reward successfully added!";
        }
        $stmt_add->close();
    } elseif ($action === 'edit') {
        $sql_edit = "UPDATE redeemable_items SET name = ?, image_url = ?, points_required = ? WHERE id = ?";
        $stmt_edit = $mysqli->prepare($sql_edit);
        $stmt_edit->bind_param("ssii", $name, $image_url, $points_required, $id);
        if ($stmt_edit->execute()) {
            $_SESSION['message'] = "Reward successfully updated!";
        }
        $stmt_edit->close();
    } elseif ($action === 'delete') {
        $sql_delete = "DELETE FROM redeemable_items WHERE id = ?";
        $stmt_delete = $mysqli->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);
        if ($stmt_delete->execute()) {
            $_SESSION['message'] = "Reward successfully deleted!";
        }
        $stmt_delete->close();
    }

    header("Location: manage_reward.php");
    exit();
}

$sql_items = "SELECT * FROM redeemable_items";
$result_items = $mysqli->query($sql_items);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rewards</title>
    <link rel="stylesheet" href="manage_reward.css">
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

<main>
    <div class="manage-rewards-container">
        <h1>Manage Redeemable Rewards</h1>

        <!-- Display success message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="success-message">
                <?= $_SESSION['message'] ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <h2>Add New Reward</h2>
        <form method="post" action="" class="manage-rewards-form">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="image_url">Image URL:</label>
                <input type="text" id="image_url" name="image_url" required>
            </div>
            <div class="form-group">
                <label for="points_required">Points Required:</label>
                <input type="number" id="points_required" name="points_required" required>
            </div>
            <button type="submit">Add Reward</button>
        </form>
    </div>

    <div class="rewards-list-container">
        <h2>Existing Rewards</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Points Required</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $result_items->fetch_assoc()): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><img src="<?= $item['image_url'] ?>" alt="<?= $item['name'] ?>" width="50"></td>
                        <td><?= $item['points_required'] ?></td>
                        <td>
                            <div class="actions-container">
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <input type="text" name="name" value="<?= $item['name'] ?>" required>
                                    <input type="text" name="image_url" value="<?= $item['image_url'] ?>" required>
                                    <input type="number" name="points_required" value="<?= $item['points_required'] ?>" required>
                                    <button class="update-btn" type="submit">Update</button>
                                </form>
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button class="delete-btn" type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<footer>
    <p>&copy; 2024 HE & SHE Coffee. All Rights Reserved.</p>
</footer>
</body>
</html>
<?php $mysqli->close(); ?>
