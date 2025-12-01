<?php
/**
 * Filename: view_enquiry.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin view for customer enquiries.
 * Date: 2025
 */

if (basename($_SERVER['PHP_SELF']) == 'view_enquiry.php') {
    header("Location: adminview.php?page=enquiry");
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

    $deleteStmt = $conn->prepare("DELETE FROM enquiry WHERE id = ?");
    $deleteStmt->bind_param("i", $deleteId);
    $deleteStmt->execute();
    $deleteStmt->close();

    $result = mysqli_query($conn, "SELECT id FROM enquiry ORDER BY id ASC");
    $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    $newId = 1;
    foreach ($records as $record) {
        $updateStmt = $conn->prepare("UPDATE enquiry SET id = ? WHERE id = ?");
        $updateStmt->bind_param("ii", $newId, $record['id']);
        $updateStmt->execute();
        $updateStmt->close();
        $newId++;
    }

    mysqli_query($conn, "ALTER TABLE enquiry AUTO_INCREMENT = " . $newId);
    mysqli_close($conn);
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM enquiry ORDER BY id ASC";
$result = mysqli_query($conn, $sql);
$enquiries = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($conn);
?>

<div class="admin-page">
    <div class="page-title-row">
        <h1 class="page-title">Enquiries</h1>
        <a href="create_enquiry.php" class="create-btn">+ Create</a>
    </div>
    
    <?php if (empty($enquiries)): ?>
        <p>No enquiries registration found.</p>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Enquiry Type</th>
                        <th>Priority</th>
                        <th>Preferred Date</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enquiries as $enquiry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($enquiry['id']); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['firstname'] . ' ' . $enquiry['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['email']); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['phonenumber']); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['enquiry_type']); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['priority']); ?></td>
                            <td><?php echo htmlspecialchars($enquiry['preferred_date']); ?></td>
                            <td><?php echo htmlspecialchars(substr($enquiry['comments'], 0, 50)) . '...'; ?></td>
                            <td>
                                <div class="action-dropdown">
                                    <input type="checkbox" id="action-<?php echo $enquiry['id']; ?>" class="action-toggle">
                                    <label for="action-<?php echo $enquiry['id']; ?>" class="action-btn">⋮</label>
                                    <div class="dropdown-menu">
                                        <a href="view_enquiry_detail.php?id=<?php echo $enquiry['id']; ?>" class="dropdown-item view-btn">View</a>
                                        <a href="edit_enquiry.php?id=<?php echo $enquiry['id']; ?>" class="dropdown-item edit-btn">Edit</a>
                                        <form method="POST" class="dropdown-form">
                                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($enquiry['id']); ?>">
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
