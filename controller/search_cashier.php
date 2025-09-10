<?php
    session_start();
    $store = $_SESSION['store_id'];
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_cashier = new selects();
    $details = $get_cashier->fetch_cashier_report($store, $from, $to);
    $n = 1; 

?>
<h2>Cashier reports between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRevenue" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Cashier report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--primaryColor)">
                <td>S/N</td>
                <td>Cashier</td>
                <!-- <td>Location</td> -->
                <td>Cash</td>
                <td>POS</td>
                <td>Transfer</td>
                <!-- <td>Wallet</td> -->
                <!-- <td>Credit</td> -->
                <td>Total</td>
                
            </tr>
        </thead>
        <tbody>
<?php
    if(gettype($details) === 'array'){
    foreach($details as $detail){

?>
            <tr>
            <?php
                    //get cashier details
                    $get_posted_by = new selects();
                    $cashierss= $get_posted_by->fetch_details_cond('users', 'user_id', $detail->posted_by);
                    foreach($cashierss as $cashiers){
                        $cashier = $cashiers->full_name;
                        $loc_id = $cashiers->store;
                    }
                    //get cashier location name
                    $get_loc = new selects();
                    $locs = $get_loc->fetch_details_group('stores', 'store', 'store_id', $loc_id);
                    $location = $locs->store;
                ?>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td style="color:var(--otherColor)">
                    <?php
                        echo $cashier;
                    ?>
                </td>
                <!-- <td><?php echo $location?></td> -->
                <td>
                    <?php
                        $get_cash = new selects();
                        $cashs = $get_cash-> fetch_sum_2dateCondGr('payments', 'amount_paid', 'payment_mode', 'date(start_dates)', 'posted_by', $from, $to, 'Cash', $detail->posted_by);
                        /* $cashs = $get_cash->fetch_sum_date4Con('payments', 'amount_paid', 'post_date', 'payment_mode', 'Cash', 'posted_by', $detail->posted_by, 'start_dates', $from, 'end_dates', $to); */
                        foreach($cashs as $cash){
                            echo "₦".number_format($cash->total, 2);
                        }
                    ?>
                </td>
                <td>
                    <?php
                        $get_cash = new selects();
                        $cashs = $get_cash-> fetch_sum_2dateCondGr('payments', 'amount_paid', 'payment_mode', 'date(start_dates)', 'posted_by', $from, $to, 'POS', $detail->posted_by);
                        foreach($cashs as $cash){
                            echo "₦".number_format($cash->total, 2);
                        }
                    ?>
                </td>
                <td>
                    <?php
                        $get_cash = new selects();
                        $cashs = $get_cash-> fetch_sum_2dateCondGr('payments', 'amount_paid', 'payment_mode', 'date(start_dates)', 'posted_by', $from, $to, 'Transfer', $detail->posted_by);
                        foreach($cashs as $cash){
                            echo "₦".number_format($cash->total, 2);
                        }
                    ?>
                </td>
                <!-- <td>
                    <?php
                        $get_cash = new selects();
                        $cashs = $get_cash->fetch_sum_2dateCondGr('payments', 'amount_paid', 'payment_mode', 'date(post_date)', 'posted_by', $from, $to, 'Wallet', $detail->posted_by);
                        foreach($cashs as $cash){
                            echo "₦".number_format($cash->total, 2);
                        }
                    ?>
                </td> -->
                <!-- <td>
                    <?php
                        /* $get_cash = new selects();
                        $cashs = $get_cash->fetch_sum_2dateCondGr('payments', 'amount_due', 'payment_mode', 'date(post_date)', 'posted_by', $from, $to, 'Credit', $detail->posted_by);
                        foreach($cashs as $cash){
                            echo "₦".number_format($cash->total, 2);
                        } */
                    ?>
                </td> -->
                <td style="color:red">
                    <?php
                        // get sum
                        $get_total = new selects();
                        $amounts = $get_total->fetch_sum_2dateCond('payments', 'amount_paid', 'posted_by', 'date(start_dates)', $from, $to, $detail->posted_by);
                       /*  $amounts = $get_total->fetch_sum_date3Con('payments', 'amount_paid', 'post_date', 'posted_by', $detail->posted_by, 'start_dates', $from, 'end_dates', $to); */
                        foreach($amounts as $amount){
                            $paid_amount = $amount->total;
                        }
                        // if credit was sold
                        /*$get_credit = new selects ();
                        $credits = $get_credit->fetch_sum_2date2Cond('payments', 'amount_due', 'date(post_date)', 'payment_mode', 'posted_by', $from, $to, 'Credit', $detail->posted_by);
                        if(gettype($credits) === "array"){
                            foreach($credits as $credit){
                                $owed_amount = $credit->total;
                            }
                            $total_revenue = $owed_amount + $paid_amount;
                            echo "₦".number_format($total_revenue, 2);

                        }
                        //if no credit sales
                        if(gettype($credits) == "string"){ */
                            echo "₦".number_format($paid_amount, 2);
                            
                        // }
                    ?>
                </td>
                
                
            </tr>
            <?php $n++; }?>
            <tr>
                <td></td>
                <td style="color:green; font-size:1rem;">Total</td>
                <!-- <td></td> -->
                <td style="color:green; font-size:1rem">
                    <?php
                        $get_total = new selects();
                        $totals = $get_total->fetch_sum_2dateCond('payments', 'amount_paid', 'payment_mode', 'date(start_dates)', $from, $to, 'Cash');
                        /* $totals = $get_total->fetch_sum_date3Con('payments', 'amount_paid', 'post_date', 'payment_mode', 'Cash', 'start_dates', $from, 'end_dates', $to); */
                        foreach($totals as $total){
                            echo "₦".number_format($total->total, 2);
                        }
                    ?>
                </td>
                <td style="color:green; font-size:1rem">
                    <?php
                        $get_total = new selects();
                        $totals = $get_total->fetch_sum_2dateCond('payments', 'amount_paid', 'payment_mode', 'date(start_dates)', $from, $to, 'POS');
                        foreach($totals as $total){
                            echo "₦".number_format($total->total, 2);
                        }
                    ?>
                </td>
                <td style="color:green; font-size:1rem">
                    <?php
                        $get_total = new selects();
                        $totals = $get_total->fetch_sum_2dateCond('payments', 'amount_paid', 'payment_mode', 'date(start_dates)', $from, $to, 'Transfer');
                        foreach($totals as $total){
                            echo "₦".number_format($total->total, 2);
                        }
                    ?>
                </td>
                <!-- <td style="color:green; font-size:1rem">
                    <?php
                        $get_total = new selects();
                        $totals = $get_total->fetch_sum_2dateCond('payments', 'amount_paid', 'payment_mode', 'date(post_date)', $from, $to, 'Wallet');
                        foreach($totals as $total){
                            echo "₦".number_format($total->total, 2);
                        }
                    ?>
                </td> -->
                <!-- <td style="color:green; font-size:1rem">
                    <?php
                        /* $get_total = new selects();
                        $totals = $get_total->fetch_sum_2date2Cond('payments', 'amount_due', 'date(post_date)', 'payment_mode', 'store', $from, $to, 'Credit', $store);
                        foreach($totals as $total){
                            echo "₦".number_format($total->total, 2);
                        } */
                    ?>
                </td> -->
                <td style="color:red; font-size:1rem">
                    <?php
                        // get sum
                        $get_total = new selects();
                        $amounts = $get_total->fetch_sum_2dateCond('sales', 'total_amount', 'sales_status', 'date(start_dates)', $from, $to, 2);
                        foreach($amounts as $amount){
                            $paid_amount = $amount->total;
                        }
                        // if credit was sold
                        /*$get_credit = new selects();
                        $credits = $get_credit->fetch_sum_2dateCond('payments', 'amount_due', 'payment_mode', 'date(post_date)', $from, $to, 'Credit');
                        if(gettype($credits) === "array"){
                            foreach($credits as $credit){
                                $owed_amount = $credit->total;
                            }
                            $total_revenue = $owed_amount + $paid_amount;
                            echo "₦".number_format($total_revenue, 2);

                        }
                        //if no credit sales
                        if(gettype($credits) == "string"){ */
                            echo "₦".number_format($paid_amount, 2);
                            
                        // }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
<?php
    }else{
        echo "<p class='no_result'>'$details'</p>";
    }
    
?>
