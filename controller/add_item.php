<?php

    $department = htmlspecialchars(stripslashes($_POST['department']));
    $category = htmlspecialchars(stripslashes($_POST['item_category']));
    $item = strtoupper(htmlspecialchars(stripslashes(($_POST['item']))));
    // $barcode = htmlspecialchars(stripslashes(($_POST['barcode'])));
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
    $reorder_level = 10;
    $data = array(
        'item_name' => $item,
        'department' => $department,
        'category' => $category,
        'barcode' => 0,
        'reorder_level' => $reorder_level
    );
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";
    include "../classes/update.php";

    //check if item already Exist
    $check = new selects();
    $results = $check->fetch_count_2cond('items', 'category', $category, 'item_name', $item);
    if($results > 0){
        echo "<p class='exist'><span>$item</span> already exists</p>";
    }else{
        //create item
        if(in_array($file_ext, $allowed_ext)){
            if($photo_size <= 500000){
                $add_data = new add_data('items', $data);
                $add_data->create_data();
                if($add_data){
                    //add photo
                    //get id
                    $ids = $check->fetch_last_inserted('items', 'item_id');
                    foreach($ids as $id){
                        $item_id = $id->item_id;
                    }
                    $foto = $ran_num."_".$item_id.".".$file_ext;
                    $photo_folder = "../photos/".$foto;
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
                    $update_foto = new Update_table();
                    $update_foto->update('items', 'photo', 'item_id', $foto, $item_id);
                    if($update_foto){
                        echo "<p><span>$item</span> created successfully!</p>";
                    }else{
                        echo "<p class='exist'>FFailed to update photo</p>";
                    }
                }
            }else{
                echo "<p class='exist'>File too large</p>";
            }
        }else{
            echo "<p class='exist'>Your Image format is not supported</p>";

        } 
    }