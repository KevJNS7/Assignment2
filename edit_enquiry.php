<?php
/**
 * Filename: edit_enquiry.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to edit an existing enquiry.
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
$message = '';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phonenumber = trim($_POST['phonenumber'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $contact_method = trim($_POST['contact_method'] ?? '');
    $interests = trim($_POST['interests'] ?? '');
    $enquiry_type = trim($_POST['enquiry_type'] ?? '');
    $priority = trim($_POST['priority'] ?? '');
    $preferred_date = trim($_POST['preferred_date'] ?? '');
    $comments = trim($_POST['comments'] ?? '');

    // Validate required fields
    if (empty($firstname) || empty($lastname) || empty($email) || empty($enquiry_type)) {
        $message = "Error: First Name, Last Name, Email, and Enquiry Type are required";
    } else {
        $firstname = mysqli_real_escape_string($conn, $firstname);
        $lastname = mysqli_real_escape_string($conn, $lastname);
        $email = mysqli_real_escape_string($conn, $email);
        $phonenumber = mysqli_real_escape_string($conn, $phonenumber);
        $address = mysqli_real_escape_string($conn, $address);
        $city = mysqli_real_escape_string($conn, $city);
        $contact_method = mysqli_real_escape_string($conn, $contact_method);
        $interests = mysqli_real_escape_string($conn, $interests);
        $enquiry_type = mysqli_real_escape_string($conn, $enquiry_type);
        $priority = mysqli_real_escape_string($conn, $priority);
        $preferred_date = mysqli_real_escape_string($conn, $preferred_date);
        $comments = mysqli_real_escape_string($conn, $comments);

        $sql = "UPDATE enquiry SET 
            firstname = '$firstname', 
            lastname = '$lastname', 
            email = '$email', 
            phonenumber = '$phonenumber', 
            address = '$address',
            city = '$city',
            contact_method = '$contact_method',
            interests = '$interests',
            enquiry_type = '$enquiry_type', 
            priority = '$priority', 
            preferred_date = '$preferred_date', 
            comments = '$comments'
            WHERE id = $id";
        
        if (mysqli_query($conn, $sql)) {
            $message = "Enquiry updated successfully!";
        } else {
            $message = "Error updating enquiry: " . mysqli_error($conn);
        }
    }
}

// Fetch current enquiry data
$sql = "SELECT * FROM enquiry WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) !== 1) {
    die("Enquiry record not found");
}

$enquiry = mysqli_fetch_assoc($result);
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
    <title>Edit Enquiry - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

<div class="view-edit-container">
    <?php if ($enquiry): ?>
        <h1 class="page-title">Edit Enquiry</h1>
        
        <?php if ($message): ?>
            <div class="message-box <?php echo strpos($message, 'successfully') !== false ? 'message-success' : 'message-error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <div class="content-card">
            <form method="POST" action="" class="edit-form">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($enquiry['id']); ?>">
                
                <fieldset>
                    <legend>Personal Information</legend>
                    
                    <div class="form-group">
                        <label for="firstname">First Name *</label>
                        <input type="text" id="firstname" name="firstname" 
                               value="<?php echo htmlspecialchars($enquiry['firstname']); ?>" 
                               required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
                    </div>
                    
                    <div class="form-group">
                        <label for="lastname">Last Name *</label>
                        <input type="text" id="lastname" name="lastname" 
                               value="<?php echo htmlspecialchars($enquiry['lastname']); ?>" 
                               required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($enquiry['email']); ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phonenumber">Phone Number</label>
                        <input type="tel" id="phonenumber" name="phonenumber" 
                               value="<?php echo htmlspecialchars($enquiry['phonenumber']); ?>">
                    </div>
                </fieldset>
                
                <fieldset id="enq-moredetail">
                    <legend>Enquiry Details</legend>
                    
                    <div class="form-group">
                        <label for="enquiry_type">Enquiry Type *</label>
                        <select id="enquiry_type" name="enquiry_type" required>
                            <option value="">Select Enquiry Type</option>
                            <option value="General" <?php echo $enquiry['enquiry_type'] === 'General' ? 'selected' : ''; ?>>General</option>
                            <option value="Product" <?php echo $enquiry['enquiry_type'] === 'Product' ? 'selected' : ''; ?>>Product</option>
                            <option value="Workshop" <?php echo $enquiry['enquiry_type'] === 'Workshop' ? 'selected' : ''; ?>>Workshop</option>
                            <option value="Membership" <?php echo $enquiry['enquiry_type'] === 'Membership' ? 'selected' : ''; ?>>Membership</option>
                            <option value="Complaint" <?php echo $enquiry['enquiry_type'] === 'Complaint' ? 'selected' : ''; ?>>Complaint</option>
                            <option value="Other" <?php echo $enquiry['enquiry_type'] === 'Other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="priority">Priority Level</label>
                        <select id="priority" name="priority">
                            <option value="Low" <?php echo $enquiry['priority'] === 'Low' ? 'selected' : ''; ?>>Low</option>
                            <option value="Medium" <?php echo $enquiry['priority'] === 'Medium' ? 'selected' : ''; ?>>Medium</option>
                            <option value="High" <?php echo $enquiry['priority'] === 'High' ? 'selected' : ''; ?>>High</option>
                            <option value="Urgent" <?php echo $enquiry['priority'] === 'Urgent' ? 'selected' : ''; ?>>Urgent</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="preferred_date">Preferred Date</label>
                        <input type="date" id="preferred_date" name="preferred_date" 
                               value="<?php echo htmlspecialchars($enquiry['preferred_date']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="comments">Additional Comments</label>
                        <textarea id="comments" name="comments" rows="4"><?php echo htmlspecialchars($enquiry['comments']); ?></textarea>
                    </div>
                </fieldset>
                
                <div class="editform-actions">
                        <button type="submit" name="update" class="editbtn editbtn-save">Save Changes</button>
                        <a href="view_enquiry.php" class="editbtn editbtn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="content-card">
            Enquiry record not found.
        </div>
        <div class="form-actions">
            <a href="view_enquiry.php" class="editbtn btn-cancel">Back to Enquiry List</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
