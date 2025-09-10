<div id="guest_details">
<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $store = $_SESSION['store'];
        // echo $user_id;
        $date = date("Y-m-d H:i:s");
    
    if(isset($_GET['guest_id'])){
        $check_id = $_GET['guest_id'];
        $get_user = new selects();
        $details = $get_user->fetch_details_cond('check_ins', 'checkin_id', $check_id);
        foreach($details as $detail){
        //get guest information
        $get_guest = new selects();
        $results = $get_guest->fetch_details_cond('guests', 'guest_id', $detail->guest);
        foreach($results as $result){
            $fullname = $result->last_name." ".$result->other_names;
            $gender = $result->gender;
            $wallet = $result->wallet;
            $guest_id = $result->guest_id;
        }

?>

<div class="info"></div>
<div class="displays all_details">
    <!-- <div class="info"></div> -->
    <button class="page_navs" id="back" onclick="showPage('check_out.php')"><i class="fas fa-angle-double-left"></i> Back</button>
    <h2 style="text-align:center; color:var(--secondaryColor)">Guest Details</h2>
    <div class="guest_name">
        <h4>
            <?php 
                if($gender == "Male"){
                    echo "Mr. ".$fullname. " | Guest00". $detail->guest;
                /* }else if($gender == "Female" && $detail->age <= 24){
                    echo "Ms. ". $detail->last_name . " ". $detail->first_name . " | Guest00". $detail->guest_id; */
                }else{
                    echo "Ms. ". $fullname . " | Guest00". $detail->guest;
                }
            ?> 
        </h4>
        <div class="displays allResults" id="payment_det">
            <table id="guest_detail_table" class="searchTable">
                <thead>
                    <tr>
                        <td>S/N</td>
                        <td>Room Category</td>
                        <td>Rate</td>
                        <td>Check in date</td>
                        <td>Check out date</td>
                        <td>Days stayed</td>
                        <td>Total Amount</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $n = 1;
                        $get_cat = new selects();
                        $categories = $get_cat->fetch_details_cond('items', 'item_id', $detail->room);
                        foreach($categories as $cats){
                            $category_id = $cats->category;
                            $item_name = $cats->item_name;
                        }
                        //get category details
                        $get_cat_name = new selects();
                        $cat_name = $get_cat_name->fetch_details_cond('categories', 'category_id', $category_id);
                        foreach($cat_name as $cate){
                            $category = $cate->category;
                        }
                        $price = $detail->rate;
                        $exp_in_date = strtotime($detail->check_in_date);
                        $exp_out_date = strtotime($detail->check_out_date);
                        $exp_date_diff = $exp_out_date - $exp_in_date;
                        $exp_days = round($exp_date_diff / (60 * 60 * 24));
                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td>
                            <?php 
                                
                                echo $category." (".$item_name.")";


                            ?>
                        </td>
                        <td style="color:green">
                            <?php echo number_format($price, 2)?>
                        </td>
                        <td><?php echo date("jS M, Y", strtotime($detail->check_in_date));?></td>
                        <td><?php echo date("jS M, Y", strtotime($detail->check_out_date));?></td>
                        <td style="text-align:center">
                            <?php 
                                $in_date = strtotime($detail->check_in_date);
                                $today = date("Y-m-d");
                                $today_date = strtotime($today);
                                $date_diff = $today_date - $in_date;
                                $days = round($date_diff / (60 * 60 * 24));
                                if($days < 0){
                                    echo "Yet to check in";
                                }else{
                                    echo $days;
                                }
                            ?>
                        </td>
                        <td style="text-align:center"><?php echo number_format($detail->rate * $exp_days, 2)?></td>
                    </tr>
                    <?php
                        $n = 2;
                        $get_checkins = new selects();
                        $datas = $get_checkins->fetch_details_negCond('check_ins', 'checkin_id', $check_id, 'sponsor', $check_id);
                        if(gettype($datas) == 'array'){
                            foreach($datas as $data){
                                $get_cat = new selects();
                               $categories = $get_cat->fetch_details_cond('items', 'item_id', $data->room);
                               foreach($categories as $cats){
                                   $category_id = $cats->category;
                                   $item_name = $cats->item_name;
                               }
                                //get category details
                                $get_cat_names = new selects();
                                $cat_names = $get_cat_name->fetch_details_cond('categories',  'category_id', $category_id);
                                foreach($cat_names as $cates){
                                    $other_category = $cates->category;
                                    
                                }
                                $exp_in_date2 = strtotime($data->check_in_date);
                                $exp_out_date2 = strtotime($data->check_out_date);
                                $exp_date_diff2 = $exp_out_date2 - $exp_in_date2;
                                $exp_days2 = round($exp_date_diff2 / (60 * 60 * 24));
                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td>
                            <?php 
                                echo $other_category." (".$item_name.")";


                            ?>
                        </td>
                        <td style="color:green">
                            <?php echo number_format($data->rate, 2)?>
                        </td>
                        <td><?php echo date("jS M, Y", strtotime($data->check_in_date));?></td>
                        <td><?php echo date("jS M, Y", strtotime($data->check_out_date));?></td>
                        <td style="text-align:center">
                            <?php 
                                $in_date = strtotime($data->check_in_date);
                                $today = date("Y-m-d");
                                $today_date = strtotime($today);
                                $date_diff = $today_date - $in_date;
                                $days = round($date_diff / (60 * 60 * 24));
                                if($days < 0){
                                    echo "Yet to check in";
                                }else{
                                    echo $days;
                                }
                            ?>
                        </td>
                        <td style="text-align:center"><?php echo number_format($data->rate * $exp_days2, 2)?></td>
                    </tr>
                    <?php $n++; } } $n++; ?>
                </tbody>
            </table>
            <?php
                //get ordered items by guest
                $get_order = new selects();
                $orders = $get_order->fetch_details_cond('sales', 'customer', $check_id);
                if(gettype($orders) == 'array'){
            ?>
            <div class="ordered_items" id="ordered_items">
                <h3>Ordered items</h3>
                <table id="ordered_items" class="searchTable">
                <thead>
                        <tr>
                            <td>S/N</td>
                            <td>Item</td>
                            <td>Quantity</td>
                            <td>Unit price</td>
                            <td>Amount</td>
                            <td>Time</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $n = 1;
                            foreach($orders as $order){
                        ?>
                        <tr>
                            <td style="text-align:center; color:red;"><?php echo $n?></td>
                            <td>
                                <?php 
                                    //get item name
                                    $get_name = new selects();
                                    $names = $get_name->fetch_details_group('items', 'item_name', 'item_id', $order->item);
                                    echo strtoupper($names->item_name);
                                ?>
                            </td>
                            <td style="text-align:center; color:var(--otherColor)"><?php echo $order->quantity?></td>
                            <td><?php echo number_format($order->price, 2);?></td>
                            <td><?php echo number_format($order->total_amount, 2)?></td>
                            <td style="color:var(--otherColor)"><?php echo date("d-m-y H:ia", strtotime($order->post_date))?></td>
                            <td>
                                <a style="color:red; font-size:1rem" href="javascript:void(0) "title="return item" onclick="getGuestReturnItem('<?php echo $order->sales_id?>', <?php echo $check_id?>)"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        
                        <?php $n++; }?>
                    </tbody>
                </table>
                <?php
                    //get total of items ordered
                    $get_total = new selects();
                    $totalss = $get_total->fetch_sum_single('sales', 'total_amount', 'customer', $check_id);
                    foreach($totalss as $totals){
                        $total_amount = $totals->total;
                    }
                ?>
                <p class='due_amount' style="text-align:right"><span>Total:</span> <?php echo "₦".number_format($total_amount, 2)?></p>
            </div>
            <?php }?>
            <div class="payment_details">
                <h3>Payment Details</h3>
                <table id="guest_payment_table" class="searchTable">
                    <thead>
                        <tr>
                            <td>S/N</td>
                            <td>Payment date</td>
                            <td>Amount due</td>
                            <td>Amount paid</td>
                            <td>Balance</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $n = 1;
                            $get_payment = new selects();
                            $rows = $get_payment->fetch_details_cond('payments', 'customer', $check_id);
                            if(gettype($rows) == 'array'){
                            foreach($rows as $row){
                        ?>
                        <tr>
                            <td style="text-align:center; color:red;"><?php echo $n?></td>
                            <td>
                                <?php 
                                    echo date("jS M, Y", strtotime($row->post_date));
                                ?>
                            </td>
                            <td><?php echo number_format($row->amount_due, 2);?></td>
                            <td><?php echo number_format($row->amount_paid, 2)?></td>
                            <td>
                                <?php 
                                    $balance = $row->amount_due - $row->amount_paid;/* - $row->discount; */
                                    echo number_format($balance, 2);
                                ?>
                            </td>
                        </tr>
                        
                        <?php $n++; } }?>
                    </tbody>
                </table>
            </div>
            <div class="amount_due" id="payments">
                <p class="due_amount"><span>Total paid:</span>
                    <?php
                        //get total paid
                        $get_total_paid = new selects();
                        $paids = $get_total_paid->fetch_sum_single('payments', 'amount_paid', 'customer', $check_id);
                        foreach($paids as $paid){
                            $total_paid = $paid->total;
                        }
                        echo  "₦".number_format($total_paid, 2);
                    ?>
                </p>
                <p class="due_amount"><span>Amount due:</span> <?php echo "₦".number_format($detail->amount_due, 2)?></p>
                <p class="due_amount" style="color:green"><span>Wallet Balance:</span> <?php echo "₦".number_format($wallet, 2)?></p>
            </div>
                <!-- check out and payment mode options -->
                <div class="payment_mode"style="display:flex;gap:1rem">
                    
                    <?php
                        if(/* $detail->check_out_date > $date &&  */$detail->guest_status != 2){
                        ?>
                        <div class="cancel_out">
                            <div>
                                <input type="hidden" name="check_id" id="check_id" value="<?php echo $check_id?>">
                                <input type="hidden" name="user" id="user" value="<?php echo $user_id?>">
                                <button type="submit" name="cancel_checkout" id="cancel_checkout" style="background:brown; border-radius:20px" href="javascript:void(0)" class="modes" onclick="cancelCheckIn()">Cancel check in <i class="fas fa-cancel"></i></button>
                            </div>
                            <?php
                            }
                            if($detail->guest_status == 2){
                                echo "<p style='color:green; font-size:1.1rem;'>Guest has checked out <i class='fas fa-thumbs-up'></i></p>";
                                ?>
                                <div>
                            <button style="background:var(--tertiaryColor); border-radius:20px" href="javascript:void(0)" class="modes" onclick="printGuestBill('<?php echo $check_id?>')">Print Bill <i class="fas fa-print"></i></button>
                            <?php if($wallet > 0){?>
                            <button style="background:var(--otherColor); border-radius:20px" href="javascript:void(0)" class="modes" onclick="showPage('refund_guest.php?guest=<?php echo $detail->guest?>')">Refund <i class="fas fa-arrow-left-rotate"></i></button>
                            <?php }?>
                        </div>
                        <?php
                            }else if($detail->guest_status == -1){
                                echo "<p style='color:red; font-size:1.1rem;'>Guest cancelled check in <i class='fas fa-thumbs-down'></i></p>";
                                ?>
                                <div>
                            <button style="background:var(--tertiaryColor); border-radius:20px" href="javascript:void(0)" class="modes" onclick="printGuestBill('<?php echo $check_id?>')">Print Bill <i class="fas fa-print"></i></button>
                            <?php if($wallet > 0){?>
                            <button style="background:var(--otherColor); border-radius:20px" href="javascript:void(0)" class="modes" onclick="showPage('refund_guest.php?guest=<?php echo $detail->guest?>')">Refund <i class="fas fa-arrow-left-rotate"></i></button>
                            <?php
                            }
                            }else if($detail->amount_due == 0){
                                
                        ?>
                        <div>
                            <button style="background:var(--tertiaryColor); border-radius:20px" href="javascript:void(0)" class="modes" onclick="printGuestBill('<?php echo $check_id?>')">Print Bill <i class="fas fa-print"></i></button>
                        </div>
                        <div>
                            <input type="hidden" name="guest_id" id="guest_id" value="<?php echo $check_id?>">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id?>">
                            <button type="submit" name="check_out" id="check_out" style="background:green; border-radius:20px" href="javascript:void(0)" class="modes" onclick="checkOut()">Check out <i class="fas fa-check-double"></i></button>
                        </div>
                    </div>
                    <?php
                        }else{
                    ?>
                    <h3>Post Payment</h3>
                    <div class="payment_mode">
                    <div class="close_stockin add_user_form" style="width:100%; margin:0;">
                        <section class="addUserForm">
                            <div class="inputs" style="display:flex;flex-wrap:wrap">
                                <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $detail->amount_due?>">
                                <input type="hidden" name="check_in_id" id="check_in_id" value="<?php echo $check_id?>">
                                <div class="data" style="width:auto">
                                    <label for="payment_type">Payment mode</label>
                                    <select name="payment_type" id="payment_type" onchange="checkOtherMode(this.value)">
                                        <option value="" selected>Select payment type</option>
                                        <option value="Cash">CASH</option>
                                        <option value="POS">POS</option>
                                        <option value="Transfer">TRANSFER</option>
                                        <option value="Wallet">WALLET</option>
                                    </select>
                                </div>
                                <div class="data" id="amount_deposit" style="width:auto">
                                    <label id="amount_label" for="deposit">Amount paid (NGN)</label>
                                    <input type="text" name="deposits" id="deposits" value="0">
                                </div>
                                <div class="data" id="selectBank" style="width:auto">
                                    <select name="bank" id="bank">
                                        <option value=""selected>Select Bank</option>
                                        <?php
                                            $get_bank = new selects();
                                            $rows = $get_bank->fetch_details('banks', 10, 10);
                                            foreach($rows as $row):
                                        ?>
                                        <option value="<?php echo $row->bank_id?>"><?php echo $row->bank?>(<?php echo $row->account_number?>)</option>
                                        <?php endforeach?>
                                    </select>
                                </div>
                                <div class="data" id="account_balance">
                                <?php
                                    //get wallet balance
                                    $get_bal = new selects();
                                    $bal = $get_bal->fetch_details_group('guests', 'wallet', 'guest_id', $detail->guest);
                                    $wallet = $bal->wallet;
                                ?>
                                <input type="hidden" name="wallet" id="wallet" value="<?php echo $wallet?>">
                                <label for="wallet">Wallet balance</label>
                                <p style="color:green; font-size:1rem"><?php echo "₦".number_format($wallet, 2)?></p>

                            </div>
                                <div class="data" style="width:auto">
                                    <button onclick="addPayment()" style="background:green; padding:8px; border-radius:5px;font-size:.8rem;">post payment <i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </section>
                    </div>
            <!-- </div> -->
                    <?php
                        }
                    ?>
                    
                </div>
                
            </div>
            <!-- paymend mode forms -->
            
            <?php
                if(gettype($details) == "string"){
                    echo "<p class='no_result'>'$details'</p>";
                }
            ?>
        </div>
    </div>
    
</div>
<?php
            }
        }
    }else{
        header("Location: ../index.php");
    }
?>
</div>