<?php
    date_default_timezone_set("Africa/Lagos");
    session_start();
    if(isset($_SESSION['user_id'])){
        $user = $_SESSION['user_id'];
        if(isset($_GET['order_id'])){
            $order = $_GET['order_id'];
            $date = date("Y-m-d H:i:s");
            include "../classes/dbh.php";
            include "../classes/select.php";
            include "../classes/update.php";
            $update = new Update_table();
            $update->update_tripple('sales', 'add_order', 0, 'dispensed_by', $user, 'dispense_date', $date, 'sales_id', $order);
            if($update){
                echo "<div class='success'><p>Order dispensed successfully <i class='fas fa-thumbs-up'></i></p></div>";
            }else{
                echo "<p class='error'>Failed to dispense order</p>";
            }
        }
    }else{
        header("Location: ../index.php");
    }