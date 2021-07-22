<?php 
require_once('../models/BaseModel.php');
/**
 * @Model
 */

class Role_model extends BaseModel{
    public $table = 'roles';
    public $primary_key = 'id';

    public function all(){
        $query = $this->_query("SELECT a.* FROM $this->table a");
        return $query ? $query : [];
    }
    
    public function all_except($id){
        $query = $this->_query("SELECT a.* FROM $this->table a WHERE a.id <> $id");
        return $query ? $query : [];
    }

    public function find($id){
        $query = $this->_row_query("SELECT * FROM $this->table WHERE $primary_key = ? ", [
            $id
        ]);
        return $query ? $query : [];
    }

    public function create($data){
        $query = $this->_create("INSERT INTO $this->table (id, role, created_at, updated_at, created_by, updated_by) VALUES (NULL, ?, ?, ?, ?, ?)", $data);
        return $query;
    }
    
    public function update($data, $id){
        $data[] = $id;
        $query = $this->_update("UPDATE $this->table SET role = ?, updated_at = ?, updated_by = ? WHERE id = ?", $data);
        return $query;
    }
    
    public function delete($id){
        $query = $this->_delete("DELETE FROM $this->table WHERE id = ?", [
            $id
        ]);
        return $query;
    }
}

?>