<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $posted = 0;
    $full_name = strtoupper(htmlspecialchars(stripslashes($_POST['full_name'])));
    $contact_phone = ucwords(htmlspecialchars(stripslashes($_POST['phone_number'])));
    $book_date = htmlspecialchars(stripslashes($_POST['book_date']));
    $seat = htmlspecialchars(stripslashes($_POST['seats']));
    $email = htmlspecialchars(stripslashes($_POST['email_address']));
    $fee = htmlspecialchars(stripslashes($_POST['fee']));
    $amount = htmlspecialchars(stripslashes($_POST['total_amount']));
    $charges = htmlspecialchars(stripslashes($_POST['charges']));
    $guests = strtoupper(htmlspecialchars(stripslashes($_POST['guests'])));
   
    $date = date("Y-m-d H:i:s");
    $book_day = date("d-M-Y", strtotime($book_date));
    $book_time = date("H:ia", strtotime($book_date));
    // $guest_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $todays_date = date("dmyh");
    $ran_num ="";
    for($i = 0; $i < 5; $i++){
        $random_num = random_int(0, 9);
        $ran_num .= $random_num;
    }
    $book_num = "MZ".$todays_date.$ran_num;
    //instantiate classes
    include "../admin/classes/dbh.php";
    include "../admin/classes/inserts.php";
    include "../admin/classes/select.php";
    include "../admin/classes/functions.php";
    $customDay = getCustomDay();
    $start_day = $customDay['start'];
    $end_day = $customDay['end'];
    
    $guest_data = array(
        "full_name" => $full_name,
        "phone" => $contact_phone,
        "email" => $email,
        "guests" => $guests,
        "checkin_date" => $book_date,
        "seat_price" => $fee,
        "total_amount" => $amount,
        "charges" => $charges,
        "seats" => $seat,
        "book_date" => $date,
        "booked_by" => $posted,
        "book_status" => 1,
        "booking_num" => $book_num,
        "book_mode" => 'Online'
    );
    $check_in = new add_data('table_bookings', $guest_data);
    $check_in->create_data();
    // $_SESSION['reg_success'] = $book_num;

    if($check_in){
        //add booking payments
        $get_id = new selects();
        $ids = $get_id->fetch_last_inserted('table_bookings', 'booking_id');
        foreach($ids as $id){
            $booking = $id->booking_id;
        }
        $todays_date = date("dmyh");
        $ran_num ="";
        for($i = 0; $i < 4; $i++){
            $random_num = random_int(0, 9);
            $ran_num .= $random_num;
            }
        $invoice = "LOU".$booking.$todays_date.$ran_num;
        $pay_data = array(
            'amount_due' => $amount,
            'amount_paid' => $amount,
            // 'discount' => $discount,
            'bank' => 0,
            'mode' => 'Transfer',
            'posted_by' => 0,
            'invoice' => $invoice,
            // 'store' => $store,
            'payment_type' => 'Lounge',
            'booking_num' => $book_num,
            'booking_id' => $booking,
            'post_date' => $date,
            'start_dates' => $start_day,
            'end_dates' => $end_day,

        );
        $add_payment = new add_data('book_payments', $pay_data);
        $add_payment->create_data();
        //success message
        
        require "../PHPMailer/PHPMailerAutoload.php";
        require "../PHPMailer/class.phpmailer.php";
        require "../PHPMailer/class.smtp.php";
        
        // send mails to customer
        function smtpmailer($to, $from, $from_name, $subject, $body){
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true; 
    
            $mail->SMTPSecure = 'ssl'; 
            $mail->Host = 'www.dorthpro.com';
            $mail->Port = 465; 
            $mail->Username = 'admin@dorthpro.com';
            $mail->Password = 'yMcmb@her0123!';
            $mail->IsHTML(true);
            $mail->From="admin@dorthpro.com";
            $mail->FromName=$from_name;
            $mail->Sender=$from;
            $mail->AddReplyTo($from, $from_name);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($to);
            // $mail->AddAddress('clozethinc@gmail.com');
            $mail->AddAddress('onostarmedia@gmail.com');
            
            if(!$mail->Send())
            {
                $_SESSION['error'] = "Failed to send mail";
                $error = $_SESSION['error'];
                header("Location: ../booking.php");
                
                return $error; 
            }
            else 
            {
                //success message
                $_SESSION['reg_success'] = "<p style='text-align:center; font-size:1rem;'>Congratulations!!!.<br>Your payment has been received. Thanks For patronizing Marzbee.<br> Kindly check your mail for  your booking deails<i class='fas fa-thumbs-up'></i></p>";
                $error = $_SESSION['reg_success'];
                header("Location: ../booking.php");
                // header("Location: index.html");
                return $error;
            }
        }
        
        $to = $email;
        $from = 'admin@dorthpro.com';
        $from_name = "Marzbee Hotels & Lounge";
        $name = 'Marzbee Lounge';
        $subj = 'Your Table Reservation is Confirmed';
        $msg = "<h3>Dear $full_name,</h3> <p>Thank you for choosing Marzbee Hotels & Lounge. We are thrilled to confirm your table reservation for:</p><br>
        <h3>Reservation Details:</h3>
        <ul>
            <li><i class='fas fa-calendar'></i> Date: $book_day</li>
            <li><i class='fas fa-clock'></i>Time: $book_time</li>
            <li>Seats: $seat</li>
            <li>Booking Reference: $book_num</li>
        </ul><br>
        <h3>NOTE: You are expected to present your Booking Reference Number at the point of entry to the lounge</h3><br>
        <p>We’re excited to provide you with a delightful experience. Should you need any special arrangements or have additional requests, feel free to contact us at </p><br>

        <p><strong>Email:<strong> info@marzbeehotel.com</p>
        <p><strong>Phone:</strong> +234 701 234 5678</p>
        <p>We look forward to welcoming you!</p>

        <p>Warm regards,</p>
        <p>John Mars</p>
        <p>Manager</p>
        <p>Marzbee Hotel & Lounge</p>
        <p>#58 Ganiu Lamina street, Alakuko, Lagos</p>
        <p>www.marzbeehotel.com</p>
        ";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);
        
    }
    
    