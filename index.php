<?php
/**
 * Filename: index.php
 * Author: Kevinn Jose, Jiang Yu, Vincent, Ahmed
 * Description: Home menu of root flower website.
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
    <?php include("INCLUDE/connection.php"); ?>
    <?php include("INCLUDE/createtable.php"); ?>
<!-- Navigation bar -->
    <?php include("INCLUDE/navigation.php"); ?>

<!-- Main content -->
    <section class="background-image">
        <div class="background-slider">
            <input type="radio" name="bg-slide" id="bg1" checked>
            <input type="radio" name="bg-slide" id="bg2">
            <input type="radio" name="bg-slide" id="bg3">

        <div class="bg-slides">
            <img src="IMAGE/bg1compress.jpg" class="bg-slide bg-slide1" alt="Background Slide 1">
            <img src="IMAGE/bg2compress.jpg" class="bg-slide bg-slide2" alt="Background Slide 2">
            <img src="IMAGE/bg3compress.jpg" class="bg-slide bg-slide3" alt="Background Slide 3">
        </div>
        <div class="bg-content">
            <h1 class="index-text-animation">Welcome to <span class="rf-animation1">R</span><span class="rf-animation2">o</span><span class="rf-animation3">o</span><span class="rf-animation4">t</span> <span class="rf-animation5">F</span><span class="rf-animation6">l</span><span class="rf-animation7">o</span><span class="rf-animation8">w</span><span class="rf-animation9">e</span><span class="rf-animation10">r</span></h1>
            <p>Your one-stop flower shop in Kuching, Sarawak</p>
        </div>
        </div>

    </section>

<!-- About us -->
    <section class="about-us">
        <h2>About Us</h2>
        <p>Root Flower is a dedicated florist based in Kuching, Malaysia. In addition to create beautiful floral products for customer orders, the company also provide interesting floral workshops. These workshops cover a range of skill such as hand-tied bouquets, flower arrangements, and more.
        The aim of the business is connecting the customers and administration support through a simple yet attractive website. The website is designed to be a central hub for all customer needs. They can easily browse the latest promotions to registering for a workshop or a membership.
        For those who join the membership program. Root Flower offers special benefits including a </p>
        <ul class="benefits-list">
            <li>5% discount on all orders</li>
            <li>10% discount on workshop registration when they sign up in a group of more than five people.</li>
        </ul>
        <p>
        Root Flower currently promotes its business through their Instagram page where customers can find more information and photos of their work.
        </p>
    </section>

<!-- Latest promotion -->
    <section class="latest-promotion">
        <h2>Latest Promotion</h2>
            <div class="css-slider">
                <input type="radio" name="slider" id="slide1" checked>
                <input type="radio" name="slider" id="slide2">
                <input type="radio" name="slider" id="slide3">
                <input type="radio" name="slider" id="slide4">

            <div class="slides">
                    <img src="IMAGE/slide1.jpg" class="slide slide1" alt="Slide 1">
                    <img src="IMAGE/slide2.jpg" class="slide slide2" alt="Slide 2">
                    <img src="IMAGE/slide3.jpg" class="slide slide3" alt="Slide 3">
                    <img src="IMAGE/slide4.jpg" class="slide slide4" alt="Slide 4">
            </div>

            <div class="slider-nav">
                    <label for="slide1"></label>
                    <label for="slide2"></label>
                    <label for="slide3"></label>
                    <label for="slide4"></label>
            </div>
            </div>
    </section>
    
<!-- Latest news -->
    <section class="latest-news">
        <h2>Latest News</h2>
        <p> We are opening a new workshop on flower arrangement techniques. Join us to learn from the experts!</p>
        <br>
        <div class="news-container">
            <div class="news-item">
                <img src="IMAGE/news1.jpg" alt="News 1">
                <h3>Handtied Bouquet</h3>
                <p>Spiral Handtied (round & classic), Single Stalk Bouquet, Korean Bouquet, Russian Bouquet, Mix Flowers Bouquet </p>
            </div>

             <div class="news-item">
                <img src="IMAGE/news2.jpg" alt="News 2">
                <h3>Florist to be 1</h3>
                <p>Korean Bouquet, Spiral Handtied, Russian Bouquet, Mix Flowers, Bridal Bouquet, Single Stalk Bouquet, Flower Stand, Boutineer, Flower Basket, Centerpiece</p>
            </div>

             <div class="news-item">
                <img src="IMAGE/news3.jpg" alt="News 3">
                <h3>Florist to be 2</h3>
                <p>Natural Design Bouquet, Korean Bouquet, Spiral Handtied, Russian Bouquet, Mix Flowers, Bridal Bouquet, Boutineer, Flowers Basket, Flowers Box, Mirror Flowers Stand</p>
            </div>
        </div>
    </section>

<!-- Footer  -->
    
    <?php include("INCLUDE/footer.php"); ?>
    <?php include("INCLUDE/profileicon.php"); ?>
</body>
</html>
