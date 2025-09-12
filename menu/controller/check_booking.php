<?php
    date_default_timezone_set("Africa/Lagos");
    
    $room = htmlspecialchars(stripslashes($_POST['room_type']));
    $check_in_date = htmlspecialchars(stripslashes($_POST['checkin']));
    $check_out_date = htmlspecialchars(stripslashes($_POST['checkout']));
    $quantity = htmlspecialchars(stripslashes($_POST['room_num']));
    $date = date("Y-m-d H:i:s");

    //instantiate classes
    include "../admin/classes/dbh.php";
    include "../admin/classes/select.php";
    
    //check room availability as at checkin date
    //check total rooms in the category
    $check_room = new selects();
    $total_room = $check_room->fetch_column_cond('items', 'item_id', 'category', $room);
    $total_room_count = count($total_room);
    if($total_room_count > 0){
        // Fetch individual rooms in the category
        $rms = array_map(fn($item) => $item->item_id, $total_room);
    
        //check total booked room
        $booked_room = $check_room->check_booked_room($room, $check_in_date, $check_out_date);
        //check total occupied room
        $occupied_room = $check_room->check_occupied_room($rms, $check_in_date, $check_out_date);
        //Available room
        $available_room = $total_room_count - count($occupied_room) - $booked_room;
    }else{
        $available_room = 0;
    }
?>
    <label for="available" style="color:green">Available Rooms</label>

    <input type="text" value="<?php echo $available_room?> room(s)"readonly>
    <input type="hidden" name="available" id="available" value="<?php echo $available_room?>" readonly>
    