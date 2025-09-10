<?php

    $room_id = htmlspecialchars(stripslashes($_POST['room_id']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_reports = new selects();
    $details = $get_reports->fetch_details_cond('check_ins', 'room', $room_id);
    $n = 1;  

    //get room name;
    $get_room = new selects();
    $rows = $get_room->fetch_details_cond('items', 'item_id', $room_id);
    foreach($rows as $row){
        $room = $row->item_name;
        $category = $row->category;
    }
    //get room category
    $get_cat_name = new selects();
    $room_cat = $get_cat_name->fetch_details_group('categories', 'category', 'category_id', $category);
    $cat_name = $room_cat->category;
?>
<h2>Room reports</h2>
<hr>
<div class="guest_name" style="width:100%; margin:10px 0;">
    <h4 style="width:100%"><i class="fas fa-house"></i> <?php echo $room. " | ". $cat_name?></h4>
</div>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="room_report_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Guest</td>
                <!-- <td>Phone Number</td> -->
                <td>Checked in</td>
                <td>Checked in by</td>
                <td>Extend stay</td>
                <td>Extended by</td>
                <td>Checked out</td>
                <td>Checked out by</td>
                <td>Amount due</td>
                
            </tr>
        </thead>
        <tbody>
<?php
    if(gettype($details) === 'array'){
    foreach($details as $detail){
        //get guest details
        $get_details = new selects();
        $rows = $get_details->fetch_details_cond('guests', 'guest_id', $detail->guest);
        foreach($rows as $row){
            $fullname = $row->last_name . " ". $row->other_names;
        }
?>
    <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><a style="color:green" href="javascript:void(0)" title="View guest details" onclick="showPage('guest_details.php?guest_id=<?php echo $detail->checkin_id?>')"><?php echo $fullname;?></a></td>
                <!-- <td><?php echo $detail->contact_phone?></td> -->
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
            </tr>
            <?php $n++; }}?>
        </tbody>
    </table>
<?php
    
    if(gettype($details) == 'string'){
        echo "<p class='no_result'>'$details'</p>";
    }
?>
