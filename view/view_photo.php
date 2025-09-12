<div id="update_photo">
<?php

    if (isset($_GET['item'])){
        $id = $_GET['item'];
    

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_item = new selects();
    $rows = $get_item->fetch_details_cond('items', 'item_id', $id);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            
        
    ?>
    <div class="add_user_form priceForm" style="width:50%; margin:20px 50px;">
        <h3 style="background:var(--primaryColor)">Update <strong><?php echo strtoupper($row->item_name)?></strong> Photo</h3>
        <section class="addUserForm" style="text-align:left;">
            <div class="inputs" style="flex-wrap:wrap; gap:1rem; align-items:flex-end; justify-content:left;">
                <!-- <div class="data item_head"> -->
                    <input type="hidden" name="item" id="item" value="<?php echo $row->item_id?>" required>
                <div class="data" style="width:35%">
                    <img src="../photos/<?php echo $row->photo?>" alt="<?php echo $row->item_name?>" style="width:100%; height:120px; object-fit:fill; border:1px solid #ccc; padding:4px;">
                </div>
                <div class="data" style="width:50%">
                    <label for="sales_price">Upload New Image</label>
                    <input type="file" name="photo" id="photo">
                </div>
                <div class="data" style="width:auto">
                    <button type="submit" id="change_price" name="change_price" onclick="updateItemPhoto()">Save <i class="fas fa-save"></i></button>
                    <a href="javascript:void(0)" title="close form" style='background:red; padding:10px; border-radius:5px; color:#fff' onclick="showPage('update_photo.php')">Return <i class='fas fa-angle-double-left'></i></a>
                </div>
                
            </div>
        </section>   
    </div>
    
<?php
    endforeach;
     }
    }    
?>

</div>