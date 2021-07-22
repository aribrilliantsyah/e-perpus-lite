<?php 
require('../controllers/BaseController.php');
require('../models/User_model.php');
require('../models/Role_model.php');
/**
 * @Controller
 */

class User extends BaseController{
    
    public static $auth;
    
    function __construct(){
        // Middlewares
        $this->is_login();
        // Sessions
        self::$auth = $this->auth();
        // Models
        $this->user = new User_model();
        $this->role = new Role_model();
    }

    public function index(){
        $data['title'] = 'User';
        $data['result'] = $this->user->all_except(self::$auth['id']);
        // pnow($data);
        $this->render_to_admin('pages/user_list.php', $data);
    }
    
    public function create(){
        $data['title'] = 'User';
        $data['subtitle'] = 'Add User';
        $data['list_role'] = $this->role->all();
        $data['action'] = base_url('controllers/User.php?type=create_action');
        $this->render_to_admin('pages/user_create.php', $data);
    }

    public function create_action(){
        if(count($_POST) > 0){
            $newFileName = 'default.png';

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['avatar']['tmp_name'];
                $fileName = $_FILES['avatar']['name'];
                $fileSize = $_FILES['avatar']['size'];
                $fileType = $_FILES['avatar']['type'];
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
                        header('location: ../controllers/User.php?type=create');
                    } 
                }else{
                    $_SESSION['validasi'] = 'File yang diperbolehkan '.implode(', ', $allowedfileExtensions);
                    header('location: ../controllers/User.php?type=create');
                }
            }
            
            if(trim($_POST['password']) != trim($_POST['repeat_password'])){
                $_SESSION['validasi'] = "Passwords doesn't match";
                header('location: ../controllers/User.php?type=create');
            }

            $options = [
                'cost' => 10,
            ];
             
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
            $data = [
                "username" => $_POST['username'],
                "email" => $_POST['email'],
                "fullname" => $_POST['fullname'],
                "avatar" => $newFileName,                
                "password" => $password,                
                "role_id" => $_POST['role_id'],                
                "created_at" => $this->timestamp(),                
                "updated_at" => $this->timestamp(),                
                "created_by" => self::$auth['id'],                
                "updated_by" => self::$auth['id'],                
            ];
            // pnow($data);
            $inserted = $this->user->create($data);

            if($inserted){
                $_SESSION['success'] = "New Data Saved";
                header('location: ../controllers/User.php');
            }else{
                $_SESSION['error'] = "Error while saving data";
                header('location: ../controllers/User.php');            
            }

        }

        header('location: ../controllers/User.php');
    }

    public function update(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->user->find($id);
            if($detail){
                $data['detail'] = $detail;
                $data['title'] = 'User';
                $data['subtitle'] = 'Edit User';
                $data['list_role'] = $this->role->all();
                $data['action'] = base_url('controllers/User.php?type=update_action');
                $this->render_to_admin('pages/user_update.php', $data);
                return;
            }
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/User.php');     
    }

    public function update_action(){
        if(count($_POST) > 0){
            $newFileName = 'default.png';

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['avatar']['tmp_name'];
                $fileName = $_FILES['avatar']['name'];
                $fileSize = $_FILES['avatar']['size'];
                $fileType = $_FILES['avatar']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                // pnow($fileExtension);
                $newFileName = md5(time().$fileName).'.'.$fileExtension;
                
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'webp', 'jpeg', 'bmp');
                if(in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = '../uploads/';
                    $dest_path = $uploadFileDir . $newFileName;
                    if(!move_uploaded_file($fileTmpPath, $dest_path)) {
                        @unlink('../uploads/'.$_POST['current_avatar']);
                        $_SESSION['validasi'] = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                        header('location: ../controllers/User.php?type=create');
                    } 
                }else{
                    $_SESSION['validasi'] = 'File yang diperbolehkan '.implode(', ', $allowedfileExtensions);
                    header('location: ../controllers/User.php?type=create');
                }
            }
            
            
            $data = [
                "username" => $_POST['username'],
                "email" => $_POST['email'],
                "fullname" => $_POST['fullname'],
                "avatar" => $newFileName,                             
                "role_id" => $_POST['role_id'],                       
                "updated_at" => $this->timestamp(),                 
                "updated_by" => self::$auth['id'],                
            ];
            
            if(trim($_POST['password']) != '' && trim($_POST['repeat_password']) != ''){
                if(trim($_POST['password']) != trim($_POST['repeat_password'])){
                    $_SESSION['validasi'] = "Passwords doesn't match";
                    header('location: ../controllers/User.php?type=create');
                }
                
                $options = [
                    'cost' => 10,
                ];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
                $data['password'] = $password;
            }

            // pnow($data);
            $updated = $this->user->update($data, $_POST['id']);

            if($updated){
                $_SESSION['success'] = "Data Updated";
                header('location: ../controllers/User.php');
            }else{
                $_SESSION['error'] = "Error while saving data";
                header('location: ../controllers/User.php');            
            }

        }

        header('location: ../controllers/User.php');
    }

    public function delete_action(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->user->find($id);
            @unlink('../uploads/'.$detail['avatar']);
            $deleted = $this->user->delete($id);

            $_SESSION['success'] = "Data Deleted";
            header('location: ../controllers/User.php');
            return;
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/User.php');   
    }

}

/**
 * Silakan ganti User sesuai dengan nama class diatas
 */
$type = isset($_GET['type']) ? $_GET['type'] : 'index';
$obj = new User();
$obj->$type();

?>