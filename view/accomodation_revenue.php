<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<div id="revenueReport" class="displays management" style="width:100%!important">
    <div class="select_date">
        <!-- <form method="POST"> -->
        <section>    
            <div class="from_to_date">
                <label>Select From Date</label><br>
                <input type="date" name="from_date" id="from_date"><br>
            </div>
            <div class="from_to_date">
                <label>Select to Date</label><br>
                <input type="date" name="to_date" id="to_date"><br>
            </div>
            <button type="submit" name="search_date" id="search_date" onclick="search('search_accmd_revenue.php')">Search <i class="fas fa-search"></i></button>
</section>
    </div>
<div class="displays allResults new_data" id="revenue_report">
    <h2>Accomodation revenue for today</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Retail sales report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="data_table" class="searchTable">
        <thead>
            <tr style="background:var(--primaryColor)">
                <td>S/N</td>
                <td>Invoice</td>
                <td>Guest</td>
                <td>Room</td>
                <td>Amount due</td>
                <td>Amount paid</td>
                <!-- <td>Discount</td> -->
                <td>Payment Mode</td>
                <td>Post Time</td>
                <td>Posted by</td>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_users = new selects();
                $details = $get_users->fetch_details_curdateGro2con('payments', 'date(post_date)', 'store', $store, 'sales_type', 'Accomodation', 'invoice');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
                    //get details guest from checkins;
                    $get_guest = new selects();
                    $guestss = $get_guest->fetch_details_cond('check_ins', 'checkin_id', $detail->customer);
                    foreach($guestss as $guests){
                        $guest = $guests->guest;
                        $room = $guests->room;
                    }
                    //get gues details
                    $get_details = new selects();
                    $results = $get_details->fetch_details_cond('guests', 'guest_id', $guest);
                    foreach($results as $result){
                        $full_name = $result->last_name." ".$result->other_names;
                    }
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><a style="color:green" href="javascript:void(0)"><?php echo $detail->invoice?></a></td>
                <td>
                    <?php
                        
                        echo $full_name;
                    ?>
                </td>
                <td>
                    <?php
                        //get room category
                        $get_cat = new selects();
                        $cats = $get_cat->fetch_details_group('items', 'category', 'item_id', $room);
                        //get category name
                        $get_cat_name = new selects();
                        $cat = $get_cat_name->fetch_details_group('categories', 'category', 'category_id', $cats->category);
                        echo $cat->category." (".$room.")";
                    ?>
                </td>
                <td style="color:var(--otherColor)">
                    <?php echo "₦".number_format($detail->amount_due, 2);?>
                </td>
                <td style="color:red">
                    <?php echo "₦".number_format($detail->amount_paid, 2);?>

                </td>
                <!-- <td style="color:red">
                    <?php echo "₦".number_format($detail->discount, 2);?>
                </td> -->
                <td>
                    <?php 
                        //get payment mode
                        $get_mode = new selects();
                        $rows = $get_mode->fetch_count_cond('payments', 'invoice', $detail->invoice);
                        if($rows >= 2){
                            echo "Multiple payment";
                        }else{
                        echo $detail->payment_mode;
                        }
                     ?>
                </td>
                <td style="color:var(--moreColor)"><?php echo date("H:i:sa", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                
            </tr>
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    
    <?php
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }

        // get sum
        $get_total = new selects();
        $amounts = $get_total->fetch_sum_curdate2Con('payments', 'amount_paid', 'post_date', 'store', $store, 'sales_type', 'Accomodation');
        foreach($amounts as $amount){
            echo "<p class='total_amount' style='color:green'>Total: ₦".number_format($amount->total, 2)."</p>";
        }
    ?>

</div>
