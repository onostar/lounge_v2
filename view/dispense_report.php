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
            <button type="submit" name="search_date" id="search_date" onclick="search('search_dispense_report.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div>
<div class="displays allResults new_data" id="revenue_report">
    <h2>Dispense Report for today</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'dispense report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--primaryColor)">
                <td>S/N</td>
                <td>Invoice</td>
                <td>Item</td>
		        <td>Qty</td>
                <td>Order Date</td>
                <td>Ordered by</td>
                <td>Dispensed by</td>
                <td>Dispensed Date</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                /* $details = $get_users->fetch_details_date2Cond('sales', 'date(post_date)', 'sales_status', 2, 'store', $store); */
                $details = $get_users->fetch_details_specdate2Con('sales', 'start_dates', $start_day, 'add_order', 0, 'store', $store);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><a style="color:green" href="javascript:void(0)"><?php echo $detail->invoice?></a></td>
                <td>
                    <?php
                        //get item name
                        $names = $get_users->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                        echo $names->item_name;
                    ?>
                </td>
		        <td style="color:green; text-align:center"><?php echo $detail->quantity?></td>
                
                <td style="color:var(--moreColor)"><?php echo date("d-M-Y, H:ia", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_users->fetch_details_group('users', 'full_name', 'user_id', $detail->order_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_users->fetch_details_group('users', 'full_name', 'user_id', $detail->dispensed_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td style="color:var(--moreColor)"><?php echo date("d-m-Y, H:ia", strtotime($detail->dispense_date));?></td>
                
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

<script src="../jquery.js"></script>
<script src="../script.js"></script>