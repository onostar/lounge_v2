
<?php
    include "receipt_style.php";
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/select.php";
    session_start();
    if(isset($_GET['guest'])){
        $guest = $_GET['guest'];
        $user = $_SESSION['user_id'];
        $store_id = $_SESSION['store_id'];
        //get store details
        $get_store_name = new selects();
        $strss = $get_store_name->fetch_details_cond('stores', 'store_id', $store_id);
        foreach($strss as $strs){
            $store_name = $strs->store;
            $address = $strs->store_address;
            $phone = $strs->phone_number;

        }
        //get checkin details
        $get_checkin = new selects();
        $rows = $get_checkin->fetch_details_cond('check_ins', 'checkin_id', $guest);
        foreach($rows as $row){
            $guest_id = $row->guest;
            $room = $row->room;
            $checkin = $row->check_in_date;
            $checkout = $row->check_out_date;
            $rate = $row->rate;
        }
        //calculate days
        $in_date = strtotime($checkin);
        $out_date = strtotime($checkout);
        $date_diff = $out_date - $in_date;
        $days = round($date_diff / (60 * 60 * 24));
        $guest_no = "00".$guest;
        //get guest name
        $get_guest = new selects();
        $gsts = $get_guest->fetch_details_cond('guests', 'guest_id', $guest_id);
        foreach($gsts as $gst){
            $full_name = $gst->last_name." ".$gst->other_names;
            $wallet = $gst->wallet;
        }
        //get room details
        $get_room = new selects();
        $rms = $get_room->fetch_details_cond('items', 'item_id', $room);
        foreach($rms as $rm){
            $room_id = $rm->item_name;
            $category = $rm->category;
        }
        //get room category name
        $cats = $get_room->fetch_details_group('categories', 'category', 'category_id', $category);
        $room_cat = $cats->category;
?>
    <div class='receipt_logo'><img src="../images/icon.png" title="logo"></div>

<div class="displays allResults sales_receipt">
    <h2><?php echo $_SESSION['company'];?></h2>
    <p><?php echo $address?></p>
    <p>Tel: <?php echo $phone?></p>
    <hr>
    <div class="checkin_det">
        <p><strong>Guest No.:</strong> <?php echo $guest_no?></p>
        <p><strong>Guest Name.:</strong> <?php echo strtoupper($full_name)?></p>
        <p><strong>Room:</strong> <?php echo $room_cat." (".$room_id.")"?></p>
        <p><strong>Check-in Date:</strong> <?php echo date("d/m/Y", strtotime($checkin))?></p>
        <p><strong>Check-out Date:</strong> <?php echo date("d/m/Y", strtotime($checkout))?></p>
    </div>
    <hr>

    <table id="postsales_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Description</td>
                <td>Qty</td>
                <td>Rate</td>
                <td>Amount</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                
            ?>
            <tr style="font-size:.9rem">
                <td style="text-align:center; color:red; font-size:.7rem"><?php echo $n?></td>
                <td style="color:var(--moreColor); font-size:.7rem">
                    <?php
                        echo strtoupper($room_cat)." (".$room_id.")";
                    ?>
                </td>
                <td style="color:red; font-size:.7rem">
                <?php
                    echo $days." Nights";
                ?>
                    
                </td>
                <td style="font-size:.7rem">
                    <?php 
                        echo number_format($rate);
                    ?>
                </td>
                <td style="font-size:.7rem">
                <?php
                    echo number_format($rate * $days);
                ?>
                </td>
                
                
            </tr>
                <?php
                $n = 2;
                $get_checkins = new selects();
                $datas = $get_checkins->fetch_details_negCond('check_ins', 'checkin_id', $guest, 'sponsor', $guest);
                if(gettype($datas) == 'array'){
                    foreach($datas as $data){
                        $get_cat = new selects();
                        $categories = $get_cat->fetch_details_cond('items', 'item_id', $data->room);
                        foreach($categories as $cats){
                            $category_id = $cats->category;
                            $item_name = $cats->item_name;
                        }
                        //get category details
                        $get_cat_names = new selects();
                        $cat_names = $get_cat_names->fetch_details_cond('categories',  'category_id', $category_id);
                        foreach($cat_names as $cates){
                            $other_category = $cates->category;
                            
                        }
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td style="font-size:.7rem">
                    <?php 
                        echo strtoupper($other_category." (".$item_name.")");

                    ?>
                </td>
                <td style="font-size:.7rem; color:red">
                    <?php 
                        $in_date2 = strtotime($data->check_in_date);
                        $out_date2 = strtotime($data->check_out_date);
                        $date_diff2 = $out_date2 - $in_date2;
                        $days2 = round($date_diff2 / (60 * 60 * 24));
                        
                            echo $days2." Nights";
                        
                    ?>
                </td>
                <td style="color:#222; font-size:.7rem">
                    <?php echo number_format($data->rate, 2)?>
                </td>
                <td style="color:#222; font-size:.7rem"><?php echo number_format($data->rate * $days2, 2)?></td>
            </tr>
            <?php $n++; } }?>
            <?php
                $get_items = new selects();
                $details = $get_items->fetch_details_condGroup('sales','customer', $guest, 'item');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr style="font-size:.9rem">
                <td style="text-align:center; color:red; font-size:.7rem"><?php echo $n?></td>
                <td style="color:var(--moreClor); font-size:.7rem">
                    <?php
                        //get category name
                        $get_item_name = new selects();
                        $item_name = $get_item_name->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                        echo $item_name->item_name;
                    ?>
                </td>
                <td style="color:red; font-size:.7rem">
                <?php
                    $get_qty = new selects();
                    $qtyss = $get_qty->fetch_sum_double('sales', 'quantity', 'customer', $guest, 'item', $detail->item); 
                    foreach($qtyss as $qtys){
                        echo $qtys->total;
                    }
                ?>
                    
                </td>
                <td style="font-size:.7rem">
                    <?php 
                        echo number_format($detail->price);
                    ?>
                </td>
                <td style="font-size:.7rem">
                <?php
                    $get_amt = new selects();
                    $amts = $get_amt->fetch_sum_double('sales', 'total_amount', 'customer', $guest, 'item', $detail->item); 
                    foreach($amts as $amt){
                        echo $amt->total;
                    }
                ?>
                </td>
                
                
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    <?php
        // get sum;
        $get_sales_total = new selects();
        $amounts = $get_sales_total->fetch_sum_con('sales', 'price', 'quantity', 'customer', $guest);
        foreach($amounts as $amount){
            $total_sales = $amount->total;
        }

        // get room price
        $room_total = $rate * $days;

        //get other room price
        $get_other_room = new selects();
        //get payments
        $get_pay = new selects();
        $pays = $get_pay->fetch_sum_single('payments', 'amount_paid', 'customer', $guest);
        foreach($pays as $pay){
            $total_paid = $pay->total;
        }
        //amount due
        echo "<p class='total_amount' style='color:#000'>Amount due: ₦".number_format($total_paid, 2)."</p>";
        //amount paid
        echo "<p class='total_amount' style='color:#000'>Amount paid: ₦".number_format($total_paid, 2)."</p>";
        //accountbalance
        echo "<p class='total_amount' style='color:#000'>Wallet Balance: ₦".number_format($wallet, 2)."</p>";
        
        //sold by
       $get_seller = new selects();
        /*$sel = $get_seller->fetch_details_group('checkins', 'order_by', 'invoice', $invoice); */
        $row = $get_seller->fetch_details_group('users', 'full_name', 'user_id', $user);
        echo ucwords("<p class='sold_by'>Printed by: <strong>$row->full_name</strong></p>");
    ?>
    <!-- <p style="margin-top:20px;text-align:center"><strong>Thanks for your patronage!</strong></p> -->
</div> 
   
<?php
    echo "<script>window.print();
    window.close();</script>";
                    // }
                }
            // }
        
    // }
?>