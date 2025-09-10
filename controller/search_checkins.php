<?php

    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));

    // instantiate classes
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_checkIns = new selects();
    $details = $get_checkIns->fetch_details_date('check_ins', 'date(check_in_date)', $from, $to);
    $n = 1;  
?>
<h2>Check in Report between <?php echo date("jS M, Y", strtotime($from)) . " and " . date("jS M, Y", strtotime($to))?></h2>
    <hr>
    <div class="search">
        <input type="search" id="searchCheckout" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="check_out_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Full Name</td>
                <td>Room Category</td>
                <td>Room</td>
                <td>Checked In</td>
                <td>Post time</td>
                <td>Checked in by</td>
                
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
                <td><a style="color:green" href="javascript:void(0)" title="View guest details" onclick="showPage('guest_details.php?guest_id=<?php echo $detail->checkin_id?>')"><?php echo $fullname?></a></td>
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
                <td>
                    <?php 
                        $get_room = new selects();
                        $rooms = $get_room->fetch_details_group('items', 'item_name', 'item_id', $detail->room);
                        echo $rooms->item_name;
                    ?>
                </td>
                <td><?php echo date("jS M, Y", strtotime($detail->check_in_date));?></td>
                <td><?php echo date("h:i:sa", strtotime($detail->post_date));?></td>
                <td>
                    <?php
                        //get posted by
                        $get_posted_by = new selects();
                        $checkedin_by = $get_posted_by->fetch_details_group('users', 'full_name', 'user_id', $detail->posted_by);
                        echo $checkedin_by->full_name;
                    ?>
                </td>
                
            </tr>
            <?php $n++; }; }?>
        </tbody>
    </table>
<?php
    if(gettype($details) == 'string'){
        echo "<p class='no_result'>'$details'</p>";
    }
?>
