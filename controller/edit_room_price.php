<?php
    session_start();    
    // if(isset($_POST['change_prize'])){
        $room = htmlspecialchars(stripslashes($_POST['item_id']));
        $price = htmlspecialchars(stripslashes($_POST['price']));
        /* $adult = htmlspecialchars(stripslashes($_POST['adult']));
        $child = htmlspecialchars(stripslashes($_POST['child']));
        $bed = htmlspecialchars(stripslashes($_POST['bed']));
        $bathroom = htmlspecialchars(stripslashes($_POST['bathroom']));
        $washer = htmlspecialchars(stripslashes($_POST['washer']));
        $aircon = htmlspecialchars(stripslashes($_POST['aircon']));
        $details = ucwords(htmlspecialchars(stripslashes($_POST['details']))); */

        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";

        $change_price = new Update_table();
        /* $change_price->update_eight('room_details', 'price', $price, 'adult', $adult, 'child', $child, 'bed', $bed, 'bathroom', $bathroom, 'washer', $washer, 'air_condition', $aircon, 'description', $details, 'room', $room); */
        $change_price->update('room_details', 'price', 'room', $price, $room);
        if($change_price){
             echo "<div class='success'><p>Room details updated successfully! <i class='fas fa-thumbs-up'></i></p></div>";
            /* $_SESSION['success'] = "<div class='success'><p>Price changed successfully! <i class='fas fa-thumbs-up'></i></p></div>";
            header("Location: ../view/users.php"); */
        }else{
            echo "<p style='background:red; color:#fff; padding:5px'>Failed to update details <i class='fas fa-thumbs-down'></i></p>";
        }
    // }