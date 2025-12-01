<?php
/**
 * Filename: edit_register.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to edit an existing workshop registration.
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
        $stmt = $conn->prepare("UPDATE workshop SET
            firstname = ?,
            lastname = ?,
            email = ?,
            phone = ?,
            street = ?,
            city = ?,
            state = ?,
            postcode = ?,
            dateofbirth = ?,
            membershiptype = ?,
            interests = ?,
            participants = ?,
            comments = ?
            WHERE id = ?");
        
        $stmt->bind_param("sssssssssssssi", $firstname, $lastname, $email, $phone, $street, $city, $state, $postcode, $dateofbirth, $membershiptype, $interests, $participants, $comments, $id);
        
        if ($stmt->execute()) {
            $message = "Workshop registration updated successfully!";
        } else {
            $message = "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch current workshop data
$stmt = $conn->prepare("SELECT * FROM workshop WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("Workshop record not found");
}
$workshop = $result->fetch_assoc();
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
            <form method="POST" class="edit-form">
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
                    
                    <label for="state">State / Federal Territory</label>
                    <select id="state" name="state">
                        <option value="">-- Select State or Territory --</option>
                        <option value="Johor" <?php echo ($workshop['state'] ?? '') === 'Johor' ? 'selected' : ''; ?>>Johor</option>
                        <option value="Kedah" <?php echo ($workshop['state'] ?? '') === 'Kedah' ? 'selected' : ''; ?>>Kedah</option>
                        <option value="Kelantan" <?php echo ($workshop['state'] ?? '') === 'Kelantan' ? 'selected' : ''; ?>>Kelantan</option>
                        <option value="Melaka" <?php echo ($workshop['state'] ?? '') === 'Melaka' ? 'selected' : ''; ?>>Melaka</option>
                        <option value="Negeri Sembilan" <?php echo ($workshop['state'] ?? '') === 'Negeri Sembilan' ? 'selected' : ''; ?>>Negeri Sembilan</option>
                        <option value="Pahang" <?php echo ($workshop['state'] ?? '') === 'Pahang' ? 'selected' : ''; ?>>Pahang</option>
                        <option value="Penang" <?php echo ($workshop['state'] ?? '') === 'Penang' ? 'selected' : ''; ?>>Penang</option>
                        <option value="Perak" <?php echo ($workshop['state'] ?? '') === 'Perak' ? 'selected' : ''; ?>>Perak</option>
                        <option value="Perlis" <?php echo ($workshop['state'] ?? '') === 'Perlis' ? 'selected' : ''; ?>>Perlis</option>
                        <option value="Sabah" <?php echo ($workshop['state'] ?? '') === 'Sabah' ? 'selected' : ''; ?>>Sabah</option>
                        <option value="Sarawak" <?php echo ($workshop['state'] ?? '') === 'Sarawak' ? 'selected' : ''; ?>>Sarawak</option>
                        <option value="Selangor" <?php echo ($workshop['state'] ?? '') === 'Selangor' ? 'selected' : ''; ?>>Selangor</option>
                        <option value="Terengganu" <?php echo ($workshop['state'] ?? '') === 'Terengganu' ? 'selected' : ''; ?>>Terengganu</option>
                        <option value="Kuala Lumpur" <?php echo ($workshop['state'] ?? '') === 'Kuala Lumpur' ? 'selected' : ''; ?>>Kuala Lumpur (FT)</option>
                        <option value="Labuan" <?php echo ($workshop['state'] ?? '') === 'Labuan' ? 'selected' : ''; ?>>Labuan (FT)</option>
                        <option value="Putrajaya" <?php echo ($workshop['state'] ?? '') === 'Putrajaya' ? 'selected' : ''; ?>>Putrajaya (FT)</option>
                    </select>
                    
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
