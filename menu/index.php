<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Relax, dine, and unwind at Marzbee Lounge & Restaurant. Enjoy delicious meals, refreshing drinks, live entertainment, and a vibrant atmosphere perfect for hangouts, events, and nightlife in Benin.">
    <meta name="keywords" content="Benin lounge, Benin restaurant, fine dining, cocktails, nightlife, bar and lounge, live entertainment, events venue, The Residence Social House, Hide By Residence, dining in Benin, weekend hangout, Benin nightlife" />
    <meta name="author" content="Marzbee Lounge & Restaurant"/>
    <meta property="og:url" content="https://"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="The Residence Social House Lounge & Restaurant | Dining & Drinks" />
    <meta property="og:site_name" content="The Residence Soccial House" />
    <meta property="og:description" content="Relax, dine, and unwind at The Residence Social House. Offering tasty dishes, cocktails, events, and vibrant nightlife in Lagos." />
    <meta property="og:image" itemprop="image" content="images/logo3.png">
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
    <title>The Residence Soccial House | Lounge & Restaurant</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="fontawesome-free-6.0.0-web/css/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.0.0-web/css/all.min.css">
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.min.css">
    <link rel="icon" href="images/logo2.png" type="image/png" size="32X32">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="main_body">
    
    <section id="banner">
        <header id="mainHeader" class="main_header">
            <h1>
                <a href="index.php" id="logos">
                    <img src="../images/logo.jpg" alt="The Residence Social House">
                </a>
            </h1>
            
        </header>
        <div id="slider">
            <div class="slides">
                <div class="slide">
                    <div class="banner_img">
                        <video autoplay muted loop playsinline poster="images/rest_table.jpg" width="640" height="360">
                            <source src="images/intro.mp4" type="video/mp4">
                            <!-- <source src="video.webm" type="video/webm"> 
                            <source src="video.ogg" type="video/ogg"> -->
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="taglines">
                        <div class="taglines_note">
                            <h2>Welcome to The Residence Social House</h2>
                            <p>Our Menu</p>
                            
                            <div class="btns">
                                <a href="food_menu.php">Food Menu <i class="fas fa-utensils"></i></a>
                                <a href="drink_menu.php">Drinks <i class="fas fa-cocktail"></i></a>
                            </div>
                        </div>
                        
                    </div>
                </div>
               
            </div>
            
        </div>
    </section>
    
    </div>
    
</body>
</html>