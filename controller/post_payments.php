<?php
    date_default_timezone_set("Africa/Lagos");
    session_start();
    $user = $_SESSION['user_id'];
    $trans_type = "sales";
    $invoice = $_POST['sales_invoice'];
    $payment_type = htmlspecialchars(stripslashes($_POST['payment_type']));
    $bank = htmlspecialchars(stripslashes($_POST['bank']));
    $cash = htmlspecialchars(stripslashes($_POST['multi_cash']));
    $pos = htmlspecialchars(stripslashes($_POST['multi_pos']));
    $transfer = htmlspecialchars(stripslashes($_POST['multi_transfer']));
    $wallet = htmlspecialchars(stripslashes($_POST['wallet']));
    $discount = htmlspecialchars(stripslashes($_POST['discount']));
    $store = htmlspecialchars(stripslashes($_POST['store']));
    $id = htmlspecialchars(stripslashes($_POST['check_in_id']));
    $amount_due = htmlspecialchars(stripslashes($_POST['total_amount']));
    $amount_deposit = htmlspecialchars(stripslashes($_POST['deposits']));
    $type = "Accomodation";
    $date = date("Y-m-d H:i:s");
    if($payment_type == "Wallet"){
        $amount_paid = $wallet;
    }else{
        $amount_paid = $amount_deposit;
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
        // $customer = $result->guest;
        $room = $result->room;
        $guest = $result->guest;
    }
    if($payment_type == "Multiple"){
        if(($cash + $pos + $transfer) > $amount_due){
           $new_amount = 0;
        }else{
           $new_amount = $amount_due - ($cash + $pos + $transfer)/* - $discount */;
        }
    }elseif($amount_paid > $amount_due){
            $new_amount = 0;
    }else{
        $new_amount = $amount_due - $amount_paid;/*  - $discount */
    }
    if($amount_paid > $amount_due){
        $new_paid = $amount_due;
        $balance = $amount_paid - $amount_due;
    }else{
        $new_paid = $amount_paid;
        $balance = 0;
    }
    if($payment_type == "Multiple"){
        //insert into payments
        if($cash !== '0'){
            //insert payment
            $pay_data = array(
                'amount_due' => $amount_due,
                'amount_paid' => $cash,
                'discount' => $discount,
                'bank' => $bank,
                'payment_mode' => 'Cash',
                'posted_by' => $user,
                'invoice' => $invoice,
                'store' => $store,
                'sales_type' => $type,
                'customer' => $id,
                'post_dates' => $date,
                'start_dates' => $start_day,
            'end_date' => $end_day,

            );
            $add_payment = new add_data('payments', $pay_data);
            $add_payment->create_data(); 
        }
        if($pos !== '0'){
            //insert payment
            $pay_data = array(
                'amount_due' => $amount_due,
                'amount_paid' => $pos,
                'discount' => $discount,
                'bank' => $bank,
                'payment_mode' => 'POS',
                'posted_by' => $user,
                'invoice' => $invoice,
                'store' => $store,
                'sales_type' => $type,
                'customer' => $id,
                'post_dates' => $date,
                'start_dates' => $start_day,
            'end_date' => $end_day,

            );
            $add_payment = new add_data('payments', $pay_data);
            $add_payment->create_data(); 
        }
        if($transfer !== '0'){
            //insert payment
            $pay_data = array(
                'amount_due' => $amount_due,
                'amount_paid' => $transfer,
                'discount' => $discount,
                'bank' => $bank,
                'payment_mode' => 'Transfer',
                'posted_by' => $user,
                'invoice' => $invoice,
                'store' => $store,
                'sales_type' => $type,
                'customer' => $id,
                'post_dates' => $date,
                'start_dates' => $start_day,
            'end_date' => $end_day,

            );
            $add_payment = new add_data('payments', $pay_data);
            $add_payment->create_data(); 
        }
        //multiple payment table
         //insert payment
         $multi_data = array(
            'cash' => $cash,
            'pos' => $pos,
            'transfer' => $transfer,
            'bank' => $bank,
            'posted_by' => $user,
            'invoice' => $invoice,
            'store' => $store,
            'post_date' => $date,
            'start_dates' => $start_day,
            'end_dates' => $end_day,

        );
        $add_multiple = new add_data('multiple_payments', $multi_data);
        $add_multiple->create_data();
    }else{
        $pay_data = array(
            'amount_due' => $amount_due,
            'amount_paid' => $new_paid,
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
    }
    if($payment_type == "Wallet"){
        //update wallet balance
        $new_balance = $wallet - $new_paid;
        $update_wallet = new Update_table();
        $update_wallet->update('guests', 'wallet', 'guest_id', $new_balance, $guest);
    }
    if($balance > 0){
        //get new wallet balance
        $get_wallet = new selects();
        $wallets = $get_wallet->fetch_details_cond('guests', 'guest_id', $guest);
        foreach($wallets as $wallett){
            $new_wallet = $wallett->wallet;
        }
        //update guest wallet
        $new_wallet_balance = $new_wallet + $balance;
        $update_wallet = new Update_table();
        $update_wallet->update('guests', 'wallet', 'guest_id', $new_wallet_balance, $guest);

    }
    if($add_payment){
        //update room
        $update_room = new Update_table();
        $update_room->update('items', 'item_status', 'item_id', 2, $room);
        //update guest status and amount due

        $update_guest = new Update_table();
        $update_guest->update_double('check_ins', 'guest_status', 1, 'amount_due', $new_amount, 'checkin_id', $id);
        echo "<p style='color:green; padding:5px 10px;'>Payment posted successfully! <i class='fas fa-thumbs-up'></i></p>";
    
?>
    <div id="printBtn">
        <button onclick="printGuestReceipt('<?php echo $invoice?>')">Print Receipt <i class="fas fa-print"></i></button>
    </div>
<?php }?>