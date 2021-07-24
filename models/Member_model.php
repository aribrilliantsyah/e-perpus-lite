<?php 
require_once('../models/BaseModel.php');
/**
 * @Model
 */

class Member_model extends BaseModel{
    public $table = 'members';
    public $table_join = 'users';
    public $primary_key = 'id';

    public function all(){
        $query = $this->_query("SELECT * FROM $this->table ");
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
        return $this->db->lastInsertId();
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

    public function generateCodeMember(){
        $query = $this->_row_query("SELECT AUTO_INCREMENT FROM $this->table WHERE 1 = ? ", [1]);
        $num =isset($query) ? $query['id'] : 0;
        // pnow($query);
        return 'MB-'.sprintf("%04d",$num+1);
    }

    public function findDetil($id){
        $query = $this->_row_query("SELECT a.*, b.fullname as created_name,c.fullname as updated_name FROM $this->table a 
        LEFT JOIN $this->table_join b ON b.id = a.created_by
        LEFT JOIN $this->table_join c ON c.id = a.updated_by
        WHERE a.id = ? ", [
            $id
        ]);
        return $query ? $query : [];
    }
}

?>