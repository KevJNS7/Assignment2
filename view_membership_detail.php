<?php
/**
 * Filename: view_membership_detail.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin view for detail membership registration.
 * Date: 2025
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Root_Flower";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request: Missing or invalid ID");
}

$id = (int)$_GET['id'];
$membership = null;

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = mysqli_real_escape_string($conn, $id);
$sql = "SELECT * FROM membership WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $membership = mysqli_fetch_assoc($result);
} else {
    die("Membership record not found");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Details - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

<div class="detail-container">
    <?php if ($membership): ?>
        <div class="detail-header">
            <h1 class="detail-title">Membership Details</h1>
        </div>
        
        <div class="detail-content">
            <div class="detail-info">
                <span class="detail-label">ID:</span>
                <span class="detail-value"><?php echo htmlspecialchars($membership['id']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">First Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($membership['firstname']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Last Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($membership['lastname']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Email:</span>
                <span class="detail-value"><?php echo htmlspecialchars($membership['email']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Login ID:</span>
                <span class="detail-value"><?php echo htmlspecialchars($membership['loginID']); ?></span>
            </div>
        </div>
        
        <div class="detail-actions">
            <a href="adminview.php?page=membership" class="back-link">Back to List</a>
        </div>
    <?php else: ?>
        <div class="error-message">
            <p>Membership not found or invalid ID.</p>
            <a href="adminview.php?page=membership" class="back-link">Back to List</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
