<?php
/**
 * Filename: view_register.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin view for workshop registrations.
 * Date: 2025
 */

if (basename($_SERVER['PHP_SELF']) == 'view_register.php') {
    header("Location: adminview.php?page=workshop");
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

    $deleteStmt = $conn->prepare("DELETE FROM workshop WHERE id = ?");
    $deleteStmt->bind_param("i", $deleteId);
    $deleteStmt->execute();
    $deleteStmt->close();

    $result = mysqli_query($conn, "SELECT id FROM workshop ORDER BY id ASC");
    $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    $newId = 1;
    foreach ($records as $record) {
        $updateStmt = $conn->prepare("UPDATE workshop SET id = ? WHERE id = ?");
        $updateStmt->bind_param("ii", $newId, $record['id']);
        $updateStmt->execute();
        $updateStmt->close();
        $newId++;
    }

    mysqli_query($conn, "ALTER TABLE workshop AUTO_INCREMENT = " . $newId);
    mysqli_close($conn);
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM workshop ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
$workshops = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($conn);
?>

<div class="admin-page">
    <div class="page-title-row">
        <h1 class="page-title">Workshops</h1>
        <a href="create_register.php" class="create-btn">+ Create</a>
    </div>
    <?php if (empty($workshops)): ?>
        <p>No workshop registrations found.</p>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                       
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Date of Birth</th>
                        <th>Interests</th>
                        <th>Participants</th>
                        <th>Additional Comments</th>
                        <th>Actions</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($workshops as $workshop): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($workshop['id']); ?></td>
                            <td><?php echo htmlspecialchars($workshop['firstname'] . ' ' . $workshop['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($workshop['email']); ?></td>
                            <td><?php echo htmlspecialchars($workshop['phone'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($workshop['dateofbirth'] ?? 'N/A'); ?></td>
                            <td><?php echo !empty($workshop['interests']) ? htmlspecialchars($workshop['interests']) : 'none'; ?></td>
                            <td><?php echo htmlspecialchars($workshop['participants'] ?? 'N/A'); ?></td>
                            <td><?php echo !empty($workshop['comments']) ? htmlspecialchars(substr($workshop['comments'], 0, 50)) : 'none'; ?></td>
                            <td>
                                <div class="action-dropdown">
                                    <input type="checkbox" id="action-<?php echo $workshop['id']; ?>" class="action-toggle">
                                    <label for="action-<?php echo $workshop['id']; ?>" class="action-btn">⋮</label>
                                    <div class="dropdown-menu">
                                        <a href="view_register_detail.php?id=<?php echo $workshop['id']; ?>" class="dropdown-item view-btn">View</a>
                                        <a href="edit_register.php?id=<?php echo $workshop['id']; ?>" class="dropdown-item edit-btn">Edit</a>
                                        <form method="POST" class="dropdown-form">
                                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($workshop['id']); ?>">
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
