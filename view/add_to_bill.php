<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        if(isset($_GET['invoice'])){
            $invoice = $_GET['invoice'];
            $get_waiter = new selects();
            $wait = $get_waiter->fetch_details_group('sales', 'order_by', 'invoice', $invoice);
            $waiter = $wait->order_by;
            $get_waiter_name = new selects();
            $rows = $get_waiter_name->fetch_details_group('users', 'full_name', 'user_id', $waiter);
            $waiter_name = $rows->full_name;
?>
<div id="sales_order">
<div id="sales_form" class="displays all_details">
    <?php
       
        // $_SESSION['invoice'] = $invoice;
    ?>
    <button class="page_navs" id="back" onclick="showPage('sales_details.php?invoice=<?php echo $invoice?>')"><i class="fas fa-angle-double-left"></i> Back</button>
    <div class="add_user_form" style="width:50%; margin:10px 0; box-shadow:none">
        <h3 style="background:var(--tertiaryColor); color:#ff; text-align:left!important;" >Add order to invoice <?php echo $invoice?></h3>
        
            <!-- search forms -->
        <!-- <form method="POST" id="addUserForm"> -->
            <section class="addUserForm">
                <div class="inputs">
                    <!-- bar items form -->
                    <div class="data" id="bar_items" style="width:100%; margin:2px 0">
                        <label for="item"> Search Items</label>
                        <input type="hidden" name="invoice" id="invoice" value="<?php echo $invoice?>">
                        <input type="hidden" name="staff" id="staff" value="<?php echo $staff?>">
                        <input type="hidden" name="order_by" id="order_by" value="<?php echo $waiter?>">
                        <input type="hidden" name="add_order" id="add_order" value="1">
                        <input type="text" name="item" id="item" required placeholder="Input item name or barcode" onkeyup="getItemsOrder(this.value)">
                        <div id="sales_item">
                            
                        </div>
                    </div>
                    
                </div>
            </section>
            
        </div>
    </div>

</div>
<!-- for editing item quantitiy and price -->
<div class="show_more"></div>
<!-- showing all items in the sales order -->
<div class="sales_order"></div>
<?php
        }
    }else{
        header("Location: ../index.php");
    }
?>
</div>