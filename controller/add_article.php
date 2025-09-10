<?php
    date_default_timezone_set("Africa/Lagos");
    $date = date("Y-m-d H:i:s");
    $title = ucwords(htmlspecialchars(stripslashes($_POST['title'])));
    $description = ucwords(htmlspecialchars(stripslashes(($_POST['details']))));
    
    $photo = $_FILES['photo']['name'];
    /* $photo2 = $_FILES['photo2']['name'];
    $photo3 = $_FILES['photo3']['name']; */
    $photo_folder = "../../media/".$photo;
  /*   $photo_folder2 = "../photos/".$photo2;
    $photo_folder3 = "../photos/".$photo3; */
    $photo_size = $_FILES['photo']['size'];
   /*  $photo_size2 = $_FILES['photo2']['size'];
    $photo_size3 = $_FILES['photo3']['size']; */
    $allowed_ext = array('png', 'jpg', 'jpeg', 'webp');
    /* get current file extention */
    $file_ext = explode('.', $photo);
    $file_ext = strtolower(end($file_ext));
   /*  $file_ext2 = explode('.', $photo2);
    $file_ext2 = strtolower(end($file_ext2));
    $file_ext3 = explode('.', $photo3);
    $file_ext3 = strtolower(end($file_ext3)); */
    $data = array(
        'title' => $title,
        'details' => $description,
        'photo' => $photo,
        'post_date' => $date
        /* 'photo2' => $photo2,
        'photo3' => $photo3, */
    );
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";

    //check if item already Exist
    $check = new selects();
    $results = $check->fetch_count_cond('news_events', 'title', $title);
    if($results > 0){
        echo "<p class='exist'><span>$title</span> already exists</p>";
    }else{
        if(in_array($file_ext, $allowed_ext)/*  && in_array($file_ext2, $allowed_ext) && in_array($file_ext3, $allowed_ext) */){
            if($photo_size <= 500000){
                //compress image
                function compressImage($source, $destination, $quality){
                    //get image info
                    $imgInfo = getimagesize($source);
                    $mime = $imgInfo['mime'];
                    //create new image from file
                    switch($mime){
                        case 'image/png':
                            $image = imagecreatefrompng($source);
                            imagejpeg($image, $destination, $quality);
                            break;
                        case 'image/jpeg':
                            $image = imagecreatefromjpeg($source);
                            imagejpeg($image, $destination, $quality);
                            break;
                        
                        case 'image/webp':
                            $image = imagecreatefromwebp($source);
                            imagejpeg($image, $destination, $quality);
                            break;
                        default:
                            $image = imagecreatefromjpeg($source);
                            imagejpeg($image, $destination, $quality);
                    }
                    //return compressed image
                    return $destination;
                }
                $compress = compressImage($_FILES['photo']['tmp_name'], $photo_folder, 70);
                /* $compress = compressImage($_FILES['photo2']['tmp_name'], $photo_folder2, 70);
                $compress = compressImage($_FILES['photo3']['tmp_name'], $photo_folder3, 70); */
                if($compress){
                    $add_item = new add_data('news_events', $data);
                    $add_item->create_data();
                    if($add_item){
                        echo "<p><span>$title</span> posted successfully</p>";
                    }else{
                        echo "<p class='exist'>Failed to post article</p>";
                    }
                }else{
                    echo "<p class='exist'>Failed to compress image</p>";
                }
            }else{
                echo "<p class='exist'>File too large</p>";
            }
        }else{
            echo "<p class='exist'>your Image format is not supported</p>";

        }                    
    }