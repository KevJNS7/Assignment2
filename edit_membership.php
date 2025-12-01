<?php
/**
 * Filename: edit_membership.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to edit an existing membership.
 * Date: 2025
 */
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Root_Flower";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request: Missing or invalid ID");
}

$id = (int)$_GET['id'];
$membership = null;
$message = '';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $loginID = trim($_POST['loginID'] ?? '');
    $oldLoginID = trim($_POST['old_loginID'] ?? '');

    // Validate required fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($loginID)) {
        $message = "Error: All fields are required!";
    } else {
        $stmt1 = $conn->prepare("UPDATE membership SET firstname=?, lastname=?, email=?, loginID=? WHERE id=?");
        $stmt1->bind_param("ssssi", $firstname, $lastname, $email, $loginID, $id);
        $membershipUpdated = $stmt1->execute();
        $stmt1->close();

        $stmt2 = $conn->prepare("UPDATE user SET username=? WHERE username=?");
        $stmt2->bind_param("ss", $loginID, $oldLoginID);
        $userUpdated = $stmt2->execute();
        $stmt2->close();
        
        if ($membershipUpdated && $userUpdated) {
            $message = "Membership updated successfully!";
        } else {
            $message = "Error updating membership: " . $conn->error;
        }
    }
}

// Fetch current membership data
$stmt = $conn->prepare("SELECT * FROM membership WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Membership record not found");
}

$membership = $result->fetch_assoc();
$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Root Flower is a flower shop that based on Kuching, Sarawak Malaysia">
    <meta name="keywords" content="Flower, Root Flower, Kuching, Sarawak, Malaysia">
    <meta name="author" content="Kevinn Jose, Jiang Yu, Vincent, Ahmed">
    <title>Edit Membership - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="view-edit-container">
        <?php if ($membership): ?>
            <h1 class="page-title">Edit Membership</h1>
            
            <?php if ($message): ?>
                <div class="message-box <?php echo strpos($message, 'successfully') !== false ? 'message-success' : 'message-error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div class="content-card">
                <form method="POST" class="edit-form">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($membership['id']); ?>">
                    <input type="hidden" name="old_loginID" value="<?php echo htmlspecialchars($membership['loginID']); ?>">
                    
                    <fieldset>
                        <legend>Personal Information</legend>
                        
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" 
                               value="<?php echo htmlspecialchars($membership['firstname']); ?>" 
                               required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
                        
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" 
                               value="<?php echo htmlspecialchars($membership['lastname']); ?>" 
                               required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
                        
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($membership['email']); ?>" 
                               required>
                        
                        <label for="loginID">Login ID</label>
                        <input type="text" id="loginID" name="loginID" 
                               value="<?php echo htmlspecialchars($membership['loginID']); ?>" 
                               required pattern="^[A-Za-z0-9]+$" title="Letters and numbers only">
                    </fieldset>
                    
                    <div class="editform-actions">
                        <button type="submit" name="update" class="editbtn editbtn-save">Save Changes</button>
                        <a href="view_membership.php" class="editbtn editbtn-cancel">Cancel</a>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="content-card">
                <?php 
                if (empty($message)) {
                    echo "Membership not found or invalid ID.";
                } else {
                    echo htmlspecialchars($message);
                }
                ?>
            </div>
            <div class="form-actions">
                <a href="view_membership.php" class="editbtn editbtn-cancel">Back to Membership List</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
