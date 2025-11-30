<?php
/**
 * Filename: create_membership.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to create a new membership.
 * Date: 2025
 */
// Redirect if accessed directly
if (basename($_SERVER['PHP_SELF']) == 'create_membership.php' && !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: adminview.php?page=membership");
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
        'firstname', 'lastname', 'email', 'loginID', 'password'
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
        $loginID = mysqli_real_escape_string($conn, $_POST['loginID']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Insert into membership table
        $sql1 = "INSERT INTO membership (
            firstname, lastname, email, loginID, password
        ) VALUES (
            '$firstname', '$lastname', '$email', '$loginID', '$password'
        )";

        // Insert into user table
        $sql2 = "INSERT INTO user (
            username, password
        ) VALUES (
            '$loginID', '$password'
        )";

        $success1 = mysqli_query($conn, $sql1);
        $success2 = mysqli_query($conn, $sql2);

        mysqli_close($conn);

        if ($success1 && $success2) {
            header("Location: view_membership.php?success=1");
            exit();
        } else {
            $error = "Error saving membership or user.";
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
    <title>Create Membership - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="admin-page">
        <div class="page-title-row">
            <h1 class="page-title">Create New Membership</h1>
            <a href="view_membership.php" class="back-btn">← Back to List</a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="" class="enquiry-form">
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
                <label for="loginID">Login ID *</label>
                <input type="text" id="loginID" name="loginID" required pattern="^[A-Za-z0-9]+$" title="Letters and numbers only">
            </div>

            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required pattern="^[A-Za-z0-9]+$" title="Letters and numbers only">
            </div>

            <div class="form-actions">
                <button type="submit" class="submitt-btn">Save Membership</button>
                <a href="view_membership.php" class="cancell-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
