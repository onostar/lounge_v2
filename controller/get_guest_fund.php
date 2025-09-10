<?php
    session_start();
    $customer = htmlspecialchars(stripslashes($_POST['customer']));
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    /* $toDate = htmlspecialchars(stripslashes($_POST['toDate']));
    $fromDate = htmlspecialchars(stripslashes($_POST['fromDate'])); */
    /* $_SESSION['toDate'] = $toDate;
    $_SESSION['fromDate'] = $fromDate; */
    $get_item = new selects();
    $rows = $get_item->fetch_details_like2Cond('guests', 'last_name', 'other_names', $customer);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
        
    ?>
<div class="results">
    <a href="javascript:void(0)" onclick="showPage('fund_guest.php?guest=<?php echo $row->guest_id?>')"><?php echo $row->other_names." ".$row->last_name?></a>
</div>
   
    
<?php
    endforeach;
     }else{
        echo "No resullt found";
     }
?>