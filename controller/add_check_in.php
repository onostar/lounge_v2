<?php
    date_default_timezone_set("Africa/Lagos");
    $sponsor = htmlspecialchars(stripslashes($_POST['guest']));
    $posted = htmlspecialchars(stripslashes($_POST['posted_by']));
    $room = htmlspecialchars(stripslashes($_POST['check_in_room']));
    $last_name = ucwords(htmlspecialchars(stripslashes($_POST['last_name'])));
    $other_name = ucwords(htmlspecialchars(stripslashes($_POST['first_name'])));
    $emergency = ucwords(htmlspecialchars(stripslashes($_POST['emergency_contact'])));
    $gender = ucwords(htmlspecialchars(stripslashes($_POST['gender'])));
    $contact_address = ucwords(htmlspecialchars(stripslashes($_POST['contact_address'])));
    $contact_phone = ucwords(htmlspecialchars(stripslashes($_POST['contact_phone'])));
    $check_in_date = htmlspecialchars(stripslashes($_POST['check_in_date']));
    $check_out_date = htmlspecialchars(stripslashes($_POST['check_out_date']));
    $amount = htmlspecialchars(stripslashes($_POST['amount_due']));
    $fee = htmlspecialchars(stripslashes($_POST['room_fee']));
    $date = date("Y-m-d H:i:s");
    // $guest_id = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    //instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";
    include "../classes/update.php";
    $guest_data = array(
        "last_name" => $last_name,
        "other_names" => $other_name,
        "gender" => $gender,
        "emergency_contact" => $emergency,
        "contact_phone" => $contact_phone,
        "contact_address" => $contact_address,
        "reg_date" => $date
    );
    //check if guest already exists
    /* $check_guest = new selects();
    $results = $check_guest->fetch_details_cond('guests', 'contact_phone', $contact_phone);
    if(gettype($results) == 'array'){
        foreach($results as $result){
            $guest_id = $result->guest_id;
        }

    } */
    // if(gettype($results) == 'string'){
        //insert into guest
        $insert_guest = new add_data('guests', $guest_data);
        $insert_guest->create_data();
        if($insert_guest){
            //get guest id
            $get_guest_id = new selects();
            $rows = $get_guest_id->fetch_last_inserted('guests', 'guest_id');
            foreach($rows as $row){
                $guest_id = $row->guest_id;
            }
        }
    // }
    //insert into checkin
    $checkin_data = array(
        "room" => $room,
        "guest" => $guest_id,
        "check_in_date" => $check_in_date,
        "check_out_date" => $check_out_date,
        "amount_due" => 0,
        "guest_status" => 1,
        "posted_by" => $posted,
        "sponsor" => $sponsor,
        "post_date" => $date,
        'rate' => $fee
    );
    //check if user already checkin
    $check = new selects();
    $checkss = $check->fetch_details_cond('check_ins', 'guest', $guest_id);
    if(gettype($checkss) == 'array'){
        foreach($checkss as $checks){
            $guest_status = $checks->guest_status;
        }
        if($guest_status == 0){
            echo "<div class='error_msg'><p>Guest already posted! Proceed to payment <i class='fas fa-cancel'></i></p></div>";
            return;
        }elseif($checks->guest_status == 1){
            echo "<div class='error_msg'><p>Guest is currently checked in! <i class='fas fa-cancel'></i></p></div>";
            return;
        }else{
            //check in guest
            $check_in = new add_data('check_ins', $checkin_data);
            $check_in->create_data();
        }
        
    }
    if(gettype($checkss) == "string"){
        //check in guest
        $check_in = new add_data('check_ins', $checkin_data);
        $check_in->create_data();

        
    }
    if($check_in){
        //update guest details
        $update_guest = new Update_table();
        $update_guest->update_tripple('guests', 'contact_address', $contact_address, 'contact_phone', $contact_phone, 'emergency_contact', $emergency, 'guest_id', $guest_id);
        //update room status
        $update_room = new Update_table();
        $update_room->update('items', 'item_status', 'item_id', 2, $room);
        //update sponsor amount due
        //get sponsor previous balance
        $get_balance = new selects();
        $balances = $get_balance->fetch_details_group('check_ins', 'amount_due', 'checkin_id', $sponsor);
        $balance = $balances->amount_due;
        $new_balance = $amount + $balance;
        $update_sponsor = new Update_table();
        $update_sponsor->update('check_ins', 'amount_due', 'checkin_id', $new_balance, $sponsor);

        echo "<div class='success'><p>Guest posted successfully! <i class='fas fa-thumbs-up'></i></p></div>";
    }
    