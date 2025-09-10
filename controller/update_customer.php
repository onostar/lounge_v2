<?php
    $guest_id = htmlspecialchars(stripslashes($_POST['guest_id']));
    $last_name = ucwords(htmlspecialchars(stripslashes($_POST['last_name'])));
    $other_names = ucwords(htmlspecialchars(stripslashes($_POST['other_names'])));
    $phone = htmlspecialchars(stripslashes($_POST['contact_phone']));
    $address = ucwords(htmlspecialchars(stripslashes(($_POST['contact_address']))));
    $gender = htmlspecialchars(stripslashes(($_POST['gender'])));
    $emergency = htmlspecialchars(stripslashes(($_POST['emergency_contact'])));

   
    // instantiate class
    include "../classes/dbh.php";
    include "../classes/update.php";

       //update customer
       $update_data = new Update_table();
       $update_data->update_six('guests', 'last_name', $last_name, 'other_names', $other_names, 'contact_phone', $phone, 'contact_address', $address, 'gender', $gender, 'emergency_contact', $emergency, 'guest_id', $guest_id);
       if($update_data){
           echo "<div class='success'><p>$last_name $other_names</span> details updated successfully! <i class='fas fa-thumbs-up'></i></p></div>";
       }
   