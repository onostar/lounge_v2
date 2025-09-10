<?php
    session_start();    
    $extended_by = htmlspecialchars(stripslashes($_POST['posted_by']));
    $guest = htmlspecialchars(stripslashes($_POST['guest']));
    $extend_date = date("Y-m-d");
    $new_checkout = htmlspecialchars(stripslashes($_POST['check_out_date']));
    $new_amount = htmlspecialchars(stripslashes($_POST['amount_due']));

        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";
        include "../classes/select.php";

        //get old amount due
        $get_amount = new selects();
        $rows = $get_amount->fetch_details_cond('check_ins', 'checkin_id', $guest);
        foreach($rows as $row){
            $old_amount = $row->amount_due;
            $guest_id = $row->guest;
        }
        //get guest details
        $get_guest = new selects();
        $results = $get_guest->fetch_details_cond('guests', 'guest_id', $guest_id);
        foreach($results as $result){
            $full_name = $result->last_name." ".$result->other_names;
        }
        //get new balance
        $new_balance = $old_amount + $new_amount;

        //now extend stay
        $extend_stay = new Update_table();
        $extend_stay->update_multiple('check_ins', 'amount_due', $new_balance, 'date_extended', $extend_date, 'extended_by', $extended_by, 'check_out_date', $new_checkout, 'stay_extended', 1, 'checkin_id', $guest);
        if($extend_stay){
            echo "<div class='succeed'><p style='text-align:center'>$full_name Stay extended!<br> <i class='fas fa-thumbs-up'></i></p></div>";
        }
