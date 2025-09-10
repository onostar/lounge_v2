<?php
    include "../controller/connections.php";
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ippssolar is an energy company which offers short, medium and long term, high-yield crypto and save energy investments to the general public. We believe that everyone should have the freedom to invest on their own terms.">
    <meta name="keyword" content="ippssolar, investments, crypto, crypto-currencies, bitcoin" />
	<meta name="author" content=""/>
	<meta name="og:url" property="og:url" content="https://">
    <meta name="og:type "property="og:type" content="website">
    <meta name="og:title" property="og:title" content="" />
    <meta name="og:site_name" property="og:site_name" content="" />
    <meta name="og:description" property="og:description" content="ippssolar is an energy company which offers short, medium and long term, high-yield crypto and save energy investments to the general public. We believe that everyone should have the freedom to invest on their own terms.">
    <meta name="og:image" property="og:image" itemprop="image" content="images/ippssolar_logo2.png">
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
    <title>Recovolt Energy | Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.min.css">
    
    <link rel="icon" href="../images/ippssolar_logo2.png" type="image/png" size="32X32">
    <link rel="stylesheet" href="../style.css">
</head>
<body id="backend">
    <!-- <div class="loading">
        <div class="loader">
            <div class="circle"></div>
            <div class="circle"></div>
        </div>
    </div> -->
    <!-- <div class="main"> -->
    <!-- <section class="top_head" id="topHeader">
        <div class="social_media">
            <p>
                <span>Call us </span>(+234) 905 397 7566
            </p>
            <p>
                info@maxenergy.com
            </p>
        </div>
        <div class="contact_phone">
            <ul>
                <li><a href="javascript:void(0);" class="showRequest">Schedule Appointment</a></li>
                <li><a href="plans.html">Find plans</a></li>
                <li><a href="javascript:void(0);">Pay Bills</a></li>
                <li><a href="javascript:void(0);">Covid-19 Updates</a></li>
            </ul>
        </div>
    </section>
    <header id="mainHeader" class="main_header login_header">
        <h1>
            <a href="../index.html">
                <img src="images/" alt="logo">
            </a>
        </h1>
    </header> -->
    <main>
            <section class="reg_log">
                
                <div class="login_page">
                    <h1>
                        <a href="../index.html">
                            <img src="../images/ippssolar_logo2.png" alt="logo">
                        </a>
                    </h1>
                    
                    <h2>Welcome back!</h2>
                    <p>Sign in to continue</p>
                    <?php
                        if(isset($_SESSION['success'])){
                            echo "<p class='success'>" . $_SESSION['success']. "</p>";
                            unset($_SESSION['success']);
                        }
                    ?>
                    <?php
                        if(isset($_SESSION['error'])){
                            echo "<p class='error'>" . $_SESSION['error']. "</p>";
                            unset($_SESSION['error']);
                        }
                    ?>
                    <form action="../controller/login.php" method="POST">
                        <div class="data">
                            <label for="username">Email</label>
                            <input type="email" name="user_email" id="user_email" placeholder="Enter email address" required>
                        </div>
                        <div class="data">
                            <div class="pass">
                                <label for="password">Password</label>
                                <a href="forgot_password.php" title="Recover your password">Forgot password?</a>
                            </div>
                            <input type="password" name="user_password" id="user_password" placeholder="Enter password">
                        </div>
                        <div class="data">
                            <button type="submit" name="login">Login <i class="fas fa-sign-in"></i></button>

                        </div>
                        
                    </form>
                    <div class="signup_option">
                        <p>Don't have an account yet? <a href="registration.php">Signup now</a></p>
                    </div>
                    <div id="foot">
                        <p >&copy;<?php echo Date("Y");?> Ippssolar. All Rights Reserved.</p>

                    </div>

                </div>
                <div class="adds">
                    
                </div>
            </section>
    </main>
    
<!-- </div> -->
    <!-- <div class="help" id="help">
        <a target="_blank" href="https://api.whatsapp.com/send?phone=2348157985866"><i class="fab fa-whatsapp"></i> Hello, How can we help?</a>
    </div> -->
    
    <div class="toTop">
        <a href="#topHeader"><i class="fas fa-chevron-up" style="color:#fff;" size="10"></i></a>
    </div>
    <script src="../jquery.js"></script>
    <script src="../script.js"></script>
</body>
</html>