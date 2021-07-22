<?php 
require('../controllers/BaseController.php');
require('../models/User_model.php');
/**
 * @Controller
 */

class Auth extends BaseController{

    public function index(){
        $data['nama'] = '';
        $this->render_view('auth/login.php', $data);
    }

    public function login(){
        if(count($_POST) > 0){
            $post = $_POST;
            $username = isset($post['username']) ? trim($post['username']) : '';
            $password = isset($post['password']) ? trim($post['password']) : '';

            if(!$username){
                $_SESSION['validasi'] = 'Silakan isi terlebih dahulu username';
                header('location: ../controllers/Auth.php');return;
            }
            if(!$password){
                $_SESSION['validasi'] = 'Silakan isi terlebih dahulu password';
                header('location: ../controllers/Auth.php');return;
            }

            if($username && $password){
                $user = new User_model();
                $qRes = $user->findByUsername($username);
                // pnow(count($qRes));
                if(count($qRes) == 0 || empty($qRes)){
                    $_SESSION['validasi'] = 'Username tidak ditemukan';
                    header('location: ../controllers/Auth.php');return;
                }

                if(password_verify($password, $qRes['password'])) {
                    $_SESSION['user'] = $qRes;
                    header('location: ../controllers/Dashboard.php');return;
                }else{
                    $_SESSION['validasi'] = 'Password tidak cocok dengan username';
                    header('location: ../controllers/Auth.php');return;
                }
            }
        }

        header('location: ../controllers/Auth.php');
    }

    public function logout(){
        unset($_SESSION['user']);
        $_SESSION['validasi'] = 'Anda berhasil logout';
        header('location: ../controllers/Auth.php');
    }
}

/**
 * Silakan ganti Auth sesuai dengan nama class diatas
 */
$type = isset($_GET['type']) ? $_GET['type'] : 'index';
$obj = new Auth();
$obj->$type();

?>