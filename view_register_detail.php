<?php
/**
 * Filename: view_register_detail.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin view for customer detail workshop registration.
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
$workshop = null;


$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$id = mysqli_real_escape_string($conn, $id);
$sql = "SELECT * FROM workshop WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $workshop = mysqli_fetch_assoc($result);
} else {
    die("Workshop record not found");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Details - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

<div class="detail-container">
    <?php if ($workshop): ?>
        <div class="detail-header">
            <h1 class="detail-title">View Workshop Details</h1>
        </div>
        
        <div class="detail-content">
            <div class="detail-info">
                <span class="detail-label">ID:</span>
                <span class="detail-value"><?php echo htmlspecialchars($workshop['id']); ?></span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($workshop['firstname'] . ' ' . $workshop['lastname']); ?></span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Email:</span>
                <span class="detail-value"><?php echo htmlspecialchars($workshop['email']); ?></span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Phone Number:</span>
                <span class="detail-value"><?php echo htmlspecialchars($workshop['phone'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Address:</span>
                <span class="detail-value">
                    <?php 
                    $address = [];
                    if (!empty($workshop['street'])) $address[] = $workshop['street'];
                    if (!empty($workshop['city'])) $address[] = $workshop['city'];
                    if (!empty($workshop['state'])) $address[] = $workshop['state'];
                    echo htmlspecialchars(implode(', ', $address) ?: 'N/A');
                    ?>
                </span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Date of Birth:</span>
                <span class="detail-value"><?php echo htmlspecialchars($workshop['dateofbirth'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Membership Type:</span>
                <span class="detail-value"><?php echo htmlspecialchars($workshop['membershiptype'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Interests:</span>
                <span class="detail-value"><?php echo !empty($workshop['interests']) ? htmlspecialchars($workshop['interests']) : 'none'; ?></span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Number of Participants:</span>
                <span class="detail-value"><?php echo htmlspecialchars($workshop['participants'] ?? 'N/A'); ?></span>
            </div>
            <div class="detail-info">
                <span class="detail-label">Additional Comments:</span>
                <span class="detail-value"><?php echo !empty($workshop['comments']) ? htmlspecialchars($workshop['comments']) : 'none'; ?></span>
            </div>
        </div>
        
        <div class="detail-actions">
            <a href="adminview.php?page=workshop" class="back-link">Back to List</a>
        </div>
    <?php else: ?>
        <div class="error-message">
            <p>Workshop record not found.</p>
            <a href="adminview.php?page=workshop" class="back-link">Back to List</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
