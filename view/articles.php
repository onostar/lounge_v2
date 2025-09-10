<div id="item_list">
<?php
session_start();
    include "../classes/dbh.php";
    include "../classes/select.php";
    

    //get user
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
        //get user role
        $get_role = new selects();
        $roles = $get_role->fetch_details_group('users', 'user_role', 'username', $username);
        $role = $roles->user_role;

?>
    <div class="info"></div>
<div class="displays allResults" id="bar_items" style="margin:20px 50px;">
    <h2>List of articles</h2>
    <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword" onkeyup="searchData(this.value)">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('item_list_table', 'Articles')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
    <table id="item_list_table" class="searchTable">
        <thead>
            <tr style="background:var(--moreColor)">
                <td>S/N</td>
                <td>Title</td>
                <td>Post Date</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php
                $n = 1;
                $get_items = new selects();
                $details = $get_items->fetch_details('news_events');
                if(gettype($details) === 'array'){
                foreach($details as $detail):
            ?>
            <tr>
                <td style="text-align:center; color:red;"><?php echo $n?></td>
               
                <td><?php echo $detail->title?></td>
               
                <td>
                    <?php
                       
                        echo date("jS M, Y", strtotime($detail->post_date));
                    ?>
                </td>
                <td>
                    <a href="../../article_info.php?id=<?php echo $detail->article_id?>" target="_blank" title="view article" style="background:var(--tertiaryColor); color:#fff; padding:5px;border-radius:15px">View <i class="fas fa-eye"></i></a>
                    
                    <a style="padding:5px; border-radius:15px;background:var(--moreColor);color:#fff;"href="javascript:void(0)" onclick="showPage('get_article_edit.php?item=<?php echo $detail->article_id?>')" title="update article"> Update <i class="fas fa-edit"></i></a>
                
                </td>
            </tr>
            
            <?php $n++; endforeach;}?>
        </tbody>
    </table>
    
    <?php
        
        if(gettype($details) == "string"){
            echo "<p class='no_result'>'$details'</p>";
        }
    
    ?>
</div>
<?php }?>
</div>