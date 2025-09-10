<?php
    session_start();
    $store = $_SESSION['store_id'];
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
        if(isset($_GET['guest_id'])){
            $check_id = $_GET['guest_id'];
            //get guest id
            $get_guest = new selects();
            $result = $get_guest->fetch_details_group('check_ins', 'guest', 'checkin_id', $check_id);
            $guest = $result->guest;
            //get guest details
            $get_details = new selects();
            $details = $get_details->fetch_details_cond('guests', 'guest_id', $guest);
            foreach($details as $detail){
                $fullname = $detail->last_name." ".$detail->other_names;
            }
        

?>
<div id="sales_order">
<div id="sales_form" class="displays all_details">
    
    <div class="add_user_form" style="width:50%; margin:10px 0">
        <h3 style="background:var(--primaryColor); color:#ff; text-align:left!important" >Add to  <?php echo $fullname?>'s Bill</h3>
        
            <!-- search forms -->
        <!-- <form method="POST" id="addUserForm"> -->
            <section class="addUserForm add_bill" style="padding:20px 0">
                <a href="javascript:void" style="background:brown" title="add accomodation" onclick="showPage('add_accomodation.php?guest=<?php echo $check_id?>')"><i class="fas fa-house-user"></i> Accomodation</a>
                <a href="javascript:void" style="background:var(--tertiaryColor)" title="add Bar & restaurant item" onclick="showPage('add_sales.php?customer=<?php echo $check_id?>')"><i class="fas fa-beer"></i> <i class="fas fa-cutlery"></i> Bar & Restaurant</a>
            </section>
            
        </div>
    </div>

</div>
<!-- for editing item quantitiy and price -->
<div class="show_more"></div>
<!-- showing all items in the sales order -->
<div class="sales_order"></div>
<?php
        }
    }else{
        header("Location: ../index.php");
    }
?>
</div>