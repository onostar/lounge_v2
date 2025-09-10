<div id="edit_price">
<?php

    include "../classes/dbh.php";
    include "../classes/select.php";
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }

?>

    <div class="info" style="width:100%; margin:0!important"></div>
    <div class="displays allResults" style="width:80%!important; margin:0 50px!important">
        <h2>Manage Room Details</h2>
        <hr>
        <div class="search">
            <input type="search" id="searchGuestPayment" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('roomPriceTable', 'Rooms Price list')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="roomPriceTable" class="searchTable">
            <thead>
                <tr style="background:var(--otherColor)">
                    <td>S/N</td>
                    <td>Room Category</td>
                    <td>Price (₦)</td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
            <?php
                $n = 1;
                $select_cat = new selects();
                $rows = $select_cat->fetch_details_cond('categories', 'department', 1);
                if(gettype($rows) == "array"){
                foreach($rows as $row):
            ?>
                <tr>
                    <td style="text-align:center;"><?php echo $n?></td>
                    <td><?php echo strtoupper($row->category)?></td>
                    <td>
                        <?php 
                            $get_price = new selects();
                            $dets = $get_price->fetch_details_group('room_details', 'price', 'room', $row->category_id);
                            echo number_format($dets->price);
                        ?>
                    </td>
                    <td class="prices">
                        <a style="background:var(--tertiaryColor)!important; color:#fff!important; padding:5px 8px; margin:5px;border-radius:15px; box-shadow:1px 1px 1px #222" href="javascript:void(0)" title="update room details" class="each_prices" onclick="getForm('<?php echo $row->category_id?>', 'get_room_details.php');">Update details <i class="fas fa-edit"></i></a>
                        <!-- <a style="background:var(--tertiaryColor)!important; color:#fff!important; padding:5px 8px; border-radius:15px; box-shadow:1px 1px 1px #222" href="javascript:void(0)" title="update room photos" onclick="getForm('<?php echo $row->category_id?>', 'get_room_photos.php');">Update photo <i class="fas fa-camera"></i></a>
                        <a style="background:var(--primaryColor)!important; color:#fff!important; padding:5px 8px; border-radius:15px; box-shadow:1px 1px 1px #222" href="../../rooms.php?room=<?php echo $row->category_id?>" target="_blank"title="view room">View <i class="fas fa-eye"></i></a> -->
                    </td>
                </tr>
            <?php $n++; endforeach; }?>

            </tbody>

        </table>
        
        <?php
            if(gettype($rows) == "string"){
                echo "<p class='no_result'>'$rows'</p>";
            }
        ?>
    </div>
</div>