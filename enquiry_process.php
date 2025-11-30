<?php
/**
 * Filename: enquiry_process.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Process enquiry form submission.
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

$required_fields = ["firstname", "lastname", "email", "phonenumber", "address", "city", "contactMethod", "enquiryType", "preferredDate", "priority"];
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
        <title>Enquiry Failed - Root Flower</title>
    </head>
    <body>
        <div class='process'>
        <div class='processcontainer'>
        <div class='processcard'>
            <h1>Enquiry Submission Failed</h1>
            <p>Please fill in all required fields.</p>
            <div class='button-membership-process'><a href='enquiry.php'>Go Back</a></div>
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
$submission_status = record_submission($user_identifier, 'enquiry', $conn);
if (!$submission_status['allowed']) {
    display_block_message($submission_status['message']);
}

// Sanitize inputs
$firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
$lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
$email = mysqli_real_escape_string($conn, $_POST["email"]);
$phonenumber = mysqli_real_escape_string($conn, $_POST["phonenumber"]);
$address = mysqli_real_escape_string($conn, $_POST["address"]);
$city = mysqli_real_escape_string($conn, $_POST["city"]);
$contact_method = mysqli_real_escape_string($conn, $_POST["contactMethod"]);

$interests = "";
if (isset($_POST["interests"])) {
    $clean_interests = [];
    foreach ($_POST["interests"] as $val) {
        $clean_interests[] = mysqli_real_escape_string($conn, $val);
    }
    $interests = implode(", ", $clean_interests);
}

$enquiry_type = mysqli_real_escape_string($conn, $_POST["enquiryType"]);
$preferred_date = mysqli_real_escape_string($conn, $_POST["preferredDate"]);
$comments = isset($_POST["comments"]) ? mysqli_real_escape_string($conn, $_POST["comments"]) : "";
$priority = mysqli_real_escape_string($conn, $_POST["priority"]);

// Insert into database
$sql = "INSERT INTO enquiry (firstname, lastname, email, phonenumber, address, city, contact_method, interests, enquiry_type, preferred_date, comments, priority)
        VALUES ('$firstname', '$lastname', '$email', '$phonenumber', '$address', '$city', '$contact_method', '$interests', '$enquiry_type', '$preferred_date', '$comments', '$priority')";

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
    <title>Enquiry Process - Root Flower</title>
</head>

<body>

    <div class="process">
    <div class="processcontainer">
    <div class="processcard">
    <h1>Thank You <?php echo htmlspecialchars($_POST["firstname"]); ?>!</h1> 

    <p>Your enquiry has been submitted successfully</p>
    <br>

    <div class="confirmation-table">
        <table>
            <tr>
                <th>Name:</th>
                <td><?php echo htmlspecialchars($_POST["firstname"] . " " . $_POST["lastname"]); ?></td>
            </tr>

            <tr>
                <th>Email:</th>
                <td><?php echo htmlspecialchars($_POST["email"]); ?></td>
            </tr>

            <tr>
                <th>Phone Number:</th>
                <td><?php echo htmlspecialchars($_POST["phonenumber"]); ?></td>
            </tr>

            <tr>
                <th>Address:</th>
                <td><?php echo htmlspecialchars($_POST["address"]); ?></td>
            </tr>

            <tr>
                <th>City:</th>
                <td><?php echo htmlspecialchars($_POST["city"]); ?></td>
            </tr>

            <tr>
                <th>Preferred Contact Method:</th>
                <td><?php echo htmlspecialchars($_POST["contactMethod"]); ?></td>
            </tr>

            <tr>
                <th>Services Interested In:</th>
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
                <th>Type of Enquiry:</th>
                <td><?php echo htmlspecialchars($_POST["enquiryType"]); ?></td>
            </tr>

            <tr>
                <th>Preferred Contact Date:</th>
                <td><?php echo htmlspecialchars($_POST["preferredDate"]); ?></td>
            </tr>

            <tr>
                <th>Enquiry Priority:</th>
                <td><?php echo htmlspecialchars($_POST["priority"]) . "/5"; ?></td>
            </tr>

            <tr>
                <th>Your Message:</th>
                <td><?php echo !empty($_POST["comments"]) ? htmlspecialchars($_POST["comments"]) : 'N/A'; ?></td>
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
    </div>
    </div>
    </div>

</body>
</html>
