<?php
    session_start();    
    // if(isset($_POST['change_prize'])){
        $article = htmlspecialchars(stripslashes($_POST['article']));
        $title = ucwords(htmlspecialchars(stripslashes($_POST['title'])));
        $details = ucwords(htmlspecialchars(stripslashes($_POST['details'])));

        // instantiate classes
        include "../classes/dbh.php";
        include "../classes/update.php";

        $change_name = new Update_table();
        $change_name->update_double('news_events', 'title', $title, 'details', $details, 'article_id', $article);
        if($change_name){
             echo "<div class='success'><p>Article details updated successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            echo "<p style='background:red; color:#fff; padding:5px'>Failed to modify article <i class='fas fa-thumbs-down'></i></p>";
        }
    // }