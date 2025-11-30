<?php
/**
 * Filename: membership_process.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Process membership registration form submission.
 * Date: 2025
 */
// Include anti-spam protection
require_once 'anti_spam.php';

// Database connection
$servername = "localhost";
$username = "root";
$db_password = "";
$dbname = "Root_Flower";

$conn = mysqli_connect($servername, $username, $db_password, $dbname);

if (!$conn) {
    die("Connection failed: ". mysqli_connect_error());
}

// Server-side validation
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Error: Invalid request method.");
}

$required_fields = ["fname", "lname", "email", "loginID", "password"];
$missing_fields = [];

foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $missing_fields[] = $field;
    }
}

if (!empty($missing_fields)) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='CSS/style.css'>
        <title>Membership Registration Failed - Root Flower</title>
    </head>
    <body>
        <div class='process'>
        <div class='processcontainer'>
        <div class='processcard'>
            <h1>Membership Registration Failed</h1>
            <p>Please fill in all required fields.</p>
            <div class='button-membership-process'><a href='membership.php'>Go Back</a></div>
        </div>
        </div>
        </div>
    </body>
    </html>";
    mysqli_close($conn);
    exit();
}

// Get user identifier
$user_identifier = get_user_identifier();

// Check if user is blocked
$block_status = check_spam_block($user_identifier, $conn);
if ($block_status['blocked']) {
    display_block_message($block_status['message']);
}

// Record and check submission
$submission_status = record_submission($user_identifier, 'membership', $conn);
if (!$submission_status['allowed']) {
    display_block_message($submission_status['message']);
}

// Sanitize inputs
$firstname = mysqli_real_escape_string($conn, $_POST["fname"]);
$lastname = mysqli_real_escape_string($conn, $_POST["lname"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$loginID = mysqli_real_escape_string($conn, $_POST["loginID"]);
$password_plain = $_POST["password"];
$hasp = password_hash($password_plain, PASSWORD_BCRYPT, ["cost" => 10]);

// Insert into database
$sql = "INSERT INTO membership(firstname, lastname, email, loginID, password)
        VALUES ('$firstname', '$lastname', '$email', '$loginID', '$hasp')";

$sql2 = "INSERT INTO user(username, password)
        VALUES ('$loginID', '$password_plain')";

$success = mysqli_query($conn, $sql) && mysqli_query($conn, $sql2);

mysqli_close($conn);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Root Flower is a flower shop based in Kuching, Sarawak Malaysia">
    <meta name="keywords" content="Flower, Root Flower, Kuching, Sarawak, Malaysia">
    <meta name="author" content="Kevinn Jose, Jiang Yu, Vincent, Ahmed">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Membership Process Form - Root Flower</title>
</head>

<body>

    <div class="process">
    <div class="processcontainer">
    <div class="processcard">
    <?php if ($success): ?>
    <h1>Welcome <?php echo htmlspecialchars($firstname);?></h1> 

    <p>Your membership has been processed</p>
    <br>

    <div class="confirmation-table">
        <table>
            <tr>
                <th>Name:</th>
                <td><?php echo htmlspecialchars($firstname . " " . $lastname);?></td>
            </tr>

            <tr>
                <th>Email:</th>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>

            <tr>
                <th>Login ID:</th>
                <td><?php echo htmlspecialchars($loginID); ?></td>
            </tr>
        </table>

        <?php if (!empty($submission_status['message'])): ?>
        <p class="warning-message">
            ⚠️ <?php echo htmlspecialchars($submission_status['message']); ?>
        </p>
        <?php endif; ?>

        <div class="button-membership-process">
        <a href="index.php">Back to Website</a>
        </div>
    </div>
    <?php else: ?>
    <h1>Registration Failed</h1>
    <p>There was an error processing your membership. Please try again later.</p>
    <div class="button-membership-process">
        <a href="index.php">Back to Website</a>
    </div>
    <?php endif; ?>
    </div>
    </div>
    </div>

</body>
</html>
