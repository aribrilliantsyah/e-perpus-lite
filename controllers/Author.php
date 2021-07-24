<?php 
require('../controllers/BaseController.php');
require('../models/Author_model.php');

/**
 * @Controller
 */

class Author extends BaseController{
    
    public static $auth;
    
    function __construct(){
        // Middlewares
        $this->is_login();
        // Sessions
        self::$auth = $this->auth();
        // Models
        $this->author = new Author_model();
    }

    public function index(){
        $data['title'] = 'Author';
        $data['result'] = $this->author->all(self::$auth['id']);
        
        $this->render_to_admin('pages/author_list.php', $data);
    }
    
    public function create(){
        $data['title'] = 'Author';
        $data['subtitle'] = 'Add Author';
        $data['action'] = base_url('controllers/Author.php?type=create_action');
        $this->render_to_admin('pages/author_create.php', $data);
    }

    public function create_action(){
        $data = [
            "author_name" => $_POST['authorname'],       
            "created_at" => $this->timestamp(),                
            "updated_at" => $this->timestamp(),                
            "created_by" => self::$auth['id'],                
            "updated_by" => self::$auth['id'],                
        ];
        
        $inserted = $this->author->create($data);

        if($inserted){
            $_SESSION['success'] = "New Data Saved";
            header('location: ../controllers/Author.php');
        }else{
            $_SESSION['error'] = "Error while saving data";
            header('location: ../controllers/Author.php');            
        }

        header('location: ../controllers/Author.php');
    }

    public function update(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->author->find($id);
            if($detail){
                $data['detail'] = $detail;
                $data['title'] = 'Author';
                $data['subtitle'] = 'Edit Author';
                $data['action'] = base_url('controllers/Author.php?type=update_action');
                $this->render_to_admin('pages/author_update.php', $data);
                return;
            }
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/Author.php');     
    }

    public function update_action(){
        if(count($_POST) > 0){
            
            $data = [
                "author_name" => $_POST['authorname'],                      
                "updated_at" => $this->timestamp(),                 
                "updated_by" => self::$auth['id'],                
            ];
            $updated = $this->author->update($data, $_POST['id']);

            if($updated){
                $_SESSION['success'] = "Data Updated";
                header('location: ../controllers/Author.php');
            }else{
                $_SESSION['error'] = "Error while saving data";
                header('location: ../controllers/Author.php');            
            }

        }

        header('location: ../controllers/Author.php');
    }

    public function delete_action(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->author->find($id);
            @unlink('../uploads/'.$detail['avatar']);
            $deleted = $this->author->delete($id);

            $_SESSION['success'] = "Data Deleted";
            header('location: ../controllers/Author.php');
            return;
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/Author.php');   
    }

}

/**
 * Silakan ganti Author sesuai dengan nama class diatas
 */
$type = isset($_GET['type']) ? $_GET['type'] : 'index';
$obj = new Author();
$obj->$type();

?>