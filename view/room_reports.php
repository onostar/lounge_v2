<?php

    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<div id="revenueReport" class="displays management">
    <div class="select_date">
        <!-- <form method="POST"> -->
        <section>    
            <div class="from_to_date">
                <label>Select a room</label><br>
                <select name="room" id="room" onchange="getRoomReports(this.value)">
                    <option value=""selected>Select room</option>
                    <?php
                        $get_rooms = new selects();
                        $rows = $get_rooms->fetch_details_cond('items', 'department', '1');
                        foreach($rows as $row){

                    ?>
                    <option value="<?php echo $row->item_id?>"><?php echo $row->item_name?></option>
                    <?php }?>
                </select>
            </div>
            
        </section>
    </div>
<div class="displays allResults new_data" id="room_report">
    <h2>Reports by room</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="check_out_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Full Name</td>
                <td>Room Category</td>
                <td>Room</td>
                <td>Checked In</td>
                <td>Checked in by</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_checkIn('check_ins', 'guest_status', 'check_in_date', 1);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
                    //get guest details
                    $get_details = new selects();
                    $rows = $get_details->fetch_details_cond('guests', 'guest_id', $detail->guest);
                    foreach($rows as $row){
                        $fullname = $row->last_name . " ". $row->other_names;
                    }
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><a style="color:green" href="javascript:void(0)" title="View guest details" onclick="showPage('guest_details.php?guest_id=<?php echo $detail->checkin_id?>')"><?php echo $fullname;?></a></td>
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
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                
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

<script src="../jquery.js"></script>
<script src="../script.js"></script>