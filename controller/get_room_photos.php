
<?php
    
        // echo $user_id;
    
        if (isset($_GET['item_id'])){
            $id = $_GET['item_id'];
        //get item;
        include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
        $get_item = new selects();
        $rows = $get_item->fetch_details_cond('room_details', 'room', $id);
        foreach($rows as $row){
            // $item_name = $row->item_name;
            $photo = $row->photo1;
            $photo2 = $row->photo2;
            $photo3 = $row->photo3;
            

        }
        $names = $get_item->fetch_details_group('categories', 'category', 'category_id', $id);
        $room_name = $names->category;
?>
<div class="add_user_form priceForm" style="width:60%; margin: 0 50px">
        <h3>Update <?php echo $room_name?> Photos</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm" enctype="multipart/form-data" >
            <div class="inputs">
                <input type="hidden" name="item" id="item" value="<?php echo $id?>">
                <div class="data" id="foto">
                    <img src="<?php echo '../../photos/'.$photo?>" alt="First Photo">
                </div>
                <div class="data" id="foto">
                    <img src="<?php echo '../../photos/'.$photo2?>" alt="Second photo">
                </div>
                <div class="data" style="text-align:left">
                    <label for="foto">Select photo</label>
                    <select name="pics" id="pics">
                        <option value="photo1">First Photo</option>
                        <option value="photo2">Second Photo</option>
                        <option value="photo3">Third Photo</option>
                    </select>
                </div>
                <div class="data" style="text-align:left">
                    <label for="photo">Upload image</label>
                    <input type="file" name="photo" id="photo">
                </div>
            </div>
            <div class="inputs">
                <button type="submit" id="upload" name="upload" onclick="updatePhoto()">Update image <i class="fas fa-upload"></i></button>
                <a href="javascript:void(0)" title="close form" style='background:red; padding:10px; border-radius:5px; color:#fff' onclick="closeForm()">Return <i class='fas fa-angle-double-left'></i></a>
            </div>
</section>    
    </div>
<?php
            }
        
    
?>
