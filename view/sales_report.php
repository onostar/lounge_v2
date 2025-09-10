<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/functions.php";

    $customDay = getCustomDay();
    $start_day = date("Y-m-d", strtotime($customDay['start']));
    $end_day = date("Y-m-d", strtotime($customDay['end']));

?>
<div id="revenueReport" class="displays management" style="margin:0!important; width:100%!important">
    <div class="select_date">
        <!-- <form method="POST"> -->
        <section>    
            <div class="from_to_date">
                <label>Select From Date</label><br>
                <input type="date" name="from_date" id="from_date"><br>
            </div>
            <div class="from_to_date">
                <label>Select to Date</label><br>
                <input type="date" name="to_date" id="to_date"><br>
            </div>
            <button type="submit" name="search_date" id="search_date" onclick="search('search_sales_report.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div>
<div class="displays allResults new_data" id="revenue_report">
    <h2>Sales Report for today</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
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
                <td>Date</td>
                <td>Post Time</td>
                <td>Ordered by</td>
                <td>Posted by</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                /* $details = $get_users->fetch_details_date2Cond('sales', 'date(post_date)', 'sales_status', 2, 'store', $store); */
                $details = $get_users->fetch_sales_report($store, $start_day);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
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
                <td style="color:var(--moreColor)"><?php echo date("d-M-Y", strtotime($detail->post_date));?></td>
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
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
    ?>
        <!-- <div class="all_amounts"> -->
            <div class="all_modes">
    <?php
        //get cash
        $get_cash = new selects();
        // $cashs = $get_cash->fetch_sum_curdate2Con('payments', 'amount_paid', 'post_date', 'payment_mode', 'Cash', 'store', $store);
        $cashs = $get_cash->fetch_sum_date4Con('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'Cash', 'store', $store, $start_day);
        if(gettype($cashs) === "array"){
            foreach($cashs as $cash){
            ?>
                <p class="sum_amount" onclick="showPage('cash_list.php')" style="background:var(--otherColor);border-radius:15px; box-shadow:1px solid #cdcdcd; border:1px solid #fff"><strong>Cash</strong>: ₦ <?php echo number_format($cash->total, 2)?></p>
            <?php
            }
        }
        //get pos
        $get_pos = new selects();
        $poss = $get_pos->fetch_sum_date4Con('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'POS', 'store', $store, $start_day);
        if(gettype($poss) === "array"){
            foreach($poss as $pos){
                ?>
                <p class="sum_amount" onclick="showPage('pos_list.php')"style="background:var(--secondaryColor);border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff"><strong>POS</strong>: ₦ <?php echo number_format($pos->total, 2)?></p>

            <?php
            }
        }
        //get transfer
        $get_transfer = new selects();
        $trfs = $get_transfer->fetch_sum_date4Con('payments', 'amount_paid', 'date(start_dates)', 'payment_mode', 'Transfer', 'store', $store, $start_day);
        if(gettype($trfs) === "array"){
            foreach($trfs as $trf){
                ?>
                <p class="sum_amount" onclick="showPage('transfer_list.php')" style="background:var(--primaryColor);border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff"><strong>Transfer</strong>: ₦ <?php echo number_format($trf->total, 2)?></p>

            <?php
            }
        }
        //credit/unposted sales
        $get_credits = new selects();
        $credits = $get_credits->fetch_sum_CustomSales2con('sales', 'total_amount', $start_day, 'sales_status', 1, 'store', $store);
        if(is_array($credits)){
            foreach($credits as $credit){
                $owed_amount = $credit->total;
            }
            

        }else{
            $owed_amount = 0;
        }
        echo "<p class='sum_amount' style='background:brown;border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff'><strong>Unpaid</strong>: ₦".number_format($owed_amount, 2)."</p>";
        ?>
        
            <!-- </div> -->
            <!-- <div class="all_total"> -->
        <?php
        // get sum
        $get_total = new selects();
        $amounts = $get_total->fetch_sum_CustomSales2con('sales', 'total_amount', $start_day, 'sales_status', 2, 'store', $store);
            $paid_amount = $amounts->total;
            
        
            echo "<p class='sum_amount' style='background:green; margin-left:100px; border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff'><strong>Total</strong>: ₦".number_format($paid_amount, 2)."</p>";
            
        // }
        
    ?>
        <a href="javascript:void(0)" title="print end of day summary" class="sum_amount" style="background:#c4c4c4; color:#000; border-radius:15px; box-shadow:1px solid #cdcdcd; border:1px solid #fff" onclick="printEndOfDay()">Print Summary <i class="fas fa-print"></i></a>
            <!-- </div> -->
        </div>
</div>

<script src="../jquery.js"></script>
<script src="../script.js"></script>