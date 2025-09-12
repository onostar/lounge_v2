<?php
    include "connections.php";
    session_start();
    $_SESSION['success'] = "";
    $_SESSION['error'] = "";

    if(isset($_POST['post_media'])){
        $subject = ucwords(htmlspecialchars(stripslashes($_POST['title'])));
        $photo = $_FILES['photo']['name'];
        $photo_folder = "../media/".$photo;
        $photo_size = $_FILES['photo']['size'];
        $allowed_ext = array('png', 'jpg', 'jpeg', 'webp');
        /* get current file extention */
        $file_ext = explode('.', $photo);
        $file_ext = strtolower(end($file_ext));
        $check_status = $connectdb->prepare("SELECT * FROM gallery WHERE title = :title");
        $check_status->bindvalue("title", $subject);
        $check_status->execute();

        if($check_status->rowCount() > 0){
            $_SESSION['error'] = "$subject already posted!";
            header("Location: ../views/admin.php");
        }else{
            if(in_array($file_ext, $allowed_ext)){
                // if($passport_size <= 1000000){
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
                    $compress = compressImage($_FILES['photo']['tmp_name'], $photo_folder, 80);
                    /* update profile */
                    if($compress){
                    $insert_news = $connectdb->prepare("INSERT INTO gallery (title, photo) VALUES(:title, :photo)");
                    $insert_news->bindvalue("title", $subject);
                    $insert_news->bindvalue("photo", $photo);
                    $insert_news->execute();

                    if($insert_news){
                        $_SESSION['success'] = "$subject posted successfully!";
                        /* send notification and email */
                        //get receipients and send message
                        
                        header("Location: ../admin/admin.php");
                    }else{
                        $_SESSION['error'] = "failed to post image";
                        header("Location: ../admin/admin.php");
                    }
                }else{
                    $_SESSION['error'] = "failed to upload image";
                    header("Location: ../admin/admin.php");
                }
            }
        }
    }   
    

?>