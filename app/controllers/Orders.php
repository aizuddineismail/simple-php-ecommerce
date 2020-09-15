<?php 
    class Orders extends Controller {
        public function __construct() {
            $this->cartModel = $this->model('Cart');
            $this->orderModel = $this->model('Order');
            $this->productModel = $this->model('Product');
            $this->notificationModel = $this->model('Notification');
        }

        public function index() {
            if (isLoggedIn()) {
                if($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $data = $this->cartModel->getCart($_SESSION['user_id']);
                    $this->orderModel->orderBulk($_SESSION['user_id'], $data);
                    $this->cartModel->deleteAll($_SESSION['user_id'], $data);
                    flash('order_placed', 'You order has been placed');
                    redirect('carts');
                } else {
                    $result = $this->orderModel->getOrders($_SESSION['user_id']);
                    $orders = [];
    
                    foreach($result as $item) {
                        $tempProduct = $this->productModel->getProductById($item->product_id);
                        $tempProduct = array_merge($tempProduct, json_decode(json_encode($item), true));
                        array_push($orders, $tempProduct);
                    }
    
                    $data = [
                        "orders" => $orders,
                    ];
    
                    $this->view('orders/index', $data);
    
                }
            } else {
                flash('register_required', 'Please login to view notifications', 'alert alert-danger');
                redirect('users/login');
            }
        }

        // Fake update API
        public function updateOrder() {
            if($_SERVER['REQUEST_METHOD'] == 'PUT') {
                try {
                    $data = file_get_contents('php://input');
                    $data = json_decode($data, true);
                    
                    if ($data['order_status'] != 'Cancelled') {
                        $notificationMessage = 'Order #'. $data['order_id'] . ' status is now \'' . $data['order_status'] . '\'';
                    } else {
                        $notificationMessage = 'Order #'. $data['order_id'] . ' status is \'' . $data['order_status'] . '\'';
                        
                    }
                    $this->orderModel->updateStatus($data['user_id'], $data['order_id'], $data['order_status']);
                    $this->notificationModel->addNotification($data['user_id'], $notificationMessage);

                    echo 'DONE';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        }
    }