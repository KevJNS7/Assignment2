<?php
/**
 * Filename: createtable.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Script to create database tables.
 * Date: 2025
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Root_Flower";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn) {
    die("Connection Failed". mysqli_connect_error());
}

$sql1 = "CREATE TABLE IF NOT EXISTS membership (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(100) NOT NULL,
    loginID VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
)";

$sqli2 = "CREATE TABLE IF NOT EXISTS workshop (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(100) NOT NULL,
    street VARCHAR(100) NOT NULL,
    city VARCHAR(25) NOT NULL,
    state TEXT,
    postcode INT(6) NOT NULL,
    membershiptype TEXT,
    interests TEXT,
    phone VARCHAR(20) NOT NULL,
    dateofbirth DATE NOT NULL,
    participants INT NOT NULL,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sqli3 = "CREATE TABLE IF NOT EXISTS enquiry (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phonenumber VARCHAR(20) NOT NULL,
    address VARCHAR(100) NOT NULL,
    city VARCHAR(50) NOT NULL,
    contact_method TEXT,
    interests TEXT,
    enquiry_type TEXT,
    preferred_date DATE NOT NULL,
    comments TEXT NOT NULL,
    priority INT NOT NULL
)";

$sqli4 = "CREATE TABLE IF NOT EXISTS user (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    profile_pic VARCHAR(255) DEFAULT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sqli5 = "CREATE TABLE IF NOT EXISTS submission_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_identifier VARCHAR(100) NOT NULL,
    form_type VARCHAR(50) NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_time (user_identifier, form_type, submitted_at)
)";

$sqli6 = "CREATE TABLE IF NOT EXISTS spam_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_identifier VARCHAR(100) NOT NULL,
    reason TEXT NOT NULL,
    blocked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    block_until DATETIME NOT NULL,
    INDEX idx_user_block (user_identifier, block_until)
)";

$sqli7 = "CREATE TABLE IF NOT EXISTS promotions (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255) NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

mysqli_query($conn, $sql1);
mysqli_query($conn, $sqli2);
mysqli_query($conn, $sqli3);
mysqli_query($conn, $sqli4);
mysqli_query($conn, $sqli5);
mysqli_query($conn, $sqli6);
mysqli_query($conn, $sqli7);
mysqli_close($conn);
?>

<?php
// Insert default data for promotions
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn) {
    $check_promo = "SELECT count(*) as count FROM promotions";
    $result_promo = mysqli_query($conn, $check_promo);
    if ($result_promo) {
        $row_promo = mysqli_fetch_assoc($result_promo);

        if ($row_promo['count'] == 0) {
            $promotions = [
                ['IMAGE/promotions1.jpg', 'Special Christmas Giveaway', 'Get a special Christmas gift! 3 Lucky Winners for Christmas Floral Workshop on 23 December 2023, 3pm-5pm. Follow our page, like and share this post, tag 3 friends in the comment.'],
                ['IMAGE/promotions2.jpg', '520 Give Away', 'Cry Baby Bouquet & Hacipupu Bouquet from Pop Mart Store. Like & Follow us, Comment & tag your 3 friends, Share this post at your story, and Verify your participation.'],
                ['IMAGE/promotions3.jpg', 'Preserved Flowers in Glass', 'Beautiful preserved flowers in elegant glass domes. Perfect gifts that last forever with our special preservation technique. Terms & Conditions Apply.'],
                ['IMAGE/promotions4.jpg', "Valentine's Day Early Bird", "14% off early bird special! Order before 30 January 2023 and get amazing discounts on all Valentine's Day bouquets. Limited time offer."],
                ['IMAGE/promotions5.jpg', "Happy Mother's Day", "10% off early birds before 30 April 2023. Show your love with beautiful bouquets for Mother's Day celebration on 14 May 2023."],
                ['IMAGE/promotions6.jpg', 'Valentine Collection 2023', "Discover our exclusive Valentine's collection with various bouquet designs. 14% off early bird and 7% off orders before 5 February 2023."]
            ];

            foreach ($promotions as $promo) {
                $img = mysqli_real_escape_string($conn, $promo[0]);
                $title = mysqli_real_escape_string($conn, $promo[1]);
                $desc = mysqli_real_escape_string($conn, $promo[2]);
                $sql_insert = "INSERT INTO promotions (image, title, description) VALUES ('$img', '$title', '$desc')";
                mysqli_query($conn, $sql_insert);
            }
        }
    }
    mysqli_close($conn);
}
?>
