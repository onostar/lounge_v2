<?php

    if (isset($_GET['item_id'])){
        $id = $_GET['item_id'];
    

    // instantiate class
    include "../classes/dbh.php";
    include "../classes/select.php";

    $get_item = new selects();
    $rows = $get_item->fetch_details_cond('categories', 'category_id', $id);
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            //get room details
            $details = $get_item->fetch_details_cond('room_details', 'room', $id);
            foreach($details as $detail){
                $room = $detail->room;
                $price = $detail->price;
                $adult = $detail->adult;
                $child = $detail->child;
                $bathroom = $detail->bathroom;
                $bed = $detail->bed;
                $washer = $detail->washer;
                $air_con = $detail->air_condition;
                $description = $detail->description;
            }
        
    ?>
    <div class="add_user_form priceForm" style="width:50%; margin:0 50px">
        <h3 style='background:var(--primaryColor);'>Edit <?php echo strtoupper($row->category)?> details</h3>
        <section style="text-align:left">
            <div class="inputs" style="justify-content:left; gap:.1rem">
                    <input type="hidden" name="item_id" id="item_id" value="<?php echo $room?>" required>
                <!-- </div> -->
                
                <div class="data" style="width:50%; text-align:left;">
                    <label for="sales_price">Amount (NGN)</label>
                    <input type="text" name="price" id="price" value="<?php echo $price?>">
                </div>
                <!-- <div class="data" style="width:14%; text-align:left;">
                    <label for="sales_price">Adults</label>
                    <input type="number" name="adult" id="adult" value="<?php echo $adult?>">
                </div>
                <div class="data" style="width:14%; text-align:left;">
                    <label for="sales_price">Kids</label>
                    <input type="number" name="child" id="child" value="<?php echo $child?>">
                </div>
                <div class="data" style="width:14%; text-align:left;">
                    <label for="bed">Beds</label>
                    <input type="number" name="bed" id="bed" value="<?php echo $bed?>">
                </div>
                <div class="data" style="width:14%; text-align:left;">
                    <label for="sales_price">Bathrooms</label>
                    <input type="number" name="bathroom" id="bathroom" value="<?php echo $bathroom?>">
                </div>
                <div class="data" style="width:14%; text-align:left;">
                    <label for="washer">Washing Machine</label>
                    <select name="washer" id="washer">
                        <option value="<?php echo $washer?>"><?php echo $washer?></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="data" style="width:14%; text-align:left;">
                    <label for="aircon">Air Conditioner</label>
                    <select name="aircon" id="aircon">
                        <option value="<?php echo $air_con?>"><?php echo $air_con?></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="data" style="width:100%; text-align:left; margin-top:20px">
                    <label for="details">Room Description</label>
                    <textarea name="details" id="details" rows="5"><?php echo $description?></textarea>
                </div>
 -->
                <div class="data">
                    <button type="submit" id="change_price" name="change_price" onclick="changeRoomPrice()">Save <i class="fas fa-save"></i></button>
                    <a href="javascript:void(0)" title="close form" style='background:red; padding:10px; border-radius:5px; color:#fff' onclick="closeForm()">Return <i class='fas fa-angle-double-left'></i></a>
                </div>
            </div>
        </section>   
    </div>
    
<?php
    endforeach;
     }
    }    
?>