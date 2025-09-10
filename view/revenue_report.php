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
<div id="revenueReport" class="displays management" style="width:100%!important">
    <!-- <section id="stores_change">
        <label>Select store</label><br>
        <select name="store" id="store" required onchange="changeStoreRevenue(this.value)">
            <option value="" selected>Select store</option>
            <?php
                $get_store = new selects();
                $strs = $get_store->fetch_details('stores');
                foreach($strs as $str){
            ?>
            <option value="<?php echo $str->store_id?>"><?php echo $str->store?></option>
            <?php }?>
        </select>
    </section> -->
    <div class="general_revenue">
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
                <button type="submit" name="search_date" id="search_date" onclick="search('search_revenue.php')">Search <i class="fas fa-search"></i></button>
            </section>
        </div>
        <div class="displays allResults new_data" id="revenue_report">
            <h2>Revenue Report for today</h2>
            <hr>
            <div class="search">
                <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
                <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Revenue report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
            </div>
            <table id="data_table" class="searchTable">
                <thead>
                    <tr style="background:var(--primaryColor)">
                        <td>S/N</td>
                        <td>Invoice</td>
                        <td>Type</td>
                        <td>Amount due</td>
                        <td>Amount paid</td>
                        <!-- <td>Discount</td> -->
                        <td>Payment Mode</td>
                        <td>Post Time</td>
                        <td>Posted by</td>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $n = 1;
                        $get_users = new selects();
                        $details = $get_users->fetch_general_revenue($start_day);
                        if(gettype($details) === 'array'){
                        foreach($details as $detail):
                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td><a style="color:green" href="javascript:void(0)"><?php echo $detail->invoice?></a></td>
                        <td><?php echo $detail->sales_type?></td>
                        <td>
                            <?php echo "₦".number_format($detail->amount_due, 2);?>
                        </td>
                        <td style="color:var(--otherColor)">
                            <?php 
                                //get sum of invoice
                                $get_sum = new selects();
                                $sums = $get_sum->fetch_sum_single('payments', 'amount_paid', 'invoice', $detail->invoice);
                                foreach($sums as $sum){
                                    echo "₦".number_format($sum->total, 2);

                                }
                            ?>
                        </td>
                        <!-- <td style="color:red">
                            <?php echo "₦".number_format($detail->discount, 2);?>
                        </td> -->
                        <td>
                            <?php 
                                //get payment mode
                                $get_mode = new selects();
                                $rows = $get_mode->fetch_count_cond('payments', 'invoice', $detail->invoice);
                                if($rows >= 2){
                                    echo "Multiple payment";
                                }else{
                                echo $detail->payment_mode;
                                }
                            ?>
                        </td>
                        <td style="color:var(--moreColor)"><?php echo date("H:i:sa", strtotime($detail->post_date));?></td>
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
                $cashs = $get_cash->fetch_sum_curdateCon('payments', 'amount_paid', 'start_dates', 'payment_mode', 'Cash');
                if(gettype($cashs) === "array"){
                    foreach($cashs as $cash){
                    ?>
                        <p class="sum_amount" onclick="showPage('cash_list.php')"style="background:var(--otherColor); border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff"><strong>Cash</strong>: ₦ <?php echo number_format($cash->total, 2)?></p>

                    <?php
                    }
                }
                //get pos
                $get_pos = new selects();
                $poss = $get_pos->fetch_sum_curdateCon('payments', 'amount_paid', 'start_dates', 'payment_mode', 'POS');
                if(gettype($poss) === "array"){
                    foreach($poss as $pos){
                        ?>
                        <p class="sum_amount" onclick="showPage('pos_list.php')"style="background:var(--secondaryColor); border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff"><strong>POS</strong>: ₦ <?php echo number_format($pos->total, 2)?></p>

                    <?php
                    }
                }
                //get transfer
                $get_transfer = new selects();
                $trfs = $get_transfer->fetch_sum_curdateCon('payments', 'amount_paid', 'start_dates', 'payment_mode', 'Transfer');
                if(gettype($trfs) === "array"){
                    foreach($trfs as $trf){
                        ?>
                        <p class="sum_amount" onclick="showPage('transfer_list.php')"style="background:var(--primaryColor);border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff"><strong>Transfer</strong>: ₦ <?php echo number_format($trf->total, 2)?></p>

                    <?php
                    }
                }
                ?>
                    <!-- </div> -->
                    <!-- <div class="all_total"> -->
                <?php
                // get sum
                $get_total = new selects();
                $amounts = $get_total->fetch_sum_startDayRev('payments', $start_day, 'amount_paid');
                foreach($amounts as $amount){
                    $paid_amount = $amount->total;
                    
                }
                /* //if credit was sold
                $get_credit = new selects();
                $credits = $get_credit->fetch_sum_curdateCon('payments', 'amount_due', 'start_dates', 'payment_mode', 'Credit');
                if(gettype($credits) === "array"){
                    foreach($credits as $credit){
                        $owed_amount = $credit->total;
                    }
                    $total_revenue = $owed_amount + $paid_amount;
                    echo "<p class='sum_amount' style='background:green; margin-left:250px; font-size:1rem;'><strong>Total</strong>: ₦".number_format($total_revenue, 2)."</p>";

                }
                //if no credit sales
                if(gettype($credits) == "string"){ */
                    echo "<p class='sum_amount' style='background:green; margin-left:100px; border-radius:15px; box-shadow:1px solid #cdcdcd;border:1px solid #fff'><strong>Total</strong>: ₦".number_format($paid_amount, 2)."</p>";
                    
                // }
            ?>
                    <!-- </div> -->
        </div>
    </div>
</div>
<script src="../jquery.js"></script>
<script src="../script.js"></script>