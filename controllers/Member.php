<?php 
require('../controllers/BaseController.php');
require('../models/Member_model.php');
require('../models/Author_model.php');
/**
 * @Controller
 */

class Member extends BaseController{
    
    public static $auth;
    
    function __construct(){
        // Middlewares
        $this->is_login();
        // Sessions
        self::$auth = $this->auth();
        // Models
        $this->member = new Member_model();
    }

    public function index(){
        $data['title'] = 'Member';
        $data['result'] = $this->member->all();
        // pnow($data);
        $this->render_to_admin('pages/member_list.php', $data);
    }
    
    public function create(){
        $data['title'] = 'Member';
        $data['subtitle'] = 'Add Member';
        $data['list_gender'] = array("Male","Female");
        $data['code_member'] = $this->member->generateCodeMember();
        $data['action'] = base_url('controllers/Member.php?type=create_action');
        $this->render_to_admin('pages/member_create.php', $data);
    }

    public function create_action(){
        if(count($_POST) > 0){
            $newFileName = 'default.png';

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileName = $_FILES['photo']['name'];
                $fileSize = $_FILES['photo']['size'];
                $fileType = $_FILES['photo']['type'];
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
                        header('location: ../controllers/Member.php?type=create');
                    } 
                }else{
                    $_SESSION['validasi'] = 'File yang diperbolehkan '.implode(', ', $allowedfileExtensions);
                    header('location: ../controllers/Member.php?type=create');
                }
            }
            $code = $this->member->generateCodeMember();
            $data = [
                "code" => $code,
                "full_name" => $_POST['name'],
                "address" => $_POST['address'],
                "gender" => $_POST['gender'],
                "photo" => $newFileName,                      
                "profession" => $_POST['profession'],                
                "created_at" => $this->timestamp(),                
                "updated_at" => $this->timestamp(),                
                "created_by" => self::$auth['id'],                
                "updated_by" => self::$auth['id'],                
            ];
            // pnow($data);
            $inserted = $this->member->create($data);
            // pnow($inserted);

            if($inserted){
                $_SESSION['success'] = "New Data Saved";
                header('location: ../controllers/Member.php');
            }else{
                $_SESSION['error'] = "Error while saving data";
                header('location: ../controllers/Member.php');            
            }

        }

        header('location: ../controllers/Member.php');
    }

    public function update(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->member->find($id);
            if($detail){
                $data['detail'] = $detail;
                $data['title'] = 'Member';
                $data['subtitle'] = 'Edit Member';
                $data['list_gender'] = array("Male","Female");
                $data['action'] = base_url('controllers/Member.php?type=update_action');
                $this->render_to_admin('pages/member_update.php', $data);
                return;
            }
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/Member.php');     
    }

    public function update_action(){
        if(count($_POST) > 0){
            $newFileName = 'default.png';

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileName = $_FILES['photo']['name'];
                $fileSize = $_FILES['photo']['size'];
                $fileType = $_FILES['photo']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                // pnow($fileExtension);
                $newFileName = md5(time().$fileName).'.'.$fileExtension;
                
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'webp', 'jpeg', 'bmp');
                if(in_array($fileExtension, $allowedfileExtensions)) {
                    $uploadFileDir = '../uploads/';
                    $dest_path = $uploadFileDir . $newFileName;
                    if(!move_uploaded_file($fileTmpPath, $dest_path)) {
                        @unlink('../uploads/'.$_POST['current_photo']);
                        $_SESSION['validasi'] = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                        header('location: ../controllers/Member.php?type=create');
                    } 
                }else{
                    $_SESSION['validasi'] = 'File yang diperbolehkan '.implode(', ', $allowedfileExtensions);
                    header('location: ../controllers/Member.php?type=create');
                }
            }
            
            
            $data = [
                "full_name" => $_POST['name'],
                "address" => $_POST['address'],
                "gender" => $_POST['gender'],
                "photo" => $newFileName,                             
                "profession" => $_POST['profession'],                       
                "updated_at" => $this->timestamp(),                 
                "updated_by" => self::$auth['id'],                
            ];

            // pnow($data);
            $updated = $this->member->update($data, $_POST['id']);

            if($updated){
                $_SESSION['success'] = "Data Updated";
                header('location: ../controllers/Member.php');
            }else{
                $_SESSION['error'] = "Error while saving data";
                header('location: ../controllers/Member.php');            
            }

        }

        header('location: ../controllers/Member.php');
    }

    public function detail(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->member->findDetil($id);
            if($detail){
                $data['detail'] = $detail;
                $data['title'] = 'Member';
                $data['subtitle'] = 'Detail Member';
                $this->render_to_admin('pages/member_detail.php', $data);
                return;
            }
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/Member.php');     
    }
    
    public function delete_action(){
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        
        if($id){
            $detail = $this->member->find($id);
            @unlink('../uploads/'.$detail['photo']);
            $deleted = $this->member->delete($id);

            $_SESSION['success'] = "Data Deleted";
            header('location: ../controllers/Member.php');
            return;
        }

        $_SESSION['error'] = "Data not found";
        header('location: ../controllers/Member.php');   
    }

}

/**
 * Silakan ganti Member sesuai dengan nama class diatas
 */
$type = isset($_GET['type']) ? $_GET['type'] : 'index';
$obj = new Member();
$obj->$type();

?>