<?php
    session_start();
    
        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";
        include "../classes/select.php";
        include "../classes/inserts.php";
        $date = date("Y-m-d H:i:s");
        $new_room = htmlspecialchars(stripslashes($_POST['new_room']));
        $current_room = htmlspecialchars(stripslashes($_POST['current_room']));
        $guest = htmlspecialchars(stripslashes($_POST['guest']));
        $posted = htmlspecialchars(stripslashes($_POST['posted_by']));
        $change_room = new Update_table();
        $change_room->update('check_ins', 'room', 'checkin_id', $new_room, $guest);
        if($change_room){
        //update old room status
        $update_old_room = new Update_table();
        $update_old_room->update('items', 'item_status', 'item_id', 0, $current_room);
        //update new room status
        $update_new_room = new Update_table();
        $update_new_room->update('items', 'item_status', 'item_id', 2, $new_room);
        //update guest room details
        //insert into change room table
        $data = array(
            "checkin_id" => $guest,
            "old_room" => $current_room,
            "new_room" => $new_room,
            "changed_by" => $posted,
            "changed_date" =>$date
        );
        $insert_change = new add_data('change_room', $data);
        $insert_change->create_data();
        if($insert_change){
            echo "<div class='succeed'><p><i class='fas fa-thumbs-up'></i></p><p>Room changed successfully!</p></div>";

        }else{
            echo "<p>Failed to insert change room! <i class='fas fa-thumbs-up'></i></p>";

        }
        // if($change_room){
            // header("Location: ../view/users.php");
        }else{
            echo "<p>Failed to update room! <i class='fas fa-thumbs-up'></i></p>";
            // header("Location: ../view/users.php");
        }
    // }