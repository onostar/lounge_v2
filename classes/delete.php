<?php
    class deletes extends Dbh{
        public function delete_item($table, $condition, $id){
            $delete = $this->connectdb()->prepare("DELETE FROM $table WHERE $condition =:$condition");
            $delete->bindValue("$condition", $id);
            $delete->execute();
        }
    }

?>