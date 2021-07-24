<?php 
require('../controllers/BaseController.php');
require('../models/User_model.php');
require('../models/Member_model.php');
require('../models/Borrow_log_model.php');
require('../models/Book_model.php');
/**
 * @Controller
 */

class Library extends BaseController{
    
    public static $auth;
    
    function __construct(){
        // Middlewares
        $this->is_login();
        // Sessions
        self::$auth = $this->auth();
        // Models
        $this->user = new User_model();
        $this->member = new Member_model();
        $this->borrow_log = new Borrow_log_model();
        $this->book = new Book_model();
    }

    public function index(){
        $data = [];
        if(isset($_GET['member_id'])){
            $data['member_id'] = $_GET['member_id'];
        }
        $data['title'] = 'Library';
        $this->render_to_admin('pages/library_home.php', $data);
    }

    public function autocomplete(){
        if(!isset($_GET['searchTerm'])){ 
            $json = [];
        }else{
            $search = $_GET['searchTerm'];
            $result = $this->member->like($search);
            $json = [];

            foreach($result as $item){
                $json[] = [
                    'id' => $item['id'], 
                    'text'=> $item['code'].' - '.strtoupper($item['full_name']),
                    'html' => '<div class="d-flex flex-row">
                        <div class="p-2 align-self-center">
                            <img onerror="this.src=\''.asset('/assets/img/theme/team-3.jpg').'\'" src="'.base_url('/uploads/'.$item['photo']) .'" class="avatar avatar-xs rounded-circle" >
                        </div>
                        <div class="p-2 d-flex flex-column align-content-center justify-content-center">
                            <h4>'.strtoupper($item['full_name']).'</h4>
                            <h6 class="text-muted">'.$item['code'].'</h6>
                        </div>
                    </div>'
                ];
            }
        }
    
        echo json_encode($json);
    }

    public function get_info_member(){
        $member_id = isset($_GET['member_id']) ? $_GET['member_id'] : '';
        if($member_id){
            $qRes = $this->member->find($member_id);
            echo json_encode([
                'status' => true,
                'data' => $qRes
            ]);exit;
        }

        echo json_encode([
            'status' => false
        ]);
    }

    public function get_borrowed_books(){
        $member_id = isset($_GET['member_id']) ? $_GET['member_id'] : '';
        if($member_id){
            $qRes = $this->borrow_log->get_logs_by_member_id($member_id);
            echo json_encode([
                'status' => true,
                'data' => $qRes
            ]);exit;
        }

        echo json_encode([
            'status' => false
        ]);
    }
    
    public function borrow(){
        $member_id = isset($_GET['member_id']) ? $_GET['member_id'] : '';
        if(!$member_id){
            $_SESSION['error'] = "Member id not found";
            header('location: ../controllers/Library.php');exit;     
        }

        $data['title'] = 'Library';
        $data['result'] = $this->book->all();
        $data['member_id'] = $member_id;
        // pnow($data);
        $this->render_to_admin('pages/library_borrow.php', $data);
    }

    public function on_borrow(){
        $member_id = isset($_GET['member_id']) ? $_GET['member_id'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if($member_id && $id){
            $stock = $this->book->stock($id);
            if($stock > 0){
                $created = $this->borrow_log->create([
                    'book_id' => $id,
                    'member_id' => $member_id,
                    'is_returned' => 0,
                    'return_estimate' => date('Y-m-d', strtotime(date('Y-m-d'). ' + 7 days')).' 17:00:00',
                    'created_at' => date('Y-m-d H:i:s'),
                    'created_by' => self::$auth['id']
                ]);

                if($created){
                    $this->book->decrease($id);
                }
                $_SESSION['success'] = "Successfully added to borrow list";
                header('location: ../controllers/Library.php?type=borrow&member_id='.$member_id);exit;  
            }else{
                $_SESSION['error'] = "Stock of book is 0";
                header('location: ../controllers/Library.php?type=borrow&member_id='.$member_id);exit;
            }
        }

        $_SESSION['error'] = "Invalid Parameters";
        header('location: ../controllers/Library.php'); 
    }

    public function on_return(){
        $member_id = isset($_GET['member_id']) ? $_GET['member_id'] : '';
        $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : '';
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        if($book_id && $member_id && $id){
            $updated = $this->borrow_log->update([
                'is_returned' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => self::$auth['id']
            ], $id);

            if($updated){
                $this->book->increase($book_id);
            }
            $_SESSION['success'] = "Successfully returned the book";
            header('location: ../controllers/Library.php?member_id='.$member_id);exit;
        }

        $_SESSION['error'] = "Invalid Parameters";
        header('location: ../controllers/Library.php');exit;
    }
}

/**
 * Silakan ganti User sesuai dengan nama class diatas
 */
$type = isset($_GET['type']) ? $_GET['type'] : 'index';
$obj = new Library();
$obj->$type();

?>