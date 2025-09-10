<?php
date_default_timezone_set("Africa/Lagos");
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/update.php";
include "../classes/select.php";
include "../classes/inserts.php";
    session_start();
    if(isset($_SESSION['user_id'])){
        $trans_type = "sales";
        $user = $_SESSION['user_id'];
        $invoice = $_POST['sales_invoice'];
        $payment_type = htmlspecialchars(stripslashes($_POST['payment_type']));
        $store = htmlspecialchars(stripslashes($_POST['store']));
        $type = "Guest_sales";
        // $wallet = htmlspecialchars(stripslashes($_POST['wallet']));
        $customer = htmlspecialchars(stripslashes($_POST['customer_id']));
        $date = date("Y-m-d H:i:s");
        //insert into audit trail
        //get items and quantity sold in the invoice
        $get_item = new selects();
        $items = $get_item->fetch_details_cond('sales', 'invoice', $invoice);
        foreach($items as $item){
            $all_item = $item->item;
            $sold_qty = $item->quantity;
            //get item previous quantity in inventory
            $get_qty = new selects();
            $prev_qtys = $get_qty->fetch_details_2cond('inventory', 'store', 'item', $store, $all_item);
            foreach($prev_qtys as $prev_qty){    
                //insert into audit trail
                $inser_trail = new audit_trail($all_item, $trans_type, $prev_qty->quantity, $sold_qty, $user, $store);
                $inser_trail->audit_trail();
            
            }
        }
            
        //check if mode is multiple payment
        /* $get_mode = new selects();
        $mode = $get_mode->fetch_details_group('payments', 'payment_mode', 'invoice', $invoice);
        $paymode = $mode->payment_mode; */

        //update all items with this invoice
        $update_invoice = new Update_table();
        $update_invoice->update('sales', 'sales_status', 'invoice', 2, $invoice);
        //update quantity of the items in inventory
        //get all items first in the invoice
        $get_items = new selects();
        $rows = $get_items->fetch_details_cond('sales', 'invoice', $invoice);
        
        foreach($rows as $row){
            //update individual quantity in inventory
            $update_qty = new Update_table();
            $update_qty->update_inv_qty($row->quantity, $row->item, $store);
            
        }
            if($update_invoice){
                //add total amount to guest amount due
                //get amount due
                $get_prev_bal = new selects();
                $prevs = $get_prev_bal->fetch_details_group('check_ins', 'amount_due', 'checkin_id', $customer);
                $previous_due = $prevs->amount_due;

                //get total in invoice
                $get_invoice_total = new selects();
                $total_invoices = $get_invoice_total->fetch_sum_single('sales', 'total_amount', 'invoice', $invoice);
                foreach($total_invoices as $totals){
                    $invoice_total = $totals->total;
                }
                $amount_due = $previous_due + $invoice_total;
                //update amount due;
                $update_amount_due = new Update_table();
                $update_amount_due->update('check_ins', 'amount_due', 'checkin_id', $amount_due, $customer);
?>
<div id="printBtn">
    <!-- <p><?php echo $customer?></p> -->
    <button onclick="printGuestDocket('<?php echo $invoice?>')">Print Docket <i class="fas fa-print"></i></button>
</div>
<!--  -->
   
<?php
    // echo "<script>window.print();</script>";
                    // }
                
            }
        
    }else{
        header("Location: ../index.php");
    } 
?>