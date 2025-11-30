<?php
/**
 * Filename: edit_register.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to edit an existing workshop registration.
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
$message = '';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $postcode = trim($_POST['postcode'] ?? '');
    $dateofbirth = trim($_POST['dateofbirth'] ?? '');
    $loginID = trim($_POST['loginID'] ?? '');
    $membershiptype = trim($_POST['membershiptype'] ?? '');
    $interests = trim($_POST['interests'] ?? '');
    $participants = trim($_POST['participants'] ?? '');
    $comments = trim($_POST['comments'] ?? '');


    if (empty($firstname) || empty($lastname) || empty($email)) {
        $message = "Error: Name and Email are required";
    } else {
        $firstname = mysqli_real_escape_string($conn, $firstname);
        $lastname = mysqli_real_escape_string($conn, $lastname);
        $email = mysqli_real_escape_string($conn, $email);
        $phone = mysqli_real_escape_string($conn, $phone);
        $street = mysqli_real_escape_string($conn, $street);
        $city = mysqli_real_escape_string($conn, $city);
        $state = mysqli_real_escape_string($conn, $state);
        $postcode = mysqli_real_escape_string($conn, $postcode);
        $dateofbirth = mysqli_real_escape_string($conn, $dateofbirth);
        $membershiptype = mysqli_real_escape_string($conn, $membershiptype);
        $interests = mysqli_real_escape_string($conn, $interests);
        $participants = mysqli_real_escape_string($conn, $participants);
        $comments = mysqli_real_escape_string($conn, $comments);

        $sql = "UPDATE workshop SET
            firstname = '$firstname',
            lastname = '$lastname',
            email = '$email',
            phone = '$phone',
            street = '$street',
            city = '$city',
            state = '$state',
            postcode = '$postcode',
            dateofbirth = '$dateofbirth',
            membershiptype = '$membershiptype',
            interests = '$interests',
            participants = '$participants',
            comments = '$comments'
            WHERE id = $id";
        
        if (mysqli_query($conn, $sql)) {
            $message = "Workshop registration updated successfully!";
        } else {
            $message = "Error updating record: " . mysqli_error($conn);
        }
    }
}

// Fetch current workshop data
$sql = "SELECT * FROM workshop WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) !== 1) {
    die("Workshop record not found");
}
$workshop = mysqli_fetch_assoc($result);
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
    <title>Edit Workshop Registration - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

<div class="view-edit-container">
    <?php if ($workshop): ?>
        <h1 class="page-title">Edit Workshop Registration</h1>
        
        <?php if ($message): ?>
            <div class="message-box <?php echo strpos($message, 'successfully') !== false ? 'message-success' : 'message-error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <div class="content-card">
            <form method="POST" action="" class="edit-form">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($workshop['id']); ?>">
                
                <fieldset>
                    <legend>Personal Information</legend>
                    
                    <label for="firstname">First Name *</label>
                    <input type="text" id="firstname" name="firstname" 
                           value="<?php echo htmlspecialchars($workshop['firstname']); ?>" 
                           required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
                    
                    <label for="lastname">Last Name *</label>
                    <input type="text" id="lastname" name="lastname" 
                           value="<?php echo htmlspecialchars($workshop['lastname']); ?>" 
                           required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
                    
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($workshop['email']); ?>" 
                           required>
                    
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?php echo htmlspecialchars($workshop['phone'] ?? ''); ?>">
                    
                    <label for="street">Street</label>
                    <input type="text" id="street" name="street" 
                           value="<?php echo htmlspecialchars($workshop['street'] ?? ''); ?>">
                    
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" 
                           value="<?php echo htmlspecialchars($workshop['city'] ?? ''); ?>"
                           pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
                    
                    <label for="state">State</label>
                    <input type="text" id="state" name="state" 
                           value="<?php echo htmlspecialchars($workshop['state'] ?? ''); ?>">
                    
                          <label for="dateofbirth">Date of Birth</label>
                          <input type="date" id="dateofbirth" name="dateofbirth" 
                              value="<?php echo htmlspecialchars($workshop['dateofbirth'] ?? ''); ?>">
                </fieldset>
                
                <fieldset>
                    <legend>Account & Workshop Details</legend>
                    
                    
                    <label for="membershiptype">Membership Type</label>
                    <input type="text" id="membershiptype" name="membershiptype" 
                            value="<?php echo htmlspecialchars($workshop['membershiptype'] ?? ''); ?>">
                    
                    <label for="interests">Interests</label>
                    <input type="text" id="interests" name="interests" 
                           value="<?php echo htmlspecialchars($workshop['interests'] ?? ''); ?>">
                    
                    <label for="participants">Number of Participants</label>
                    <input type="number" id="participants" name="participants" min="1" 
                           value="<?php echo htmlspecialchars($workshop['participants'] ?? 1); ?>">
                    
                    <label for="comments">Additional Comments</label>
                    <textarea id="comments" name="comments" rows="4"><?php echo htmlspecialchars($workshop['comments'] ?? ''); ?></textarea>
                </fieldset>
                
                <div class="editform-actions">
                    <button type="submit" class="editbtn editbtn-save">Save Changes</button>
                    <a href="view_register.php" class="editbtn editbtn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    <?php else: ?>
        <div class="content-card">
            Workshop record not found.
        </div>
        <div class="form-actions">
            <a href="view_register.php" class="editbtn editbtn-cancel">Back to Workshop List</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
