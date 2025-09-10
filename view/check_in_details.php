<div id="check_in" class="displays">
<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        $guest = htmlspecialchars(stripslashes($_POST['guest_phone']));
        $get_guest = new selects();
        $rows = $get_guest->fetch_details_cond('guests', 'contact_phone', $guest);
        if(gettype($rows) == 'array'){
            foreach($rows as $row){
                $last_name = $row->last_name;
                $other_name = $row->other_names;
                $gender = $row->gender;
                $address = $row->contact_address;
                $emergency = $row->emergency_contact;
            }
        
?>

    <div class="add_user_form">
        <h3>Check in a Guest</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
            <div class="inputs">
                <input type="hidden" name="posted_by" id="posted_by" value="<?php echo $user_id?>">
                <div class="data" style="width:49%">
                    <label for="check_in_category">Select room category</label>
                    <select name="check_in_category" id="check_in_category" onchange="getRooms(this.value)">
                        <option value=""selected required>Select category</option>
                        <?php
                            $get_category = new selects();
                            $rows = $get_category->fetch_details_cond('categories', 'department', 1);
                            foreach($rows as $row){
                        ?>
                        <option value="<?php echo $row->category_id?>"><?php echo $row->category?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="data" style="width:49%">
                    <label for="check_in_room">Select room</label>
                    <select name="check_in_room" id="check_in_room" onchange="getPrice(this.value)">
                        <option value=""selected required>Select room</option>
                        
                    </select>
                </div>
            </div>
            <div class="inputs">
                <div class="data">
                    <label for="last_name">Last name</label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo $last_name?>" readonly>
                </div>
                <div class="data">
                    <label for="first_name">Other name</label>
                    <input type="text" name="first_name" id="first_name" value="<?php echo $other_name?>" readonly>
                </div>
                <div class="data">
                    <label for="contact_phone">Contact Phone</label>
                    <input type="tel" name="contact_phone" id="contact_phone" value="<?php echo $guest?>" readonly>
                </div>
            </div>
            <div class="inputs">
                <div class="data">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" readonly>
                        <option value="<?php echo $gender?>" selected><?php echo $gender?></option>
                    </select>
                </div>
                <div class="data">
                    <label for="contact_address">Residential Address</label>
                    <input type="text" name="contact_address" id="contact_address" value="<?php echo $address?>">
                </div>
                <div class="data">
                    <label for="emergency_contact">Emergency Contact</label>
                    <input type="tel" name="emergency_contact" id="emergency_contact" value="<?php echo $emergency?>">
                </div>
                
            </div>                
            <div class="inputs">
                <div class="data">
                    <label for="check_in_date">Check in date</label>
                    <input type="date" name="check_in_date" id="check_in_date" required onchange="calculateDays()">
                </div>
                <div class="data" class="data">
                    <label for="check_out_date">Check out date</label>
                    <input type="date" name="check_out_date" id="check_out_date" required onchange="calculateDays()">
                </div>
                <div class="data">
                    <div id="fee">

                    </div>
                </div>
                
            </div>
            <div class="inputs" style="align-items:center">
                <div class="data" id="fees_days" style="display:flex;justify-content:space-between; align-items:center; width:100%">
                    
                    <div id="amount">

                    </div>
                    <div id="days">

                    </div>
                    <button type="submit" id="check_in_btn" name="check_in_btn" onclick="checkIn()">Check in <i class="fas fa-check-double"></i></button>
                </div>
                
                
            </div>
        </section>    
    </div>
    <?php 
        };
        if(gettype($rows) == 'string'){
    ?>
    <div class="add_user_form">
        <h3>Check in a Guest</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
            <div class="inputs">
                <input type="hidden" name="posted_by" id="posted_by" value="<?php echo $user_id?>">
                <div class="data" style="width:49%">
                    <label for="check_in_category">Select room category</label>
                    <select name="check_in_category" id="check_in_category" onchange="getRooms(this.value)">
                        <option value=""selected required>Select category</option>
                        <?php
                            $get_category = new selects();
                            $rows = $get_category->fetch_details_cond('categories', 'department', 1);
                            foreach($rows as $row){
                        ?>
                        <option value="<?php echo $row->category_id?>"><?php echo $row->category?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="data" style="width:49%">
                    <label for="check_in_room">Select room</label>
                    <select name="check_in_room" id="check_in_room" onchange="getPrice(this.value)">
                        <option value=""selected required>Select room</option>
                        
                    </select>
                </div>
            </div>
            <div class="inputs">
                <div class="data">
                    <label for="last_name">Last name</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Enter surname" required>
                </div>
                <div class="data">
                    <label for="first_name">Other name</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Enter other name" required>
                </div>
                <div class="data">
                    <label for="contact_phone">Contact Phone</label>
                    <input type="tel" name="contact_phone" id="contact_phone" value="<?php echo $guest?>">
                </div>
            </div>
            <div class="inputs">
                <div class="data">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="" selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="data">
                    <label for="contact_address">Residential Address</label>
                    <input type="text" name="contact_address" id="contact_address" placeholder="contact residential address" required>
                </div>
                <div class="data">
                    <label for="emergency_contact">Emergency Contact</label>
                    <input type="tel" name="emergency_contact" id="emergency_contact" placeholder="+2347012345678" required>
                </div>
                
            </div>                
            <div class="inputs">
                <div class="data">
                    <label for="check_in_date">Check in date</label>
                    <input type="date" name="check_in_date" id="check_in_date" required onchange="calculateDays()">
                </div>
                <div class="data" class="data">
                    <label for="check_out_date">Check out date</label>
                    <input type="date" name="check_out_date" id="check_out_date" required onchange="calculateDays()">
                </div>
                <div class="data">
                    <div id="fee">

                    </div>
                </div>
                
            </div>
            <div class="inputs" style="align-items:center">
                <div class="data" id="fees_days" style="display:flex;justify-content:space-between; align-items:center; width:100%">
                    <div id="amount">

                    </div>
                    <div id="days">

                    </div>
                    <button type="submit" id="check_in_btn" name="check_in_btn" onclick="checkIn()">Check in <i class="fas fa-check-double"></i></button>
                </div>
                
                
            </div>
        </section>    
    </div>
    <?php }?>
</div>
<?php
    }else{
        header("Location: ../index.php");

    }
?>