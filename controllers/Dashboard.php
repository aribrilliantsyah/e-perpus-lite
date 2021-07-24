<?php 
require('../controllers/BaseController.php');
require('../models/Borrow_log_model.php');
require('../models/Member_model.php');
require('../models/User_model.php');
/**
 * @Controller
 */

class Dashboard extends BaseController{
    
    function __construct(){
        // Middleware
        $this->is_login();
        // Models
        $this->borrow_log = new Borrow_log_model();
        $this->member = new Member_model();
        $this->user = new User_model();
    }
    
    public function index(){
        // pnow($_SESSION);
        $data['title'] = 'Dashboard';
        $data['result'] = $this->borrow_log->all(20);
        $data['popular'] = $this->borrow_log->get_popular();
        $data['count'] = @$this->borrow_log->count_borrowing();
        $data['all_member'] = $this->member->count_all();
        $data['books_borrowed'] = $this->borrow_log->count_all(0);
        $data['books_returned'] = $this->borrow_log->count_all(1);
        $data['admin_total'] = $this->user->count_all();
        // pnow($data);
        $this->render_to_admin('pages/dashboard.php', $data);
    }
}

/**
 * Silakan ganti Dashboard sesuai dengan nama class diatas
 */
$type = isset($_GET['type']) ? $_GET['type'] : 'index';
$obj = new Dashboard();
$obj->$type();

?>