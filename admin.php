<?php
    session_start();
    require "../controller/connections.php";
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        /* get user_id */
        // $get_id = $connectdb->prepare("SELECT user_id FROM users WHERE user_email = 
        // :user_email");
        // $get_id->bindvalue("user_email", $username);
        // $get_id->execute();
        // $user_id = $get_id->fetch();
        // $user = $user_id->user_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aussie hotels and suites is an exquisite hotel .of its kind made for your relaxation and comfort.">
    <meta name="keyword" content="Aussie hotels, Aussie, aussie restaurant, aussie bar, hotels in benin, benin city, hotel, luxury, suites, lounge, swimming pool, lodging, accomodation" />
	<meta name="author" content=""/>
	<meta name="og:url" property="og:url" content="https://">
    <meta name="og:type "property="og:type" content="website">
    <meta name="og:title" property="og:title" content="" />
    <meta name="og:site_name" property="og:site_name" content="" />
    <meta name="og:description" property="og:description" content="Aussie hotels hotels and suites is an exquisite hotel .of its kind made for your rrlaxation and comfort.">
    <meta name="og:image" property="og:image" itemprop="image" content="images/logo.jpg">
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />
    <title>Admin | Aussie Hotels and suites</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.min.css">
    
    <link rel="icon" href="../images/bobsil_logo.jpg" type="image/png" size="32X32">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- <div class="loader">
        <img src="images/psn_logo.jpg" alt="PSN">
        <h2>Welcome to PSN national Conference registration</h2>
    </div> -->
    <main>
        
        <header>
            <h1 class="logo">
                <a href="admin.php" title="logo">
                    <img src="../images/bobsil_logo.JPG" alt="Logo" class="img-fluid">
                </a>
            </h1>
            <div class="search" id="admin_search">
                <form class="form-inline" method="POST">
                    <input type="search" name="search_items" placeholder="search members, reg_number, search phone number" id="search_items">
                    <button type="submit" name="searchBtn" id="searchBtn" class="main_searchbtn">Search <i class="fas fa-search"></i></button>
                    <button type="submit" name="searchBtn" id="searchBtn" class="mobilesearchbtn" ><i class="fas fa-search"></i></button>
                </form>
                
            </div>
            <div class="other_menu">
                <a href="#" title="Our Gallery">Admin Portal</a>
            </div>
            <div class="login">
                <button id="loginDiv"><i class="far fa-user"></i> Account <i class="fas fa-chevron-down"></i></button>
                <div class="login_option">
                    <div>
                        <button id="loginBtn"><a href="../controller/logout.php"><i class="fas fa-power-off"></i>Log out</a></button>
                    </div>    
                </div>
            </div>
            <div class="cart" id="user_data">
                <a href="javascript:void(0);" id="user_name">
                     <span>Hello, Admin</span> 
                    <div class="user_img">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </a>
            </div>
            <div class="menu_icon">
                <a href="javascript:void(0)"><i class="fas fa-bars"></i></a>
            </div>
        </header>
    
        
        <div class="admin_main">
            <aside class="main_menu" id="mobile_log">
                <div class="login">
                    <button id="loginDiv"><i class="far fa-user"></i> Account <i class="fas fa-chevron-down"></i></button>
                    <div class="login_option">
                        <div>
                            <button id="loginBtn"><a href="../controller/logout.php">Log out </a></button>
                            
                        </div>
                    </div>
                </div>
                <nav>
                    <h3><a href="admin.php" title="Home"><i class="fas fa-home"></i> Dashboard</a></h3>
                    <ul>        
                        <!-- <li><a href="javascript:void(0);" id="event" class="page_navs" data-page="projects"><i class="fas fa-helmet-safety"></i> Projects</a></li> -->
                        <li><a href="javascript:void(0);" id="galleryBtn" class="page_navs" data-page="gallery"><i class="fas fa-photo-video"></i> Gallery</a></li>
                        <li><a href="javascript:void(0);" id="event" class="page_navs" data-page="events_news"><i class="fas fa-newspaper"></i> Events & News</a></li>
                    </ul>
                </nav>
            </aside>
            <aside class="mobile_menu" id="mobile_log">
                <div class="login">
                    <button id="loginDiv"><i class="far fa-user"></i> <a href="../controller/logout.php">Log out <i class="fas fa-power-off"></i></a</button>
                    <div class="login_option">
                        <div>
                            <!-- <button id="loginBtn"><a href="../controller/logout.php">Log out <i class="fas fa-power-off"></i></a></button> -->
                            
                        </div>
                    </div>
                </div>
                <nav>
                    <h3><a href="admin.php" title="Home"><i class="fas fa-home"></i> Dashboard</a></h3>
                    <ul>        
                        <li><a href="javascript:void(0);" id="event" class="page_navs" data-page="projects"><i class="fas fa-helmet-safety"></i> Projects</a></li>
                        <li><a href="javascript:void(0);" id="galleryBtn" class="page_navs" data-page="gallery"><i class="fas fa-photo-video"></i> Gallery</a></li>
                        <li><a href="javascript:void(0);" id="event" class="page_navs" data-page="events_news"><i class="fas fa-newspaper"></i> Events & News</a></li>
                    </ul>
                </nav>
            </aside>
            <section id="contents">
                <div class="success_message">
                    <p>
                        <?php
                            if(isset($_SESSION['success'])){
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            }
                        ?>
                    </p>
                </div>
                <div class="error_message">
                    <p>
                        <?php
                            if(isset($_SESSION['error'])){
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            }
                        ?>
                    </p>
                </div>
               <!-- dash board -->
                <div id="dashboard">
                    
                    <div class="cards" id="card5">
                        <a href="javascript:void(0)" data-page="gallery" class="page_navs">
                            <p>Gallery</p>
                            <div class="infos">
                                <i class="fas fa-photo-video"></i>
                                <p>
                                    <?php
                                        $get_gallery = $connectdb->prepare("SELECT * FROM gallery");
                                        $get_gallery->execute();
                                        echo $get_gallery->rowCount()." Photos";
                                    ?>
                                </p>
                            </div>
                        </a>
                    </div> 
                    <div class="cards" id="card3">
                        <a href="javascript:void(0)" data-page="events_news" class="page_navs">
                            <p>News and updates</p>
                            <div class="infos">
                                <i class="fas fa-newspaper"></i>
                                <p>
                                    <?php
                                        $get_gallery = $connectdb->prepare("SELECT * FROM news_events");
                                        $get_gallery->execute();
                                        echo $get_gallery->rowCount();
                                    ?>
                                </p>
                            </div>
                        </a>
                    </div> 
                    
                   
                </div>
                
                <!-- gallery -->
                <div id="gallery" class="displays" style="background:transparent">
                    <div class="info"></div>
                    <div class="add_user_form" id="brd_mess">
                        <h3>Add images to gallery</h3>
                        <form method="POST" action="../controller/post_media.php" enctype="multipart/form-data">
                            <div class="inputs">
                                <div class="data">
                                    <label for="subject">Title</label><br>
                                    <input type="text" name="title" id="title" required>
                                </div>
                                <div class="data">
                                    <label for="event_-img">Upload image (not more than 300kb)</label>
                                    <input type="file" name="photo" id="photo">
                                </div>
                            </div>
                            <button type="submit" id="post_media" name="post_media">Upload <i class="fas fa-upload"></i></button>
                        </form>
                    </div>
                    <!-- uploaded images -->
                    <div class="uploaded">
                        <?php
                            $get_images = $connectdb->prepare("SELECT * FROM gallery ORDER BY post_date DESC");
                            $get_images->execute();
                            $photos = $get_images->fetchAll();
                            foreach($photos as $photo):
                        ?>
                        <figure>
                            <div class="photo">
                                <img src="<?php echo '../media/'.$photo->photo?>" alt="">

                            </div>
                            <figcaption>
                                <h4><?php echo $photo->title?></h4>
                                <a href="javascript:void(0)" title="Delete Photo" onclick= "deletePhoto('<?php echo $photo->media_id?>')"><i class="fas fa-trash"></i></a>
                            </figcaption>
                        </figure>
                        <?php endforeach?>
                    </div>
                </div>
                
                <!-- post news and updates -->
                <div id="events_news"class="displays">
                    <div class="info"></div>
                    <div class="add_user_form" id="brd_mess">
                        <h3>Post events/news</h3>
                        <form method="POST" action="../controller/post_news.php" enctype="multipart/form-data">
                            <div class="inputs">
                                <div class="data">
                                    <label for="subject">Title</label><br>
                                    <input type="text" name="title" id="title" placeholder="Event/news title" required>
                                </div>
                                <div class="data">
                                    <label for="event_img">Upload Cover image (not more than 300kb)</label>
                                    <input type="file" name="photo" id="photo">
                                </div>
                                
                            </div>
                            <div class="inputs">
                                <div class="data" style="width:100%; margin-top:0px;">
                                    <label for="broadcast_message">Details</label><br>
                                    <textarea name="details" id="details" cols="40" rows="5"></textarea>
                                </div>
                            </div>
                            <button type="submit" id="post_event" name="post_event">Post <i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                    <!-- uploaded events and news -->
                    <div class="uploaded">
                        <?php
                            $get_images = $connectdb->prepare("SELECT * FROM news_events ORDER BY post_date DESC");
                            $get_images->execute();
                            $photos = $get_images->fetchAll();
                            foreach($photos as $photo):
                        ?>
                        <figure>
                            <div class="photo">
                                <img src="<?php echo '../media/'.$photo->photo?>" alt="event">

                            </div>
                            <figcaption>
                                <h4><?php echo $photo->title?></h4>
                                <!-- <p><?php echo $photo->details?></p> -->
                                <a href="javascript:void(0)" title="Delete Event" onclick="deleteArticle('<?php echo $photo->article_id?>')"><i class="fas fa-trash"></i></a>
                            </figcaption>
                        </figure>
                        <?php endforeach?>
                    </div>
                </div>
            </section>

        </div>
        
    </main>
    
    

        <script src="../jquery.js"></script>
    <script src="../script.js"></script>
</body>
</html>

<?php 
                
    }else{
        header("Location: index.php");
    }
?>