<?php

    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<div id="checkReport" class="displays management">
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
            <button type="submit" name="search_date" id="search_date" onclick="search('change_room_reports.php')">Search <i class="fas fa-search"></i></button>
</section>
    </div>
<div class="displays allResults new_data" id="check_in_report">
    <h2>Changed room reports for today</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="check_out_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Guest</td>
                <td>Old room</td>
                <td>New room</td>
                <td>Checked In</td>
                <td>Post Time</td>
                <td>changed by</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_curdate('change_room', 'date(changed_date)');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
                    //get checkin details details
                    $get_guest = new selects();
                    $rows = $get_guest->fetch_details_cond('check_ins', 'checkin_id', $detail->checkin_id);
                    foreach($rows as $row){
                        $guest = $row->guest;
                        $checkin_date = $row->check_in_date;
                    }
                    //get guest details
                    $get_details = new selects();
                    $results = $get_details->fetch_details_cond('guests', 'guest_id', $guest);
                    foreach($results as $result){
                        $fullname = $result->last_name." ".$result->other_names;
                    }

            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $fullname?></td>
                <td>
                    <?php 
                        $get_old = new selects();
                        $olds = $get_old->fetch_details_group('items', 'item_name', 'item_id', $detail->old_room);
                        echo $olds->item_name;
                    ?>
                </td>
                <td>
                    <?php 
                        $get_new = new selects();
                        $new = $get_new->fetch_details_group('items', 'item_name', 'item_id', $detail->new_room);
                        echo $new->item_name;
                    ?>
                </td>
                <td><?php echo date("jS M, Y", strtotime($checkin_date));?></td>
                <td><?php echo date("h:i:sa", strtotime($detail->changed_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->changed_by);
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