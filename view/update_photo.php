<div id="adjust_quantity">
<?php

    include "../classes/dbh.php";
    include "../classes/select.php";
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }

?>

    <div class="info" style="width:100%; margin:0!important"></div>
    <div class="allResults" style="width:80%!important;margin:20px 50px!important">
            <section class="addUserForm">
                <div class="add_user_form" style="width:60%; margin:10px 0; box-shadow:none">
                    <h3 style="background:var(--tertiaryColor); color:#fff; text-align:left!important;" >Update Item Photo</h3>
                    <div class="inputs">
                        <!-- bar items form -->
                        <div class="data" id="bar_items" style="width:100%; margin:2px 0">
                            <!-- <label for="item"> Search Items</label> -->
                            <input type="text" name="item" id="item" required placeholder="Search item" onkeyup="getItemDetails(this.value, 'get_item_photo.php')">
                            <div id="sales_item">
                                
                            </div>
                        </div>
                    
                    </div>
                </div>
            </section>
</div>