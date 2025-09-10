
<?php
    include "receipt_style.php";
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/select.php";
include "../classes/functions.php";
    session_start();
    
        $user = $_SESSION['user_id'];
        $store = $_SESSION['store_id'];
        $customDay = getCustomDay();
        $start_day = date("Y-m-d", strtotime($customDay['start']));
        $end_day = date("Y-m-d", strtotime($customDay['end']));
        //get store name
        $get_store_name = new selects();
        $strss = $get_store_name->fetch_details_cond('stores', 'store_id', $store);
        foreach($strss as $strs){
            $store_name = $strs->store;
            $address = $strs->store_address;
            $phone = $strs->phone_number;

        }
        //get user name
        $get_user = new selects();
        $names= $get_user->fetch_details_group('users', 'full_name', 'user_id', $user);
        $fullname = $names->full_name;

        //get total sales for the curent day
        $get_total = new selects();
        /* $amounts = $get_total->fetch_sum_curdateCon('payments', 'amount_paid', 'date(post_date)', 'store', $store); */
        $amounts = $get_total->fetch_sum_CustomSales('sales', 'total_amount', $start_day, 'sales_status', 2);
        // foreach($amounts as $amount){
            $paid_amount = $amounts->total;
            
        // }
?>
<div class="sales_receipt">
<h2><?php echo $_SESSION['company'];?></h2>
    <p><?php echo $address?></p>
    <p>Tel: <?php echo $phone?></p>
    <hr style="background:#222; color:#222; height:4px;">
    <!-- get sales type -->
    <p>Summary for <?php echo date("M, jS, Y")?></p>
    <div class="print_by" style="display:flex;justify-content:space-between; align-items:center">
        <p><strong>Printed by:</strong> <?php echo $fullname?></p>
        <p><strong>Date:</strong> <?php echo date("d-m-Y")?>, <?php echo date("h:i:a")?></p>
    </div>
    <div class="summ" style="display:flex; justify-content:space-between">
        <p>Summary Total :-</p>
        <p><?php echo "₦".number_format($paid_amount,2)?></p>
    </div>
    <h2 style="text-align:left;margin-top:20px">Transaction Summary</h2>
    <div class="summ" style="display:flex; justify-content:space-between">
        <p>Cash :-</p>
        <p>
            <?php 
                //get cash
                $get_cash = new selects();
                /* $cashs = $get_cash->fetch_sum_curdate2Con('payments', 'amount_paid', 'post_date', 'payment_mode', 'Cash', 'store', $store); */
                $cashs = $get_cash->fetch_sum_date4Con('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'Cash', 'store', $store,$start_day);
                if(gettype($cashs) === "array"){
                    foreach($cashs as $cash){
                    ?>
                         ₦ <?php echo number_format($cash->total, 2)?>

                    <?php
                    }
                }
            ?>
        </p>
    </div>
    <div class="summ" style="display:flex; justify-content:space-between">
        <p>POS :-</p>
        <p>
            <?php 
                //get pos
                $get_pos = new selects();
                $poss = $get_pos->fetch_sum_date4Con('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'POS', 'store', $store, $start_day);
                if(gettype($poss) === "array"){
                    foreach($poss as $pos){
                        ?>
                        ₦ <?php echo number_format($pos->total, 2)?>

                    <?php
                    }
                }
            ?>
        </p>
    </div>
    <div class="summ" style="display:flex; justify-content:space-between;border-bottom:1px dotted #222;">
        <p>Transfer :-</p>
        <p>
            <?php 
                //get transfer
                $get_transfer = new selects();
                $trfs = $get_transfer->fetch_sum_date4Con('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'Transfer', 'store', $store, $start_day);
                if(gettype($trfs) === "array"){
                    foreach($trfs as $trf){
                        ?>
                       ₦ <?php echo number_format($trf->total, 2)?>

                    <?php
                    }
                }
            ?>
        </p>
    </div>
    <h2 style="text-align:left;margin-top:20px">Cashier Sales Summary</h2>
    <div class="cashier_summary">
        <table>
            <thead>
                <tr>
                    <th>Cashier</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //get cahsier totals
                    $get_users = new selects();
                    $details = $get_users->fetch_cashier_report($store, $start_day, $end_day);
                    if(gettype($details) === 'array'){
                    foreach($details as $detail):
                ?>
                <tr>
                    <td style="font-size:1rem">
                        <?php
                            //get posted by
                            $get_posted_by = new selects();
                            $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                            echo $checkedin_by->full_name;
                        ?>
                    </td>
                    <td style="font-size:1rem">
                    <?php
                        // get sum
                        $get_total = new selects();
                        $amounts = $get_total->fetch_sum_specdate2Con('payments', 'amount_paid', 'date(start_dates)', $start_day, 'posted_by', $detail->posted_by);
                        foreach($amounts as $amount){
                            $paid_amount = $amount->total;
                            echo "₦".number_format($paid_amount, 2);
                        }
                    ?>
                    </td>
                </tr>
                <?php endforeach; }?>
            </tbody>
        </table>
    </div>
    <p style="margin-top:20px;text-align:center">Powered by Onostar Media (07068897068)</p>
</div> 
   
<?php
    echo "<script>window.print();
    window.close();</script>
    ";
                  
?>