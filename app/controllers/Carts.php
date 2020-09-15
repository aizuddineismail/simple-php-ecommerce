<?php
    class Carts extends Controller {
        public function __construct() {
            $this->cartModel = $this->model('Cart');
            $this->productModel = $this->model('Product');
        }

        public function index() {
            if(isLoggedIn()) {
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // if ($this->cartModel->add($_SESSION['user_id'], $_POST['productId'])) {
                    //     return true;
                    // } else {
                    //     return false;
                    // }
                    try {
                        $this->cartModel->add($_SESSION['user_id'], $_POST['productId']);
                        echo 'passed';
                    } catch (Exception $e) {
                        echo 'failed';
                    }
                } else {
                    $result = $this->cartModel->getCart($_SESSION['user_id']);
                    $products = [];
    
                    foreach($result as $item) {
                        $tempProduct = $this->productModel->getProductById($item->product_id);
                        $tempProduct = array_merge($tempProduct, json_decode(json_encode($item), true));
                        array_push($products, $tempProduct);
                    }
                    
                    $data = [
                        "products" => $products,
                    ];
    
                    $this->view('carts/index', $data);
                }
            } else {
                flash('register_required', 'Please login to view notifications', 'alert alert-danger');
                redirect('users/login');
            }
        }
        
        public function add() {
            if (isLoggedIn()) {
                if($_SERVER['REQUEST_METHOD'] == 'PUT') {
                    try {
                        $productId = file_get_contents('php://input');
                        $this->cartModel->add($_SESSION['user_id'], $productId);
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    die('CANT GO DOWN');
                }
            } else {
                die('Please log in to continue)');
            }
        }
        
        public function minus() {
            if (isLoggedIn()) {
                if($_SERVER['REQUEST_METHOD'] == 'PUT') {
                    try {
                        $productId = file_get_contents('php://input');
                        $this->cartModel->minus($_SESSION['user_id'], $productId);
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    die('ERROR 404');
                }
            } else {
                die('Please log in to continue');
            }
        }

        public function delete() {
            if (isLoggedIn()) {
                if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
                    try {
                        $productId = file_get_contents('php://input');
                        $this->cartModel->delete($_SESSION['user_id'], $productId);
                    } catch (Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    die('ERROR 404');
                }
            } else {
                die('Please log in to continue');
            }
        }

        public function save() {
            if (isLoggedIn()) {
                if($_SERVER['REQUEST_METHOD'] == 'PUT') {
                    $data = file_get_contents('php://input');
                    $data = json_decode($data, true);
    
                    $this->cartModel->updateRows($_SESSION['user_id'], $data);
                    echo 'Successfully saved';
                }
            } else {
                die('Please log in to continue');
            }
        }

        // public function proceed() {
        //     if($_SERVER['REQUEST_METHOD'] == 'POST') {
        //         $data = $this->db->getCart($_SESSION['user_id']);
        //         print_r($data);
        //     }
        // }
    }