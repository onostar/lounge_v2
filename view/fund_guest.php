<div id="refund" class="displays">

<?php
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_GET['guest'])){
        $guest = $_GET['guest'];
        $get_guest = new selects();
        $rows = $get_guest->fetch_details_cond('guests', 'guest_id', $guest);
        foreach($rows as $row){
            $wallet = $row->wallet;
            $full_name = $row->last_name." ".$row->other_names;
        }
?>
    <div class="info"></div>
    <button class="page_navs" id="back" onclick="showPage('fund_wallet.php')"><i class="fas fa-angle-double-left"></i> Back</button>
    <div class="add_user_form" style="width:50%; margin:0">
        <h3 style="background:var(--tertiaryColor)">Fund <?php echo strtoupper($full_name)?> Account</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
            <div class="inputs">
                <input type="hidden" id="guest" name="guest" value="<?php echo $guest?>">
                <div class="data">
                    <label for="Wallet">Current Balance (₦)</label>
                    <input type="text" value="<?php echo number_format($wallet, 2)?>" readonly style="color:green">
                    <input type="hidden" name="wallet" id="wallet"value="<?php echo $wallet?>">
                </div>
                <div class="data">
                    <label for="amount">Amount (₦)</label>
                    <input type="number" name="amount" id="amount" required>
                </div>
                
            </div>
            <div class="inputs">
                <button type="submit" id="add_cat" name="add_cat" onclick="fundGuest()">Refund <i class="fas fa-spin-reverse"></i></button>
            </div>
    </section>    
    </div>
<?php }?>

</div>