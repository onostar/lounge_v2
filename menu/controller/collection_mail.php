<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $posted = 0;
    $full_name = strtoupper(htmlspecialchars(stripslashes($_POST['full_name'])));
    $gender = ucwords(htmlspecialchars(stripslashes($_POST['gender'])));
    $contact_address = ucwords(htmlspecialchars(stripslashes($_POST['address'])));
    $contact_phone = ucwords(htmlspecialchars(stripslashes($_POST['phone_number'])));
    $pickup_date = htmlspecialchars(stripslashes($_POST['pickup_date']));
    $email = htmlspecialchars(stripslashes($_POST['email_address']));
    $seats = htmlspecialchars(stripslashes($_POST['seat']));
    $amount = htmlspecialchars(stripslashes($_POST['fee']));
    $charges = htmlspecialchars(stripslashes($_POST['charges']));
    $passengers = htmlspecialchars(stripslashes($_POST['passengers']));
    $names = htmlspecialchars(stripslashes($_POST['passenger_names']));
    $destination = htmlspecialchars(stripslashes($_POST['destination']));
    $location = htmlspecialchars(stripslashes($_POST['location']));
    $vehicle = htmlspecialchars(stripslashes($_POST['vehicle']));
   
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
    $guest_data = array(
        "full_names" => $full_name,
        "gender" => $gender,
        "phone" => $contact_phone,
        "location_address" => $contact_address,
        "email" => $email,
        "pickup_date" => $pickup_date,
        "vehicle" => $vehicle,
        "location" => $location,
        "destination" => $destination,
        "passengers" => $passengers,
        "passenger_names" => $names,
        "amount" => $amount,
        "charges" => $charges,
        "book_date" => $date,
        "booked_by" => $posted,
        "book_status" => 1,
        "booking_num" => $book_num,
        "book_mode" => 'Online'
    );
    $check_in = new add_data('airport_collections', $guest_data);
    $check_in->create_data();
    // $_SESSION['reg_success'] = $book_num;

    if($check_in){
        //add booking payments
        $get_id = new selects();
        $ids = $get_id->fetch_last_inserted('airport_collections', 'collection_id');
        foreach($ids as $id){
            $booking = $id->collection_id;
        }
        $todays_date = date("dmyh");
        $ran_num ="";
        for($i = 0; $i < 4; $i++){
            $random_num = random_int(0, 9);
            $ran_num .= $random_num;
            }
        $invoice = "AIR".$booking.$todays_date.$ran_num;
        $pay_data = array(
            'amount_due' => $amount,
            'amount_paid' => $amount,
            // 'discount' => $discount,
            'bank' => 0,
            'mode' => 'Transfer',
            'posted_by' => 0,
            'invoice' => $invoice,
            // 'store' => $store,
            'payment_type' => 'Airport Collection',
            'booking_num' => $book_num,
            'booking_id' => $booking,
            'post_date' => $date,
            'start_dates' => $start_day,
            'end_dates' => $end_day,

        );
        $add_payment = new add_data('book_payments', $pay_data);
        $add_payment->create_data(); 
        //success message
        $_SESSION['reg_success'] = "<p style='text-align:center; font-size:1rem;'>Congratulations!!!.<br>Your payment has been received. Thanks For patronizing Marzbee.<br>Kindly Check your mail for receipt of payment.<br> We will get across to you shortly <i class='fas fa-thumbs-up'></i></p>";
        $error = $_SESSION['reg_success'];
        header("Location: ../booking.php");
    }
        /* require "../PHPMailer/PHPMailerAutoload.php";
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
                $_SESSION['reg_success'] = "<p style='text-align:center; font-size:1rem;'>Congratulations!!!.<br>Your payment has been received. Thanks For patronizing Marzbee.<br>Kindly Check your mail for receipt of payment.<br> We will get across to you shortly <i class='fas fa-thumbs-up'></i></p>";
                $error = $_SESSION['reg_success'];
                header("Location: ../booking.php");
                // header("Location: index.html");
                return $error;
            }
        }
        
        $to = $email;
        $from = 'admin@dorthpro.com';
        $from_name = "Marzbee Airport Collections";
        $name = 'Marzbee Airport Collections';
        $subj = 'Reservation Confirmed: Your Airport Collection Service Details';
        $msg = "<h3>Dear $full_name,</h3> <p>Thank you for choosing our airport collection service. Your reservation has been successfully confirmed. Below are the details of your booking:</p><br>
        <h3>Reservation Details:</h3>
        <ul>
            <li>Pick up Location: $location</li>
            <li>Drop-off Location: $destination</li>
            <li>Pickup Date & Time: date("d-M-Y", strtotime($pickup_date)), at date("H:ia", strtotime($pickup_date))</li>
            <li>Vehicle Type: $vehicle</li>
            <li>Total Amount Fee: ₦".number_format($amount)."</li>
            <li>Booking Reference: $invoice</li>
        </ul><br>
        <h3>Driver Details</h3>
        <ul>
        <li>Driver Name: $driver</li>
        <li>Contact Number: $driver_contact </li>
        <li>Vehicle Details: $Vehicle_details </li>
        </ul><br>
        <h3>Need Assistance?</h3>
        <p>If you have any questions or need further assistance, please don’t hesitate to contact us at:</p>

        <p><strong>Email:<strong> info@marzbeehotel.com</p>
        <p><strong>Phone:</strong> +234 701 234 5678</p>
        <p>We look forward to providing you with a smooth and comfortable ride.<br>
Safe travels, and thank you for trusting us!</p>

        <p>Warm regards,</p>
        <p>John Mars</p>
        <p>Manager</p>
        <p>Marzbee Airport Collections</p>
        <p>#58 Ganiu Lamina street, Alakuko, Lagos</p>
        <p>www.marzbeehotel.com</p>
        ";
        
        $error=smtpmailer($to, $from, $name ,$subj, $msg); */
        
    // }
    