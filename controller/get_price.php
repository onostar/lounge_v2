<?php

    $room = htmlspecialchars(stripslashes($_POST['check_in_room']));

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_category = new selects();
    $row = $get_category->fetch_details_group('items', 'category', 'item_id', $room);
     $category = $row->category;
    
    $prices = $get_category->fetch_details_group('room_details', 'price', 'room', $category);
    $price = $prices->price;
?>
    <!-- <label for='amount_due' style='color:red' >Amount per Night (NGN): </label> -->
    <input type="hidden" name="room_fee" id="room_fee" value="<?php echo $price?>">
    <input type="text" value="<?php echo "NGN". number_format($price, 2)?>/Night" readonly style="color:green; border:none; font-size:1rem">
<?php
        
?>