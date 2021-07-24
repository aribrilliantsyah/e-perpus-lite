<?php 
require_once('../models/BaseModel.php');
/**
 * @Model
 */

class User_model extends BaseModel{
    public $table = 'users';
    public $table_join = 'roles';
    public $primary_key = 'id';

    public function all(){
        $query = $this->_query("SELECT a.*, b.role FROM $this->table a LEFT JOIN $this->table_join b ON b.id = a.role_id");
        return $query ? $query : [];
    }
    
    public function all_except($id){
        $query = $this->_query("SELECT a.*, b.role FROM $this->table a LEFT JOIN $this->table_join b ON b.id = a.role_id WHERE a.id <> $id");
        return $query ? $query : [];
    }

    public function find($id){
        $query = $this->_row_query("SELECT * FROM $this->table WHERE $this->primary_key = ? ", [
            $id
        ]);
        return $query ? $query : [];
    }

    public function create($data){
        $query = $this->_create("INSERT INTO $this->table (".implode(', ', array_keys($data)).") VALUES (:".implode(', :', array_keys($data)).")", $data);
        return $query;
    }
    
    public function update($data, $id){
        $set = '';
        $numItems = count($data);
        $i = 0;
        foreach($data as $key => $item){
            if(++$i === $numItems) {
                $set .= $key.' = '.':'.$key.' ';
            }else{
                $set .= $key.' = '.':'.$key.', ';
            }
        }

        $data['id'] = $id;
        // pnow("UPDATE $this->table SET  $set WHERE $this->primary_key = :id");

        $query = $this->_update("UPDATE $this->table SET  $set WHERE $this->primary_key = :id", $data);
        return $query;
    }
    
    public function delete($id){
        $query = $this->_delete("DELETE FROM $this->table WHERE id = ?", [
            $id
        ]);
        return $query;
    }

    public function findByUsername($username){
        $query = $this->_row_query("SELECT * FROM $this->table WHERE username = ? ", [
            $username
        ]);
        return $query ? $query : [];
    }

    public function count_all(){
        $query = $this->_query("SELECT count(a.id) as count FROM $this->table a");
        return isset($query[0]['count']) ? $query[0]['count'] : 0;
    }
}

?>