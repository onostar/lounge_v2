<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $posted = 0;
    $room = htmlspecialchars(stripslashes($_POST['room_type']));
    $last_name = strtoupper(htmlspecialchars(stripslashes($_POST['last_name'])));
    $other_name = strtoupper(htmlspecialchars(stripslashes($_POST['other_names'])));
    // $emergency = ucwords(htmlspecialchars(stripslashes($_POST['emergency_contact'])));
    $gender = ucwords(htmlspecialchars(stripslashes($_POST['gender'])));
    $contact_address = ucwords(htmlspecialchars(stripslashes($_POST['home_address'])));
    $contact_phone = ucwords(htmlspecialchars(stripslashes($_POST['phone_number'])));
    $check_in_date = htmlspecialchars(stripslashes($_POST['check_in_date']));
    $check_out_date = htmlspecialchars(stripslashes($_POST['check_out_date']));
    $email = htmlspecialchars(stripslashes($_POST['email_address']));
    $quantity = htmlspecialchars(stripslashes($_POST['quantity']));
    $amount = htmlspecialchars(stripslashes($_POST['total_amount']));
    $charges = htmlspecialchars(stripslashes($_POST['charges']));
    $fee = htmlspecialchars(stripslashes($_POST['fee']));
    $title = htmlspecialchars(stripslashes($_POST['title']));
    $city = strtoupper(htmlspecialchars(stripslashes($_POST['city'])));
    $country = strtoupper(htmlspecialchars(stripslashes($_POST['country'])));
    $date = date("Y-m-d H:i:s");
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

    //get room type
    $get_room = new selects();
    $row = $get_room->fetch_details_group('categories', 'category', 'category_id', $room);
    $room_type = $row->category;
    $guest_data = array(
        "last_name" => $last_name,
        "other_names" => $other_name,
        "gender" => $gender,
        "phone" => $contact_phone,
        "home_address" => $contact_address,
        "email" => $email,
        "checkin" => $check_in_date,
        "checkout" => $check_out_date,
        "room" => $room,
        "quantity" => $quantity,
        "unit_price" => $fee,
        "total_amount" => $amount,
        "charges" => $charges,
        "city" => $city,
        "country" => $country,
        "title" => $title,
        "book_date" => $date,
        "booked_by" => $posted,
        "book_status" => 1,
        "booking_num" => $book_num,
        "book_mode" => 'Online'
    );
    $check_in = new add_data('bookings', $guest_data);
    $check_in->create_data();
    // $_SESSION['reg_success'] = $book_num;

    if($check_in){
        //add booking payments
        $get_id = new selects();
        $ids = $get_id->fetch_last_inserted('bookings', 'booking_id');
        foreach($ids as $id){
            $booking = $id->booking_id;
        }
        $todays_date = date("dmyh");
        $ran_num ="";
        for($i = 0; $i < 4; $i++){
            $random_num = random_int(0, 9);
            $ran_num .= $random_num;
            }
        $invoice = "ACC".$booking.$todays_date.$ran_num;
        $pay_data = array(
            'amount_due' => $amount,
            'amount_paid' => $amount,
            // 'discount' => $discount,
            'bank' => 0,
            'mode' => 'Transfer',
            'posted_by' => 0,
            'invoice' => $invoice,
            // 'store' => $store,
            'payment_type' => 'Accomodation',
            'booking_num' => $book_num,
            'booking_id' => $booking,
            'post_date' => $date,
            'start_dates' => $start_day,
            'end_dates' => $end_day,

        );
        $add_payment = new add_data('book_payments', $pay_data);
        $add_payment->create_data(); 
    
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
                $_SESSION['reg_success'] = "<p style='text-align:center; font-size:1rem;'>Congratulations!!!.<br>Your payment has been received. Thanks For patronizing Marzbee.<br>Kindly Check your mail for receipt of payment.<br> We look forward to having you <i class='fas fa-thumbs-up'></i></p>";
                $error = $_SESSION['reg_success'];
                header("Location: ../booking.php");
                // header("Location: index.html");
                return $error;
            }
        }
        
        $to = $email;
        $from = 'admin@dorthpro.com';
        $from_name = "Marzbee Hotels & Lounge";
        $name = 'Marzbee Room Reservations';
        $subj = 'Booking Confirmation - Marzbee Hotel';
        $msg = "<h3>Dear $last_name $other_name,</h3> <p>Thank you for choosing Marzbee Hotels & Lounge! We are delighted to confirm your booking and payment for your upcoming stay with us. Below are the details of your reservation:</p><br>
        <h3>Booking Details:</h3>
        <ul>
            <li>Guest Name: $last_name $other_name</li>
            <li>Check-In Date: $check_in_date</li>
            <li>Check-Out Date: $check_out_date</li>
            <li>Number of Rooms: $quantity</li>
            <li>Room Type: $room_type</li>
            <li>Total Amount Paid: ₦".number_format($amount)."</li>
            <li>Booking Reference Number: $invoice</li>
        </ul><br>
        <h3>What to Expect</h3>
        <p>We look forward to welcoming you to Marzbee Hotel & Lounge. Here’s what you can expect during your stay:</p><br>
        <ul>
        <li>Complimentary breakfast, free Wi-Fi, etc.</li>
        <li>We always appreciate early check-ins and check-out. </li>
        </ul><br>
        <h3>Need Assistance?</h3>
        <p>If you have any questions or need further assistance, please don’t hesitate to contact us at:</p>

        <p><strong>Email:<strong> info@marzbeehotel.com</p>
        <p><strong>Phone:</strong> +234 701 234 5678</p>
        <p>We are excited to host you and ensure your stay is comfortable and memorable.</p>

        <p>Warm regards,</p>
        <p>John Mars</p>
        <p>Manager</p>
        <p>Marzbee Hotels</p>
        <p>#58 Ganiu Lamina street, Alakuko, Lagos</p>
        <p>www.marzbeehotel.com</p>
        ";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg);
        
    }
    