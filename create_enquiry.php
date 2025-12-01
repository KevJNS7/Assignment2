<?php
/**
 * Filename: create_enquiry.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to create a new enquiry.
 * Date: 2025
 */
// Redirect if accessed directly
if (basename($_SERVER['PHP_SELF']) == 'create_enquiry.php' && !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: adminview.php?page=enquiry");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Root_Flower";

$success = false;
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requiredFields = [
        'firstname', 'lastname', 'email', 'phonenumber',
        'enquiry_type', 'priority', 'preferred_date', 'comments'
    ];
    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        $error = "Please fill in all required fields: " . implode(', ', $missingFields);
    } else {
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Sanitize inputs
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
        $enquiry_type = mysqli_real_escape_string($conn, $_POST['enquiry_type']);
        $priority = mysqli_real_escape_string($conn, $_POST['priority']);
        $preferred_date = mysqli_real_escape_string($conn, $_POST['preferred_date']);
        $comments = mysqli_real_escape_string($conn, $_POST['comments']);

        // Insert into database
        $sql = "INSERT INTO enquiry (
            firstname, lastname, email, phonenumber,
            enquiry_type, priority, preferred_date, comments
        ) VALUES (
            '$firstname', '$lastname', '$email', '$phonenumber',
            '$enquiry_type', '$priority', '$preferred_date', '$comments'
        )";

        if (mysqli_query($conn, $sql)) {
            $success = true;
        } else {
            $error = "Error saving enquiry: " . mysqli_error($conn);
        }

        mysqli_close($conn);

        // Redirect after successful submission to prevent resubmission
        if ($success) {
            header("Location: view_enquiry.php?success=1");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Root Flower is a flower shop that based on Kuching, Sarawak Malaysia">
    <meta name="keywords" content="Flower, Root Flower, Kuching, Sarawak, Malaysia">
    <meta name="author" content="Kevinn Jose, Jiang Yu, Vincent, Ahmed">
    <title>Create Enquiry - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="admin-page">
        <div class="page-title-row">
            <h1 class="page-title">Create New Enquiry</h1>
            <a href="view_enquiry.php" class="back-btn">Back to List</a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" class="create-form-admin">
            <div class="form-group">
                <label for="firstname">First Name *</label>
                <input type="text" id="firstname" name="firstname" required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
                </div>

            <div class="form-group">
                <label for="lastname">Last Name *</label>
                <input type="text" id="lastname" name="lastname" required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="address">Address *</label>
                <input type="text" id="address" name="address" required>
            </div>

             <div class="form-group">
                <label for="city">City *</label>
                <input type="text" id="city" name="city" required>
            </div>

            <div class="form-group">
                <label for="phonenumber">Phone Number *</label>
                <input type="tel" id="phonenumber" name="phonenumber" required>
            </div>

            <div class="form-group">
                <label for="enquiry_type">Enquiry Type *</label>
                <select id="enquiry_type" name="enquiry_type" required>
                    <option value="">Select Enquiry Type</option>
                    <option value="general">General</option>
                    <option value="product">Product</option>
                    <option value="workshop">Workshop</option>
                    <option value="membership">Membership</option>
                    <option value="complaint">Complaint</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="priority">Priority *</label>
                <select id="priority" name="priority" required>
                    <option value="">Select Priority</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </div>

            <div class="form-group">
                <label for="preferred_date">Preferred Date *</label>
                <input type="date" id="preferred_date" name="preferred_date" required>
            </div>

            <div class="form-group">
                <label for="comments">Message *</label>
                <textarea id="comments" name="comments" rows="4" required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submitt-btn">Save Enquiry</button>
                <a href="view_enquiry.php" class="cancell-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
