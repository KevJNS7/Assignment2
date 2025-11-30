<?php 
/**
 * Filename: navigation.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Navigation bar component included in all pages.
 * Date: 2025
 */
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
    $username = $isLoggedIn ? $_SESSION['username'] : '';
    $isAdmin = $isLoggedIn && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
?>
    <header class="header">
    <nav class="navigator">
        <div class="left-group">
            <span class="logo2"><img src="IMAGE/logo.jpg" alt="Root Flower Logo"></span>
            <span class="logo">Root Flower</span>
        </div>
        <input type="checkbox" id="check">
        <label for="check" class="checkbutton">
         &#9776;
        </label>
        <ul>
            <li> <a href="index.php">Home</a></li>

            <li class="dropdown"> 
                <a href="allproducts.php">Product</a>
                <ul class="dropdown-menu">
                    <li><a href="product1.php">Hand-bouquet</a></li>
                    <li><a href="product2.php">CNY decoration</a></li>
                    <li><a href="product3.php">Grand Opening</a></li>
                    <li><a href="product4.php">Graduation</a></li>
                </ul>
            </li>

            <li class="dropdown"> 
                <a href="#">Activities</a>
                <ul class="dropdown-menu">
                    <li><a href="workshop.php">Workshop</a></li>
                    <li><a href="promotion.php">Promotion</a></li>  
                </ul>
            </li>
            <li class="dropdown"> 
                <a href="#">Register</a>
                <ul class="dropdown-menu">
                    <li><a href="register.php">Workshop</a></li>
                    <li><a href="membership.php">Membership</a></li>   
                </ul>
            </li>

            <li> <a href="enquiry.php">Enquiry</a></li>

            <?php if ($isLoggedIn): ?>
            <li class="dropdown"> 
                <a href="#">
                    <?php echo htmlspecialchars($username); ?>
                </a>
                <ul class="dropdown-menu">
                    <?php if ($isAdmin): ?>
                    <li><a href="adminview.php">Admin</a></li>
                    <?php else: ?>
                    <li><a href="user.php">Profile</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </li>
            <?php else: ?>
            <li> <a href="login.php">
                <img src="IMAGE/login.svg" alt="Login"> Login
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    </header>
