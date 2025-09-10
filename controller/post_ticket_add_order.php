<?php
// session_start();
// instantiate class
include "../classes/dbh.php";
include "../classes/update.php";
include "../classes/select.php";
include "../classes/inserts.php";
    session_start();
    if(isset($_SESSION['user_id'])){
        $user = $_SESSION['user_id'];
            $invoice = $_POST['sales_invoice'];
           $store = $_SESSION['store_id'];
           $trans_type ="sales";
       
        //update all items with this invoice
        $update_invoice = new Update_table();
        $update_invoice->update('sales', 'sales_status', 'invoice', 1, $invoice);
            if($update_invoice){
                //update quantity of the items in inventory
                //get all items first in the invoice
                $get_items = new selects();
                $rows = $get_items->fetch_details_2cond('sales', 'invoice', 'add_order', $invoice, 1);
                
                foreach($rows as $row){
                    //update individual quantity in inventory
                    $update_qty = new Update_table();
                    $update_qty->update_inv_qty($row->quantity, $row->item, $store);
                    
                }
                 //insert into audit trail
                //get items and quantity sold in the invoice
                $get_item = new selects();
                $items = $get_item->fetch_details_2cond('sales', 'invoice', 'add_order', $invoice, 1);
                foreach($items as $item){
                    $all_item = $item->item;
                    $sold_qty = $item->quantity;
                    //get item previous quantity in inventory
                    $get_qty = new selects();
                    $prev_qtys = $get_qty->fetch_details_2cond('inventory', 'store', 'item', $store, $all_item);
                    foreach($prev_qtys as $prev_qty){    
                        //insert into audit trail
                        $inser_trail = new audit_trail($all_item, $trans_type, $prev_qty->quantity, $sold_qty, $user, $store);
                        $inser_trail->audit_trail();
                    
                    }
                }
                //update all items with add order status to 0
           /*  $update_stat = new Update_table();
            $update_stat->update('sales', 'add_order', 'invoice', 0, $invoice); */
?>
<div class="notify">
    <p>Order Saved Succesfully <i class="fas fa-thumbs-up"></i></p>
</div>
<!-- <div id="printBtn">
    <button onclick="printSalesTicket('<?php echo $invoice?>')">Print Docket <i class="fas fa-print"></i></button>
</div> -->
<!--  -->
   
<?php
    // echo "<script>window.print();</script>";
                    // }
                }
            
        
    }else{
        header("Location: ../index.php");
    } 
?>