<?php
    if(isset($_GET['discount']) && isset($_GET['guest_id'])){
        $id = $_GET['guest_id'];
        $discount = $_GET['discount'];
        $days = $_GET['days'];
        $room = $_GET['room'];

        include "../classes/dbh.php";
        include "../classes/select.php";
        include "../classes/update.php";
        $get_rate = new selects();
        $rows = $get_rate->fetch_details_group('room_details', 'price', 'room', $room);
        $rate = $rows->price;

        $discount_amount = $rate * ($discount/100);
        $new_rate = $rate - $discount_amount;
        $new_amount_due = $new_rate * $days;
        $update = new Update_table();
        $update->update_quadruple("check_ins", 'rate', $new_rate, 'discount', $discount_amount, 'amount_due', $new_amount_due, 'percent_discount', $discount, 'checkin_id', $id);
        if($update){
            echo "<div class='success'><p>$discount% Discount applied successfully! Proceed to payment. <i class='fas fa-thumbs-up'></i></p></div>";
        }
    }