<?php

    include "../classes/dbh.php";
    include "../classes/select.php";
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }

?>
    <div class="info"></div>
<div class="displays allResults" id="guest_payment">
    <h2>Post Other payments/Balances</h2>
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
                <td>Amount Due</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_negCond('check_ins', 'amount_due', 0, 'status', 1);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td style="color:green;"><?php echo $detail->last_name . " ". $detail->first_name;?></td>
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
                <td style="color:var(--secondaryColor);"><?php echo "₦".number_format($detail->amount_due, 2)?></td>
                <td style="text-align:center"><span style="font-weight:bold; background:skyblue; border-radius:5px; text-align:Center; width:auto;padding:5px 10px;"><a href="javascript:void(0)" class="page_navs" title="View guest details" style="color:#fff" onclick="showPage('post_payment.php?guest_id=<?php echo $detail->guest_id?>')">Details</a></span></td>
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