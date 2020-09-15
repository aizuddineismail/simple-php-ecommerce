<?php
    class Pages extends Controller {
        public function __construct() {
            $this->productModel = $this->model('Product');
            // $this->notificationModel = $this->model('Notification');
        }

        public function index() {
            $this->productModel->getProductByPage();
            $data = [
                'products' => $this->productModel->getProductByPage(),
            ];

            $this->view('pages/index', $data);
        }
    }