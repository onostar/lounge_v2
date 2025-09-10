<?php

    $room = htmlspecialchars(stripslashes($_POST['check_in_category']));
    $checkin = htmlspecialchars(stripslashes($_POST['check_in_date']));
    $checkout = htmlspecialchars(stripslashes($_POST['check_out_date']));

    include "../classes/dbh.php";
    include "../classes/select.php";

    //check rooms available for checkout date
    $check = new selects();
    //get total rooms
    $total_rooms = $check->fetch_count_cond('items', 'category', $room);
    //get available rooms
    $available = $check->fetch_count_2cond1Neg('items', 'category', $room, 'item_status', 2);
    //check bookings
    // $bookings = $check->fetch_count_2cond('bookings', ')