<?php

    $item = htmlspecialchars(stripslashes(($_POST['item'])));
    $photo = $_FILES['photo']['name'];
    $photo_size = $_FILES['photo']['size'];
    $allowed_ext = array('png', 'jpg', 'jpeg', 'webp');
    /* get current file extention */
    $file_ext = explode('.', $photo);
    $file_ext = strtolower(end($file_ext));
    $ran_num ="";
    for($i = 0; $i < 5; $i++){
        $random_num = random_int(0, 9);
        $ran_num .= $random_num;
    }
    $foto = $ran_num."_".$item.".".$file_ext;
    $photo_folder = "../photos/".$foto;
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/update.php";

        if(in_array($file_ext, $allowed_ext)){
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
                if($compress){
                    $update = new Update_table();
                    $update->update('items', 'photo', 'item_id', $foto, $item);
                    if($update){
                        echo "<p style='color:#fff;background:green; padding:8px; font-size:.9rem;margin:20px auto;width:80%;text-align:center'>Photo updated successfully</p>";
                    }else{
                        echo "<p class='exist'>Failed to add item</p>";
                    }
                }else{
                    echo "<p class='exist'>Failed to compress image</p>";
                }
            }else{
                echo "<p class='exist'>File too large</p>";
            }
        }else{
            echo "<p class='exist'>Image format not supported</p>";

        }                    
    