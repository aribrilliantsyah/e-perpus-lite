<?php
session_start();
ob_start();

require('../config/app.php');
require('../helpers/Utils.php');

class BaseController{

    function __construct(){

    }
 
    public function render_to_admin($page, $data = []){
        $data = $data;
        $data['page'] = '../views/'.$page;
        include_once('../views/app.php');
    }
    
    public function render_view($page, $data = []){
        $data = $data;
        include_once('../views/'.$page);
    }

    public function is_login(){
        if(!isset($_SESSION['user']) || $_SESSION['user'] == ''){
            $_SESSION['validasi'] = 'Anda belum masuk sebagi user';
            header('location: ../controllers/Auth.php');
        }
    }

    public function auth(){
        return isset($_SESSION['user']) ? $_SESSION['user'] : [];
    }

    public function timestamp(){
        return  date('Y-m-d H:i:s');
    }

}

?>