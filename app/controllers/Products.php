<?php
    class Products extends Controller {
        public function __construct() {
            $this->productModel = $this->model('Product');
        }
        
        public function pages($id = 1) {
            $data = [
                'id' => $id,
                'products' => $this->productModel->getProductByPage($id),
            ];

            $this->view('products/pages', $data);
        }
    }