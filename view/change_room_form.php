<div id="guest_room_details">
<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
    
    if(isset($_GET['guest_id'])){
        $guest = $_GET['guest_id'];
        $get_user = new selects();
        $details = $get_user->fetch_details_cond('check_ins', 'checkin_id', $guest);
        foreach($details as $detail){
        //get guest information
        $get_guest = new selects();
        $results = $get_guest->fetch_details_cond('guests', 'guest_id', $detail->guest);
        foreach($results as $result){
            $fullname = $result->last_name." ".$result->other_names;
            $gender = $result->gender;
        }
            //get room details
            $get_room_name = new selects();
            $rows = $get_room_name->fetch_details_cond('items', 'item_id', $detail->room);
            foreach ($rows as $row){
                $room_name = $row->item_name;
                $room = $row->item_id;
                $category = $row->category;
            }
            //get room category

?>


<div class="displays all_details" style="width:35%!important; margin:30px 0!important;">
    <!-- <div class="info"></div> -->
    <button class="page_navs" id="back" onclick="showPage('change_room.php')"><i class="fas fa-angle-double-left"></i> Back</button>
    <h2>Change Guest room</h2>
    <div class="guest_name">
        <div class="displays allResults" id="payment_det">
            <div class="add_user_form">
            <!-- <form method="POST" id="addUserForm"> -->
                <h3><?php 
                if($gender == "Male"){
                    echo "Mr. ".$fullname. " | Guest00". $detail->guest;
                /* }else if($gender == "Female" && $detail->age <= 24){
                    echo "Ms. ". $detail->last_name . " ". $detail->first_name . " | Guest00". $detail->guest_id; */
                }else{
                    echo "Ms. ". $fullname . " | Guest00". $detail->guest;
                }
            ?> </h3>
            <section class="addUserForm">
                <div class="inputs">
                    <div class="data" style="width:100%; margin:10px 0;">
                        <label for="current_room">Current room</label>
                        <input type="hidden" name="guest" id="guest" value="<?php echo $detail->checkin_id?>">
                        <input type="hidden" name="posted_by" id="posted_by" value="<?php echo $user_id?>">
                        <input type="hidden" name="current_room" id="current_room" value="<?php echo $detail->room?>">
                        <input type="text" value="<?php echo $room_name?>" readonly>
                    </div>
                    <div class="data" style="width:100%; margin:10px 0">
                        <label for="new_room"> New room</label>
                        <select name="new_room" id="new_room">
                            <option value=""selected required>Select new room</option>
                            <?php
                                $get_rooms = new selects();
                                $cats = $get_rooms->fetch_details_2cond('items', 'category', 'item_status', $category, 0);
                                foreach($cats as $cat){

                            ?>
                            <option value="<?php echo $cat->item_id?>"><?php echo $cat->item_name?></option>
                            <?php }?>
                        </select>
                    </div>
                    
                </div>
                <div class="inputs">
                        <button type="submit" id="add_item" name="change_room" id="change_room"onclick="changeRoom()">Change room <i class="fas fa-save"></i></button>
                </div>
            </section>    
        </div>
        </div>
    </div>
    
</div>
<?php
            }
        }
    }else{
        header("Location: ../index.php");
    }
?>
</div>