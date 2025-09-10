<?php
date_default_timezone_set("Africa/Lagos");
// instantiate class
include "../classes/dbh.php";
include "../classes/update.php";
include "../classes/select.php";
include "../classes/inserts.php";
include "../classes/functions.php";
session_start();
$customDay = getCustomDay();
$start_day = $customDay['start'];
$end_day = $customDay['end'];
    if(isset($_SESSION['user_id'])){
        $trans_type ="sales";
        $user = $_SESSION['user_id'];
            $invoice = $_POST['sales_invoice'];
            $payment_type = htmlspecialchars(stripslashes($_POST['payment_type']));
            $bank = htmlspecialchars(stripslashes($_POST['bank']));
            $cash = htmlspecialchars(stripslashes($_POST['multi_cash']));
            $pos = htmlspecialchars(stripslashes($_POST['multi_pos']));
            $store = htmlspecialchars(stripslashes($_POST['store']));
            $transfer = htmlspecialchars(stripslashes($_POST['multi_transfer']));
            $discount = htmlspecialchars(stripslashes($_POST['discount']));
            $type = "Retail";
            $customer = 0;
            $date = date("Y-m-d H:i:s");
        
            
        //update all items with this invoice
        $update_invoice = new Update_table();
        $update_invoice->update('sales', 'sales_status', 'invoice', 2, $invoice);
            if($update_invoice){
                //insert payment details into payment table
                //get invoice total amount
                $get_inv_total = new selects();
                $results = $get_inv_total->fetch_sum_single('sales', 'total_amount', 'invoice', $invoice);
                foreach($results as $result){
                    $inv_amount = $result->total;
                }
                //get amount paid
                $amount_paid = $inv_amount - $discount;
                if($payment_type == "Multiple"){
                    //insert into payments
                    if($cash !== '0'){
                       /*  $insert_payment = new payments($user, 'Cash', $bank, $inv_amount, $cash, $discount, $invoice, $store, $type, $customer, $date);
                        $insert_payment->payment(); */
                        //insert payment
                        $pay_data = array(
                            'amount_due' => $inv_amount,
                            'amount_paid' => $cash,
                            'discount' => $discount,
                            'bank' => $bank,
                            'payment_mode' => 'Cash',
                            'posted_by' => $user,
                            'invoice' => $invoice,
                            'store' => $store,
                            'sales_type' => $type,
                            'customer' => $customer,
                            'post_dates' => $date,
                            'start_dates' => $start_day,
                        'end_date' => $end_day,

                        );
                        $add_payment = new add_data('payments', $pay_data);
                        $add_payment->create_data(); 
                    }
                    if($pos !== '0'){
                        /* $insert_payment = new payments($user, 'POS', $bank, $inv_amount, $pos, $discount, $invoice, $store, $type, $customer, $date);
                        $insert_payment->payment(); */
                        //insert payment
                        $pay_data = array(
                            'amount_due' => $inv_amount,
                            'amount_paid' => $pos,
                            'discount' => $discount,
                            'bank' => $bank,
                            'payment_mode' => 'POS',
                            'posted_by' => $user,
                            'invoice' => $invoice,
                            'store' => $store,
                            'sales_type' => $type,
                            'customer' => $customer,
                            'post_dates' => $date,
                            'start_dates' => $start_day,
                        'end_date' => $end_day,

                        );
                        $add_payment = new add_data('payments', $pay_data);
                        $add_payment->create_data(); 
                    }
                    if($transfer !== '0'){
                        /* $insert_payment = new payments($user, 'Transfer', $bank, $inv_amount, $transfer, $discount, $invoice, $store, $type, $customer, $date);
                        $insert_payment->payment(); */
                        //insert payment
                        $pay_data = array(
                            'amount_due' => $inv_amount,
                            'amount_paid' => $transfer,
                            'discount' => $discount,
                            'bank' => $bank,
                            'payment_mode' => 'Transfer',
                            'posted_by' => $user,
                            'invoice' => $invoice,
                            'store' => $store,
                            'sales_type' => $type,
                            'customer' => $customer,
                            'post_dates' => $date,
                            'start_dates' => $start_day,
                        'end_date' => $end_day,

                        );
                        $add_payment = new add_data('payments', $pay_data);
                        $add_payment->create_data(); 
                    }
                    //
                    /* $insert_multi = new multiple_payment($user, $invoice, $cash, $pos, $transfer, $bank, $store, $date);
                    $insert_multi->multi_pay();
                     */
                    //multiple payment table
                     //insert payment
                     $multi_data = array(
                        'cash' => $cash,
                        'pos' => $pos,
                        'transfer' => $transfer,
                        'bank' => $bank,
                        'posted_by' => $user,
                        'invoice' => $invoice,
                        'store' => $store,
                        'post_date' => $date,
                        'start_dates' => $start_day,
                        'end_dates' => $end_day,

                    );
                    $add_multiple = new add_data('multiple_payments', $multi_data);
                    $add_multiple->create_data();
                }else{
                   /*  $insert_payment = new payments($user, $payment_type, $bank, $inv_amount, $amount_paid, $discount, $invoice, $store, $type, $customer, $date);
                    $insert_payment->payment(); */
                    $pay_data = array(
                        'amount_due' => $inv_amount,
                        'amount_paid' => $amount_paid,
                        'discount' => $discount,
                        'bank' => $bank,
                        'payment_mode' => $payment_type,
                        'posted_by' => $user,
                        'invoice' => $invoice,
                        'store' => $store,
                        'sales_type' => $type,
                        'customer' => $customer,
                        'post_date' => $date,
                        'start_dates' => $start_day,
                        'end_dates' => $end_day,

                    );
                    $add_payment = new add_data('payments', $pay_data);
                    $add_payment->create_data(); 
                }
                
                if($add_payment){
                
                
?>
<div id="printBtn">
    <button onclick="printSalesReceipt('<?php echo $invoice?>')">Print Receipt <i class="fas fa-print"></i></button>
</div>
<!--  -->
   
<?php
    // echo "<script>window.print();</script>";
                    // }
                }
            }
        
    }else{
        header("Location: ../index.php");
    } 
?>