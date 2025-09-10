<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
    
?>

<div id="check_in" class="displays">
    <div class="info"></div>
    <div class="add_user_form">
        <h3 style="background:var(--tertiaryColor);">Check in guest</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
            <div class="inputs" style="justify-content:center">
                <div class="data">
                    <input type="text" name="guest_phone" id="guest_phone" placeholder="enter guest phone number" required>
                </div>
                <div class="data">
                    <button type="submit" id="get_det_btn" name="get_det_btn" onclick="checkGuest()" style="background:var(--otherColor)">Get details <i class="fas fa-user-tie"></i></button>

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