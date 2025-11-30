<?php
/**
 * Filename: view_promotion.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin view for promotions.
 * Date: 2025
 */

if (basename($_SERVER['PHP_SELF']) == 'view_promotion.php') {
    header("Location: adminview.php?page=promotion");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Root_Flower";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $deleteStmt = $conn->prepare("DELETE FROM promotions WHERE id = ?");
    $deleteStmt->bind_param("i", $deleteId);
    $deleteStmt->execute();
    $deleteStmt->close();

    // Reorder IDs
    $result = mysqli_query($conn, "SELECT id FROM promotions ORDER BY id ASC");
    $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    $newId = 1;
    foreach ($records as $record) {
        $updateStmt = $conn->prepare("UPDATE promotions SET id = ? WHERE id = ?");
        $updateStmt->bind_param("ii", $newId, $record['id']);
        $updateStmt->execute();
        $updateStmt->close();
        $newId++;
    }

    mysqli_query($conn, "ALTER TABLE promotions AUTO_INCREMENT = " . $newId);
    mysqli_close($conn);
    
    // Redirect to avoid form resubmission
    header("Location: adminview.php?page=promotion");
    exit;
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM promotions ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
$promotions = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($conn);
?>

<div class="admin-page">
    <div class="page-title-row">
        <h1 class="page-title">Promotions</h1>
        <a href="create_promotion.php" class="create-btn">+ Create</a>
    </div>
    
    <?php if (empty($promotions)): ?>
        <p>No promotions found.</p>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promotions as $promo): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($promo['id']); ?></td>
                            <td><?php echo htmlspecialchars($promo['title']); ?></td>
                            <td><?php echo htmlspecialchars(substr($promo['description'], 0, 50)) . '...'; ?></td>
                            <td>
                                <div class="action-dropdown">
                                    <input type="checkbox" id="action-<?php echo $promo['id']; ?>" class="action-toggle">
                                    <label for="action-<?php echo $promo['id']; ?>" class="action-btn">⋮</label>
                                    <div class="dropdown-menu">
                                        <a href="edit_promotion.php?id=<?php echo $promo['id']; ?>" class="dropdown-item edit-btn">Edit</a>
                                        <form method="POST" action="" class="dropdown-form">
                                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($promo['id']); ?>">
                                            <button type="submit" class="dropdown-item dropdown-delete-btn">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
