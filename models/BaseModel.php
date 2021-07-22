<?php

class BaseModel {
    public function __construct() {
        include('../config/database.php');

        $host     = $db_conf['host'];
        $dbname   = $db_conf['db_name'];
        $username = $db_conf['username'];
        $password = $db_conf['password'];
        $this->db = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
    }

    public function _query($query) {
        try{
            // pnow($query);
            $query = $this->db->prepare("$query");
            $query->execute();
            $data = $query->fetchAll();
            return $data;
        }catch (PDOException $e){
            echo $e->getMessage();die;
        }
    }
 
    public function _row_query($query, $where){
        try{
            $query = $this->db->prepare($query);
            $query->execute($where);
            return $query->fetch();
        }catch (PDOException $e){
            echo $e->getMessage();die;
        }
    }

    public function _create($query, $data) {
        try{
            $query = $this->db->prepare($query);
            $query->execute($data);
            return $query->rowCount();
        }catch (PDOException $e){
            echo $e->getMessage();die;
        }
    }
 
    public function _update($query, $data) {
        try{
            $query = $this->db->prepare($query);
            $query->execute($data);
            return $query->rowCount();
        }catch (PDOException $e){
            echo $e->getMessage();die;
        }
    }
 
    public function _delete($query, $data) {
        try{
            $query = $this->db->prepare($query);
            $query->execute($data);
            return $query->rowCount();
        }catch (PDOException $e){
            echo $e->getMessage();die;
        }
    }
 
}