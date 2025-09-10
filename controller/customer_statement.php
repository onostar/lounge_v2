<?php
    session_start();
    $store = $_SESSION['store_id'];
    if(isset($_GET['customer'])){
        $customer = $_GET['customer'];
    }
    /* $from = $_SESSION['fromDate'];
    $to = $_SESSION['toDate']; */
   /*  $to = htmlspecialchars(stripslashes($_POST['toDate']));
    $from = htmlspecialchars(stripslashes($_POST['fromDate'])); */
    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";
    //get customer details
    $get_customer = new selects();
    $rows = $get_customer->fetch_details_cond('guests', 'guest_id', $customer);
    foreach($rows as $row){
        $name = $row->last_name." ".$row->other_names;
        $phone = $row->contact_phone;
        $address = $row->contact_address;
        // $email = $row->contact_email;
        $joined = $row->reg_date;
        $wallet = $row->wallet;
    }
    
?>
<!-- customer info -->
<div class="close_btn">
    <a href="javascript:void(0)" title="Close form" onclick="showPage('../view/customer_statement.php');" class="close_form">Close <i class="fas fa-close"></i></a>
</div>
<div class="customer_info" class="allResults">
    <h3 style="background:var(--tertiaryColor)">Check-in report for <?php echo $name?></h3>
    <div class="demography">
        <div class="demo_block">
            <h4><i class="fas fa-id-card"></i> Name:</h4>
            <p><?php echo $name?></p>
        </div>
        <div class="demo_block">
            <h4><i class="fas fa-map"></i> Address:</h4>
            <p><?php echo $address?></p>
        </div>
        <div class="demo_block">
            <h4><i class="fas fa-phone-square"></i> Phone numbers:</h4>
            <p><?php echo $phone?></p>
        </div>
        <!-- <div class="demo_block">
            <h4><i class="fas fa-envelope"></i> Email:</h4>
            <p><?php echo $email?></p>
        </div> -->
        <div class="demo_block">
            <h4><i class="fas fa-calendar"></i> First checked in:</h4>
            <p><?php echo date("jS M, Y", strtotime($joined))?></p>
        </div>
        <div class="demo_block" style="color:green">
            <h4 style="color:green"><i class="fas fa-piggy-bank"></i> Wallet:</h4>
            <p><?php echo "₦".number_format($wallet, 2)?>
                <?php if($wallet > 0){?>
                <a href="javascript:void(0)" style="color:#fff;padding:5px; background:green;border:1px;border-radius:15px;box-shadow:1px 1px 1px #c4c4c4" title="Refund amount" onclick="showPage('refund_guest.php?guest=<?php echo $customer?>')">Refund <i class="fas fa-arrow-circle-left"></i></a>
                <?php }?>
            </p>
        </div>
    </div>
    <!-- <h3 style="background:red; text-align:center; color:#fff; padding:10px;margin:0;">Check in details</h3> -->
    <div class="transactions">
        <div class="all_credit allResults" style="width:100%">
            <h3 style="background:var(--otherColor); color:#fff"><i class="fas fa-house"></i> Check in report for <?php echo $name?></h3>
            <table id="data_table" class="searchTable">
                <thead>
                <tr style="background:var(--primaryColor)">
                        <td>S/N</td>
                        <td>Checked in</td>
                        <td>Checked in by</td>
                        <td>Extend stay</td>
                        <td>Extended by</td>
                        <td>Checked out</td>
                        <td>Checked out by</td>
                        <td>Amount due</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //get transaction history
                        $get_transactions = new selects();
                        $details = $get_transactions->fetch_details_cond('check_ins', 'guest', $customer);
                        $n = 1;
                        if(gettype($details) === 'array'){
                        foreach($details as $detail){
                            //get room name;
                            $get_room = new selects();
                            $rowss = $get_room->fetch_details_cond('items', 'item_id', $detail->room);
                            foreach($rowss as $rows){
                                $room = $rows->item_name;
                                $category = $rows->category;
                            }
                            //get room category
                            $get_cat_name = new selects();
                            $room_cat = $get_cat_name->fetch_details_group('categories', 'category', 'category_id', $category);
                            $cat_name = $room_cat->category;
                    ?>
                    <tr>
                    
                <!-- <td><?php echo $detail->contact_phone?></td> -->
                <td><?php echo $n?></td>
                <td><?php echo date("jS M, Y", strtotime($detail->check_in_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                <td>
                    <?php 
                        if($detail->extended_by == 0){
                            echo "<span style='color:red'>Not extended</span>";
                        }else{
                            echo date("jS M, Y", strtotime($detail->date_extended));
                        }
                    ?>
                </td>
                <td>
                    <?php
                        if($detail->extended_by == 0){
                            echo "";
                        }else{
                            //get extended by
                            $get_posted_by = new selects();
                            $extended_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->extended_by);
                            echo $extended_by->full_name;
                        }
                    ?>
                </td>
                <td>
                    <?php
                        if($detail->guest_status == 1){
                            echo "<span style='color:green'>Still checked in</span>";
                        }else if($detail->guest_status == -1){
                            echo "<span style='color:red'>cancelled (".date("jS M, Y", strtotime($detail->cancel_check)).")</span>";
                        }else{
                            echo date("jS M, Y", strtotime($detail->checked_out));
                        }
                    ?>
                </td>
                <td>
                    <?php
                        if($detail->guest_status == 1){
                            echo "";
                        }else if($detail->guest_status == -1){
                            //get cancel by
                            $get_cancel_by = new selects();
                            $cancelled_by = $get_cancel_by->fetch_details_group('users', 'full_name', 'user_id', $detail->cancelled_by);
                            echo $cancelled_by->full_name;
                        }else{
                            //get posted by
                            $get_posted_by = new selects();
                            $checkedout_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->checked_out_by);
                            echo $checkedout_by->full_name;
                        }
                    ?>
                </td>
                <td style="color:var(--secondaryColor)"><?php echo "₦".number_format($detail->amount_due, 2)?></td>
                <td>
                    <a style="background:var(--otherColor); color:#fff; padding:5px; border-radius:10px" href="javascript:void(0)" title="View guest details" onclick="showPage('guest_details.php?guest_id=<?php echo $detail->checkin_id?>')">view bill <i class="fas fa-eye"></i></a>
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
                $amounts = $get_total->fetch_sum_single('check_ins', 'amount_due', 'guest', $customer);
                if(gettype($amounts) == "array"){
                    foreach($amounts as $amount){
                        $paid_amount = $amount->total;
                    }
                    echo "<p class='total_amount' style='color:red'>Amount due: ₦".number_format($paid_amount, 2)."</p>";

                }
                
            ?>
        </div>
        
    </div>
    <div id="customer_invoices">
        
    </div>
</div>