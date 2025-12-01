<?php
/**
 * Filename: create_register.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Admin page to create a new workshop registration.
 * Date: 2025
 */
// Redirect if accessed directly
if (basename($_SERVER['PHP_SELF']) == 'create_register.php' && !isset($_SERVER['HTTP_REFERER'])) {
    header("Location: adminview.php?page=register");
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
        'firstname', 'lastname', 'email', 'street', 'city', 
        'state', 'postcode', 'phone', 'dob', 'participants'
    ];
    $missingFields = [];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    // Check at least one membership is selected
    if (empty($_POST['membershipType'])) {
        $missingFields[] = 'membershipType';
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
        $street = mysqli_real_escape_string($conn, $_POST['street']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $state = mysqli_real_escape_string($conn, $_POST['state']);
        $postcode = mysqli_real_escape_string($conn, $_POST['postcode']);
        $membershipType = mysqli_real_escape_string($conn, $_POST['membershipType']);
        
        $interests = "";
        if (isset($_POST['interests'])) {
            $clean_interests = [];
            foreach ($_POST['interests'] as $val) {
                $clean_interests[] = mysqli_real_escape_string($conn, $val);
            }
            $interests = implode(',', $clean_interests);
        }

        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $participants = mysqli_real_escape_string($conn, $_POST['participants']);
        $comments = mysqli_real_escape_string($conn, $_POST['comments']);

        // Insert into database
        $sql = "INSERT INTO workshop (
            firstname, lastname, email, street, city, state, postcode,
            membershiptype, interests, phone, dateofbirth, participants, comments
        ) VALUES (
            '$firstname', '$lastname', '$email', '$street', '$city', '$state', '$postcode',
            '$membershipType', '$interests', '$phone', '$dob', '$participants', '$comments'
        )";

        if (mysqli_query($conn, $sql)) {
            $success = true;
        } else {
            $error = "Error saving registration: " . mysqli_error($conn);
        }

        mysqli_close($conn);

        // Redirect after successful submission to prevent resubmission
        if ($success) {
            header("Location: view_register.php?success=1");
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
    <title>Create Registration - Root & Flower</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="admin-page">
        <div class="page-title-row">
            <h1 class="page-title">Create New Registration</h1>
            <a href="view_register.php" class="back-btn">Back to List</a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" class="create-form-admin">
            <!-- Personal Info -->
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

            <!-- Address -->
            <div class="form-group">
                <label for="street">Street Address *</label>
                <input type="text" id="street" name="street" required>
            </div>

            <div class="form-group">
                <label for="city">City / Town *</label>
                <input type="text" id="city" name="city" required pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" title="Letters, spaces, apostrophes and hyphens only">
            </div>

            <div class="form-group">
                <label for="state">State / Federal Territory *</label>
                <select id="state" name="state" required>
                    <option value="">-- Select State or Territory --</option>
                    <option value="Johor">Johor</option>
                    <option value="Kedah">Kedah</option>
                    <option value="Kelantan">Kelantan</option>
                    <option value="Melaka">Melaka</option>
                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                    <option value="Pahang">Pahang</option>
                    <option value="Penang">Penang</option>
                    <option value="Perak">Perak</option>
                    <option value="Perlis">Perlis</option>
                    <option value="Sabah">Sabah</option>
                    <option value="Sarawak">Sarawak</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Terengganu">Terengganu</option>
                    <option value="Kuala Lumpur">Kuala Lumpur (FT)</option>
                    <option value="Labuan">Labuan (FT)</option>
                    <option value="Putrajaya">Putrajaya (FT)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="postcode">Postcode *</label>
                <input
                    id="postcode"
                    name="postcode"
                    type="text"
                    pattern="^\d{5}$"
                    maxlength="6"
                    required
                    placeholder="e.g. 93000">
            </div>

            <!-- Membership Type -->
            <fieldset class="form-group">
                <legend>Membership Type *</legend>
                <div class="workshop-radio">
                    <label><input type="radio" name="membershipType" value="standard" id="standard" required> Standard</label>
                    <label><input type="radio" name="membershipType" value="premium" id="premium"> Premium</label>
                </div>
            </fieldset>

            <!-- Interests -->
            <fieldset class="form-group">
                <legend>Interests</legend>
                <div class="workshop-check">
                    <label><input type="checkbox" name="interests[]" value="products" id="products"> Products</label>
                    <label><input type="checkbox" name="interests[]" value="workshops" id="workshops"> Workshops</label>
                    <label><input type="checkbox" name="interests[]" value="promotions" id="promotions"> Promotions</label>
                </div>
            </fieldset>

            <!-- Contact Info -->
            <div class="form-group">
                <label for="phone">Phone Number *</label>
                <input
                    id="phone"
                    name="phone"
                    type="tel"
                    pattern="[0-9]+"
                    maxlength="20"
                    required
                    placeholder="e.g. 0123456789">
            </div>
               
            <div class="form-group">
                <label for="dob">Date of Birth *</label>
                <input id="dob" name="dob" type="date" required>
            </div>

            <div class="form-group">
                <label for="participants">Number of Participants *</label>
                <input
                    id="participants"
                    name="participants"
                    type="number"
                    min="1"
                    max="99"
                    required
                    placeholder="1">
            </div>

            <div class="form-group">
                <label for="comments">Additional Comments</label>
                <textarea id="comments" name="comments" rows="4" cols="50" placeholder="Any special requests or notes..."></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submitt-btn">Save Registration</button>
                <a href="view_register.php" class="cancell-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
