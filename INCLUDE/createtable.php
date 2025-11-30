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
    participants INT(4) NOT NULL,
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sqli4b = "CREATE TABLE IF NOT EXISTS admin (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
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

$sqli8 = "CREATE TABLE IF NOT EXISTS products (
    id INT(6) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    type VARCHAR(50) NOT NULL,
    delivery VARCHAR(100) NOT NULL,
    current_price VARCHAR(20) NOT NULL,
    original_price VARCHAR(20) NOT NULL,
    discount VARCHAR(10) NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_name (name)
)";

mysqli_query($conn, $sql1);
mysqli_query($conn, $sqli2);
mysqli_query($conn, $sqli3);
mysqli_query($conn, $sqli4);
mysqli_query($conn, $sqli4b);
mysqli_query($conn, $sqli5);
mysqli_query($conn, $sqli6);
mysqli_query($conn, $sqli7);
mysqli_query($conn, $sqli8);

mysqli_close($conn);
?>

<?php
// Insert default admin
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn) {
    $check_admin = mysqli_query($conn, "SELECT id FROM admin LIMIT 1");
    if (mysqli_num_rows($check_admin) == 0) {
        $admin_username = 'Admin';
        $admin_password = 'Admin';
        $insert_admin = "INSERT INTO admin (username, password) VALUES ('$admin_username', '$admin_password')";
        mysqli_query($conn, $insert_admin);
    }
    mysqli_close($conn);
}
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

