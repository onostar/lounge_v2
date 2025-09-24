<?php
    session_start();
    $store = $_SESSION['store_id'];
    $user = $_SESSION['user_id'];
    $role = $_SESSION['role'];
    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<div id="postSales" class="displays management">
    <!-- <div class="select_date" style="width:100%;">
       
        <section>    
            <div class="from_to_date" style="width:20%;">
                <label>Select From Date</label><br>
                <input type="date" name="from_date" id="from_date"><br>
            </div>
            <div class="from_to_date" style="width:20%;">
                <label>Select to Date</label><br>
                <input type="date" name="to_date" id="to_date"><br>
            </div>
            <button type="submit" name="search_date" style="width:25%;" id="search_date" onclick="search('search_sales_order.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div> -->
<div class="displays allResults new_data" id="revenue_report" style="margin:0!important; width:100%!important">
    <h2>Print Docket for Pending Orders</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Sales orders')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Invoice</td>
                <td>Date</td>
                <td>Post Time</td>
                <td>Amount</td>
                <td>Total Items</td>
                <td>Ordered by</td>
                <td></td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_2condGroup('sales', 'store', 'add_order', $store, 1, 'invoice');
                
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><a style="color:green" href="javascript:void(0)" title="View invoice details"><?php echo $detail->invoice?></a></td>
                <td style="color:var(--otherColor)"><?php echo date("d-M-Y", strtotime($detail->post_date));?></td>
                <td style="color:var(--moreColor)"><?php echo date("h:i:sa", strtotime($detail->post_date));?></td>
                <td style="color:red">
                    <?php
                        //get total on invoice
                        $ttls = $get_users->fetch_sum_double('sales', 'total_amount', 'invoice', $detail->invoice, 'add_order', 1);
                        foreach($ttls as $ttl){
                            $total = $ttl->total;
                        }
                        echo "₦".number_format($total, 2)
                    ?>
                </td>
                <td style="text-align:center">
                    <?php
                        //get items in invoice;
                        $get_items = new selects();
                        $items = $get_items->fetch_count_2cond('sales', 'invoice', $detail->invoice, 'add_order', 1);
                        echo $items;
                    ?>
                </td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->order_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <!-- <td>
                    <?php
                        //get posted by
                       /*  $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name; */
                    ?>
                </td> -->
                <td>
                    <a style="background:green; color:#fff; padding:5px 10px; border-radius:5px;" href="javascript:void(0)" title="Print Docket" onclick="printSalesTicket('<?php echo $detail->invoice?>')"><i class="fas fa-print"></i> Print</a>
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

</div>

<script src="../jquery.js"></script>
<script src="../script.js"></script>