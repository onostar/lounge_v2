<?php
    include "connections.php";
    session_start();
    $_SESSION['success'] = "";
    $_SESSION['error'] = "";
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";

    // $_SESSION['success'] = "";


    if(isset($_POST['send_message'])){
        $full_name = ucwords(htmlspecialchars(stripslashes($_POST['full_name'])));
        $email = htmlspecialchars(stripslashes($_POST['email']));
        $phone = htmlspecialchars(stripslashes($_POST['phone']));
        $message = ucwords(htmlspecialchars(stripslashes($_POST['message'])));

        function smtpmailer($to, $from, $from_name, $subject, $body){
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; 
    
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = 'www.aussiehotelng.com';
            $mail->Port = 465; 
            $mail->Username = 'contact@aussiehotelng.com';
            $mail->Password = 'aussie1010.';   
    
    
            $mail->IsHTML(true);
            $mail->From="contact@aussiehotelng.com";
            $mail->FromName=$from_name;
            $mail->Sender=$from;
            $mail->AddReplyTo($from, $from_name);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($to);
            if(!$mail->Send())
            {
                $error ="Please try Later, Error Occured while Processing...";
                return $error; 
            }
            else 
            {
                
                $_SESSION['successful'] = "Thanks for sending us a message. We will get in touch as soon as possible!";
            
            $error = $_SESSION['successful'];
            header("Location: ../index.php");
                return $error;
                /* unlink($ssn_folder);
                unlink($dlf_folder);
                unlink($dlb_folder); */
                // header("Location: index.html");
                // return $error;
            }
        }
        
        $to   = 'contact@aussiehotelng.com';
        $from = $email;
        $from_name = $full_name;
        $name = ' Aussie Contact message';
        $subj = 'Aussie Contact message';
        $msg = "<h2>New message from $full_name</h2>
        <p>Below are the details of the message</p> <br><p>$phone</p><br>\n
        <div class='user_infos'>
            $message
        </div>";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);

    
    }

?>