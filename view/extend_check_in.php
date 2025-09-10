<div id="extend_stay">
<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        if(isset($_GET['guest_id'])){
            $check_id = $_GET['guest_id'];
            $get_user = new selects();
            $details = $get_user->fetch_details_cond('check_ins', 'checkin_id', $check_id);
            foreach($details as $detail){
                //get room details
                $get_room = new selects();
                $results = $get_room->fetch_details_cond('items', 'item_id', $detail->room);
                foreach($results as $result){
                    $room = $result->item_name;
                    $category = $result->category;
                }
                //get room category
                $get_room_cat = new selects();
                $rows = $get_room_cat->fetch_details_cond('categories', 'category_id', $category);
                foreach($rows as $row){
                    $room_category = $row->category;
                    $cat_price = $row->price;
                }
?>

<div id="check_in" class="displays">
    <button class="page_navs" id="back" onclick="showPage('extend_stay.php')"><i class="fas fa-angle-double-left"></i> Back</button>
    <div class="info"></div>
    <div class="add_user_form">
        <h3>Extend guest stay</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
                <input type="hidden" name="posted_by" id="posted_by" value="<?php echo $user_id?>">
                <input type="hidden" name="guest" id="guest" value="<?php echo $check_id?>">
            <div class="inputs" style="align-items:center">
                <div class="data">
                    <h3 style="background:var(--otherColor)"><?php echo $room_category?></h3>
                </div>
                <div class="data">
                    <p style="color:green;font-weight:bold; font-size:1rem"><?php echo $room?></p>
                </div>
                <div class="data">
                    <p style="color:red; font-size:1rem">₦<?php echo number_format($cat_price, 2)?> per Night</p>
                </div>
            </div>
            <div class="inputs">
                <div class="data" style="width:48%">
                    <label for="check_in_date">Check in date</label>
                    <input type="date" name="check_in_date" id="check_in_date" value="<?php echo date("Y-m-d")?>"required readonly>
                </div>
                <div class="data" class="data" style="width:48%">
                    <label for="check_out_date">Check out date</label>
                    <input type="date" name="check_out_date" id="check_out_date" required oninput="calculateDays()">
                </div>
                
                
            </div>
            <div class="inputs">
                <div class="data">
                    <div id="amount">

                    </div>
                    <div id="fee">
                        <?php
                            //get room price
                            $get_cat = new selects();
                            $categories = $get_cat->fetch_details_group('items', 'category', 'item_id', $detail->room);
                            $category_id = $categories->category;
                            //get category price
                            $get_price = new selects();
                            $cat_price = $get_price->fetch_details_group('categories', 'price', 'category_id', $category_id);
                            $room_price =  $cat_price->price;


                        ?>
                        <input type="hidden" name="room_fee" id="room_fee" value="<?php echo $room_price?>">
                    </div>
                </div>
                <div class="data" id="days">

                </div>
                <div class="data">
                    <button type="submit" id="extend" name="extend" onclick="extendStay()">Extend stay <i class="fas fa-gauge"></i></button>
                </div>
                
            </div>
        </section>    
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