if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'] ?? 0;

    $sql_item = "SELECT points_required FROM redeemable_items WHERE id = ?";
    $stmt_item = $mysqli->prepare($sql_item);
    $stmt_item->bind_param("i", $item_id);
    $stmt_item->execute();
    $stmt_item->bind_result($points_required);
    $stmt_item->fetch();
    $stmt_item->close();

    if ($user_points >= $points_required) {
        // Deduct points
        $update_points = "UPDATE user_profiles SET points = points - ? WHERE user_id = ?";
        $stmt_update = $mysqli->prepare($update_points);
        $stmt_update->bind_param("ii", $points_required, $user_id);
        $stmt_update->execute();
        $stmt_update->close();

        // Add redemption record
        $insert_history = "INSERT INTO redemption_history (user_id, item_id, redeemed_at) VALUES (?, ?, NOW())";
        $stmt_history = $mysqli->prepare($insert_history);
        $stmt_history->bind_param("ii", $user_id, $item_id);
        $stmt_history->execute();
        $stmt_history->close();

        echo "<script>alert('Successfully redeemed!');</script>";
        header("Refresh:0");
    } else {
        echo "<script>alert('Not enough points to redeem this item.');</script>";
    }
}
