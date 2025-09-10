<?php

    include "../classes/dbh.php";
    include "../classes/select.php";


?>
    <div class="info"></div>
<div class="displays allResults" id="extend_stay">
    <h2>Extend Guest stay</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchDisable" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="guest_payment_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Full Name</td>
                <td>Room Category</td>
                <td>Room</td>
                <td>Check out date</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_curdateCon('check_ins', 'check_out_date', 'guest_status', 1);
                if(gettype($details) == 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td><?php echo $n?></td>
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
                <td><?php echo date("jS M, Y", strtotime($detail->check_out_date));?></td>
                <td>
                    <a style="background:var(--otherColor); color:#fff; padding:5px; border-radius:10px" href="javascript:void(0)" title="View guest details" onclick="showPage('extend_check_in.php?guest_id=<?php echo $detail->checkin_id?>')">view <i class="fas fa-eye"></i></a>
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