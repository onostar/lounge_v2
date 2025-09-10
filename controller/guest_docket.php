
<?php
    include "receipt_style.php";
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/select.php";
include "../classes/update.php";
    session_start();
    if(isset($_GET['receipt'])){
        $user = $_SESSION['user_id'];
        $invoice = $_GET['receipt'];
        //get store
        $get_store = new selects();
        $strs = $get_store->fetch_details_cond('sales', 'invoice', $invoice);
        foreach($strs as $str){
            $store = $str->store;
            $customer = $str->customer;
        }
        //get order by
        $get_order = new selects();
        $ord = $get_order->fetch_details_group('sales', 'order_by', 'invoice', $invoice);
        $order = $ord->order_by;
        //get store name
        $get_store_name = new selects();
        $rows = $get_store_name->fetch_details_cond('stores', 'store_id', $store);
        foreach($rows as $row){
            $store_name = $row->store;
            $address = $row->store_address;
            $phone = $row->phone_number;

        }
        //get post date and time
        $get_date = new selects();
        $dts = $get_date->fetch_details_cond('sales', 'invoice', $invoice);
        foreach($dts as $dt){
            $posted_date = $dt->post_date;
        }
        //get room
        $get_room = new selects();
        $rooms = $get_room->fetch_details_group('check_ins', 'room', 'checkin_id', $customer);
        $room = $rooms->room;
?>
<div class="displays allResults sales_receipt">
<h2><?php echo $_SESSION['company'];?></h2>
    <p><?php echo $address?></p>
    <p>Tel: <?php echo $phone?></p>
    <!-- get sales type -->
        <p>Date: <?php echo date("d-m-Y", strtotime($posted_date))?>, <?php echo date("h:i:sa", strtotime($posted_date))?></p>

    <div class="receipt_head">
        <p><?php echo $invoice?></p>
    <p>ORDER TICKET <strong>(Room <?php echo $room?>)</strong></p>
    </div>
    <table id="postsales_table" class="searchTable" style="border-collapse:collapse;">
        <thead>
            <tr style="background:var(--moreColor)">
                <td style="text-align:center">S/N</td>
                <td>Item</td>
                <td style="text-align:center">Qty</td>
            </tr>
        </thead>
        <tbody>
        <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details_2cond('sales','invoice', 'add_order', $invoice, 1);
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr style="font-size:.9rem">
                <td style="text-align:center; color:red; font-size:.7rem"><?php echo $n?></td>
                <td style="color:var(--moreClor); font-size:.7rem">
                    <?php
                        //get category name
                        $get_item_name = new selects();
                        $item_name = $get_item_name->fetch_details_group('items', 'item_name', 'item_id', $detail->item);
                        echo $item_name->item_name;
                    ?>
                </td>
                <td style="text-align:center; color:red; font-size:.7rem"><?php echo $detail->quantity?>
                    
                </td>
                
            </tr>
            <?php endforeach; }?>
        </tbody>
    </table>

    <?php
        //sold by
        $get_seller = new selects();
        $row = $get_seller->fetch_details_group('users', 'full_name', 'user_id', $order);
        echo ucwords("<p class='sold_by'>Ordered by: <strong>$row->full_name</strong></p>");
    ?>
    
</div> 
   
<?php
    echo "<script>window.print();
    window.close();</script>";
                    // }
                }
            // }
        
    // }
    
?>