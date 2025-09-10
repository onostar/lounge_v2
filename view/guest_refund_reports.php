<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";


?>
<div id="revenueReport" class="displays management" style="width:100%!important">
    
    <div class="general_revenue">
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
                <button type="submit" name="search_date" id="search_date" onclick="search('search_refunds.php')">Search <i class="fas fa-search"></i></button>
            </section>
        </div>
        <div class="displays allResults new_data" id="revenue_report">
            <h2>Guest Refunds done today</h2>
            <hr>
            <div class="search">
                <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
                <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('data_table', 'Guest refund report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
            </div>
            <table id="data_table" class="searchTable">
                <thead>
                    <tr style="background:var(--tertiaryColor)">
                        <td>S/N</td>
                        <td>Guest</td>
                        <td>Refund No.</td>
                        <td>Amount</td>
                        <td>Post Time</td>
                        <td>Posted by</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $n = 1;
                        $get_users = new selects();
                        $details = $get_users->fetch_details_curdate('refunds', 'date(post_date)');
                        if(gettype($details) === 'array'){
                        foreach($details as $detail):
                    ?>
                    <tr>
                        <td style="text-align:center; color:red;"><?php echo $n?></td>
                        <td>
                            <?php 
                                $get_guest = new selects();
                                $rows = $get_guest->fetch_details_cond('guests', 'guest_id', $detail->guest);
                                foreach($rows as $row){
                                    $full_name = $row->last_name." ".$row->other_names;
                                }
                                echo strtoupper($full_name);
                            ?>
                        </td>
                        <td><?php echo $detail->invoice?></td>
                        <td>
                            <?php echo "₦".number_format($detail->amount, 2);?>
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
            ?>
                <!-- <div class="all_amounts"> -->
                    <div class="all_modes">
            <?php
                //get sum
                if(gettype($details) == "array"){
                    $get_credit = new selects();
                    $credits = $get_credit->fetch_sum_curdate('refunds', 'amount', 'post_date');
                    if(gettype($credits) === "array"){
                        foreach($credits as $credit){
                            $deposits = $credit->total;
                        }
                    }
                    echo "<p class='sum_amount' style='background:green; margin-left:100px;'><strong>Total</strong>: ₦".number_format($deposits, 2)."</p>";
                    
                }
            ?>
                    <!-- </div> -->
        </div>
    </div>
</div>
<script src="../jquery.js"></script>
<script src="../script.js"></script>