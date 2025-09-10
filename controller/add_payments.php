<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    $user = $_SESSION['user_id'];
    $store = $_SESSION['store_id'];
    $trans_type = "add_payment";
    $payment_type = htmlspecialchars(stripslashes($_POST['payment_type']));
    $discount = 0;
    $bank = htmlspecialchars(stripslashes($_POST['bank']));
    $id = htmlspecialchars(stripslashes($_POST['check_in_id']));
    $amount_due = htmlspecialchars(stripslashes($_POST['total_amount']));
    $amount_paid = htmlspecialchars(stripslashes($_POST['deposits']));
    $type = "Accomodation";
    $date = date("Y-m-d H:i:s");
    $todays_date = date("dmyh");
    $ran_num ="";
    for($i = 0; $i < 4; $i++){
        $random_num = random_int(0, 9);
        $ran_num .= $random_num;
    }
    //instantiate classes
    include "../classes/dbh.php";
    include "../classes/inserts.php";
    include "../classes/select.php";
    include "../classes/update.php";
    include "../classes/functions.php";
    $customDay = getCustomDay();
    $start_day = $customDay['start'];
    $end_day = $customDay['end'];
    //get guest details from checkin
    $get_guest = new selects();
    $results = $get_guest->fetch_details_cond('check_ins', 'checkin_id', $id);
    foreach($results as $result){
        $customer = $result->guest;
        $room = $result->room;
    }
    $invoice = "ACC".$id.$todays_date.$ran_num.$customer;
    //insert payments
        /* $insert_payment = new payments($user, $payment_type, $bank, $amount_due, $amount_paid, $discount, $invoice, $store, $type, $id, $date);
        $insert_payment->payment(); */
        $pay_data = array(
            'amount_due' => $amount_due,
            'amount_paid' => $amount_paid,
            'discount' => $discount,
            'bank' => $bank,
            'payment_mode' => $payment_type,
            'posted_by' => $user,
            'invoice' => $invoice,
            'store' => $store,
            'sales_type' => $type,
            'customer' => $id,
            'post_date' => $date,
            'start_dates' => $start_day,
            'end_dates' => $end_day,
        );
        $add_payment = new add_data('payments', $pay_data);
        $add_payment->create_data(); 
    if($add_payment){
        //get new balance
        $balance = $amount_due - $amount_paid;
        if($balance < 0){
            $new_amount = intval($balance) * (-1);
            //add excess payment to guest wallet
            //get guest id
            $get_guest_id = new selects();
            $guests = $get_guest_id->fetch_details_group('check_ins', 'guest', 'checkin_id', $id);
            $guest = $guests->guest;
            //get guest details
            $get_details = new selects();
            $rows = $get_details->fetch_details_group('guests', 'wallet', 'guest_id', $guest);
            $wallet = $rows->wallet;
            //get remainder from deposits
            $new_wallet = $wallet + $new_amount;
            $update_wallet = new Update_table();
            $update_wallet->update('guests', 'wallet', 'guest_id', $new_wallet, $guest);
            //update amount due
            $update_guest = new Update_table();
            $update_guest->update('check_ins', 'amount_due', 'checkin_id', 0, $id);
        }else{
            $new_amount = $balance;
            //update amount due
            $update_guest = new Update_table();
            $update_guest->update('check_ins', 'amount_due', 'checkin_id', $new_amount, $id);
        }
        
        //check if payment type is wallet
        if($payment_type == "Wallet"){
            //update wallet balance
            //get guest id
            $get_guestsid = new selects();
            $guestss = $get_guestsid->fetch_details_group('check_ins', 'guest', 'checkin_id', $id);
            //get old balance
            $get_wal = new selects();
            $old_balance = $get_wal->fetch_details_group('guests', 'wallet', 'guest_id', $guestss->guest);
            $new_wallet = $old_balance->wallet - $amount_paid;
            //update wallet
            $update_new_bal = new Update_table();
            $update_new_bal->update('guests', 'wallet', 'guest_id', $new_wallet, $guestss->guest);
        }
        
        echo "<p style='color:green; padding:5px 10px;'>Payment posted successfully! <i class='fas fa-thumbs-up'></i></p>";
    
?>
    <!-- <div id="printBtn">
        <button onclick="printSalesReceipt('<?php echo $invoice?>')">Print Receipt <i class="fas fa-print"></i></button>
    </div> -->
<?php }?>