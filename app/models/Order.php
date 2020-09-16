<?php
    class Order {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function orderBulk($userId, $data) {
            foreach($data as $item) {
                $this->orderSingle($userId, $item->product_id, $item->quantity);
            }
        }

        public function orderSingle($userId, $productId, $quantity, $orderStatus='Payment pending') {
            $this->db->query('INSERT INTO orders (user_id, product_id, quantity, order_status) VALUES (:user_id, :product_id, :quantity, :orderStatus)');

            $this->db->bind(':user_id', $userId);
            $this->db->bind(':product_id', $productId);
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':orderStatus', $orderStatus);

            $this->db->execute();
        }

        public function getOrders($userId) {
            $this->db->query('SELECT * FROM orders WHERE user_id = :userId ORDER BY updated_at DESC');
            $this->db->bind(':userId', $userId);

            $result = $this->db->resultAll();

            return $result;
        }

        public function updateStatus($userId, $orderId, $orderStatus) {
            // $updatedAt = date('Y-m-d h:i:s');
            $updatedAt = getCurrentTime();
            $this->db->query('UPDATE orders SET order_status=:order_status, updated_at=:updated_at WHERE order_id=:order_id AND user_id=:user_id');
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':order_status', $orderStatus);
            $this->db->bind(':updated_at', $updatedAt);

            $this->db->execute();
        }
    }
