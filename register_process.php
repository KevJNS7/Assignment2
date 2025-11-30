<?php
/**
 * Filename: register_process.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Process workshop registration form submission.
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

$required_fields = ["fname", "lname", "email", "street", "city", "state", "postcode", "membershipType", "phone", "dob", "participants"];
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
        <title>Registration Failed - Root Flower</title>
    </head>
    <body>
        <div class='process'>
        <div class='processcontainer'>
        <div class='processcard'>
            <h1>Registration Failed</h1>
            <p>Please fill in all required fields.</p>
            <div class='button-membership-process'><a href='register.php'>Go Back</a></div>
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
$submission_status = record_submission($user_identifier, 'workshop', $conn);
if (!$submission_status['allowed']) {
    display_block_message($submission_status['message']);
}

// Sanitize inputs
$firstname = mysqli_real_escape_string($conn, $_POST["fname"]);
$lastname = mysqli_real_escape_string($conn, $_POST["lname"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$street = mysqli_real_escape_string($conn, $_POST["street"]);
$city = mysqli_real_escape_string($conn, $_POST["city"]);
$state = mysqli_real_escape_string($conn, $_POST["state"]);
$postcode = mysqli_real_escape_string($conn, $_POST["postcode"]);
$membershipType = mysqli_real_escape_string($conn, $_POST["membershipType"]);

$interests = "";
if (isset($_POST["interests"])) {
    $clean_interests = [];
    foreach ($_POST["interests"] as $val) {
        $clean_interests[] = mysqli_real_escape_string($conn, $val);
    }
    $interests = implode(", ", $clean_interests);
}

$phone = mysqli_real_escape_string($conn, $_POST["phone"]);
$dob = mysqli_real_escape_string($conn, $_POST["dob"]);
$participants = mysqli_real_escape_string($conn, $_POST["participants"]);
$comments = isset($_POST["comments"]) ? mysqli_real_escape_string($conn, $_POST["comments"]) : "";

// Insert into database
$sql = "INSERT INTO workshop (firstname, lastname, email, street, city, state, postcode, membershiptype, interests, phone, dateofbirth, participants, comments)
        VALUES ('$firstname', '$lastname', '$email', '$street', '$city', '$state', '$postcode', '$membershipType', '$interests', '$phone', '$dob', '$participants', '$comments')";

mysqli_query($conn, $sql);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Root Flower is a flower shop based in Kuching, Sarawak Malaysia">
    <meta name="keywords" content="Flower, Root Flower, Kuching, Sarawak, Malaysia">
    <meta name="author" content="Kevinn Jose, Jiang Yu, Vincent, Ahmed">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Registration Process - Root Flower</title>
</head>

<body>
    <div class="process">
    <div class="processcontainer">
    <div class="processcard">
    <?php
    // Server-side validation
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $required_fields = ["fname", "lname", "email", "street", "city", "state", "postcode", "membershipType", "phone", "dob", "participants"];
        $missing_fields = [];
        
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $missing_fields[] = $field;
            }
        }
        
        if (!empty($missing_fields)) {
            echo "<h1>Registration Failed</h1>";
            echo "<p>Please fill in all required fields.</p>";
            echo "<div class='button-membership-process'><a href='register.php'>Go Back</a></div>";
        } else {
    ?>
    <h1>Welcome <?php echo htmlspecialchars($_POST["fname"]); ?>!</h1> 

    <p>Your workshop registration has been processed successfully</p>
    <br>

    <div class="confirmation-table">
        <table>
            <tr>
                <th>Name:</th>
                <td><?php echo htmlspecialchars($_POST["fname"] . " " . $_POST["lname"]); ?></td>
            </tr>

            <tr>
                <th>Email:</th>
                <td><?php echo htmlspecialchars($_POST["email"]); ?></td>
            </tr>

            <tr>
                <th>Phone Number:</th>
                <td><?php echo htmlspecialchars($_POST["phone"]); ?></td>
            </tr>

            <tr>
                <th>Address:</th>
                <td>
                    <?php 
                    echo htmlspecialchars($_POST["street"] . ", " . 
                         $_POST["postcode"] . " " . 
                         $_POST["city"] . ", " . 
                         $_POST["state"]);
                    ?>
                </td>
            </tr>

            <tr>
                <th>Date of Birth:</th>
                <td><?php echo htmlspecialchars($_POST["dob"]); ?></td>
            </tr>

            <tr>
                <th>Membership Type:</th>
                <td><?php echo htmlspecialchars($_POST["membershipType"]); ?></td>
            </tr>

            <tr>
                <th>Interests:</th>
                <td>
                    <?php 
                    if(isset($_POST["interests"])) {
                        echo htmlspecialchars(implode(", ", $_POST["interests"]));
                    } else {
                        echo "None selected";
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th>Number of Participants:</th>
                <td><?php echo htmlspecialchars($_POST["participants"]); ?></td>
            </tr>

            <?php if (!empty($_POST["comments"])): ?>
            <tr>
                <th>Additional Comments:</th>
                <td><?php echo htmlspecialchars($_POST["comments"]); ?></td>
            </tr>
            <?php endif; ?>
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
    <?php 
        }
    } else {
        echo "<h1>Error</h1><p>Invalid request method.</p>";
    }
    ?>
    </div>
    </div>
    </div>
</body>
</html>
