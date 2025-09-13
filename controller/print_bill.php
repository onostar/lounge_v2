
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
        $str = $get_store->fetch_details_group('sales', 'store', 'invoice', $invoice);
        //get store name
        $get_store_name = new selects();
        $strss = $get_store_name->fetch_details_cond('stores', 'store_id', $str->store);
        foreach($strss as $strs){
            $store_name = $strs->store;
            $address = $strs->store_address;
            $phone = $strs->phone_number;

        }
        //get payment details
        /* $get_payment = new selects();
        $payments = $get_payment->fetch_details_cond('payments', 'invoice', $invoice);
        foreach($payments as $payment){
            $pay_mode = $payment->payment_mode;
            $customer = $payment->customer;
            $type = $payment->sales_type;
            $paid_date = $payment->post_date;

        } */
         //get post date and time
        $get_date = new selects();
        $dts = $get_date->fetch_details_cond('sales', 'invoice', $invoice);
        foreach($dts as $dt){
            $posted_date = $dt->post_date;
        }       
?>
    <div class='receipt_logo'><img src="../images/logo.jpeg" title="logo"></div>

<div class="displays allResults sales_receipt">
<h2><?php echo $store_name;?></h2>
    <p><?php echo $address?></p>
    <p>Tel: <?php echo $phone?></p>
    <!-- get sales type -->
        <p>Date: <?php echo date("d-m-Y", strtotime($posted_date))?>, <?php echo date("h:i:sa", strtotime($posted_date))?></p>

    <div class="receipt_head">
        <p><?php echo $invoice?></p>
    <!-- <p><strong>ORDER TICKET</strong> (<?php $store_name?>)</p> -->
    </div>
    <table id="postsales_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Item</td>
                <td>Qty</td>
                <td>Rate</td>
                <td>Amount</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_condGroup('sales','invoice', $invoice, 'item');
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
                <td style="text-align:center; color:red; font-size:.7rem">
                <?php
                    $get_qty = new selects();
                    $qtyss = $get_qty->fetch_sum_double('sales', 'quantity', 'invoice', $invoice, 'item', $detail->item); 
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
                    $amts = $get_amt->fetch_sum_double('sales', 'total_amount', 'invoice', $invoice, 'item', $detail->item); 
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
        /* $get_paid = new selects();
        $amt_paids = $get_paid->fetch_sum_single('payments', 'amount_paid', 'invoice', $invoice);
        foreach($amt_paids as $amt){
            $amount_paid = $amt->total;
        } */
        //get discount
        /* $get_discount = new selects();
        $discs = $get_discount->fetch_sum_2colCond('sales', 'quantity', 'discount', 'invoice', $invoice);
        foreach($discs as $disc){
            $discount = $disc->total;
        }
        $rows = $get_paid->fetch_details_cond('payments', 'invoice', $invoice);
        foreach($rows as $row){
            $amount_paid = $row->amount_paid;
            $amount_due = $row->amount_due;
            // $discount = $row->discount;
            $balance = $amount_due - $amount_paid;
            //amount due
            echo "<p class='total_amount' style='color:green'>Amount due: ₦".number_format($amount_due, 2)."</p>";
            //amount paid
            echo "<p class='total_amount' style='color:green'>Amount Paid: ₦".number_format($amount_paid, 2)."</p>";
            //discount
            echo "<p class='total_amount' style='color:green'>Total Discount: ₦".number_format($discount, 2)."</p>";
            //balance
            echo "<p class='total_amount' style='color:green'>Balance: ₦".number_format($balance, 2)."</p>";
        } */

        
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
        //amount due
        echo "<p class='total_amount' style='color:green'>Amount due: ₦".number_format($total_amount, 2)."</p>";
        //sold by
        $get_seller = new selects();
        $sel = $get_seller->fetch_details_group('sales', 'order_by', 'invoice', $invoice);
        $row = $get_seller->fetch_details_group('users', 'full_name', 'user_id', $sel->order_by);
        echo ucwords("<p class='sold_by'>Ordered by: <strong>$row->full_name</strong></p>");
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