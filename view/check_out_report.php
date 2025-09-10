<?php

    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<div id="revenueReport" class="displays management">
    <div class="select_date">
        <!-- <form method="POST"> -->
        <section>    
            <div class="from_to_date">
                <label>Select From Date</label><br>
                <input type="date" name="from_date" id="from_date"><br>
            </div>
            <div class="from_to_date">
                <label>Select to Date</label><br>
                <input type="date" name="to_date" id="to_date"><br>
            </div>
            <button type="submit" name="search_date" id="search_date" onclick="search('search_checkouts.php')">Search <i class="fas fa-search"></i></button>
</section>
    </div>
<div class="displays allResults new_data" id="check_in_report">
    <h2>Check out Report for today</h2>
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
                <td>Checked in</td>
                <td>Checked out</td>
                <td>Checked out by</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_checkIn('check_ins', 'guest_status', 'date(checked_out)', 2);
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
                <td><a style="color:green" href="javascript:void(0)" title="View guest details" onclick="showPage('guest_details.php?guest_id=<?php echo $detail->checkin_id?>')"><?php echo $fullname?></a></td>
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
                <td style="color:var(--moreColor)"><?php echo date("h:i:sa", strtotime($detail->checked_out));?></td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->checked_out_by);
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