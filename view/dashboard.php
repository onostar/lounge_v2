<div id="general_dashboard">
<div class="dashboard_all">
    <?php
        if($role == "Front Desk"){
    ?>
    <h3><i class="fas fa-home"></i> Front desk  <span style="color:var(--secondaryColor);font-size:1rem">Dashboard</span></h3>
    <?php }else{?>
    <h3><i class="fas fa-home"></i> Dashboard for <span style="color:var(--secondaryColor);font-size:1rem"><?php echo $store?></span></h3>
    <?php }?>
    <?php 
        if($role === "Admin" || $role == "Accountant"){
    ?>
    
    <div id="dashboard">
        <div class="cards" id="card4">
            <a href="javascript:void(0)" onclick="showPage('sales_report.php')">
                <div class="infos">
                    <p><i class="fas fa-coins"></i> Daily Revenue</p>
                    <p>
                    <?php
                        $get_sales = new selects();
                        
                        $rows = $get_sales->fetch_sum_startDayStore($start_day , 'total_amount', $store_id);
                       
                            $today_revenue = $rows->total;
                            echo "₦".number_format($today_revenue, 2);
                            
                       
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card1">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                     <p><i class="fas fa-users"></i> Cost of sales</p>
                    <p>
                    <?php
                        $get_cost = new selects();
                        $costs = $get_cost->fetch_sum_startDaySTore($start_day, 'cost', $store_id);
                        $sales_cost = $costs->total;
                        // foreach($costs as $cost){
                            echo "₦".number_format($sales_cost, 2);
                        // }
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card5" style="background:var(--primaryColor)">
            <a href="javascript:void(0)" class="page_navs" onclick="showPage('expense_report.php')">
                <div class="infos">
                    <p><i class="fas fa-hand-holding-dollar"></i> Daily Expense</p>
                    <p>
                    <?php
                        $get_exp = new selects();
                        $exps = $get_exp->fetch_sum_curdateCon('expenses', 'amount', 'date(expense_date)', 'store', $store_id);
                        foreach($exps as $exp){
                            $expense = $exp->total;
                            echo "₦".number_format($expense, 2);
                        }
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card0">
            <a href="javascript:void(0)" class="page_navs" onclick="showPage('post_sales_order.php')">
                <div class="infos">
                    <p><i class="fas fa-piggy-bank"></i> Receivables</p>
                    <p>
                    <?php
                        //total unpaid items
                        $get_tots = new selects();
                        $tots = $get_tots->fetch_sum_double('sales', 'total_amount', 'sales_status', 1, 'store', $store_id);
                        if(is_array($tots)){
                            foreach($tots as $tot){
                                $credit = $tot->total;
                            }
                        }else{
                            $credit = 0;
                        }
                        
                        echo "₦".number_format($credit, 2);
                    ?>
                    </p>
                </div>
            </a>
            
        </div> 
        
        
    </div>
    <?php
        }elseif($role == "Barman" || $role == "Kitchen Staff"){
    ?>
   
    <div id="dashboard">
        <div class="cards" id="card1">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-box-open"></i> Orders Dispensed</p>
                    <p>
                    <?php
                        //get total customers
                       $get_cus = new selects();
                       $orders =  $get_cus->fetch_sum_date3Con('sales', 'quantity', 'start_dates', 'dispensed_by', $user_id,  $start_day);
                       if(is_array($orders)){
                            foreach($orders as $ord){
                                $total_order = $ord->total;
                            }
                       }else{
                        $total_order = 0;
                       }
                       echo $total_order;
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card4">
            <a href="javascript:void(0)" onclick="showPage('dispense_order.php')">
                <div class="infos">
                    <p><i class="fas fa-coins"></i> Pending Dispense</p>
                    <p>
                        <?php
                            $dispenses = $get_cus->fetch_sum_double('sales', 'quantity',  'add_order', 1, 'store', $store_id);
                            if(is_array($dispenses)){
                                foreach($dispenses as $dispen){
                                    $dispense = $dispen->total;
                                }
                            }else{
                                $dispense = 0;
                            }
                            echo $dispense;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card3">
            <a href="javascript:void(0)" onclick="showPage('expired_items.php')" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-money-check"></i> Expired items</p>
                    <p>
                        <?php
                            $get_expired = new selects();
                            $expired = $get_expired->fetch_expired('inventory', 'expiration_date', 'quantity', 'store', $store_id);
                            echo $expired;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card2" style="background: var(--moreColor)">
            <a href="javascript:void(0)" class="page_navs" onclick="showPage('reached_reorder.php')">
                <div class="infos">
                    <p><i class="fas fa-hand-holding-dollar"></i> Out of stock</p>
                    <p>
                        <?php
                            $out_stock = new selects();
                            $stock = $out_stock->fetch_count_2cond('inventory', 'quantity', 0, 'store', $store_id);
                            echo $stock;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
            
    </div>
    <?php
        }elseif($role == "Sales Rep"){
    ?>
   
    <div id="dashboard">
        <div class="cards" id="card1">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-users"></i> Total Customers</p>
                    <p>
                    <?php
                        //get total customers
                       $get_cus = new selects();
                       $customers =  $get_cus->fetch_count_1cond1neg1DateGro('sales', 'sales_status', 0, 'posted_by', $user_id, 'start_dates', $start_day, 'invoice');
                       echo $customers;
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card4">
            <a href="javascript:void(0)" onclick="showPage('post_sales_order.php')">
                <div class="infos">
                    <p><i class="fas fa-coins"></i> Active Table</p>
                    <p>
                        <?php
                            //get total customers
                            $active =  $get_cus->fetch_count_2cond1DateGro('sales', 'sales_status', 1, 'posted_by', $user_id, 'start_dates', $start_day, 'invoice');
                            echo $active;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card3">
            <a href="javascript:void(0)" onclick="showPage('expired_items.php')" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-money-check"></i> Expired items</p>
                    <p>
                        <?php
                            $get_expired = new selects();
                            $expired = $get_expired->fetch_expired('inventory', 'expiration_date', 'quantity', 'store', $store_id);
                            echo $expired;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card2" style="background: var(--moreColor)">
            <a href="javascript:void(0)" class="page_navs" onclick="showPage('reached_reorder.php')">
                <div class="infos">
                    <p><i class="fas fa-hand-holding-dollar"></i> Out of stock</p>
                    <p>
                        <?php
                            $out_stock = new selects();
                            $stock = $out_stock->fetch_count_2cond('inventory', 'quantity', 0, 'store', $store_id);
                            echo $stock;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
            
    </div>
    <?php
        }else{
    ?>
   
    <div id="dashboard">
        <div class="cards" id="card1">
            <a href="javascript:void(0)" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-users"></i> Customers</p>
                    <p>
                    <?php
                        //get total customers
                       $get_cus = new selects();
                       $customers =  $get_cus->fetch_count_2cond1DateGro('sales', 'sales_status', 2, 'posted_by', $user_id, 'start_dates', $start_day, 'invoice');
                       echo $customers;
                    ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card4">
            <a href="javascript:void(0)" onclick="showPage('expire_soon.php')">
                <div class="infos">
                    <p><i class="fas fa-coins"></i> Pending Payment</p>
                    <p>
                        <?php
                            //get pending payment
                            $pays = $get_cus->fetch_sum_specdate3Con('sales', 'total_amount', 'start_dates', $start_day, 'sales_status', 1, 'store', $store_id);
                            if(is_array($pays)){
                                foreach($pas as $pay){
                                    $debt = $pay->total;
                                }
                            }else{
                                $debt = 0;
                            }
                            
                            echo "₦".number_format($debt, 2);
                        ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card3">
            <a href="javascript:void(0)" onclick="showPage('expired_items.php')" class="page_navs">
                <div class="infos">
                    <p><i class="fas fa-money-check"></i> Expired items</p>
                    <p>
                        <?php
                            $get_expired = new selects();
                            $expired = $get_expired->fetch_expired('inventory', 'expiration_date', 'quantity', 'store', $store_id);
                            echo $expired;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
        <div class="cards" id="card2" style="background: var(--moreColor)">
            <a href="javascript:void(0)" class="page_navs" onclick="showPage('reached_reorder.php')">
                <div class="infos">
                    <p><i class="fas fa-hand-holding-dollar"></i> Out of stock</p>
                    <p>
                        <?php
                            $out_stock = new selects();
                            $stock = $out_stock->fetch_count_2cond('inventory', 'quantity', 0, 'store', $store_id);
                            echo $stock;
                        ?>
                    </p>
                </div>
            </a>
        </div> 
            
    </div>
    <?php }?>
