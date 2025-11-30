<?php
/**
 * Filename: edit_membership.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to edit an existing membership.
 * Date: 2025
 */
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
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Root_Flower";

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $membership = null;
    $message = '';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        $id = (int)$_POST['id'];
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $loginID = trim($_POST['loginID']);
        $oldLoginID = trim($_POST['old_loginID']); // Store old loginID to find user record

        // Validate required fields
        if (empty($firstname) || empty($lastname) || empty($email) || empty($loginID)) {
            $message = "All fields are required!";
        } else {
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                $message = "Database connection failed: " . mysqli_connect_error();
            } else {
                $firstname = mysqli_real_escape_string($conn, $firstname);
                $lastname = mysqli_real_escape_string($conn, $lastname);
                $email = mysqli_real_escape_string($conn, $email);
                $loginID = mysqli_real_escape_string($conn, $loginID);
                $oldLoginID = mysqli_real_escape_string($conn, $oldLoginID);

                $sql1 = "UPDATE membership SET firstname='$firstname', lastname='$lastname', email='$email', loginID='$loginID' WHERE id=$id";
                $membershipUpdated = mysqli_query($conn, $sql1);

                $sql2 = "UPDATE user SET username='$loginID' WHERE username='$oldLoginID'";
                $userUpdated = mysqli_query($conn, $sql2);
                
                mysqli_close($conn);
                
                if ($membershipUpdated && $userUpdated) {
                    $message = "Membership and User account updated successfully! Login ID changed to: " . htmlspecialchars($loginID);
                } elseif ($membershipUpdated) {
                    $message = "Membership updated, but User table update failed or user not found.";
                } else {
                    $message = "Error updating membership.";
                }
            }
        }
    }

    // Fetch current membership data
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        $message = "Database connection failed: " . mysqli_connect_error();
    } else {
        $sql = "SELECT id, firstname, lastname, email, loginID FROM membership WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $membership = mysqli_fetch_assoc($result);
        
        mysqli_close($conn);
    }
    ?>

    <div class="view-edit-container">
        <?php if ($membership): ?>
            <h1 class="page-title">Edit Membership</h1>
            
            <?php if ($message): ?>
                <div class="message-box <?php echo strpos($message, 'successfully') !== false ? 'message-success' : 'message-error'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <div class="content-card">
                <form method="POST" action="" class="edit-form">
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
