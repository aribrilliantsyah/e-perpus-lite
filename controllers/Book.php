<?php 
require('../controllers/BaseController.php');
require('../models/Book_model.php');
require('../models/Author_model.php');
/**
 * @Controller
 */

class Book extends BaseController{
    
    public static $auth;
    
    function __construct(){
        // Middlewares
        $this->is_login();
        // Sessions
        self::$auth = $this->auth();
        // Models
        $this->book = new Book_model();
        $this->author = new Author_model();
    }

    public function index(){
        $data['title'] = 'Book';
        $data['result'] = $this->book->all();
        // pnow($data);
        $this->render_to_admin('pages/book_list.php', $data);
    }
    
    public function create(){
        $data['title'] = 'Book';
        $data['subtitle'] = 'Add Book';
        $data['list_author'] = $this->author->all();
        $data['code_book'] = $this->book->generateCodeBook();
        $data['action'] = base_url('controllers/Book.php?type=create_action');
        $this->render_to_admin('pages/book_create.php', $data);
    }

    public function create_action(){
        if(count($_POST) > 0){
            $newFileName = 'default.png';

            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['cover']['tmp_name'];
                $fileName = $_FILES['cover']['name'];
                $fileSize = $_FILES['cover']['size'];
                $fileType = $_FILES['cover']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                // pnow($fileExtension);
                $newFileName = md5(time().$fileName).'.'.$fileExtension;

                $allowedfileExtensions = array('jpg', 'gif', 'png', 'webp', 'jpeg', 'bmp');
                if(in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = '../uploads/';
                    $dest_path = $uploadFileDir . $newFileName;
                    if(!move_uploaded_file($fileTmpPath, $dest_path)) {
                        $_SESSION['validasi'] = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                        header('location: ../controllers/Book.php?type=create');die;
                    } 
                }else{
                    $_SESSION['validasi'] = 'File yang diperbolehkan '.implode(', ', $allowedfileExtensions);
                    header('location: ../controllers/Book.php?type=create');die;
                }
            }
            $code = $this->book->generateCodeBook();
            $data = [
                "code" => $code,
                "name" => $_POST['name'],
                "summary" => $_POST['summary'],
                "cover" => $newFileName,                      
                "author_id" => $_POST['author_id'],                
                "stock" => $_POST['stock'],                
                "created_at" => $this->timestamp(),                
                "updated_at" => $this->timestamp(),                
                "created_by" => self::$auth['id'],                
                "updated_by" => self::$auth['id'],                
            ];
            // pnow($data);
            $inserted = $this->book->create($data);
            // pnow($inserted);

            if($inserted){
                $_SESSION['success'] = "New Data Saved";
                header('location: ../controllers/Book.php');
            }else{
                $_SESSION['error'] = "Error while saving data";
                header('location: ../controllers/Book.php');            
            }

        }

        header('location: ../controllers/Book.php');
    }

    public function update(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->book->find($id);
            if($detail){
                $data['detail'] = $detail;
                $data['title'] = 'Book';
                $data['subtitle'] = 'Edit Book';
                $data['list_author'] = $this->author->all();
                $data['action'] = base_url('controllers/Book.php?type=update_action');
                $this->render_to_admin('pages/book_update.php', $data);
                return;
            }
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/Book.php');     
    }

    public function update_action(){
        if(count($_POST) > 0){
            $newFileName = 'default.png';

            if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['cover']['tmp_name'];
                $fileName = $_FILES['cover']['name'];
                $fileSize = $_FILES['cover']['size'];
                $fileType = $_FILES['cover']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                // pnow($fileExtension);
                $newFileName = md5(time().$fileName).'.'.$fileExtension;
                
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'webp', 'jpeg', 'bmp');
                if(in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = '../uploads/';
                    $dest_path = $uploadFileDir . $newFileName;
                    if(!move_uploaded_file($fileTmpPath, $dest_path)) {
                        @unlink('../uploads/'.$_POST['current_cover']);
                        $_SESSION['validasi'] = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                        header('location: ../controllers/Book.php?type=create');die;
                    } 
                }else{
                    $_SESSION['validasi'] = 'File yang diperbolehkan '.implode(', ', $allowedfileExtensions);
                    header('location: ../controllers/Book.php?type=create');die;
                }
            }
            
            
            $data = [
                "name" => $_POST['name'],
                "summary" => $_POST['summary'],
                "stock" => $_POST['stock'],
                "cover" => $newFileName,                             
                "author_id" => $_POST['author_id'],                       
                "updated_at" => $this->timestamp(),                 
                "updated_by" => self::$auth['id'],                
            ];

            // pnow($data);
            $updated = $this->book->update($data, $_POST['id']);

            if($updated){
                $_SESSION['success'] = "Data Updated";
                header('location: ../controllers/Book.php');
            }else{
                $_SESSION['error'] = "Error while saving data";
                header('location: ../controllers/Book.php');            
            }

        }

        header('location: ../controllers/Book.php');
    }

    public function detail(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->book->findDetil($id);
            if($detail){
                $data['detail'] = $detail;
                $data['title'] = 'Book';
                $data['subtitle'] = 'Detail Book';
                $this->render_to_admin('pages/book_detail.php', $data);
                return;
            }
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/Book.php');     
    }

    public function delete_action(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->book->find($id);
            @unlink('../uploads/'.$detail['cover']);
            $deleted = $this->book->delete($id);

            $_SESSION['success'] = "Data Deleted";
            header('location: ../controllers/Book.php');
            return;
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/Book.php');   
    }

}

/**
 * Silakan ganti Book sesuai dengan nama class diatas
 */
$type = isset($_GET['type']) ? $_GET['type'] : 'index';
$obj = new Book();
$obj->$type();

?>