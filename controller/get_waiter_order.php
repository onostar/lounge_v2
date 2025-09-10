<?php
date_default_timezone_set("Africa/Lagos");
    session_start();
    $item = htmlspecialchars(stripslashes($_POST['item']));
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";
    $toDate = htmlspecialchars(stripslashes($_POST['toDate']));
    $fromDate = htmlspecialchars(stripslashes($_POST['fromDate']));
    $_SESSION['toDate'] = $toDate;
    $_SESSION['fromDate'] = $fromDate;
    $get_item = new selects();
    $rows = $get_item->fetch_details_like('users', 'full_name', $item);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
        
    ?>
    <div class="results">
        <a href="javascript:void(0)" onclick="checkwaiterHistory('<?php echo $row->user_id?>')"> <?php echo $row->full_name?></a>
    </div>

    
<?php
    endforeach;
     }else{
        echo "No resullt found";
     }
?>