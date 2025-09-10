<?php

    $category = ucwords(htmlspecialchars(stripslashes($_POST['category'])));
    $department = ucwords(htmlspecialchars(stripslashes($_POST['department'])));

    $data = array(
        'department' => $department,
        'category' => $category
    );
    //instantiate class
    
    include "../classes/dbh.php";
    include "../classes/select.php";
    include "../classes/inserts.php";

    //check if categeory exist
    $check = new selects();
    $results = $check->fetch_count_2cond('categories', 'department', $department, 'category', $category);
    if($results > 0){
        echo "<p class='exist'>$category already exists</p>";
    }else{
        //add new catgory
        $add_data = new add_data('categories', $data);
        $add_data->create_data();
        if($add_data){
            if($department == 1){
                //add to room details
                $rows = $check->fetch_last_inserted('categories', 'category_id');
                foreach($rows as $row){
                    $last_id = $row->category_id;
                }
                $room_data =array(
                    'room' => $last_id
                );
                $add_data = new add_data('room_details', $room_data);
                $add_data->create_data();   
            }
            echo "<p>$category added</p>";
        }
    }