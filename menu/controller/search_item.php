<?php

    
        $item = htmlspecialchars(stripslashes($_GET['item']));

        //get all items in this categeory
        include "../../classes/dbh.php";
        include "../../classes/select.php";

        $get_items = new selects();
?>
        <h3 style="text-transform:uppercase"><span style="font-weight:normal">Search Result for </span> "<?php echo $item?>"</h3>
        <div class="menu_item">
<?php
            $rows = $get_items->fetch_details_like('items', 'item_name', $item);
            if(is_array($rows)){
                foreach($rows as $row){
    ?>      
            <figure>
                <img src="../photos/<?php echo $row->photo?>" alt="<?php echo $row->item_name?>" loading="lazy">
                <figcaption>
                    <h4><?php echo $row->item_name?></h4>
                    <p><?php echo "₦".number_format($row->sales_price, 2);?></p>
                </figcaption>
            </figure>
    <?php
                }
            }else{
                echo "No result found for $item";
            }
    ?>
    </div>