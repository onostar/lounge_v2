<?php
    session_start();
    $user = $_SESSION['user_id'];
    date_default_timezone_set("Africa/Lagos");
    $date = date("Y-m-d H:i:s");
    $guest = htmlspecialchars(stripslashes($_POST['guest']));
    $wallet = htmlspecialchars(stripslashes($_POST['wallet']));
    $amount = htmlspecialchars(stripslashes($_POST['amount']));

    $todays_date = date("dmyh");
    $ran_num ="";
    for($i = 0; $i < 5; $i++){
        $random_num = random_int(0, 9);
        $ran_num .= $random_num;
    }
    $invoice = "DP".$todays_date.$user.$ran_num;
    include "../classes/dbh.php";
    include "../classes/update.php";
    include "../classes/inserts.php";

    $data = array(
        'guest' => $guest,
        'amount' => $amount,
        'post_date' => $date,
        'invoice' => $invoice,
        'posted_by' => $user
    );
    $new_amount = $wallet + $amount;
    $update = new Update_table();
    $update->update('guests', 'wallet', 'guest_id', $new_amount, $guest);
    if($update){
        $add_data = new add_data('deposits',$data);
        $add_data->create_data();
        echo "<div class='succeed'><p><i class='fas fa-thumbs-up'></i></p><p>Account funded successfully!</p></div>";
    }
