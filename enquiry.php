<?php
/**
 * Filename: enquiry.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Customer enquiry form page.
 * Date: 2025
 */
session_start();

// Get user data if logged in
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
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Root Flower is a flower shop based in Kuching, Sarawak Malaysia">
    <meta name="keywords" content="Flower, Root Flower, Kuching, Sarawak, Malaysia">
    <meta name="author" content="Kevinn Jose, Jiang Yu, Vincent, Ahmed">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Enquiry Form - Root Flower</title>
</head>
<body>

<!-- Navigation bar -->
    <?php include("INCLUDE/navigation.php"); ?>

    <main class="enquiry-reg-container">
    <section class="enquiry-reg">
        <h1>Customer Enquiry Form</h1>
        <p>Complete this form to get information about our services.</p>
    </section>

    <div class="enquiryform">
        <form id="enquiry-detail" method="post" action="enquiry_process.php">
        <div class="enquiry-form-container">
        <!-- Personal Information Fieldset -->
        <fieldset class="form-fieldset">
            <legend>Personal Information</legend>
            
            <div class="form-row">
                <div class="form-group">
                    <label for ="firstname">First Name:</label>
	                <input type="text" 
	                id="firstname"
					name="firstname"
					required
					maxlength="25"
					pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" 
					title="Letters, spaces, apostrophes and hyphens only"
					value="<?php echo $userData ? htmlspecialchars($userData['firstname']) : ''; ?>"
					<?php echo $userData ? 'readonly' : ''; ?>>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" 
					id="lastname"
					name="lastname"
					required
					maxlength="25"
					pattern="^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$" 
					title="Letters, spaces, apostrophes and hyphens only"
					value="<?php echo $userData ? htmlspecialchars($userData['lastname']) : ''; ?>"
					<?php echo $userData ? 'readonly' : ''; ?>>            
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" 
					id="email"
					name="email"
					required
					placeholder="xxxxxxxxxxxx@gmail.com"
					value="<?php echo $userData ? htmlspecialchars($userData['email']) : ''; ?>"
					<?php echo $userData ? 'readonly' : ''; ?>>
		   
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" 
	                id="phone"
					name="phonenumber"
					required
                    pattern="[0-9]{10}"
					maxlength="10"
					placeholder="0123456789">     
            </div>
            </div>
	
            <div class="form-row">
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" 
                        id="address"
                        name="address"
                        required
                        maxlength="100"
                        placeholder="Your full address">
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" 
                        id="city"
                        name="city"
                        required
                        maxlength="50"
                        pattern="[A-Za-z ]+"
                        placeholder="Your city">
                </div>
            </div>
        </fieldset>

        <!-- Enquiry Details Fieldset -->
        <fieldset class="form-fieldset">
            <legend>Enquiry Details</legend>
            
            <div class="form-group">
                <label>Preferred Contact Method:</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="contactMethod" value="email" required> Email
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="contactMethod" value="phone"> Phone Call
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="contactMethod" value="whatsapp"> WhatsApp
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Services You're Interested In:</label>
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="interests[]" value="delivery"> Products
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="interests[]" value="custom"> Custom Arrangements
                    </label>
                    <label class="checkbox-label">
                        <input type="checkbox" name="interests[]" value="workshops"> Flower Workshops
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="enquiryType">Type of Enquiry:</label>
                <select id="enquiryType" name="enquiryType" required class="form-select">
                    <option value="" disabled selected>Select an option</option>
                    <option value="products">Product Information</option>
                    <option value="pricing">Pricing & Discounts</option>
                    <option value="membership">Membership Benefits</option>
                    <option value="workshop">Workshop Schedules</option>
                    <option value="complaint">Complaint</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="preferredDate">Preferred Contact Date:</label>
                <input type="date" 
                    id="preferredDate"
                    name="preferredDate"
                    required
                    min="2025-01-01">
            </div>

            <div class="form-group">
                <label for="comments">Your Message:</label>
                <textarea id="comments" name="comments" rows="4" 
                        placeholder="Describe your enquiry..." 
                        required
                        minlength="10"
                        maxlength="500"
                        title="Please enter at least 10 characters"></textarea>
            </div>
			
			<div class="form-group">
                    <label for="priority">Enquiry Priority:</label>
                    <input type="range" id="priority" name="priority" 
                           min="1" max="5" value="3">
                    <div class="priority-level">
                        <span>Low</span>
                        <span>High</span>
                    </div>
            </div>
        </fieldset>

        <fieldset class="form-fieldset">
            <legend>Verification</legend>
            
            <div class="form-group captcha-group">
                <img src="IMAGE/captcha.png" alt="Captcha: 64 5BA" class="captcha-img">
                <input type="text" id="captcha" name="captcha" 
                       placeholder="Enter captcha" 
                       required
                       pattern="645BA"
                       title="Enter 'captcha' code as shown in the image">
            </div>

            <div class="form-group checkbox-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" required> 
                    I confirm that the information provided is accurate
                </label>
            </div>
        </fieldset>

        <div class="button-group-enquiry">        
            <button type="submit">SEND ENQUIRY</button>
            <button type="reset" class="clear-btn">Reset Form</button>
        </div>
        </div>
    </form>
</div>
</main>

<!-- Footer  -->
<?php include("INCLUDE/footer.php"); ?>

<?php include("INCLUDE/profileicon.php"); ?>
</body>
</html>

