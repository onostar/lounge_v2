
<?php
    include "receipt_style.php";
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/select.php";
    session_start();
    if(isset($_GET['receipt'])){
        $user = $_SESSION['user_id'];
        $invoice = $_GET['receipt'];
        //get store
        $get_store = new selects();
        $str = $get_store->fetch_details_group('payments', 'store', 'invoice', $invoice);
        //get store name
        $get_store_name = new selects();
        $strss = $get_store_name->fetch_details_cond('stores', 'store_id', $str->store);
        foreach($strss as $strs){
            $store_name = $strs->store;
            $address = $strs->store_address;
            $phone = $strs->phone_number;

        }
        //get payment details
        $get_payment = new selects();
        $payments = $get_payment->fetch_details_cond('payments', 'invoice', $invoice);
        foreach($payments as $payment){
            $pay_mode = $payment->payment_mode;
            $customer = $payment->customer;
            $type = $payment->sales_type;
            $paid_date = $payment->post_date;
            $total_due = $payment->amount_due;
        }
                
?>
<div class="displays allResults sales_receipt">
    <?php include "receipt_header.php"?>
        <p><strong>(<?php echo strtoupper($pay_mode)?>)</strong></p>
        
    </div>
    <table id="postsales_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Item</td>
                <td>Rate</td>
                <td>Days</td>
                <td>Amount</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_cond('check_ins', 'checkin_id', $customer);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
                    //get item details
                    $get_rooms = new selects();
                    $rooms = $get_rooms->fetch_details_cond('items', 'item_id', $detail->room);
                    foreach($rooms as $room){
                        $room_name = $room->item_name;
                        $categ = $room->category;
                    }
                    //get category name and price;
                    $get_cat = new selects();
                    $cats = $get_cat->fetch_details_cond('categories', 'category_id', $categ);
                    foreach($cats as $cat){
                        $category = $cat->category;
                       
                    }
                    $rates = $get_cat->fetch_details_group('room_details', 'price', 'room', $categ);
                    $price = $rates->price;
            ?>
            <tr style="font-size:.9rem">
                <td style="text-align:center; color:red; font-size:.8rem"><?php echo $n?></td>
                <td style="color:var(--moreClor); font-size:.8rem">
                    <?php
                        echo $category." (".$room_name.")";
                    ?>
                </td>
                <td style="font-size:.7rem">
                    <?php 
                        echo number_format($detail->rate);
                    ?>
                </td>
                <td style="text-align:center; color:red; font-size:.7rem">
                <?php 
                    $in_date = strtotime($detail->check_in_date);
                    $out_date = strtotime($detail->check_out_date);
                    $date_diff = $out_date - $in_date;
                    $days = round($date_diff / (60 * 60 * 24));
                        echo $days;
                    
                ?>
                </td>
                <td style="font-size:.7rem">
                    <?php 
                        echo number_format($total_due);
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
        // get sum;
        $get_total = new selects();
        $amounts = $get_total->fetch_sum_con('sales', 'price', 'quantity', 'invoice', $invoice);
        foreach($amounts as $amount){
            $total_amount = $amount->total;
        }

        // get amount paid from payments;
        $get_paid = new selects();
        $amt_paids = $get_paid->fetch_sum_single('payments', 'amount_paid', 'invoice', $invoice);
        foreach($amt_paids as $amt){
            $amount_paid = $amt->total;
        }
        //get discount
        /* $get_discount = new selects();
        $discs = $get_discount->fetch_sum_2colCond('sales', 'quantity', 'discount', 'invoice', $invoice);
        foreach($discs as $disc){
            $discount = $disc->total;
        } */
        $rows = $get_paid->fetch_details_cond('payments', 'invoice', $invoice);
        foreach($rows as $row){
            $amount_paid = $row->amount_paid;
            $amount_due = $row->amount_due;
            $discount = $row->discount;
            $balance = $amount_due - $amount_paid;
            //amount due
            echo "<p class='total_amount' style='color:green'>Amount due: ₦".number_format($amount_due, 2)."</p>";
            //amount paid
            echo "<p class='total_amount' style='color:green'>Amount Paid: ₦".number_format($amount_paid, 2)."</p>";
            //discount
            echo "<p class='total_amount' style='color:green'>Discount: ₦".number_format($discount, 2)."</p>";
            //balance
            echo "<p class='total_amount' style='color:green'>Balance: ₦".number_format($balance, 2)."</p>";
        }

        
        //get amount due
        /* if($pay_mode == "Credit"){
            echo "<p class='total_amount' style='color:green'>Amount due: ₦".number_format($total_amount, 2)."</p>";
            //amount paid
            echo "<p class='total_amount' style='color:green'>Amount Paid: ₦".number_format($amount_paid, 2)."</p>";
        }else{
            //amount due
            if($discount != 0){
                echo "<p class='total_amount' style='color:green'>Amount due: ₦".number_format($total_amount, 2)."</p>";
            }
            
            //amount paid
            echo "<p class='total_amount' style='color:green'>Amount Paid: ₦".number_format($amount_paid, 2)."</p>";

            //discount
            if($discount != 0){
                echo "<p class='total_amount' style='color:green'>Discount: ₦".number_format($discount, 2)."</p>";

            }
        } */
        //sold by
        $get_seller = new selects();
        $row = $get_seller->fetch_details_group('users', 'full_name', 'user_id', $user);
        echo ucwords("<p class='sold_by'>Printed by: <strong>$row->full_name</strong></p>");
    ?>
    <p style="margin-top:20px;text-align:center"><strong>Thanks for your patronage!</strong></p>
</div> 
   
<?php
    echo "<script>window.print();
    window.close();</script>";
                    // }
                }
            // }
        
    // }
?>