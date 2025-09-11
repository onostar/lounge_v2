<?php
    date_default_timezone_set("Africa/Lagos");
    // session_start();
    class selects extends Dbh{
        
         //fetch details from any table
        public function fetch_details($table){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;

            }else{
                $rows = "<p class='no_result'>No records found</p>";
            }
        }
        //fetch last inseeted
        public function fetch_last_inserted($table, $order){
            $get_data = $this->connectdb()->prepare("SELECT * FROM $table ORDER BY $order DESC LIMIT 1");
            $get_data->execute();
            if($get_data->rowCount() > 0){
                $rows = $get_data->fetchAll();
                return $rows;
            }else{
                $rows = "No record found";
                return $rows;
            }
        }
        //fetch limit
        public function fetch_details_limit($table, $limit, $order){
            $get_data = $this->connectdb()->prepare("SELECT * FROM $table ORDER BY $order DESC LIMIT $limit");
            $get_data->execute();
            if($get_data->rowCount() > 0){
                $rows = $get_data->fetchAll();
                return $rows;
            }else{
                $rows = "No record found";
                return $rows;
            }
        }
        // fetch details like 2 conditions
        public function fetch_details_like2EqualCond($table, $column1, $column2, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 LIKE '%$value%' OR $column2 = :$column2");
            $get_user->bindValue("$column2", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch details with condition
        public function fetch_details_cond($table, $column, $condition){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column = :$column");
            $get_user->bindValue("$column", $condition);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch details with like or close to
        public function fetch_details_like($table, $column, $condition){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column LIKE '%$condition%'");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch details with like or close to with a condition
        public function fetch_details_likeCond($table, $column, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column LIKE '%$value%'");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch details like 2 conditions
        public function fetch_details_like2Cond($table, $column1, $column2, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 LIKE '%$value%' OR $column2 LIKE '%$value%'");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch details like 2 conditions and 1 negative
        public function fetch_details_like2Cond1Neg($table, $column1, $column2, $value, $condition, $condition_value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition != :$condition AND $column1 LIKE '%$value%' OR $column2 LIKE '%$value%'");
            $get_user->bindValue("$condition", $condition_value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch details count without condition
        public function fetch_count($table){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                
                return "0";
            }
        }
        //fetch details count with condition
        public function fetch_count_cond($table, $column, $condition){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column = :$column");
            $get_user->bindValue("$column", $condition);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //fetch details count with 2 condition
        public function fetch_count_2cond($table, $column1, $condition1, $column2, $condition2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 = :$column1 AND $column2 = :$column2");
            $get_user->bindValue("$column1", $condition1);
            $get_user->bindValue("$column2", $condition2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //fetch details count with 2 condition 1 negative
        public function fetch_count_2cond1Neg($table, $column1, $condition1, $column2, $condition2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 = :$column1 AND $column2 != :$column2");
            $get_user->bindValue("$column1", $condition1);
            $get_user->bindValue("$column2", $condition2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //fetch details count with 2 condition and current date
        public function fetch_count_2condDate($table, $column1, $condition1, $column2, $condition2, $date){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 = :$column1 AND $column2 = :$column2 AND date($date) = CURDATE()");
            $get_user->bindValue("$column1", $condition1);
            $get_user->bindValue("$column2", $condition2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //fetch details count with 2 condition and current date and grouped by
        public function fetch_count_2condDateGro($table, $column1, $condition1, $column2, $condition2, $date, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 = :$column1 AND $column2 = :$column2 AND date($date) = CURDATE() GROUP BY $group");
            $get_user->bindValue("$column1", $condition1);
            $get_user->bindValue("$column2", $condition2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        public function fetch_count_2cond1DateGro($table, $column1, $condition1, $column2, $condition2, $date, $start, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 = :$column1 AND $column2 = :$column2 AND date($date) = '$start' GROUP BY $group");
            $get_user->bindValue("$column1", $condition1);
            $get_user->bindValue("$column2", $condition2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //negative
        public function fetch_count_1cond1neg1DateGro($table, $column1, $condition1, $column2, $condition2, $date, $start, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 != :$column1 AND $column2 = :$column2 AND date($date) = '$start' GROUP BY $group");
            $get_user->bindValue("$column1", $condition1);
            $get_user->bindValue("$column2", $condition2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //fetch details count with 2 condition and current date and grouped by
        public function fetch_count_2cond2DateGro($table, $column1, $condition1, $column2, $condition2, $date, $start, $start_date, $end, $end_date, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 = :$column1 AND $column2 = :$column2 AND date($date) BETWEEN :$start AND :$end GROUP BY $group");
            $get_user->bindValue("$column1", $condition1);
            $get_user->bindValue("$column2", $condition2);
            $get_user->bindValue("$start", $start_date);
            $get_user->bindValue("$end", $end_date);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //fetch details count with condition and curdate
        public function fetch_count_curDate($table, $column){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE date($column) = CURDATE()");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        // select count with date and negative condition
        public function fetch_count_curDateCon($table, $column, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE date($column) = CURDATE() AND $condition != :$condition");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //fetch details count with condition where another condition is <= current
        public function fetch_count_curDateLessCon($table, $column, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE date($column) <= CURDATE() AND $condition = :$condition");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                return $get_user->rowCount();
            }else{
                return "0";
            }
        }
        //fetch with two condition
        public function fetch_details_2cond($table, $condition1, $condition2, $value1, $value2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 = :$condition2");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch articles
        public function fetch_articles(){
            $get_user = $this->connectdb()->prepare("SELECT SUBSTRING_INDEX(details, ' ', 40) AS details, title, article_id, photo, post_date FROM news_events ORDER BY post_date DESC LIMIT 4");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with two condition group by
        public function fetch_details_2condGroup($table, $condition1, $condition2, $value1, $value2, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 = :$condition2 GROUP BY $group");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with one condition group by
        public function fetch_details_condGroup($table, $condition1, $value1, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 GROUP BY $group");
            $get_user->bindValue("$condition1", $value1);
            // $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with one condition group by
        public function fetch_AllStock(){
            $get_user = $this->connectdb()->prepare("SELECT SUM(DISTINCT quantity) AS total, cost_price, item FROM inventory GROUP BY item");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with one condition positiove and another negative group by
        public function fetch_details_2condNegGroup($table, $condition1, $condition2, $value1, $value2, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 != :$condition2 GROUP BY $group");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with one condition positive and another negative on curren dategroup by
        public function fetch_details_2condNegDateGroup($table, $condition1, $condition2, $value1, $value2, $date, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 != :$condition2 AND date($date) = CURDATE() GROUP BY $group");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with one condition positive and another negative on curren dategroup by
        public function fetch_details_2condNeg2DateGroup($table, $condition1, $condition2, $value1, $value2, $column, $from, $to, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 != :$condition2 AND $column BETWEEN '$from' AND '$to' GROUP BY $group");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with one condition positive and another negative between two dates
        public function fetch_details_2condNeg2Date($table, $condition1, $condition2, $value1, $value2, $column, $from, $to){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 != :$condition2 AND $column BETWEEN '$from' AND '$to'");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with two condition (one is negative)
        public function fetch_details_2cond1neg($table, $condition1, $condition2, $value1, $value2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 != :$condition2");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates
        public function fetch_details_date($table, $condition1, $value1, $value2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 BETWEEN '$value1' AND '$value2'");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and a condition
        public function fetch_details_date2Con($table, $column, $value1, $value2, $condition, $condition_value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition AND $column BETWEEN '$value1' AND '$value2'");
            $get_user->bindValue("$condition",$condition_value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and 2 condition
        public function fetch_details_2date2Con($table, $column, $value1, $value2, $condition, $condition_value, $condition2, $condition_value2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition AND $condition2 = :$condition2 AND $column BETWEEN '$value1' AND '$value2'");
            $get_user->bindValue("$condition",$condition_value);
            $get_user->bindValue("$condition2",$condition_value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and 2 condition 1 negative
        public function fetch_details_2date2Con1neg($table, $column, $value1, $value2, $condition, $condition_value, $condition2, $condition_value2, $con3, $val3){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition AND $condition2 = :$condition2 AND $con3 != :$con3 AND $column BETWEEN '$value1' AND '$value2'");
            $get_user->bindValue("$condition",$condition_value);
            $get_user->bindValue("$condition2",$condition_value2);
            $get_user->bindValue("$con3",$val3);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and 2 condition 1 negative
        public function fetch_waiter_order($waiter, $store, $start, $end){
            $get_user = $this->connectdb()->prepare("SELECT * FROM sales WHERE store = :store AND order_by = :order_by AND sales_status != 0 AND date(start_dates) BETWEEN '$start' AND '$end'");
            $get_user->bindValue("store", $store);
            $get_user->bindValue("order_by",$waiter);
            /*$get_user->bindValue("end_dates",$end); */
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and grouped
        public function fetch_details_dateGro($table, $condition1, $value1, $value2, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 BETWEEN '$value1' AND '$value2' GROUP BY $group");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and a condition and grouped
        public function fetch_details_dateGro1con($table, $condition1, $value1, $value2, $con, $con_value, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $con = :$con AND $condition1 BETWEEN '$value1' AND '$value2' GROUP BY $group");
            $get_user->bindValue("$con", $con_value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and 2 condition and grouped
        public function fetch_details_dateGro2con($table, $condition1, $value1, $value2, $con, $con_value, $con2, $con_value2, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $con = :$con AND $con2 = :$con2 AND $condition1 BETWEEN '$value1' AND '$value2' GROUP BY $group");
            $get_user->bindValue("$con", $con_value);
            $get_user->bindValue("$con2", $con_value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and Condition
        public function fetch_details_2dateCon($table, $column, $condition1, $value1, $value2, $column_value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column = :$column AND $condition1 BETWEEN '$value1' AND '$value2'");
            $get_user->bindValue("$column", $column_value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch between two dates and Condition grouped by 
        public function fetch_details_2dateConGr($table, $condition1, $value1, $value2, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE  $condition1 BETWEEN '$value1' AND '$value2' GROUP BY $group");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with current date
        public function fetch_details_curdate($table, $column){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE date($column) = CURDATE()");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with current date grouped by condition
        public function fetch_details_curdateGro($table, $column, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE date($column) = CURDATE() GROUP BY $group");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with current date and a condition grouped by condition
        public function fetch_details_curdateGro1con($table, $column, $condition, $value, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE date($column) = CURDATE() AND $condition = :$condition GROUP BY $group");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with current date and 2 condition grouped by condition
        public function fetch_details_curdateGro2con($table, $column, $condition, $value, $condition2, $value2, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE date($column) = CURDATE() AND $condition = :$condition AND $condition2 = :$condition2 GROUP BY $group");
            $get_user->bindValue("$condition", $value);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sums of certain column with current date grouped by condition
        public function fetch_details_curdateGroMany($table, $column4, $column1, $column2, $column3, $condition, $value, $group, $order){
            $get_user = $this->connectdb()->prepare("SELECT $column4, SUM($column1) AS column1, SUM($column2) AS column2 FROM $table WHERE date($column3) = CURDATE() AND $condition = :$condition GROUP BY $group ORDER BY $order DESC");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sums of certain column with current date by a condition grouped by another condition
        public function fetch_details_curdateGroMany1c($table, $column4, $column1, $column2, $column3, $condition, $value, $con2, $value2, $group, $order){
            $get_user = $this->connectdb()->prepare("SELECT $column4, SUM($column1) AS column1, SUM($column2) AS column2 FROM $table WHERE date($column3) = CURDATE() AND $condition = :$condition AND $con2 = :$con2 GROUP BY $group ORDER BY $order DESC");
            $get_user->bindValue("$condition", $value);
            $get_user->bindValue("$con2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        public function fetch_details_specdateGroMany1c($table, $column4, $column1, $column2, $column3, $date, $condition, $value, $con2, $value2, $group, $order){
            $get_user = $this->connectdb()->prepare("SELECT $column4, SUM($column1) AS column1, SUM($column2) AS column2 FROM $table WHERE date($column3) = '$date' AND $condition = :$condition AND $con2 = :$con2 GROUP BY $group ORDER BY $order DESC");
            $get_user->bindValue("$condition", $value);
            $get_user->bindValue("$con2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sums of certain column with 2 date by a condition grouped by another condition
        public function fetch_details_2dateGroMany1c($table, $column4, $column1, $column2, $column3, $condition, $value, $con2, $value2, $group, $order, $from, $to){
            $get_user = $this->connectdb()->prepare("SELECT $column4, SUM($column1) AS column1, SUM($column2) AS column2 FROM $table WHERE date($column3) BETWEEN '$from' AND '$to' AND $condition = :$condition AND $con2 = :$con2 GROUP BY $group ORDER BY $order DESC");
            $get_user->bindValue("$condition", $value);
            $get_user->bindValue("$con2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with current date and condition
        public function fetch_details_curdateCon($table, $column, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition =:$condition AND date($column) = CURDATE()");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with specific date and condition
        public function fetch_details_specdateCon($table, $column, $date, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition =:$condition AND date($column) = '$date'");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with specific date and 2 condition
        public function fetch_details_specdate2Con($table, $column, $date, $condition, $value, $con2, $val2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition =:$condition AND $con2 = :$con2 AND date($column) = '$date'");
            $get_user->bindValue("$condition", $value);
            $get_user->bindValue("$con2", $val2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with date greater or equal to current date and condition
        public function fetch_details_curdateGreCon($table, $column, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition =:$condition AND date($column) <= CURDATE()");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch with date greater or equal to current date and condition
        public function fetch_details_curdateLessCon($table, $column, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition =:$condition AND date($column) >= CURDATE()");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
         //fetch all item grouped by a column
         public function fetch_single_grouped($table, $group){
            $get_details = $this->connectdb()->prepare("SELECT * FROM $table GROUP BY $group");
            $get_details->execute();
            if($get_details->rowCount() > 0){
                $row = $get_details->fetchAll();
                return $row;
            }else{
                $row = "No record found";
                return $row;
            }
        }
        //fetch sales order pending payment for individual rep
        public function fetch_salesOrder($store,$user){
            $get_user = $this->connectdb()->prepare("SELECT SUM(total_amount) AS total, invoice, posted_by, order_by, post_date FROM sales WHERE sales_status = 1 AND store = :store AND order_by = :order_by/* AND date(post_date) = CURDATE() */ GROUP BY invoice ORDER BY post_date");
            $get_user->bindValue("store", $store);
            $get_user->bindValue("order_by", $user);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sales order pending payment for all rep
        public function fetch_generalOrder($store){
            $get_user = $this->connectdb()->prepare("SELECT SUM(total_amount) AS total, invoice, posted_by, order_by, post_date FROM sales WHERE sales_status = 1 AND store = :store GROUP BY invoice ORDER BY post_date");
            $get_user->bindValue("store", $store);
            // $get_user->bindValue("order_by", $user);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch pending orders for dispense
        public function fetch_Orders($store){
            $get_user = $this->connectdb()->prepare("SELECT * FROM sales WHERE add_order = 1 AND store = :store ORDER BY post_date");
            $get_user->bindValue("store", $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sales order from two selected date
        public function fetch_salesOrderDate($from, $to, $store){
            $get_user = $this->connectdb()->prepare("SELECT SUM(total_amount) AS total, invoice, posted_by, post_date FROM sales WHERE sales_status = 1 AND store = :store AND date(post_date) BETWEEN '$from' AND '$to' GROUP BY invoice ORDER BY post_date");
            $get_user->bindValue("store", $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        public function fetch_sales_receipt($invoice, $store){
            $get_user = $this->connectdb()->prepare("SELECT SUM(quantity) AS quantity, price, item, total_amount, post_date FROM sales WHERE invoice =:invoice AND store = :store GROUP BY invoice, item ORDER BY post_date");
            $get_user->bindValue("invoice", $invoice);
            $get_user->bindValue("store", $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        public function fetch_sales_report($store, $start){
            $get_user = $this->connectdb()->prepare("SELECT quantity, price, item, total_amount, post_date, order_by, posted_by, invoice FROM sales WHERE store = :store AND sales_status = 2 AND date(start_dates) = '$start' ORDER BY post_date");
            /* $get_user->bindValue("start_dates", $start);
            $get_user->bindValue("end_dates", $end); */
            $get_user->bindValue("store", $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch revenue by category with date
        public function fetch_revenue_cat($start){
            $get_user = $this->connectdb()->prepare("SELECT SUM(sales.total_amount) AS total, SUM(sales.cost) AS total_cost, sales.item, items.item_id, items.cost_price, sales.quantity, items.department FROM sales, items WHERE /* sales.store = :store AND  */items.item_id = sales.item AND sales.sales_status = 2 AND date(sales.start_dates) = '$start' GROUP BY items.department");
            // $get_user->bindValue("store", $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sales items in each revenue by category with current date
        public function fetch_revenue_cat_items($department, $start/* , $store */){
            $get_user = $this->connectdb()->prepare("SELECT sales.total_amount, sales.cost, sales.item, items.item_id, items.cost_price, items.item_name, sales.quantity, items.department, sales.invoice, sales.posted_by, sales.post_date FROM sales, items WHERE /* sales.store = :store AND */ items.department ='$department' AND items.item_id = sales.item AND sales.sales_status = 2 AND date(sales.start_dates) = '$start'");
            // $get_user->bindValue("store", $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sales items in each revenue by category with 2 dates
        public function fetch_revenue_cat_itemsdate($from, $to, $department/* , $store */){
            $get_user = $this->connectdb()->prepare("SELECT sales.total_amount, sales.cost, sales.item, items.item_id, items.cost_price, items.item_name, sales.quantity, items.department, sales.invoice, sales.posted_by, sales.post_date FROM sales, items WHERE /* sales.store = :store AND */ items.department ='$department' AND items.item_id = sales.item AND sales.sales_status = 2 AND date(sales.start_dates) BETWEEN '$from' AND '$to'");
            // $get_user->bindValue("store", $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch general revenue with date
        public function fetch_general_revenue($start){
            $get_user = $this->connectdb()->prepare("SELECT * FROM payments WHERE date(start_dates) = '$start' GROUP BY invoice");
            // $get_user->bindValue('store', $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch general revenue with date
        public function fetch_general_revenueDate($from, $to){
            $get_user = $this->connectdb()->prepare("SELECT * FROM payments WHERE date(start_dates) BETWEEN '$from' AND '$to' GROUP BY invoice");
            // $get_user->bindValue('store', $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch revenue with date
        public function fetch_revenue($start){
            $get_user = $this->connectdb()->prepare("SELECT SUM(sales.total_amount) AS total, SUM(sales.cost) AS total_cost, sales.item, items.item_id, items.cost_price, sales.quantity, items.department FROM sales, items WHERE /*sales. store = :store AND  */items.item_id = sales.item AND sales.sales_status = 2 AND date(sales.start_dates) = '$start'");
            // $get_user->bindValue('store', $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch revenue by category with 2 dates
        public function fetch_revenue_catDate($from, $to /* $store */){
            $get_user = $this->connectdb()->prepare("SELECT SUM(sales.total_amount) AS total, SUM(sales.cost) AS total_cost, sales.item, items.item_id, items.cost_price, sales.quantity, items.department FROM sales, items WHERE /* sales.store = :store AND  */items.item_id = sales.item AND sales.sales_status = 2 AND date(sales.start_dates) BETWEEN '$from' AND '$to' GROUP BY items.department");
            // $get_user->bindValue('store', $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch revenue with 2 dates
        public function fetch_revenueDate($from, $to){
            $get_user = $this->connectdb()->prepare("SELECT SUM(sales.total_amount) AS total, SUM(sales.cost) AS total_cost, sales.item, items.item_id, items.cost_price, sales.quantity, items.department FROM sales, items WHERE /* sales.store = :store AND  */items.item_id = sales.item AND sales.sales_status = 2 AND date(sales.start_dates) BETWEEN '$from' AND '$to'");
            // $get_user->bindValue('store', $store);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }//fetch sum with 2 condition
        public function fetch_sum_double($table, $column1, $condition, $value, $condition2, $value2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition = :$condition AND $condition2 = :$condition2");
            $get_user->bindValue("$condition", $value);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with current date
        public function fetch_sum_curdate($table, $column1, $column2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE date($column2) = CURDATE()");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with current date
        public function fetch_sum_curdateNeg($table, $column1, $column2, $neg, $value){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE date($column2) = CURDATE() AND $neg != :$neg");
            $get_user->bindValue("$neg", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum
        public function fetch_sum($table, $column1){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with single condition
        public function fetch_sum_single($table, $column1, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition = :$condition");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of 2 columns multiplied
        public function fetch_sum_2col($table, $column1, $column2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of 2 columns multiplied and one condition
        public function fetch_sum_2colCond($table, $column1, $column2, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table WHERE $condition = :$condition");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of column multiplied and current date
        public function fetch_sum_2colCurDate($table, $column1, $column2, $date){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table WHERE date($date) = CURDATE()");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of column multiplied and current date with condition
        public function fetch_sum_2colCurDate1Con($table, $column1, $column2, $date, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table WHERE date($date) = CURDATE()AND $condition = :$condition");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of 2 columns multiplied with 2 dates
        public function fetch_sum_2col2date($table, $column1, $column2, $date, $from, $to){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table WHERE date($date) BETWEEN '$from' AND '$to'");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of 2 columns multiplied with 2 dates and a condition
        public function fetch_sum_2col2date1con($table, $column1, $column2, $date, $from, $to, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table WHERE $condition = :$condition AND date($date) BETWEEN '$from' AND '$to'");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of 2 columns multiplied with 2 dates and 2 condition
        public function fetch_sum_2col2date2con($table, $column1, $column2, $date, $from, $to, $condition, $value, $con2, $value2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table WHERE $condition = :$condition AND $con2 = :$con2 AND date($date) BETWEEN '$from' AND '$to'");
            $get_user->bindValue("$condition", $value);
            $get_user->bindValue("$con2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with conditions
        public function fetch_sum_2con($table, $column1, $column2, $condition1, $condition2, $value1, $value2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table WHERE $condition1 = :$condition1 AND $condition2 = :$condition2");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with a condition
        public function fetch_sum_con($table, $column1, $column2, $condition1, $value1){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) AS total FROM $table WHERE $condition1 = :$condition1");
            $get_user->bindValue("$condition1", $value1);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with current date AND condition
        public function fetch_sum_curdateCon($table, $column1, $column2, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition =:$condition AND date($column2) = CURDATE()");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with specific date AND condition
        public function fetch_sum_dateCon($table, $column1, $column2, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition =:$condition AND date('start_dates') = $column2");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of current daily payments
        public function fetch_payments_startDay($start){
            $get_user = $this->connectdb()->prepare("SELECT SUM(amount_paid) AS total FROM payments WHERE date(start_dates) = '$start'");
            /* $get_user->bindValue("$con", $value);
            $get_user->bindValue("$column2", $start); */
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetch();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of curent  day revenue
        public function fetch_sum_startDayRev($table, $start, $column){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column) AS total FROM $table WHERE date(start_dates) = '$start'");
            /* $get_user->bindValue("$con", $value);
            $get_user->bindValue("$column2", $start); */
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of current daily sales
        public function fetch_sum_startDay($start, $column,){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column) AS total FROM sales WHERE sales_status = 2 AND date(start_dates) = '$start'");
            /* $get_user->bindValue("$con", $value);
            $get_user->bindValue("$column2", $start); */
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetch();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of current daily sales
        public function fetch_sum_startDayStore($start, $column, $store){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column) AS total FROM sales WHERE sales_status = 2 AND date(start_dates) = '$start' AND store = :store");
            $get_user->bindValue("store", $store);
            // $get_user->bindValue("$column2", $start);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetch();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of current daily sales
        public function fetch_sum_startDayCond($start, $column, $con, $val){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column) AS total FROM payments WHERE $con = :$con AND date(start_dates) = '$start'");
            $get_user->bindValue("$con", $val);
            /*$get_user->bindValue("$column2", $start); */
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetch();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        public function fetch_sum_CustomSales($table, $column, $start, $con, $val, $con2, $val2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column) AS total FROM $table WHERE $con = :$con AND $con2 = :$con2 AND date(start_dates) = :start_dates");
            $get_user->bindValue(":start_dates", $start);
            $get_user->bindValue("$con", $val);
            $get_user->bindValue("$con2", $val2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetch();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        public function fetch_sum_CustomSales2con($table, $column, $start, $con, $val){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column) AS total FROM $table WHERE $con = :$con AND date(start_dates) = :start_dates");
            $get_user->bindValue(":start_dates", $start);
            $get_user->bindValue("$con", $val);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetch();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum of cost of sales
        public function fetch_sum_CustomDateCon($table, $column, $start, $end, $con,$val){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column) AS total FROM $table WHERE $con =:$con AND date(post_date) BETWEEN :start_dates AND :end_dates");
            $get_user->bindValue(":$con", $val);
            $get_user->bindValue(":start_dates", $start);
            $get_user->bindValue(":end_dates", $end);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetch();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with current date AND 2 condition
        public function fetch_sum_curdate2Con($table, $column1, $column2, $condition1, $value1, $condition2, $value2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition1 =:$condition1 AND $condition2 =:$condition2 AND date($column2) = CURDATE()");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        public function fetch_sum_specdate2Con($table, $column1, $column2, $start, $condition1, $value1){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition1 =:$condition1 AND date($column2) = '$start'");
            $get_user->bindValue("$condition1", $value1);
            // $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        public function fetch_sum_specdate3Con($table, $column1, $column2, $start, $condition1, $value1, $con2 , $val2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition1 =:$condition1 AND $con2 = :$con2 AND date($column2) = '$start'");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$con2", $val2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with current date AND 2 condition
        public function fetch_sum_date4Con($table, $column1, $column2, $condition1, $value1, $condition2, $value2, $start){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition1 =:$condition1 AND $condition2 =:$condition2 AND date($column2) = '$start'");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            // $get_user->bindValue("$con3", $val3);
            // $get_user->bindValue("$con4", $val4);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with current date AND 2 condition
        public function fetch_sum_date3Con($table, $column1, $column2, $condition1, $value1, $start){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition1 =:$condition1 AND date($column2) = '$start'");
            $get_user->bindValue("$condition1", $value1);
            // $get_user->bindValue("$condition2", $value2);
            // $get_user->bindValue("$con3", $val3);
            // $get_user->bindValue("$con4", $val4);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with current date AND 3 condition
        public function fetch_sum_curdate3Con($table, $column1, $column2, $condition1, $value1, $condition2, $value2, $condition3, $value3){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total FROM $table WHERE $condition1 =:$condition1 AND $condition2 =:$condition2 AND $condition3 = :$condition3 AND date($column2) = CURDATE()");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            $get_user->bindValue("$condition3", $value3);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum with current date AND 2 condition grouped by
        public function fetch_sum_curdate2ConGro($table, $column1, $column2, $condition1, $value1, $group){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) AS total, posted_by, payment_mode FROM $table WHERE $condition1 =:$condition1 AND date($column2) = CURDATE() GROUP BY $group");
            $get_user->bindValue("$condition1", $value1);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum between date
        //fetch between two dates
        public function fetch_sum_2date($table, $column, $condition1, $value1, $value2){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column) as total FROM $table WHERE $condition1 BETWEEN '$value1' AND '$value2'");
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum between two dates and condition
        public function fetch_sum_2dateCond($table, $column1, $column2, $condition1, $value1, $value2, $value3){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) as total FROM $table WHERE $column2 = :$column2 AND $condition1 BETWEEN '$value1' AND '$value2'");
            $get_user->bindValue("$column2", $value3);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum between two dates and  2 condition
        public function fetch_sum_2date2Cond($table, $column1, $column2, $condition1, $condition2, $value1, $value2, $value3, $value4){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) as total FROM $table WHERE $condition1 = :$condition1 AND $condition2 = :$condition2 AND $column2 BETWEEN '$value1' AND '$value2'");
            $get_user->bindValue("$condition1", $value3);
            $get_user->bindValue("$condition2", $value4);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch sum between two dates and  3 condition
        public function fetch_sum_2date3Cond($table, $column1, $column2, $condition1, $condition2, $condition3,  $value1, $value2, $value3, $value4, $value5){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) as total FROM $table WHERE $condition1 = :$condition1 AND $condition2 = :$condition2 AND $condition3 = :$condition3 AND $column2 BETWEEN '$value1' AND '$value2'");
            $get_user->bindValue("$condition1", $value3);
            $get_user->bindValue("$condition2", $value4);
            $get_user->bindValue("$condition3", $value5);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch expired item with condition
        function fetch_expired($table, $column, $quantity, $condition, $value){
            $get_exp = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition AND date($column) <= CURDATE() AND $quantity >= 1");
            $get_exp->bindValue("$condition", $value);
            $get_exp->execute();

            if($get_exp->rowCount() > 0){
                return $get_exp->rowCount();
            }else{
                return "0";
            }
        }
        //fetch count with group
        function fetch_count_group($table, $condition, $value, $group){
            $get_exp = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition GROUP BY $group");
            $get_exp->bindValue("$condition", $value);
            $get_exp->execute();

            if($get_exp->rowCount() > 0){
                return $get_exp->rowCount();
            }else{
                return "0";
            }
        }
        //fetch expired item details
        function fetch_expired_det($table, $column, $quantity, $condition, $value){
            $get_exp = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition =:$condition AND date($column) <= CURDATE() AND $quantity >= 1");
            $get_exp->bindValue("$condition", $value);
            $get_exp->execute();

            if($get_exp->rowCount() > 0){
                $rows = $get_exp->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch soon to expire item
        function fetch_expire_soon($table, $column, $quantity, $condition, $value){
            $get_exp = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition AND $quantity >= 1 AND date($column) BETWEEN CURDATE() AND CURDATE() + INTERVAL 3 MONTH");
            $get_exp->bindValue("$condition", $value);
            $get_exp->execute();

            if($get_exp->rowCount() > 0){
                return $get_exp->rowCount();
            }else{
                return "0";
            }
        }
        //fetch soon to expire item details
        function fetch_expire_soon_det($table, $column, $quantity, $condition, $value){
            $get_exp = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition =:$condition AND $quantity >= 1 AND date($column) BETWEEN CURDATE() AND CURDATE() + INTERVAL 3 MONTH");
            $get_exp->bindValue("$condition", $value);
            $get_exp->execute();

            if($get_exp->rowCount() > 0){
                $rows = $get_exp->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch soon to expire item sum
        function fetch_expire_soonSum($table, $column, $column2, $column3, $condition, $value){
            $get_exp = $this->connectdb()->prepare("SELECT SUM($column2 * $column3) AS total FROM $table WHERE $condition = :$condition AND date($column) BETWEEN CURDATE() AND CURDATE() + INTERVAL 3 MONTH");
            $get_exp->bindValue("$condition", $value);
            $get_exp->execute();

            if($get_exp->rowCount() > 0){
                $rows = $get_exp->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch soon to expire item sum
        function fetch_expired_Sum($table, $column, $column2, $column3, $condition, $value){
            $get_exp = $this->connectdb()->prepare("SELECT SUM($column2 * $column3) AS total FROM $table WHERE $condition = :$condition AND date($column) <= CURDATE()");
            $get_exp->bindvalue("$condition", $value);
            $get_exp->execute();

            if($get_exp->rowCount() > 0){
                $rows = $get_exp->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch items lesser than a value
        function fetch_lesser($table, $column, $value){
            $get_item = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column <= $value");
            $get_item->execute();

            if($get_item->rowCount() > 0){
                return $get_item->rowCount();
            }else{
                return "0";
            }
        }
        //fetch items lesser than a value from 2 tables with condition
        function fetch_lesser_cond($table, $column, $value, $condition, $condition_value){
            $get_item = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition AND $column <= $value");
            $get_item->bindValue("$condition", $condition_value);
            $get_item->execute();

            if($get_item->rowCount() > 0){
                return $get_item->rowCount();
            }else{
                return "0";
            }
        }
        //fetch items lesser than a value details
        function fetch_lesser_detail($table, $column, $value){
            $get_item = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column <= $value");
            $get_item->execute();

            if($get_item->rowCount() > 0){
                $rows = $get_item->fetchAll();
                return $rows;
            }else{
                $rows = "No record found";
                return $rows;
            }
        }
        //fetch items lesser than a value with condition details
        function fetch_lesser_detailCond($table, $column, $value, $condition, $cond_value){
            $get_item = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition AND $column <= $value");
            $get_item->bindValue("$condition", $cond_value);
            $get_item->execute();

            if($get_item->rowCount() > 0){
                $rows = $get_item->fetchAll();
                return $rows;
            }else{
                $rows = "No record found";
                return $rows;
            }
        }
        //fetch items lesser than a value details
        function fetch_lesser_sum($table, $column, $value, $column1, $column2){
            $get_item = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) as total FROM $table WHERE $column <= $value");
            $get_item->execute();

            if($get_item->rowCount() > 0){
                $rows = $get_item->fetchAll();
                return $rows;
            }else{
                $rows = "No record found";
                return $rows;
            }
        }
        function fetch_lesser_sumCon($table, $column, $value, $condition, $con_value, $column1, $column2){
            $get_item = $this->connectdb()->prepare("SELECT SUM($column1 * $column2) as total FROM $table WHERE $condition = :$condition AND $column <= $value");
            $get_item->bindValue("$condition", $con_value);
            $get_item->execute();

            if($get_item->rowCount() > 0){
                $rows = $get_item->fetchAll();
                return $rows;
            }else{
                $rows = "No record found";
                return $rows;
            }
        }
        //fetch sum between two dates and condition grouped by
        public function fetch_sum_2dateCondGr($table, $column1, $column2, $condition1, $condition2, $value1, $value2, $value3, $value4){
            $get_user = $this->connectdb()->prepare("SELECT SUM($column1) as total FROM $table WHERE $column2 = :$column2 AND $condition2 = :$condition2 and $condition1 BETWEEN '$value1' AND '$value2'");
            $get_user->bindValue("$column2", $value3);
            $get_user->bindValue("$condition2", $value4);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch details with negative condition
        public function fetch_details_negCond1($table, $column1, $value1){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 != :$column1");
            $get_user->bindValue("$column1", $value1);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch details with negative condition and a positive
        public function fetch_details_negCond($table, $column1, $value1, $column2, $value2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $column1 != :$column1 AND $column2 = :$column2");
            $get_user->bindValue("$column1", $value1);
            $get_user->bindValue("$column2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch details with date condition
        public function fetch_details_dateCond($table, $condition1, $value1){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND date(check_out_date) = CURDATE()");
            $get_user->bindValue("$condition1", $value1);
            // $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch details with date and 2 conditions
        public function fetch_details_date2Cond($table, $column, $condition1, $value1, $condition2, $value2){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 = :$condition2 AND $column = CURDATE()");
            $get_user->bindValue("$condition1", $value1);
            $get_user->bindValue("$condition2", $value2);
            // $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch item history
        public function fetch_item_history($from, $to, $value3, $store){
            $get_history = $this->connectdb()->prepare("SELECT * FROM audit_trail WHERE item = :item AND store = :store AND date(post_date) BETWEEN '$from' AND '$to' ORDER BY DATE(post_date) ASC");
            $get_history->bindValue("item", $value3);
            $get_history->bindValue("store", $store);
            $get_history->execute();
            if($get_history->rowCount() > 0){
                $rows = $get_history->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch todays check in
        public function fetch_checkIn($table, $condition1, $condition2, $value1){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition1 = :$condition1 AND $condition2 = CURDATE()");
            $get_user->bindValue("$condition1", $value1);
            // $get_user->bindValue("$condition2", $value2);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $rows = $get_user->fetchAll();
                return $rows;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch single column details with single condition grouped
        public function fetch_details_group($table, $column, $condition, $value){
            $get_user = $this->connectdb()->prepare("SELECT $column FROM $table WHERE $condition = :$condition");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $row = $get_user->fetch();
                return $row;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch all details with 1 condition grouped
        public function fetch_details_Allgroup($table, $condition, $value, $group){
            $get_user = $this->connectdb()->prepare("SELECT * FROM $table WHERE $condition = :$condition GROUP BY $group");
            $get_user->bindValue("$condition", $value);
            $get_user->execute();
            if($get_user->rowCount() > 0){
                $row = $get_user->fetch();
                return $row;
            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        
        // fetch daily sales
        public function fetch_daily_sales($store){
            $get_daily = $this->connectdb()->prepare("SELECT COUNT(distinct invoice) AS customers, SUM(amount_paid) AS revenue, post_date FROM payments WHERE store = :store GROUP BY date(post_date) ORDER BY date(post_date) DESC");
            $get_daily->bindValue('store', $store);
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch daily sales with custom date
        public function fetch_daily_salesDate($store){
            $get_daily = $this->connectdb()->prepare("SELECT COUNT(distinct invoice) AS customers, SUM(total_amount) AS revenue, post_date, start_dates, end_dates FROM sales WHERE store = :store AND sales_status = 2 GROUP BY date(start_dates) ORDER BY date(start_dates) DESC LIMIT 30");
            $get_daily->bindValue('store', $store);
            /* $get_daily->bindValue('start_dates', $start);
            $get_daily->bindValue('end_dates', $end); */
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch cashier report with custome date
        public function fetch_cashier_report($store, $start, $end){
            $get_daily = $this->connectdb()->prepare("SELECT * FROM payments WHERE store = :store AND date(start_dates) = :start_dates GROUP BY posted_by ORDER BY posted_by");
            $get_daily->bindValue('store', $store);
            $get_daily->bindValue('start_dates', $start);
            // $get_daily->bindValue('end_dates', $end);
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch cashier report with custome date
        public function fetch_cashier_reportDate($store, $start, $end){
            $get_daily = $this->connectdb()->prepare("SELECT * FROM payments WHERE store = :store AND date(start_dates) BETWEEN '$start' AND '$end' GROUP BY posted_by ORDER BY posted_by");
            $get_daily->bindValue('store', $store);
            // $get_daily->bindValue('start_dates', $start);
            // $get_daily->bindValue('end_dates', $end);
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch cashier report with custome date
        public function fetch_cashier_sales($cashier, $store, $start){
            $get_daily = $this->connectdb()->prepare("SELECT * FROM sales WHERE store = :store AND sales_status = 2 AND posted_by = :posted_by AND date(start_dates) = '$start'  ORDER BY post_date");
            $get_daily->bindValue('store', $store);
            $get_daily->bindValue('posted_by', $cashier);
            /* $get_daily->bindValue('start_dates', $start);
            $get_daily->bindValue('end_dates', $end) */;
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch sales rep report with custom date
        public function fetch_rep_orders($rep, $store, $start){
            $get_daily = $this->connectdb()->prepare("SELECT * FROM sales WHERE store = :store AND sales_status != 0 AND order_by = :order_by AND date(start_dates) = '$start'  ORDER BY post_date");
            $get_daily->bindValue('store', $store);
            $get_daily->bindValue('order_by', $rep);
            /* $get_daily->bindValue('start_dates', $start);
            $get_daily->bindValue('end_dates', $end) */;
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch dispense for individual
        public function fetch_dispense($rep, $store, $start){
            $get_daily = $this->connectdb()->prepare("SELECT * FROM sales WHERE store = :store AND add_order = 0 AND dispensed_by = :dispensed_by AND date(start_dates) = '$start'  ORDER BY dispense_date");
            $get_daily->bindValue('store', $store);
            $get_daily->bindValue('dispensed_by', $rep);
            /* $get_daily->bindValue('start_dates', $start);
            $get_daily->bindValue('end_dates', $end) */;
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        // fetch daily credit sales
        public function fetch_daily_credit($store){
            $get_daily = $this->connectdb()->prepare("SELECT COUNT(distinct invoice) AS customers, SUM(amount_paid) AS revenue, post_date FROM payments WHERE store = :store GROUP BY date(post_date) ORDER BY date(post_date) DESC");
            $get_daily->bindValue('store', $store);
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
       //fetch monthly sales
       public function fetch_monthly_sales($store){
        $get_monthly = $this->connectdb()->prepare("SELECT COUNT(distinct invoice) AS customers, SUM(amount_paid) AS revenue, post_date, COUNT(post_date) AS arrivals, COUNT(DISTINCT date(post_date)) AS daily_average FROM payments WHERE store = :store GROUP BY MONTH(post_date) ORDER BY MONTH(post_date)");
        $get_monthly->bindValue('store', $store);
        $get_monthly->execute();
        if($get_monthly->rowCount() > 0){
            $rows = $get_monthly->fetchAll();
            return $rows;

        }else{
            $rows = "No records found";
            return $rows;
        }
    }
       //fetch monthly sales
       public function fetch_monthly_salesDate($store){
        $get_monthly = $this->connectdb()->prepare("SELECT COUNT(distinct invoice) AS customers, SUM(total_amount) AS revenue, post_date, start_dates, COUNT(start_dates) AS arrivals, COUNT(DISTINCT date(start_dates)) AS daily_average FROM sales WHERE store = :store AND sales_status = 2 GROUP BY MONTH(start_dates), YEAR(start_dates) ORDER BY YEAR(start_dates), MONTH(start_dates)");
        $get_monthly->bindValue('store', $store);
        $get_monthly->execute();
        if($get_monthly->rowCount() > 0){
            $rows = $get_monthly->fetchAll();
            return $rows;

        }else{
            $rows = "No records found";
            return $rows;
        }
    }
        // fetch daily checkins
        public function fetch_daily_checkins(){
            $get_daily = $this->connectdb()->prepare("SELECT COUNT(distinct check_ins.checkin_id) AS customers, SUM(payments.amount_paid) AS revenue, check_ins.check_in_date FROM check_ins, payments WHERE date(payments.post_date) = date(check_ins.check_in_date) AND check_ins.checkin_id = payments.customer GROUP BY check_ins.check_in_date ORDER BY check_ins.check_in_date DESC");
            $get_daily->execute();
            if($get_daily->rowCount() > 0){
                $rows = $get_daily->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
        //fetch monthly check ins
        public function fetch_monthly_checkins(){
            $get_monthly = $this->connectdb()->prepare("SELECT COUNT(checkin_id) AS customers, check_in_date, COUNT(check_in_date) AS arrivals, COUNT(DISTINCT check_in_date) AS daily_average FROM check_ins WHERE guest_status != 0 GROUP BY MONTH(check_in_date) ORDER BY MONTH(check_in_date)");
            $get_monthly->execute();
            if($get_monthly->rowCount() > 0){
                $rows = $get_monthly->fetchAll();
                return $rows;

            }else{
                $rows = "No records found";
                return $rows;
            }
        }
    //update value with condion
        
    }    
    //controller for user details
    /* class user_detailsController extends user_details{
        private $table;
        private $condition;

        public function __construct($table, $condition){
            $this->table = $table;
            $this->condition = $condition;
        }

        public function get_user(){
            return $this->fetch_details($this->table);
        }
        public function get_user_cond(){
            return $this->fetch_details_cond($this->table, $this->condition);

        }
    } */

