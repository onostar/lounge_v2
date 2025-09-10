<?php

    include "../classes/dbh.php";
    include "../classes/select.php";


?>
    <div class="info"></div>
<div class="displays allResults" id="bar_items">
    <h2>List of Restaurant items with prices</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="bar_items_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Category</td>
                <td>Item name</td>
                <td>Regular Price(₦)</td>
                <td>Vip Price(₦)</td>
                <!-- <td>Status</td> -->
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_cond('items', 'department', 2);
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
                        echo number_format($detail->sales_price, 2);
                    ?>
                </td>
                <td>
                    <?php 
                        echo number_format($detail->wholesale, 2);
                    ?>
                </td>
                <!-- <td>
                    <?php
                        /* if($detail->item_status == 0){
                            echo "<span style='color:green'>Active <i class='fas fa-check'></i></span>";
                        }else{
                            echo "<span style='color:red'>Disabled <i class='fas fa-ban'></i></span>";
                        } */
                    ?>
                </td> -->
                
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