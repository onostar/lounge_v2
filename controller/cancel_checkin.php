<?php
    session_start();
    
        $guest = $_POST['check_id'];
        $user = $_POST['user'];
        $date = date("Y-m-d H:i:m");
        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";
        include "../classes/select.php";

        $cancel = new Update_table();
        $cancel->update_multiple('check_ins', 'guest_status', -1, 'cancel_check', $date, 'cancelled_by', $user, 'checked_out', $date, 'amount_due', 0, 'checkin_id', $guest);
        if($cancel){
        // update room
        //get room
        $get_room = new selects();
        $rooms = $get_room->fetch_details_group('check_ins', 'room', 'checkin_id', $guest);
        $the_room = $rooms->room;
        //update room status
        $update_room = new Update_table();
        $update_room->update('items', 'item_status', 'item_id', 0, $the_room);
        if($update_room){
            echo "<div class='succeed'><p><i class='fas fa-thumbs-up'></i></p><p>Guest Check in  cancelled successfully!</p></div>";
            // header("Location: ../view/users.php");
        }else{
            echo "<p>Failed to update room! <i class='fas fa-thumbs-up'></i></p>";
            // header("Location: ../view/users.php");
        }
    }