<?php
/**
 * Filename: register.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Registration page for workshops.
 * Date: 2025
 */
session_start();

$userData = null;
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Root_Flower";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Automatic fill the form if user already login
    if ($conn) {
        $loginID = mysqli_real_escape_string($conn, $_SESSION['username']);
        $sql = "SELECT firstname, lastname, email FROM membership WHERE loginID = '$loginID'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_assoc($result);
        }
        mysqli_close($conn);
    }
}
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
    <title>Register Form - Root Flower</title>
</head>
<body>
<!-- Navigation bar -->
    <?php include("INCLUDE/navigation.php"); ?>

    <main class="workshop-reg-container">
    <section class="workshop-regiseration">
        <h1>Register for Our Workshop</h1>
        <p>Fill out the form below to reserve your spot.</p>
    </section>

    <div>
         <form id="worksho_details" method="post" action="register_process.php">

            <!-- Personal Info -->
            <fieldset>
                <legend>Personal Information</legend>

                <!-- First name (text) -->
                <label for="fname">First name:</label>
                <input
                id="fname"
                name="fname"
                type="text"
                maxlength="25"
                pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]{1,25}$"
                title="Letters, spaces, apostrophes and hyphens only (max 25 chars)"
                required
                placeholder="e.g. Ahmad"
                value="<?php echo $userData ? htmlspecialchars($userData['firstname']) : ''; ?>"
                >

                <!-- Last name (text) -->
                <label for="lname">Last name:</label>
                <input
                id="lname"
                name="lname"
                type="text"
                maxlength="25"
                pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]{1,25}$"
                title="Letters, spaces, apostrophes and hyphens only (max 25 chars)"
                required
                placeholder="e.g. Hassan"
                value="<?php echo $userData ? htmlspecialchars($userData['lastname']) : ''; ?>"
                >

                <!-- Email (email type) -->
                <label for="email">Email address:</label>
                <input
                id="email"
                name="email"
                type="email"
                required
                placeholder="you@example.com"
                value="<?php echo $userData ? htmlspecialchars($userData['email']) : ''; ?>"
                >
            </fieldset>

            <!-- Address -->
            <fieldset>
                <legend>Address</legend>

                <label for="street">Street address:</label>
                <input
                id="street"
                name="street"
                type="text"
                maxlength="40"
                required
                placeholder="Street, unit, building">

                <label for="city">City / Town:</label>
                <input
                id="city"
                name="city"
                type="text"
                maxlength="20"
                pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$"
                title="Letters, spaces, apostrophes and hyphens only"
                required
                placeholder="Kuching">

                <label for="state">State / Federal Territory:</label>
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

                <label for="postcode">Postcode:</label>
                <input
                id="postcode"
                name="postcode"
                type="text"
                pattern="^\d{5}$"
                maxlength="6"
                required
                placeholder="e.g. 93000">
            </fieldset>

            <!--  Preferences (radio, checkbox) -->
            <fieldset>
                <legend>Preferences</legend>

                <!-- Radio (membership type) -->
                <label>Membership Type:</label>
                <div class="workshop-radio">
                <label><input type="radio" name="membershipType" value="standard" id="standard" required> Standard</label>
                <label><input type="radio" name="membershipType" value="premium" id="premium"> Premium</label>
                </div>

                <!-- Checkbox group (interests) -->
                <label>Interests:</label>
                <div class="workshop-check">
                <label><input type="checkbox" name="interests[]" value="products" id="products"> Products</label>
                <label><input type="checkbox" name="interests[]" value="workshops" id="workshops"> Workshops</label>
                <label><input type="checkbox" name="interests[]" value="promotions" id="promotions"> Promotions</label>
                </div>
            </fieldset>


            <!-- Contact Info -->
            <fieldset>
                <legend>Contact & Extra</legend>

                <!-- Phone -->
                <label for="phone">Phone number:</label>
                <input
                id="phone"
                name="phone"
                type="tel"
                pattern="[0-9]+"
                maxlength="20"
                required
                placeholder="e.g. 0123456789">

                <!-- Date -->
                <label for="dob">Date of birth *</label>
                <input id="dob" name="dob" type="date" required>

                <!-- Number (participants) -->
                <label for="participants">Number of participants:</label>
                <input
                id="participants"
                name="participants"
                type="number"
                min="1"
                max="99"
                required
                placeholder="1">
            </fieldset>

            <!-- Comments -->
            <fieldset>
                <legend>Additional Comments</legend>
                <textarea id="comments" name="comments" rows="4" cols="50" placeholder="Any special requests or notes..."></textarea>
            </fieldset>

            <div class="button-group-enquiry">        
                <button type="submit">SEND WORKSHOP</button>
                <button type="reset" class="clear-btn">Reset Form</button>
            </div>

        </form>
    </div>
    </main>

<!-- Footer  -->
    <?php include("INCLUDE/footer.php"); ?>
    <?php include("INCLUDE/profileicon.php"); ?>
</body>
</html>

