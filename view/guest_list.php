<?php

    include "../classes/dbh.php";
    include "../classes/select.php";
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }

?>
    <div class="info"></div>
<div class="displays allResults" id="guest_payment">
    <h2>Current Checked in Guests</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchGuestPayment" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="guest_payment_table" class="searchTable">
        <thead>
            <tr>
                <td>S/N</td>
                <td>Full Name</td>
                <td>Room Category</td>
                <td>Room</td>
                <td>Checked in</td>
                <td>Phone Number</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_cond('check_ins', 'guest_status', 1);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td>
                    <?php
                        //get guest details
                        $get_name = new selects();
                        $rows = $get_name->fetch_details_cond('guests', 'guest_id', $detail->guest);
                        foreach($rows as $row){
                            $full_name = $row->last_name." ".$row->other_names;
                        }
                    ?>
                    <?php echo $full_name;?>
                </td>
                <td>
                    <?php 
                        $get_cat = new selects();
                        $categories = $get_cat->fetch_details_group('items', 'category', 'item_id', $detail->room);
                        $category_id = $categories->category;
                        //get category name
                        $get_cat_name = new selects();
                        $cat_name = $get_cat_name->fetch_details_group('categories', 'category', 'category_id', $category_id);
                        echo $cat_name->category;
                    ?>
                </td>
                <td>
                    <?php 
                        $get_room = new selects();
                        $rooms = $get_room->fetch_details_group('items', 'item_name', 'item_id', $detail->room);
                        echo $rooms->item_name;
                    ?>
                </td>
                <td><?php echo date("jS M, Y", strtotime($detail->check_in_date));?></td>
                <td>
                    <?php 
                        //get phoe number
                        $get_phone = new selects();
                        $result = $get_phone->fetch_details_group('guests', 'contact_phone', 'guest_id', $detail->guest);
                        echo $result->contact_phone
                    ?>
                </td>
                <td><a style="background:var(--otherColor); color:#fff; padding:5px; border-radius:10px" href="javascript:void(0)" class="page_navs" title="View guest details" style="color:#fff" onclick="showPage('guest_details.php?guest_id=<?php echo $detail->checkin_id?>')">View Bill <i class="fas fa-eye"></i></a></td>
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
    ?>
</div>