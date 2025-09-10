<?php
    session_start();
    $store = $_SESSION['store_id'];
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_revenue = new selects();
    $details = $get_revenue->fetch_details_2date2Con('sales', 'date(start_dates)', $from, $to, 'sales_status', 2, 'store', $store);
    // $details = $get_revenue->fetch_sales_report( $store, $from, $to);
    $n = 1;
?>
<h2>Sales Report between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRevenue" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Sales report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
        <tr style="background:var(--primaryColor)">
		    <td>S/N</td>
                <td>Invoice</td>
                <td>Item</td>
		<td>Qty</td>
                <td>Unit Price</td>
                <td>Total Amount</td>
                <!-- <td>Discount</td> -->
                <!-- <td>Payment Mode</td> -->
		<td>Date</td>
                <td>Post Time</td>
                <td>Ordered by</td>
                <td>Posted by</td>
                
            </tr>
        </thead>
        <tbody>
<?php
    if(gettype($details) === 'array'){
    foreach($details as $detail){

?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><a style="color:green" href="javascript:void(0)" title="View invoice details" onclick="showPage('invoice_details.php?payment_id=<?php echo $detail->payment_id?>')"><?php echo $detail->invoice?></a></td>
		        <td>
		            <?php
                        //get item name
                        $get_item = new selects();
                        $names = $get_item->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                        echo $names->item_name;
                    ?>
		        </td>
		        <td style="color:green; text-align:center"><?php echo $detail->quantity?></td>
                <td style="color:var(--otherColor)">
                    <?php echo "₦".number_format($detail->price, 2);?>
                </td>
                <td style="color:var(--secondaryColor)">
                    <?php 
                        echo "₦".number_format($detail->total_amount, 2)
                    ?>
                </td>
                <!-- <td style="color:red">
                    <?php echo "₦".number_format($detail->discount, 2);?>
                </td> -->
                <!-- <td>
                    <?php
                            //get payment mode
                            $get_mode = new selects();
                            $mode = $get_mode->fetch_details_group('payments', 'payment_mode', 'invoice', $detail->invoice);
                            //check if invoice is more than 1
                            $get_mode_count = new selects();
                            $rows = $get_mode_count->fetch_count_cond('payments', 'invoice', $detail->invoice);
                                if($rows >= 2){
                                    echo "Multiple payment";
                                }else{
                                    echo $mode->payment_mode;

                                }
                            ?>
                </td> -->
                <td style="color:var(--otherColor)"><?php echo date("d-M-y", strtotime($detail->post_date));?></td>
                <td style="color:var(--moreColor)"><?php echo date("H:i:sa", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->order_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                
            </tr>
            <?php $n++; }?>
        </tbody>
    </table>
<?php
    }else{
        echo "<p class='no_result'>'$details'</p>";
    }
?>
<div class="all_modes">
    <?php
    //get cash
    $get_cash = new selects();
    $cashs = $get_cash->fetch_sum_2date2Cond('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'store', $from, $to, 'Cash', $store);
    if(gettype($cashs) === "array"){
        foreach($cashs as $cash){
            echo "<p class='sum_amount' style='background:var(--otherColor);border-radius:15px; box-shadow:1px solid #cdcdcd; border:1px solid #fff' onclick='showPage('cash_list.php')'><strong>Cash</strong>: ₦".number_format($cash->total, 2)."</p>";
        }
    }
    //get POS
    $get_pos = new selects();
    $poss = $get_pos->fetch_sum_2date2Cond('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'store', $from, $to, 'POS', $store);
    if(gettype($poss) === "array"){
        foreach($poss as $pos){
            echo "<p class='sum_amount' style='background:var(--secondaryColor);border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff' onclick='showPage('pos_list.php')'><strong>POS</strong>: ₦".number_format($pos->total, 2)."</p>";
        }
    }
    //get transfer
    $get_transfer = new selects();
    $trfs = $get_transfer->fetch_sum_2date2Cond('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'store', $from, $to, 'Transfer', $store);
    /* $trfs = $get_transfer->fetch_sum_date4Con('payments', 'amount_paid', 'post_date', 'payment_mode', 'Transfer', 'store', $store, 'start_dates', $from, 'end_dates', $to); */
    if(gettype($trfs) === "array"){
        foreach($trfs as $trf){
            echo "<p class='sum_amount' style='background:var(--primaryColor);border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff' onclick='showPage('transfer_list.php')'><strong>Transfer</strong>: ₦".number_format($trf->total, 2)."</p>";
        }
    }
     //credit/unposted sales
    $get_credit = new selects();
    $credits = $get_credit->fetch_sum_2date2Cond('sales', 'total_amount', 'date(start_dates)', 'sales_status', 'store', $from, $to, 1, $store);
    if(gettype($credits) === "array"){
        foreach($credits as $credit){
            $owed_amount = $credit->total;
        }
        
        echo "<p class='sum_amount' style='background:brown;border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff'><strong>Unpaid</strong>: ₦".number_format($owed_amount, 2)."</p>";

    }
    // get sum
    $get_total = new selects();
    $amounts = $get_total->fetch_sum_2date2Cond('sales', 'total_amount', 'date(start_dates)', 'store', 'sales_status', $from, $to, $store, 2);
    // $amounts = $get_total->fetch_sum_CustomSales('payments', 'amount_paid', $from, $to);
    if(gettype($amounts) == 'array'){
        foreach($amounts as $amount){
            $paid_amount = $amount->total;
        }
    }
    
   
        echo "<p class='sum_amount' style='background:green; margin-left:100px; border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff'><strong>Total</strong>: ₦".number_format($paid_amount, 2)."</p>";
        
    // }
?>
    <a href="javascript:void(0)" title="print end of day summary" class="sum_amount" style="background:#c4c4c4; color:#000; border-radius:15px; box-shadow:1px solid #cdcdcd; border:1px solid #fff" onclick="printEndOfDayByDate('<?php echo $from?>', '<?php echo $to?>')">Print Summary <i class="fas fa-print"></i></a>
</div>