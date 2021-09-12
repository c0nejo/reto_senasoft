<?php

    include_once '../lib/conf/connection.php';

    class MasterModel extends Connection{

        public function query($sql){
            $result = mysqli_query($this->getConnect(),$sql);
            return $result;
        }
        
        public function autoIncrement($table,$field){
            $sql="SELECT MAX($field) FROM $table";
            $result=$this->query($sql);
            $account=mysqli_fetch_row($result);

            return end($account)+1;
        }
    }
