<?php
/**
 * Filename: view_enquiry_detail.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin view for detail customer enquiries.
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
$enquiry = null;

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = mysqli_real_escape_string($conn, $id);
$sql = "SELECT * FROM enquiry WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $enquiry = mysqli_fetch_assoc($result);
} else {
    die("Enquiry record not found");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Details - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

<div class="detail-container">
    <?php if ($enquiry): ?>
        <div class="detail-header">
            <h1 class="detail-title">Enquiry Details</h1>
        </div>
        
        <div class="detail-content">
            <div class="detail-info">
                <span class="detail-label">ID:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['id']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">First Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['firstname']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Last Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['lastname']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Email:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['email']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Phone Number:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['phonenumber']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Enquiry Type:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['enquiry_type']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Priority Level:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['priority']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Preferred Date:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['preferred_date']); ?></span>
            </div>
            
            <div class="detail-info">
                <span class="detail-label">Additional Comments:</span>
                <span class="detail-value"><?php echo htmlspecialchars($enquiry['comments']); ?></span>
            </div>
        
        <div class="detail-actions">
            <a href="adminview.php?page=enquiry" class="back-link">Back to List</a>
        </div>
    <?php else: ?>
        <div class="error-message">
            <p>Enquiry not found or invalid ID.</p>
            <a href="adminview.php?page=enquiry" class="back-link">Back to List</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
