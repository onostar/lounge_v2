<?php
    include "connections.php";
    session_start();

    $_SESSION['success'] = "";
    $_SESSION['error'] = "";


    if(isset($_POST['login'])){
        $username = ucwords(htmlspecialchars(stripslashes($_POST['username'])));
        $password = htmlspecialchars(stripslashes($_POST['user_password']));

        $get_user = $connectdb->prepare("SELECT * FROM users WHERE username = :username AND user_password = :user_password");
        $get_user->bindvalue("username", $username);
        $get_user->bindvalue("user_password", $password);
        $get_user->execute();

        if($get_user->rowCount() > 0){
            $_SESSION['user'] = $username;
            $users = $get_user->fetchAll();
            foreach($users as $user){
                if($username === "Admin"){
                    $_SESSION['success'] = "Welcome Admin";
                    header("Location: ../admin/admin.php");
                }else{
                    $_SESSION['success'] = "Welcome " . $user->last_name;
                    header("Location: ../views/users.php");
                }
            }
        }else{
            $_SESSION['error'] = "Invalid username or password";
            header("Location: ../admin/index.php");
        }
    }