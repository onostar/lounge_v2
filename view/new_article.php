<?php
    session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    if(isset($_SESSION['user_id'])){
?>

<div id="add_room" class="displays">
    <div class="info"></div>
    <div class="add_user_form" style="width:80%">
        <h3 style="background:var(--moreColor)">Write a new article</h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm" enctype="multipart/form-data" id="addForm">
            <div class="inputs">
                
                <div class="data" style="margin:10px 0;">
                    <label for="item">Title</label>
                    <input type="text" name="title" id="title" required placeholder="Input title">
                </div>
                <div class="data" style="margin:10px 0;">
                    <label for="photo">Upload photo</label>
                    <input type="file" name="photo" id="photo">
                </div>
                <div class="data" style="margin:10px 0; width:100%">
                    <label for="details"> Details</label>
                    <textarea name="details" id="details" placeholder="Article Body"></textarea>
                </div>
                
                <div class="data" style="width:30%;">
                    <button type="submit" id="add_item" name="add_item" onclick="addArticle()">Post ARticle <i class="fas fa-save"></i></button>
                </div>
            </div>
        </section>    
    </div>
</div>
<?php }else{
    header("Location: ../index.php");
}