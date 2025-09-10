<div class="displays allResults" id="staff_list" style="width:80%!important;margin:20px 50px!important">
<?php

    include "../classes/dbh.php";
    include "../classes/select.php";


?>

    <h2>Select Staffs</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchStaff" placeholder="Enter keyword" onkeyup="searchData(this.value)">
    </div>
    <table id="room_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Full Name</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_details = new selects();
                $details = $get_details->fetch_details_negCond1('users', 'user_role', 'Admin');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
                <td><?php echo $detail->full_name?></td>
                <td>
                    <a href="javascript:void(0)" onclick="showPage('sales_order.php?waiter=<?php echo $detail->user_id?>')" style="background:var(--tertiaryColor); color:#fff; padding:5px 8px; border-radius:10px"><i class="fas fa-pen"></i></a>
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
</div>