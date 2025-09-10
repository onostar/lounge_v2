<?php
    session_start();
    $store = $_SESSION['store_id'];
    if(isset($_GET['waiter'])){
        $waiter = $_GET['waiter'];
    }
    $from = $_SESSION['fromDate'];
    $to = $_SESSION['toDate'];
    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";
    //get item name
    $get_name = new selects();
    $names = $get_name->fetch_details_group('users', 'full_name', 'user_id', $waiter);
    $name = $names->full_name;
    //get purchase history
    $get_purchase = new selects();
    $details = $get_purchase->fetch_waiter_order($waiter, $store, $from, $to);
    $n = 1;
?>
<div class="search">
    <input type="search" id="searchPurchase" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Waiter order report for <?php echo $name?>')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
</div>
<h3 style="background:red; text-align:center; color:#fff; padding:10px;">Waiter Order for <?php echo strtoupper($name)?> between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h3>
    
    <table id="data_table" class="searchTable">
        <thead>
        <tr style="background:var(--primaryColor)">
                <td>S/N</td>
                <td>Invoice</td>
                <td>Item</td>
                <td>Qty</td>
                <td>Price</td>
                <td>Total</td>
                <td>Status</td>
                <td>Date</td>
                <td>Time</td>
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
                <td><?php echo $detail->invoice?></td>
                <td>
                    <?php
                        $get_guest = new selects();
                        $rows = $get_guest->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                        echo $rows->item_name;
                    ?>
                </td>
                
                <td style="text-align:center; color:green;"><?php echo $detail->quantity;?></td>
                <td><?php echo "₦".number_format($detail->price, 2)?></td>
                <td>
                    <?php
                        $total_cost = $detail->quantity * $detail->price; 
                        echo "₦".number_format($total_cost, 2)
                    ?>
                </td>
                <td>
                    <?php
                        if($detail->sales_status == 2){
                            echo "<p style='color:green'>Paid</p>";
                        }else{
                            echo "<p style='color:red'>Not paid</p>";
                        }
                    ?>
                </td>
                <td style="color:var(--otherColor)"><?php echo date("d-M-Y", strtotime($detail->post_date));?></td>
                <td style="color:var(--moreColor)"><?php echo date("H:i:sa", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $posted_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $posted_by->full_name;
                    ?>
                </td>
                
            </tr>
            <?php $n++; }}?>
        </tbody>
    </table>
<?php
    if(gettype($details) == "string"){
        echo "<p class='no_result'>'$details'</p>";
    }
    // get sum
    $get_total = new selects();
    $amounts = $get_total->fetch_sum_2col2date2con('sales', 'price', 'quantity', 'date(post_date)', $from, $to, 'order_by', $waiter, 'sales_status', 2);
    foreach($amounts as $amount){
        echo "<p class='total_amount' style='color:green; text-align:center'>Total Sales: ₦".number_format($amount->total, 2)."</p>";
    }
    
?>
