<?php
/**
 * Filename: promotion.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Promotion page.
 * Date: 2025
 */
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Root Flower is a flower shop that based on Kuching, Sarawak Malaysia">
    <meta name="keywords" content="Flower, Root Flower, Kuching, Sarawak, Malaysia">
    <meta name="author" content="Kevinn Jose, Jiang Yu, Vincent, Ahmed">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Promotion Pages</title>
</head>
<body>

<!-- Navigation bar -->
    <?php include("INCLUDE/navigation.php"); ?>

    <main>
        <section class="promotion">
            <div class="main-promotion">
                <h1>Check Our Latest Promotion</h1>
                <p>Beautiful bouquets are available through the city's best florists. Limited time only!</p>
                <a href="allproducts.php" class="register-btn">Shop Now</a>
            </div>
            <figure class="promotion-image">
                <img src="IMAGE/promotionbg.jpg" alt="Beautiful flower bouquet">
                <figcaption>Our signature Valentine's Day flowers</figcaption>
            </figure>
        </section>

        
        <section class="promotion-features">
            <div class="feature-cards">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "Root_Flower";
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if ($conn) {
                    $sql = "SELECT * FROM promotions";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="promotion-card">';
                            echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '">';
                            echo '<div class="card-content">';
                            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    mysqli_close($conn);
                }
                ?>
            </div>

        <aside class="promotion-aside">
            <h3>Popular Promotion</h3>
            <dl id="promo-categories">
                <dt>Valentine</dt>
                <dd>Exclusive discount for couples on Valentine's Day</dd>
                
                <dt>Christmas</dt>
                <dd>Exclusive discount for Christmas celebration</dd>
                
                <dt>Mother Day</dt>
                <dd>Exclusive discount to express gratitude and love to your parents</dd>
            </dl>

            <div class="membership-benefits">
                <h4>Membership Benefits</h4>
                <table>
                    <tr>
                        <th>Type</th>
                        <th>Discount</th>
                    </tr>
                    <tr>
                        <td>Non-membership</td>
                        <td>No Discount</td>
                    </tr>
                    <tr>
                        <td>Membership</td>
                        <td>Up to 5% Discount</td>
                    </tr>
                </table>
                <a href="allproducts.php" class="register-btn">Buy Product</a>
            </div>
        </aside>
    </section>
    </main>

    <!-- Footer  -->
    <?php include("INCLUDE/footer.php"); ?>
    <?php include("INCLUDE/profileicon.php"); ?>

</body>
</html>
