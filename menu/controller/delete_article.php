<?php
    include "connections.php";
    session_start();

    $_SESSION['success'] = "";
    $_SESSION['error'] = "";

    if(isset($_GET['news'])){
        $project = $_GET['news'];
        $delete_project = $connectdb->prepare("DELETE FROM news_events WHERE article_id = :article_id");
        $delete_project->bindvalue("article_id", $project);
        $delete_project->execute();
        if($delete_project){
             

            $_SESSION['success'] = "Post Deleted!";
            header("Location: ../admin/admin.php");
        }else{
            $_SESSION['error'] = "Delete failed";
        }
    }
?>