</div>
<?php 
    if($role === "Admin" || $role === "Accountant"){
?>
<!-- management summary -->
<div id="paid_receipt" class="management">
    <hr>
    <div class="daily_monthly">
        <!-- daily revenue summary -->
        <div class="daily_report allResults">
            <h3 style="background:var(--otherColor)">Daily Sales Record</h3>
            <table>
                <thead>
                    <tr>
                        <td>S/N</td>
                        <td>Date</td>
                        <td>Customers</td>
                        <td>Revenue</td>
                    </tr>
                </thead>
                <?php
                    $n = 1;
                    $get_daily = new selects();
                    $dailys = $get_daily->fetch_daily_salesDate($store_id);
                    if(gettype($dailys) == "array"){
                    foreach($dailys as $daily):

                ?>
                <tbody>
                    <tr>
                        <td><?php echo $n?></td>
                        <td><?php echo date("jS M, Y",strtotime($daily->start_dates))?></td>  
                        <td style="text-align:center; color:var(--otherColor)"><?php echo $daily->customers?></td>
                        <td style="color:green;"><?php echo "₦".number_format($daily->revenue)?></td>
                    </tr>
                </tbody>
                <?php $n++; endforeach; }?>

                
            </table>
            <?php
                if(gettype($dailys) == "string"){
                    echo "<p class='no_result'>'$dailys'</p>";
                }
            ?>
        </div>
        <!-- monthly revenue summary -->
        <div class="monthly_report allResults">
            <div class="chart">
                <!-- chart for technical group -->
                <?php
                $get_monthly = new selects();
                $monthlys = $get_monthly->fetch_monthly_salesDate($store_id);
                if(gettype($monthlys) == "array"){
                    foreach($monthlys as $monthly){
                        $revenue[] = $monthly->revenue;
                        $month[] = date("M, Y", strtotime($monthly->start_dates));
                    }
                }
                ?>
                <h3 style="background:var(--moreColor)">Monthly statistics</h3>
                <canvas id="chartjs_bar2"></canvas>
            </div>
            <div class="monthly_encounter">
                <h3>Monthly Sales Record</h3>
                <table>
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>Month</td>
                            <td>Customers</td>
                            <td>Amount</td>
                            <td>Daily Average</td>
                        </tr>
                    </thead>
                    <?php
                        $n =1;
                        $get_monthly = new selects();
                        $monthlys = $get_monthly->fetch_monthly_salesDate($store_id);
                        if(gettype($monthlys) == "array"){
                        foreach($monthlys as $monthly):

                    ?>
                    <tbody>
                        <tr>
                            <td><?php echo $n?></td>
                            <td><?php echo date("M, Y", strtotime($monthly->start_dates))?></td>
                            <td style="text-align:center; color:var(--otherColor"><?php echo $monthly->customers?></td>
                            <td style="text-align:center; color:green"><?php echo "₦".number_format($monthly->revenue)?></td>
                            <td style="text-align:center; color:red"><?php
                                $average = $monthly->revenue/$monthly->daily_average;
                                echo "₦".number_format($average, 2);
                            ?></td>
                        </tr>
                    </tbody>
                    <?php $n++; endforeach; }?>

                    
                </table>
                <?php 
                    if(gettype($monthlys) == "string"){
                        echo "<p class='no_result'>'$monthlys'</p>";
                    }
                ?>
            </div>
        </div>
        
    </div>
</div>

<?php 
    }elseif($role == "Sales Rep"){
?>
<div class="check_out_due">
    <hr>
    <div class="displays allResults" id="check_out_guest">
       
        <h3 style="background:var(--otherColor)">My Daily transactions</h3>
        <table id="check_out_table" class="searchTable" style="width:100%;">
            <thead>
                <tr style="background:var(--moreColor)">
                    <td>S/N</td>
                    <td>Invoice</td>
                    <td>Item</td>
                    <td>Qty</td>
                    <td>Unit sales</td>
                    <td>Amount</td>
                    <td>Status</td>
                    <td>Dispensed By</td>
                    <td>Order Time</td>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $n = 1;
                    $get_users = new selects();
                    $details = $get_users->fetch_rep_orders($user_id, $store_id, $start_day);
                    if(gettype($details) === 'array'){
                    foreach($details as $detail):
                ?>
                <tr>
                    <td style="text-align:center; color:red;"><?php echo $n?></td>
                    <td style="color:green"><?php echo $detail->invoice?></td>
                    <td>
                        <?php
                            $get_name = new selects();
                            $name = $get_name->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                            echo $name->item_name;
                        ?>
                    </td>
                    <td style="text-align:center; color:var(--otherColor)"><?php echo $detail->quantity?></td>
                    <td><?php echo "₦".number_format($detail->price)?></td>
                    <td><?php echo "₦".number_format($detail->total_amount)?></td>
                    <td>
                        <?php
                            if($detail->add_order == 0){
                                echo "<span style='color:green'>Dispensed</span>";
                            }else{
                                echo "<span style='color:red'>Pending</span>";
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if($detail->add_order == 0){
                                $get_name = new selects();
                                $names = $get_name->fetch_details_group('users', 'full_name', 'user_id', $detail->dispensed_by);
                                echo $names->full_name;
                            }else{
                                echo "";
                            }
                        ?>
                    </td>
                    <td><?php echo date("h:i:sa", strtotime($detail->post_date))?></td>
                </tr>
                <?php $n++; endforeach;}?>
            </tbody>
        </table>
        
        <?php
            if(gettype($details) == "string"){
                echo "<p class='no_result'>'$details'</p>";
            }
        ?>
    </div>
</div>
<?php 
    }elseif($role == "Barman" || $role == "Kitchen Staff"){
?>
<div class="check_out_due">
    <hr>
    <div class="displays allResults" id="check_out_guest">
       
        <h3 style="background:var(--otherColor)">My Daily transactions</h3>
        <table id="check_out_table" class="searchTable" style="width:100%;">
            <thead>
                <tr style="background:var(--moreColor)">
                    <td>S/N</td>
                    <td>Invoice</td>
                    <td>Item</td>
                    <td>Qty</td>
                    <td>Ordered By</td>
                    <td>Time</td>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $n = 1;
                    $get_users = new selects();
                    $details = $get_users->fetch_dispense($user_id, $store_id, $start_day);
                    if(gettype($details) === 'array'){
                    foreach($details as $detail):
                ?>
                <tr>
                    <td style="text-align:center; color:red;"><?php echo $n?></td>
                    <td style="color:green"><?php echo $detail->invoice?></td>
                    <td>
                        <?php
                            $get_name = new selects();
                            $name = $get_name->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                            echo $name->item_name;
                        ?>
                    </td>
                    <td style="text-align:center; color:var(--otherColor)"><?php echo $detail->quantity?></td>
                    <td>
                        <?php
                            $get_name = new selects();
                            $names = $get_name->fetch_details_group('users', 'full_name', 'user_id', $detail->order_by);
                            echo $names->full_name;
                        ?>
                    </td>
                    <td><?php echo date("h:i:sa", strtotime($detail->dispense_date))?></td>
                </tr>
                <?php $n++; endforeach;}?>
            </tbody>
        </table>
        
        <?php
            if(gettype($details) == "string"){
                echo "<p class='no_result'>'$details'</p>";
            }
        ?>
    </div>
</div>
<?php 
    }else{
?>
<div class="check_out_due">
    <hr>
    <div class="displays allResults" id="check_out_guest">
       
        <h3 style="background:var(--otherColor)">My Daily transactions</h3>
        <table id="check_out_table" class="searchTable" style="width:100%;">
            <thead>
                <tr style="background:var(--moreColor)">
                    <td>S/N</td>
                    <td>Invoice</td>
                    <td>Item</td>
                    <td>Qty</td>
                    <td>Unit sales</td>
                    <td>Amount</td>
                    <td>Ordered By</td>
                    <td>mode</td>
                    <td>Time</td>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $n = 1;
                    $get_users = new selects();
                    $details = $get_users->fetch_cashier_sales($user_id, $store_id, $start_day);
                    if(gettype($details) === 'array'){
                    foreach($details as $detail):
                ?>
                <tr>
                    <td style="text-align:center; color:red;"><?php echo $n?></td>
                    <td style="color:green"><?php echo $detail->invoice?></td>
                    <td>
                        <?php
                            $get_name = new selects();
                            $name = $get_name->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                            echo $name->item_name;
                        ?>
                    </td>
                    <td style="text-align:center; color:var(--otherColor)"><?php echo $detail->quantity?></td>
                    <td><?php echo "₦".number_format($detail->price)?></td>
                    <td><?php echo "₦".number_format($detail->total_amount)?></td>
                    <td>
                        <?php
                            $get_name = new selects();
                            $names = $get_name->fetch_details_group('users', 'full_name', 'user_id', $detail->order_by);
                            echo $names->full_name;
                        ?>
                    </td>
                    <td>
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
                    </td>
                    <td><?php echo date("h:i:sa", strtotime($detail->post_date))?></td>
                </tr>
                <?php $n++; endforeach;}?>
            </tbody>
        </table>
        
        <?php
            if(gettype($details) == "string"){
                echo "<p class='no_result'>'$details'</p>";
            }
        ?>
    </div>
</div>
<?php
    }
?>
</div>