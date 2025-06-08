<?php
session_start();

$mysqli = new mysqli('localhost', 'root', '', 'he&she_coffee');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized: Admin access only.");
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? 0;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $purchase_threshold = $_POST['purchase_threshold'] ?? 0;
    $icon_url = $_POST['icon_url'] ?? '';

    if ($action === 'add') {
        $sql_add = "INSERT INTO badges (name, description, purchase_threshold, icon_url) VALUES (?, ?, ?, ?)";
        $stmt_add = $mysqli->prepare($sql_add);
        $stmt_add->bind_param("ssis", $name, $description, $purchase_threshold, $icon_url);
        if ($stmt_add->execute()) {
            $message = "Badge successfully added!";
        }
        $stmt_add->close();
    } elseif ($action === 'edit') {
        $sql_edit = "UPDATE badges SET name = ?, description = ?, purchase_threshold = ?, icon_url = ? WHERE id = ?";
        $stmt_edit = $mysqli->prepare($sql_edit);
        $stmt_edit->bind_param("ssisi", $name, $description, $purchase_threshold, $icon_url, $id);
        if ($stmt_edit->execute()) {
            $message = "Badge successfully updated!";
        }
        $stmt_edit->close();
    } elseif ($action === 'delete') {
        $sql_delete = "DELETE FROM badges WHERE id = ?";
        $stmt_delete = $mysqli->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);
        if ($stmt_delete->execute()) {
            $message = "Badge successfully deleted!";
        }
        $stmt_delete->close();
    }
}

$sql_badges = "SELECT * FROM badges";
$result_badges = $mysqli->query($sql_badges);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Badges</title>
    <link rel="stylesheet" href="manage_badge.css">
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
    <div class="manage-badges-container">
        <h1 class="page-title">Manage Badges</h1>
        <?php if (!empty($message)): ?>
            <div class="success-message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <h2 class="section-title">Add New Badge</h2>
        <form method="post" action="" class="manage-badges-form">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter badge name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" placeholder="Enter badge description" required></textarea>
            </div>
            <div class="form-group">
                <label for="purchase_threshold">Purchase Threshold:</label>
                <input type="number" id="purchase_threshold" name="purchase_threshold" placeholder="Enter required purchases" required>
            </div>
            <div class="form-group">
                <label for="icon_url">Icon URL:</label>
                <input type="text" id="icon_url" name="icon_url" placeholder="Enter icon URL" required>
            </div>
            <button type="submit" class="add-badge-btn">Add Badge</button>
        </form>
    </div>

    <div class="badges-list-container">
        <h2 class="section-title">Existing Badges</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Purchase Threshold</th>
                    <th>Icon</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($badge = $result_badges->fetch_assoc()): ?>
                    <tr>
                        <td><?= $badge['id'] ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?= $badge['id'] ?>">
                                <input type="text" name="name" value="<?= $badge['name'] ?>" class="badge-input" required>
                        </td>
                        <td>
                            <textarea name="description" class="badge-textarea" required><?= $badge['description'] ?></textarea>
                        </td>
                        <td>
                            <input type="number" name="purchase_threshold" value="<?= $badge['purchase_threshold'] ?>" class="badge-input" required>
                        </td>
                        <td>
                            <input type="text" name="icon_url" value="<?= $badge['icon_url'] ?>" class="badge-input" required>
                            <br>
                            <img src="<?= $badge['icon_url'] ?>" alt="<?= $badge['name'] ?>" class="badge-icon">
                        </td>
                        <td>
                            <div class="actions-container">
                                <button class="update-btn" type="submit">Update</button>
                            </form>
                            <form method="post" action="" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $badge['id'] ?>">
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
