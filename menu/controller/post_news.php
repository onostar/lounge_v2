<?php
    include "connections.php";
    session_start();
    $_SESSION['success'] = "";
    $_SESSION['error'] = "";

    if(isset($_POST['post_event'])){
        $subject = ucwords(htmlspecialchars(stripslashes($_POST['title'])));
        $message = ucwords(htmlspecialchars(stripslashes($_POST['details'])));
        
        $photo = $_FILES['photo']['name'];
        $photo_folder = "../media/".$photo;
        $photo_size = $_FILES['photo']['size'];
        $allowed_ext = array('png', 'jpg', 'jpeg', 'webp');
        /* get current file extention */
        $file_ext = explode('.', $photo);
        $file_ext = strtolower(end($file_ext));
        $check_status = $connectdb->prepare("SELECT * FROM news_events WHERE title = :title");
        $check_status->bindvalue("title", $subject);
        $check_status->execute();

        if($check_status->rowCount() > 0){
            $_SESSION['error'] = "$subject already posted!";
            header("Location: ../admin/admin.php");
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
                    $insert_news = $connectdb->prepare("INSERT INTO news_events (title, details, photo) VALUES(:title, :details, :photo)");
                    $insert_news->bindvalue("title", $subject);
                    $insert_news->bindvalue("details", $message);
                    $insert_news->bindvalue("photo", $photo);
                    $insert_news->execute();

                    if($insert_news){
                        $_SESSION['success'] = "$subject posted successfully!";
                        /* send notification and email */
                        //get receipients and send message
                        /* $get_recipient = $connectdb->prepare("SELECT user_id FROM users WHERE phone_number != 'admin'");
                        $get_recipient->execute();
                        $views = $get_recipient->fetchAll();
                        foreach($views as $view){
                            $send_message = $connectdb->prepare("INSERT INTO notifications (not_subject, not_message, user_id) VALUES(:not_subject, :not_message, :user_id)");
                            $send_message->bindvalue("not_subject", $subject);
                            $send_message->bindvalue("not_message", $not_message);
                            $send_message->bindvalue("user_id", $view->user_id);
                            $send_message->execute();

                            
                        } */
                        /* send mail */
                        /* $get_mail = $connectdb->prepare("SELECT user_email FROM users WHERE phone_number != 'admin'");
                        $get_mail->execute();
                        $mails = $get_mail->fetchAll();
                        foreach($mails as $mail){
                            
                            //send mail
                            mail("$mail->user_email", $subject, $message, $mailHeader) or die("Error!"); */

                            
                        //  }
                        header("Location: ../admin/admin.php");
                    }else{
                        $_SESSION['error'] = "failed to post newsupload image";
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