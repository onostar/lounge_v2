<?php

    include "../classes/dbh.php";
    include "../classes/select.php";


?>
    <div class="info"></div>
<div class="displays allResults" id="room_list">
    <h2>List of rooms with prices</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="room_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Room Category</td>
                <td>Room</td>
                <td>Price</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_rooms = new selects();
                $details = $get_rooms->fetch_details_cond('items', 'department', '1');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td style="color:var(--moreClor);">
                    <?php
                        //get category name
                        $get_cat_name = new selects();
                        $cat_name = $get_cat_name->fetch_details_group('categories', 'category', 'category_id', $detail->category);
                        echo $cat_name->category;
                    ?>
                </td>
                <td><?php echo $detail->item_name?></td>
                <td>
                    <?php 
                        //get category name
                        $get_price = new selects();
                        $cat_price = $get_price->fetch_details_group('room_details', 'price', 'room', $detail->category);
                        echo "₦".number_format($cat_price->price, 2);
                    ?>
                </td>
                <td>
                    <?php
                        if($detail->item_status == 0){
                            echo "<span style='color:green'>Available <i class='fas fa-check'></i></span>";
                        }else if($detail->item_status == 1){
                            echo "<span style='color:var(--moreColor)'>Booked <i class='fas fa-spinner'></i></span>";
                        }else{
                            echo "<span style='color:red'>Occupied <i class='fas fa-ban'></i></span>";
                        }
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