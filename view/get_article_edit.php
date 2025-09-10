<div id="item_list" style="margin:40px">
<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/update.php";
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        // echo $user_id;
    
    if(isset($_GET['item'])){
        $item = $_GET['item'];
        //get item;
        $get_item = new selects();
        $rows = $get_item->fetch_details_cond('news_events', 'article_id', $item);
        foreach($rows as $row){
            $title = $row->title;
            $photo = $row->photo;
            $details = $row->details;
            

        }
        //get invoice details

?>

<div class="close_btn">
    <a href="javascript:void(0)" onclick="showPage('articles.php')" class="close_form">Return</a>
</div>
<div class="add_user_form" style="width:60%; margin: 0">
        <h3>Update <?php echo $title?> </h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm" enctype="multipart/form-data" >
            <div class="inputs">
                <input type="hidden" name="article" id="article" value="<?php echo $item?>">
                <div class="data">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="<?php echo $title?>">
                </div>
                <div class="data" style="width:100%">
                    <label for="details">Details</label>
                    <textarea name="details" id="details"><?php echo $details?></textarea>
                </div>
            </div>
            <div class="inputs">
                <button type="submit" id="upload" name="upload" onclick="updateArticle()">Update <i class="fas fa-upload"></i></button>
            </div>
</section>    
    </div>
<?php
            }
        
    }else{
        header("Location: ../index.php");
    }
?>
</div>