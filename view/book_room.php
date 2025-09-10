<div id="check_in" class="displays" style="margin: 0!important">
<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        
        
?>

    <div class="add_user_form">
        <h3 style="background:var(--tertiaryColor)">Make Reservation</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
            <div class="inputs">
                <div class="data">
                    <label for="last_name">Last name</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Enter surname" required>
                </div>
                <div class="data">
                    <label for="first_name">Other names</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Enter other name" required>
                </div>
                <div class="data">
                    <label for="contact_phone">Phone Number</label>
                    <input type="tel" name="contact_phone" id="contact_phone">
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
                    <label for="emergency_contact">Email Address</label>
                    <input type="tel" name="email" id="email" required>
                </div>
                
            </div>      
            <div class="inputs">
                <input type="hidden" name="posted_by" id="posted_by" value="<?php echo $user_id?>">
                <div class="data">
                    <label for="check_in_category">Select room category</label>
                    <select name="check_in_category" id="check_in_category" onchange="getRoomPrice(this.value)">
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
                <div class="data">
                    <label for="quantity">Rooms</label>
                    <input type="number" placeholder="Number of rooms" id="quantity" name="quantity" value="1" oninput="calculateBooking()">
                </div>
                <div class="data">
                    <label for="check_in_date">Check in date</label>
                    <input type="date" name="check_in_date" id="check_in_date" required onchange="calculateBooking()">
                </div>
                <div class="data" style="margin-top:5px">
                    <label for="check_out_date">Check out date</label>
                    <input type="date" name="check_out_date" id="check_out_date" required onchange="calculateBooking()">
                </div>
                <div id="fee" class="data">
                        
                </div>
            </div>
            <div class="inputs">
                <div class="data" id="fees_days">
                    
                    <div id="amount">

                    </div>
                    <div id="days">

                    </div>
                    <button type="submit" id="check_in_btn" name="check_in_btn" onclick="booking()">Book Room <i class="fas fa-check-double"></i></button>
                </div>
                <div class="room_availability">
                    
                </div>
                
            </div>
        </section>    
    </div>
 
</div>
<?php
    }else{
        header("Location: ../index.php");

    }
?>