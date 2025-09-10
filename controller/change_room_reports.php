<?php

    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_report = new selects();
    $details = $get_report->fetch_details_date('change_room', 'date(changed_date)', $from, $to);
    $n = 1;  
?>
<h2>Changed room Report between <?php echo date("jS M, Y", strtotime($from)) . " and " . date("jS M, Y", strtotime($to))?></h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="check_out_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Guest</td>
                <td>Old room</td>
                <td>New room</td>
                <td>Checked In</td>
                <td>Post time</td>
                <td>Date</td>
                <td>Changed by</td>
                
            </tr>
        </thead>
        <tbody>
<?php
    if(gettype($details) === 'array'){
    foreach($details as $detail){
        //get checkin details details
        $get_guest = new selects();
        $rows = $get_guest->fetch_details_cond('check_ins', 'checkin_id', $detail->checkin_id);
        foreach($rows as $row){
            $guest = $row->guest;
            $checkin_date = $row->check_in_date;
        }
        //get guest details
        $get_details = new selects();
        $results = $get_details->fetch_details_cond('guests', 'guest_id', $guest);
        foreach($results as $result){
            $fullname = $result->last_name." ".$result->other_names;
        }
?>
    <tr>
    <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $fullname?></td>
                <td>
                    <?php 
                        $get_old = new selects();
                        $olds = $get_old->fetch_details_group('items', 'item_name', 'item_id', $detail->old_room);
                        echo $olds->item_name;
                    ?>
                </td>
                <td>
                    <?php 
                        $get_new = new selects();
                        $new = $get_new->fetch_details_group('items', 'item_name', 'item_id', $detail->new_room);
                        echo $new->item_name;
                    ?>
                </td>
                <td><?php echo date("jS M, Y", strtotime($checkin_date));?></td>
                <td><?php echo date("h:i:sa", strtotime($detail->changed_date));?></td>
                <td><?php echo date("jS M, Y", strtotime($detail->changed_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->changed_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                
            </tr>
            <?php $n++; }?>
        </tbody>
    </table>
<?php
    }else{
        echo "<p class='no_result'>'$details'</p>";
    }
?>
