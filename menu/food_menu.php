<!DOCTYPE html>
<?php
    include "../classes/dbh.php";
    include "../classes/select.php";
    $title = "The Residence Social House | Food Menu";
?>
        <?php include "header.php"?>
        
    <main style="margin-top:14vh">
        <form id="menu_form">
            <input type="search" name="item" id="item" placeholder="Search menu">
            <button type="button" onclick="searchMenu()"><i class="fas fa-search"></i></button>
        </form>
        <div id="menu_category">
            <h2>Food Categories</h2>
            <div class="categories">
                <?php 
                    $get_categories = new selects();
                    $categories = $get_categories->fetch_details_cond('categories', 'department', 2);
                    if(is_array($categories)){
                        foreach($categories as $cat):
                ?>
                <figure onclick="showCategory('<?php echo $cat->category_id?>')">
                    <img src="images/food_category.jpg" alt="<?php echo $cat->category?>">
                    <figcaption><?php echo $cat->category?></figcaption>
                </figure>
                <?php endforeach; }else{
                        echo "No Category";
                    }
                ?>
            </div>
        </div>
        <Section id="menu_items" >
            <h3>Food List</h3>
            <div class="menu_item">
                <?php 
                    $items = $get_categories->fetch_details_cond('items', 'department', 2);
                    if(is_array($items)){
                        foreach($items as $item):
                ?>
                <figure>
                    <img src="../photos/<?php echo $item->photo?>" alt="<?php echo $item->item_name?>" loading="lazy">
                    <figcaption>
                        <h4><?php echo $item->item_name?></h4>
                        <p><?php echo "₦".number_format($item->sales_price, 2);?></p>
                    </figcaption>
                </figure>
                <?php endforeach; }else{
                        echo "No Food available";
                    }
                ?>
            </div>
        </Section>
    </main>

    <script src="jquery.js"></script>
    <script src="script.js"></script>
</body>
</html>