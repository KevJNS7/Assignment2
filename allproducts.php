<?php
/**
 * Filename: allproducts.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Page displaying all available products.
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
    <title>Product Pages</title>
</head>
<body>

<!-- Navigation bar -->
    <?php include("INCLUDE/navigation.php"); ?>

    <!-- Main contents -->
    <main class="main-content">
        <!-- Main products-->
        <section class="product-section">
            <div class="section-header">
                <h1>Latest Products</h1>
            </div>
            
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "Root_Flower";

            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, trim($_GET['keyword'])) : '';

            if ($keyword !== '') {
                $sql = "SELECT * FROM products WHERE 
                        name LIKE '%$keyword%' OR 
                        type LIKE '%$keyword%' OR 
                        description LIKE '%$keyword%' OR 
                        category LIKE '%$keyword%' OR
                        current_price LIKE '%$keyword%'
                        ORDER BY created_at DESC";
            } else {
                $sql = "SELECT * FROM products ORDER BY created_at DESC";
            }

            $result = mysqli_query($conn, $sql);
            ?>

            <form method="get" class="search-form modern-search-form">
                <input type="text" name="keyword" placeholder="Search products..." value="<?php echo htmlspecialchars($keyword); ?>" class="search-input modern-search-input">
                <button type="submit" class="btn modern-search-btn">Search</button>
            </form>

            <div class="product-grid">
            <?php if (mysqli_num_rows($result) === 0): ?>
                <p>No products found.</p>
            <?php else: ?>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <div class="product-card">
                    <div class="discount-badge"><p><?php echo htmlspecialchars($product['discount']); ?></p></div>
                    <figure>
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img">
                        <figcaption><?php echo htmlspecialchars($product['description']); ?></figcaption>
                    </figure>
                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <dl class="product-specs">
                        <div>
                            <dt>Type:</dt>
                            <dd><?php echo htmlspecialchars($product['type']); ?></dd>
                        </div>
                        <div>
                            <dt>Delivery:</dt>
                            <dd><?php echo htmlspecialchars($product['delivery']); ?></dd>
                        </div>
                    </dl>
                    <div class="product-price">
                        <span class="current-price"><?php echo htmlspecialchars($product['current_price']); ?></span>
                        <span class="original-price"><?php echo htmlspecialchars($product['original_price']); ?></span>
                    </div>
                    <div class="product-actions">
                        <button class="btn wishlist-btn"><img src="IMAGE/wishlist.svg" alt="wishlist"></button>
                        <button class="btn add-to-cart">Add To Cart</button>
                        <button class="btn quick-view"><img src="IMAGE/view2.svg" alt="view"> </button>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php endif; ?>
            <?php mysqli_close($conn); ?>
            </div>
        </section>

         <!-- Aside right-->
         <?php include("INCLUDE/aside.php"); ?>
    </main>
    <br>
    
    <!-- Footer  -->
    <?php include("INCLUDE/footer.php"); ?>

    <?php include("INCLUDE/profileicon.php"); ?>
</body>
</html>
    
