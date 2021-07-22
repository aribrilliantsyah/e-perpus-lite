<?php 
require('../controllers/BaseController.php');
/**
 * @Controller
 */

class Dashboard extends BaseController{
    
    function __construct(){
        // Middleware
        $this->is_login();
    }
    
    public function index(){
        // pnow($_SESSION);
        $this->render_to_admin('pages/dashboard.php');
    }
}

/**
 * Silakan ganti Dashboard sesuai dengan nama class diatas
 */
$type = isset($_GET['type']) ? $_GET['type'] : 'index';
$obj = new Dashboard();
$obj->$type();

?>