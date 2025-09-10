<?php
    session_start();
    $store = $_SESSION['store_id'];
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_revenue = new selects();
    $details = $get_revenue->fetch_details_2date2Con('sales', 'date(start_dates)', $from, $to, 'add_order', 0, 'store', $store);
    // $details = $get_revenue->fetch_sales_report( $store, $from, $to);
    $n = 1;
?>
<h2>Dispense Report between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRevenue" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Dispense report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
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
    if(gettype($details) === 'array'){
    foreach($details as $detail){

?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><a style="color:green" href="javascript:void(0)"><?php echo $detail->invoice?></a></td>
                <td>
                    <?php
                        //get item name
                        $names = $get_revenue->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                        echo $names->item_name;
                    ?>
                </td>
		        <td style="color:green; text-align:center"><?php echo $detail->quantity?></td>
                
                <td style="color:var(--moreColor)"><?php echo date("d-M-Y, H:ia", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_revenue->fetch_details_group('users', 'full_name', 'user_id', $detail->order_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td>
                    <?php
                        //get posted by
                        $checkedin_by = $get_revenue->fetch_details_group('users', 'full_name', 'user_id', $detail->dispensed_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td style="color:var(--moreColor)"><?php echo date("d-m-Y, H:ia", strtotime($detail->dispense_date));?></td>
                
            </tr>
            <?php $n++; }?>
        </tbody>
    </table>
<?php
    }else{
        echo "<p class='no_result'>'$details'</p>";
    }
?>
