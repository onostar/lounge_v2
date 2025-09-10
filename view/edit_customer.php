<div id="update_customer">
<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        if(isset($_GET['customer'])){
            $customer = $_GET['customer'];
            //get customer name
            $get_customer = new selects();
            $rows = $get_customer->fetch_details_cond('guests', 'guest_id', $customer);
            foreach($rows as $row){

?>
    <div class="add_user_form" style="width:70%">
        <h3>Edit <?php echo $row->last_name." ".$row->other_names?> details</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
            <div class="inputs" style="gap:.5rem;">
                <div class="data">
                    <label for="customer">Last Name</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Enter guest's last name" value="<?php echo $row->last_name?>" required>
                    <input type="hidden" name="guest_id" id="guest_id" value="<?php echo $row->guest_id?>" required>
                </div>
                <div class="data">
                    <label for="other_names">Other Names</label>
                    <input type="text" name="other_names" id="other_names" placeholder="Enter other names" value="<?php echo $row->other_names?>" required>
                </div>
                <div class="data">
                    <label for="contact_phone">Phone number</label>
                    <input type="text" name="contact_phone" id="contact_phone" required value="<?php echo $row->contact_phone?>">
                </div>
                <div class="data">
                    <label for="Address">Address</label>
                    <input type="text" name="contact_address" id="contact_address" required value="<?php echo $row->contact_address?>">
                </div>
                <div class="data">
                    <label for="Gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="<?php echo $row->gender?>" selected><?php echo $row->gender?></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="data">
                    <label for="emergency_contact">Emergency contact</label>
                    <input type="text" name="emergency_contact" id="emergency_contact"  required value="<?php echo $row->emergency_contact?>">
                </div>
            </div>
            <div class="inputs">
                <button type="submit" id="update_customer" name="update_customer" onclick="updateCustomer()">Update details <i class="fas fa-save"></i></button>
            </div>
        </section>    
    </div>

<?php
            }
        }
    }else{
        header("Location: ../index.php");
    }
?>
</div>
