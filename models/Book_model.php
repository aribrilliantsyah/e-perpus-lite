<?php 
require_once('../models/BaseModel.php');
/**
 * @Model
 */

class Book_model extends BaseModel{
    public $table = 'books';
    public $table_join = 'authors';
    public $table_join2 = 'users';
    public $primary_key = 'id';

    public function all(){
        $query = $this->_query("SELECT a.*, b.author_name FROM $this->table a LEFT JOIN $this->table_join b ON b.id = a.author_id");
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

    public function generateCodeBook(){
        $query = $this->_row_query("SELECT AUTO_INCREMENT FROM $this->table WHERE 1 = ? ", [1]);
        $num =isset($query) ? $query['id'] : 0;
        // pnow($query);
        return 'BK-'.sprintf("%04d",$num+1);
    }

    public function findDetil($id){
        $query = $this->_row_query("SELECT a.*, b.author_name,c.fullname as created_name,d.fullname as updated_name FROM $this->table a LEFT JOIN $this->table_join b ON b.id = a.author_id  
        LEFT JOIN $this->table_join2 c ON c.id = a.created_by
        LEFT JOIN $this->table_join2 d ON c.id = a.updated_by
        WHERE a.id = ? ", [
            $id
        ]);
        return $query ? $query : [];
    }
}

?>