<?php 
require_once('../models/BaseModel.php');
/**
 * @Model
 */

class Book_model extends BaseModel{
    public $table = 'books';
    public $primary_key = 'id';
    public $join1 = 'authors';
    public $join2 = 'users';
  
    public function all(){
        $query = $this->_query("SELECT a.*, b.author_name FROM $this->table a LEFT JOIN $this->join1 b ON b.id = a.author_id");
        return $query ? $query : [];
    }
    
    public function all_except($id){
        $query = $this->_query("SELECT a.* FROM $this->table a WHERE a.id <> $id");
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
        // pnow($query);
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

    public function like($keyword){
        $query = $this->_query("SELECT a.* FROM $this->table a WHERE a.name LIKE '%$keyword%'");
        return $query ? $query : [];
    }

    public function stock($id){
        $query = $this->_row_query("SELECT a.stock FROM $this->table a WHERE a.id = ?", [
            $id
        ]);
        return isset($query['stock']) ? $query['stock'] : 0;
    }

    public function decrease($id){
        $stock = $this->stock($id);
        $stock--;
        
        $this->update([
            'stock' => $stock,
            'updated_at' => date('Y-m-d H:i:s'),
        ], $id);
    }

    public function increase($id){
        $stock = $this->stock($id);
        $stock++;
        
        $this->update([
            'stock' => $stock,
            'updated_at' => date('Y-m-d H:i:s'),
        ], $id);
    }

    public function generateCodeBook(){
        $query = $this->_query(" SHOW TABLE STATUS LIKE 'books'");
        $num =isset($query) ? $query[0]['Auto_increment'] : 0;
        // pnow($query);
        return 'BK-'.sprintf("%04d",$num+1);
    }

    public function findDetil($id){
        $query = $this->_row_query("SELECT a.*, b.author_name,c.fullname as created_name,d.fullname as updated_name FROM $this->table a LEFT JOIN $this->join1 b ON b.id = a.author_id  
        LEFT JOIN $this->join2 c ON c.id = a.created_by
        LEFT JOIN $this->join2 d ON c.id = a.updated_by
        WHERE a.id = ? ", [
            $id
        ]);
        return $query ? $query : [];
    }
}

?>