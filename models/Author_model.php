<?php 

require_once('../models/BaseModel.php');
/**
 * @Model
 */

class Author_model extends BaseModel{
    public $table = 'authors';
    public $primary_key = 'id';

    public function all(){
        $query = $this->_query("SELECT * FROM $this->table ");
        return $query ? $query : [];
    }
    public function create($data){
        $query = $this->_create("INSERT INTO $this->table (".implode(', ', array_keys($data)).") VALUES (:".implode(', :', array_keys($data)).")", $data);
        return $query;
    }
    public function find($id){
        $query = $this->_row_query("SELECT * FROM $this->table WHERE $this->primary_key = ? ", [
            $id
        ]);
        return $query ? $query : [];
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
        $query = $this->_update("UPDATE $this->table SET  $set WHERE $this->primary_key = :id", $data);
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