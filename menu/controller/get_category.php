<?php

    if(isset($_GET['category'])){
        $category = htmlspecialchars(stripslashes($_GET['category']));

        //get all items in this categeory
        include "../../classes/dbh.php";
        include "../../classes/select.php";

        $get_items = new selects();
        //get category name
        $cat = $get_items->fetch_details_group('categories', 'category', 'category_id', $category);
        $category_name = $cat->category;
?>
        <h3 style="text-transform:uppercase"><?php echo $category_name?> <span style="font-weight:normal">Menu</span></h3>
        <div class="menu_item">
<?php
            $rows = $get_items->fetch_details_cond('items', 'category', $category);
            if(is_array($rows)){
                foreach($rows as $row){
    ?>      
            <figure>
                <img src="../photos/<?php echo $row->photo?>" alt="<?php echo $row->item_name?>">
                <figcaption>
                    <h4><?php echo $row->item_name?></h4>
                    <p><?php echo "₦".number_format($row->sales_price, 2);?></p>
                </figcaption>
            </figure>
    <?php
                }
            }else{
                echo "No item found in $category_name";
            }
    ?>
    </div>
    <?php
    }else{
        header("Location: ../index.php");
    }