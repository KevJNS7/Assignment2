<?php
/**
 * Filename: enhancement2.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Second enhancement page.
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
    <title>Root Flower</title>
</head>
<body>

<!-- Navigation bar -->
    <?php include("INCLUDE/navigation.php"); ?>

    <section class="enhancement">
        <h1>Enhancement</h1>
        <div class="enhancement-content">
            

            <div class="enhancement-box">
                <div class="enh-layout">
                    <div class="enh-text">
                        <h2>1. User Management Module</h2>
                        <p>Admins can Create, View, Edit, and Delete records (Memberships, Workshop Registrations, Enquiries, Promotions) from the admin panel with consistent validation and prepared statements.</p>
                        <p>You can find this enhancement on:</p>
                        <div class="enhancement-link">
                            <a href="view_membership.php">View Membership</a>
                            <a href="view_register.php">View Register</a>
                            <a href="view_enquiry.php">View Enquiry</a>
                            <a href="view_promotion.php">View Promotion</a>
                        </div>
                    </div>
                    <div class="enh-references">
                        <h3>Related Files</h3>
                        <a href="https://www.youtube.com/watch?v=bxe1Vgub2dw&list=PL_99hMDlL4d0iIf0aji2kc4_e8VleaFw2">Click Here for reference</a>
                    </div>
                </div>
            </div>

            <div class="enhancement-box">
                <div class="enh-layout">
                    <div class="enh-text">
                        <h2>2. Anti Spam Feature</h2>
                        <p>Prevents rapid repeat submissions using rate limiting and temporary blocks. If too many submissions happen, the user is blocked briefly and sees a friendly message.</p>
                        <p>You can find this enhancement on:</p>
                        <div class="enhancement-link">
                            <a href="membership.php">Membership</a>
                            <a href="register.php">Workshop Registration</a>
                            <a href="enquiry.php">Enquiry</a>
                        </div>
                    </div>
                    <div class="enh-references">
                        <h3>References</h3>
                        <a href="#">Click Here for reference</a>
                    </div>
                </div>
            </div>

            <div class="enhancement-box">
                <div class="enh-layout">
                    <div class="enh-text">
                        <h2>3. Promotion Module</h2>
                        <p>Admins manage promotions and upload images with validation (file size, type, and image integrity). Promotions can be created, edited, and listed securely.</p>
                        <p>You can find this enhancement on:</p>
                        <div class="enhancement-link">
                            <a href="view_promotion.php">View Promotion </a>
                            <a href="create_promotion.php">Create Promotion</a>
                            <a href="edit_promotion.php">Edit Promotion</a>
                            <a href="promotion.php"> Promotion Page</a>
                        </div>
                    </div>
                    <div class="enh-references">
                        <h3>References</h3>
                        <a href="https://www.youtube.com/watch?v=bxe1Vgub2dw&list=PL_99hMDlL4d0iIf0aji2kc4_e8VleaFw2">Click Here for reference</a>
                    </div>
                </div>
            </div>

            <div class="enhancement-box">
                <div class="enh-layout">
                    <div class="enh-text">
                        <h2>4. Search Features</h2>
                        <p>Keyword search filters the product list by name, type, description, category, and price fields using sanitized input.</p>
                        <p>You can find this enhancement on:</p>
                        <div class="enhancement-link">
                            <a href="allproducts.php">All Products</a>
                            <a href="product1.php">Handtied Bouquet</a>
                            <a href="product2.php">CNY Decoration</a>
                            <a href="product3.php">Grand Opening</a>
                            <a href="product4.php">Graduation</a>
                        </div>
                    </div>
                    <div class="enh-references">
                        <h3>References</h3>
                        <a href="https://www.slingacademy.com/article/implement-search-by-keyword-php-mysql/">Click Here for references</a>
                    </div>
                </div>
            </div>

            <div class="enhancement-box">
                <div class="enh-layout">
                    <div class="enh-text">
                        <h2>5. Automatic Fill Form</h2>
                        <p>Auto-fills forms with existing record data so users can update fields quickly without retyping (after login).</p>
                        <p>You can find this enhancement on:</p>
                        <div class="enhancement-link">
                            <a href="enquiry.php">Enquiry</a>
                            <a href="register.php">Workshop Registration</a>
                        </div>
                    </div>
                    <div class="enh-references">
                        <h3>References</h3>
                        <a href="https://www.geeksforgeeks.org/php/how-to-fetch-data-from-the-database-in-php/">Click Here for references</a>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <!-- Footer  -->
    <?php include("INCLUDE/footer.php"); ?>
</body>
</html>
