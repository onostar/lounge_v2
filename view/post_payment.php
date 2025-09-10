<div id="all_payments">
<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $store = $_SESSION['store_id'];
        // echo $user_id;
    
    if(isset($_GET['guest_id'])){
        $checkin_id = $_GET['guest_id'];
        $get_user = new selects();
        $details = $get_user->fetch_details_cond('check_ins', 'checkin_id', $checkin_id);
        foreach($details as $detail){
            //get guest information
            $get_guest = new selects();
            $results = $get_guest->fetch_details_cond('guests', 'guest_id', $detail->guest);
            foreach($results as $result){
                $fullname = $result->last_name." ".$result->other_names;
                $gender = $result->gender;
            }
            $todays_date = date("dmyh");
            $ran_num ="";
            for($i = 0; $i < 4; $i++){
                $random_num = random_int(0, 9);
                $ran_num .= $random_num;
            }
        $invoice = "ACC".$checkin_id.$todays_date.$ran_num.$detail->guest;
?>
<div id="post_payment" class="displays all_details" style="margin:0!important; width:90%!important">
    <!-- <div class="info"></div> -->
    <button class="page_navs" id="back" onclick="showPage('guest_payment.php')"><i class="fas fa-angle-double-left"></i> Back</button>
    <h2 style="margin:0 20px; color:var(--secondaryColor);text-align:center">Payment Details</h2>
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
            <table id="guest_payment_table" class="searchTable">
                <thead>
                    <tr>
                        <td>S/N</td>
                        <td>Room Category</td>
                        <td>Rate</td>
                        <td>Check in date</td>
                        <td>Check out date</td>
                        <td>Days</td>
                        <td>Amount Due</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $n = 1;
                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td>
                            <?php 
                                $get_cat = new selects();
                                $categories = $get_cat->fetch_details_group('items', 'category', 'item_id', $detail->room);
                                $category_id = $categories->category;
                                //get category name
                                $get_cat_name = new selects();
                                $cat_name = $get_cat_name->fetch_details_group('categories', 'category', 'category_id', $category_id);
                                echo $cat_name->category;


                            ?>
                        </td>
                        <td><?php echo "₦".number_format($detail->rate, 2)?></td>
                        <td><?php echo date("jS M, Y", strtotime($detail->check_in_date));?></td>
                        <td><?php echo date("jS M, Y", strtotime($detail->check_out_date));?></td>
                        <td style="text-align:center">
                            <?php 
                                $in_date = strtotime($detail->check_in_date);
                                $out_date = strtotime($detail->check_out_date);
                                $date_diff = $out_date - $in_date;
                                $days = round($date_diff / (60 * 60 * 24));
                                echo $days;
                            ?>
                        </td>
                        <td style="text-align:center; color:green"><?php echo number_format($detail->amount_due, 2)?></td>
                    </tr>
                    
                    <?php $n++; ?>
                </tbody>
            </table>
            <div class="amount_due">
                <section>
                    <label for="discount" style="color:red;">Discount (<?php echo $detail->percent_discount?>%)</label><br>
                    <input type="text" name="discount" id="discount" style="padding:5px;border-radius:5px;" value="<?php echo $detail->discount * $days?>" readonly>
                     <select name="app_discount" id="app_discount" style="padding:5px"onchange="applyDiscount(this.value, '<?php echo $category_id?>','<?php echo $checkin_id?>', '<?php echo $days?>')">
                        <option value="">Apply Discount</option>
                        <option value="1">1%</option>
                        <option value="2">2%</option>
                        <option value="3">3%</option>
                        <option value="4">4%</option>
                        <option value="5">5%</option>
                        <option value="6">6%</option>
                        <option value="7">7%</option>
                        <option value="8">8%</option>
                        <option value="9">9%</option>
                        <option value="10">10%</option>
                        <option value="15">15%</option>
                        <option value="20">20%</option>
                     </select>
                </section>
                <h2><?php echo "₦".number_format($detail->amount_due, 2)?></h2>

            </div>
            <div class="payment_mode">
                <div class="close_stockin add_user_form" style="width:50%; margin:0;">
                    <section class="addUserForm">
                        <div class="inputs" style="display:flex;flex-wrap:wrap">
                            <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $detail->amount_due?>">
                            <input type="hidden" name="sales_invoice" id="sales_invoice" value="<?php echo $invoice?>">
                            <input type="hidden" name="store" id="store" value="<?php echo $store?>">
                            <input type="hidden" name="check_in_id" id="check_in_id" value="<?php echo $checkin_id?>">
                            <div class="data">
                                <label for="payment_type">Payment options</label>
                                <select name="payment_type" id="payment_type" onchange="checkMode(this.value)">
                                    <option value="" selected>Select payment type</option>
                                    <option value="Cash">CASH</option>
                                    <option value="POS">POS</option>
                                    <option value="Transfer">TRANSFER</option>
                                    <option value="Multiple">MULTIPLE PAYMENT</option>
                                    <option value="Wallet">WALLET</option>
                                </select>
                            </div>
                            <div class="data" id="amount_deposit">
                                <label id="amount_label" for="deposit">Amount paid (NGN)</label>
                                <input type="text" name="deposits" id="deposits" value="0">
                            </div>
                        </div>
                        <div class="inputs" id="multiples">
                            <div class="data">
                                <label for="">Cash paid</label>
                                <input type="text" name="multi_cash" id="multi_cash" value="0">
                            </div>
                            <div class="data">
                                <label for="">POS</label>
                                <input type="text" name="multi_pos" id="multi_pos" value="0">
                            </div>
                            <div class="data">
                                <label for="">Transfer</label>
                                <input type="text" name="multi_transfer" id="multi_transfer" value="0">
                            </div>
                        </div>
                        <div class="inputs">
                            <div class="data" id="selectBank">
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
                                <input type="text" value="<?php echo "₦".number_format($wallet, 2)?>" readonly>

                            </div>
                            <div class="data">
                                <button onclick="postPayment()" style="background:green; padding:8px; border-radius:5px;font-size:.9rem; margin:10px">Save and Print <i class="fas fa-print"></i></button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
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