<?php
// Insert default data for products
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn) {
    $check_products = "SELECT count(*) as count FROM products";
    $result_products = mysqli_query($conn, $check_products);
    if ($result_products) {
        $row_products = mysqli_fetch_assoc($result_products);

        if ($row_products['count'] == 0) {
            $products = [
                ['Mix Flowers Bouquet', 'IMAGE/hb1.jpg', 'Mix Handtied Flowers Bouquet with premium fresh flowers', 'Premium flowers', 'Same day available', 'RM42.75', 'RM45.00', '-5%', 'Handtied-Bouquet'],
                ['Bridal Bouquet', 'IMAGE/hb2.jpg', 'Bridal ROM Bouquet with premium flowers', 'Premium flowers', 'Same day available', 'RM47.50', 'RM50.00', '5%', 'Handtied-Bouquet'],
                ['Roses Bouquet', 'IMAGE/hb3.jpg', 'Roses Bouquet with premium roses', 'Premium roses', 'Same day available', 'RM45.60', 'RM48.00', '5%', 'Handtied-Bouquet'],
                ['Gerbera Mix', 'IMAGE/hb4.jpg', 'Gerbera Mix Bouquet with premium daisy', 'Premium daisy', 'Same day available', 'RM39.90', 'RM42.00', '5%', 'Handtied-Bouquet'],
                ['Soap Roses Bouquet', 'IMAGE/hb5.jpg', 'Soap Roses Bouquet with premium roses', 'Premium roses', 'Same day available', 'RM38.00', 'RM40.00', '5%', 'Handtied-Bouquet'],
                ['Bridal Bouquet', 'IMAGE/hb6.jpg', 'Bridal ROM Bouquet with premium flowers', 'Premium flowers', 'Same day available', 'RM46.55', 'RM49.00', '5%', 'Handtied-Bouquet'],
                ['Cry Baby Bouquet', 'IMAGE/hb7.jpg', 'Cry Baby Bouquet with premium flowers', 'Premium flowers', 'Same day available', 'RM44.65', 'RM47.00', '5%', 'Handtied-Bouquet'],
                ['Sunflower Bouquet', 'IMAGE/hb8.jpg', 'Sunflower Bouquet with premium sunflowers', 'Premium sunflowers', 'Same day available', 'RM40.85', 'RM43.00', '-5%', 'Handtied-Bouquet'],
                
                ['CNY Flowers', 'IMAGE/cny1.jpg', 'CNY Flowers with premium FLOWER', 'Premium flowers', 'Same day available', 'RM59.85', 'RM63.00', '5%', 'CNY-Flowers'],
                ['CNY Flowers', 'IMAGE/cny2.jpg', 'CNY Flowers with premium flowers', 'Premium flowers', 'Same day available', 'RM52.25', 'RM55.00', '5%', 'CNY-Flowers'],
                ['CNY Flowers', 'IMAGE/cny3.jpg', 'CNY flowers with premium flowers', 'Premium flowers', 'Same day available', 'RM66.50', 'RM70.00', '5%', 'CNY-Flowers'],
                ['CNY Flowers', 'IMAGE/cny4.jpg', 'CNY flowers with premium flowers', 'Premium flowers', 'Same day available', 'RM52.50', 'RM55.00', '5%', 'CNY-Flowers'],
                ['CNY Flowers', 'IMAGE/cny5.jpg', 'CNY Flowers with premium flowers', 'Premium flowers', 'Same day available', 'RM61.75', 'RM65.00', '5%', 'CNY-Flowers'],
                ['CNY Flowers', 'IMAGE/cny6.jpg', 'CNY Flowers with premium flowers', 'Premium flowers', 'Same day available', 'RM52.75', 'RM55.50', '5%', 'CNY-Flowers'],
                ['CNY Flowers', 'IMAGE/cny7.jpg', 'CNY Flowers with premium flowers', 'Premium flowers', 'Same day available', 'RM42.75', 'RM45.00', '5%', 'CNY-Flowers'],
                ['CNY Flowers', 'IMAGE/cny8.jpg', 'CNY Flowers with premium flowers', 'Premium flowers', 'Same day available', 'RM38.00', 'RM40.00', '5%', 'CNY-Flowers'],
                
                ['Grand Opening Flowers', 'IMAGE/grandopening1.jpg', 'Opening Flower Stands with premium sunflower', 'Premium sunflower', 'Same day available', 'RM57.00', 'RM60.00', '5%', 'Grand-Opening'],
                ['Grand Opening Flowers', 'IMAGE/grandopening2.jpg', 'Opening Flower Stands with premium flowers', 'Premium flowers', 'Same day available', 'RM62.70', 'RM66.00', '5%', 'Grand-Opening'],
                ['Grand Opening Basket', 'IMAGE/grandopening3.jpg', 'Opening Flower Stands with premium flowers', 'Premium flowers', 'Same day available', 'RM43.70', 'RM46.00', '5%', 'Grand-Opening'],
                ['Grand Opening Stands', 'IMAGE/grandopening4.jpg', 'Opening Flower Stands with premium flowers', 'Premium flowers', 'Same day available', 'RM59.00', 'RM62.00', '5%', 'Grand-Opening'],
                ['Grand Opening Stands', 'IMAGE/grandopening5.jpg', 'Grand Opening Stands with premium flowers', 'Premium flowers', 'Same day available', 'RM53.40', 'RM56.25', '5%', 'Grand-Opening'],
                ['Grand Opening Basket', 'IMAGE/grandopening6.jpg', 'Grand Opening Basket with premium flowers', 'Premium flowers', 'Same day available', 'RM36.60', 'RM38.50', '5%', 'Grand-Opening'],
                ['Grand Opening Basket', 'IMAGE/grandopening7.jpg', 'Grand Opening Basket with premium flowers', 'Premium flowers', 'Same day available', 'RM36.50', 'RM38.40', '5%', 'Grand-Opening'],
                ['Grand Opening Basket', 'IMAGE/grandopening8.jpg', 'Grand Opening Basket with premium flowers', 'Premium flowers', 'Same day available', 'RM32.80', 'RM34.50', '5%', 'Grand-Opening'],
                
                ['Graduation Bouquet', 'IMAGE/graduation1.jpg', 'Graduation Bouquet with premium sunflower', 'Premium Sunflower', 'Same day available', 'RM47.50', 'RM50.00', '5%', 'Graduation'],
                ['Graduation Bouquet', 'IMAGE/graduation2.jpg', 'Graduation Bouquet with premium pompom chrysanthemum', 'Premium chrysanthemum', 'Same day available', 'RM38.00', 'RM40.00', '5%', 'Graduation'],
                ['Graduation Bouquet', 'IMAGE/graduation3.jpg', 'Graduation Bouquet with premium baby\'s breath flowers', 'Baby\'s breath flowers', 'Same day available', 'RM60.00', 'RM63.00', '5%', 'Graduation'],
                ['Graduation Bouquet', 'IMAGE/graduation4.jpg', 'Graduation Bouquet with premium dyed baby\'s breath flowers', 'Premium baby\'s breath flowers', 'Same day available', 'RM62.70', 'RM66.00', '5%', 'Graduation'],
                ['Graduation Bouquet', 'IMAGE/graduation5.jpg', 'Graduation Bouquet with premium sunflower and baby\'s breath flowers', 'Premium sunflower', 'Same day available', 'RM49.40', 'RM52.00', '5%', 'Graduation'],
                ['Graduation Bouquet', 'IMAGE/graduation6.jpg', 'Graduation Bouquet with premium pompom chrysanthemum', 'Premium chrysanthemum', 'Same day available', 'RM50.35', 'RM53.00', '5%', 'Graduation'],
                ['Graduation Bouquet', 'IMAGE/graduation7.jpg', 'Graduation 7 with premium pink chrysanthemum', 'Premium pink chrysanthemum', 'Same day available', 'RM51.30', 'RM54.00', '5%', 'Graduation'],
                ['Graduation Bouquet', 'IMAGE/graduation8.jpg', 'Graduation Bouquet with premium sunflower', 'Premium sunflower', 'Same day available', 'RM55.70', 'RM58.65', '5%', 'Graduation']
            ];

            foreach ($products as $product) {
                $name = mysqli_real_escape_string($conn, $product[0]);
                $img = mysqli_real_escape_string($conn, $product[1]);
                $desc = mysqli_real_escape_string($conn, $product[2]);
                $type = mysqli_real_escape_string($conn, $product[3]);
                $delivery = mysqli_real_escape_string($conn, $product[4]);
                $current_price = mysqli_real_escape_string($conn, $product[5]);
                $original_price = mysqli_real_escape_string($conn, $product[6]);
                $discount = mysqli_real_escape_string($conn, $product[7]);
                $category = mysqli_real_escape_string($conn, $product[8]);
                
                $sql_insert = "INSERT INTO products (name, image, description, type, delivery, current_price, original_price, discount, category) 
                              VALUES ('$name', '$img', '$desc', '$type', '$delivery', '$current_price', '$original_price', '$discount', '$category')";
                mysqli_query($conn, $sql_insert);
            }
        }
    }
    mysqli_close($conn);
}
?>
