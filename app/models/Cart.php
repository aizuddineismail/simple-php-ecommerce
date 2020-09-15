<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function add($userId, $productId) {
        if ($this->checkProductExist($userId, $productId)) {
            // Get currrent value
            $this->db->query('SELECT * from carts WHERE user_id = :userId AND product_id = :productId');
            $this->db->bind(':userId', $userId);
            $this->db->bind(':productId', $productId);
            $this->db->execute();
            $currentQuantity = $this->db->resultSingle();

            $quantity = $currentQuantity->quantity + 1;
            $this->update($userId, $productId, $quantity);
            // $this->db->query('UPDATE carts SET quantity = :quantity WHERE product_id = :productId');
            // $this->db->bind(':quantity', $currentQuantity->quantity + 1);
            // $this->db->bind(':productId', $productId);

            // if ($this->db->execute()) {
            //     return true;
            // } else {
            //     return false;
            // }

        } else {
            $this->db->query('INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)');
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':product_id', $productId);
            $this->db->bind(':quantity', 1);

            $this->db->execute();
        }
    }

    public function minus($userId, $productId) {
        if ($this->checkProductExist($userId, $productId)) {
            // Get currrent value
            $this->db->query('SELECT * from carts WHERE user_id = :userId AND product_id = :productId');
            $this->db->bind(':userId', $userId);
            $this->db->bind(':productId', $productId);
            $this->db->execute();
            $currentQuantity = $this->db->resultSingle();

            if ($currentQuantity->quantity > 1) {
                $quantity = $currentQuantity->quantity -1;
                $this->update($userId, $productId, $quantity);
                // $this->db->query('UPDATE carts SET quantity = :quantity WHERE product_id = :productId');
                // $this->db->bind(':quantity', $currentQuantity->quantity - 1);
                // $this->db->bind(':productId', $productId);

                // if ($this->db->execute()) {
                //     return true;
                // }
            } else {
                return false;
            }

        }
    }

    public function update($userId, $productId, $quantity) {
        $this->db->query('UPDATE carts SET quantity = :quantity WHERE product_id = :productId AND user_id = :userId');
        $this->db->bind(':userId', $userId);
        $this->db->bind(':productId', $productId);
        $this->db->bind(':quantity', $quantity);
        
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function deleteAll($userId, $data) {
        foreach($data as $item) {
            $this->delete($userId, $item->product_id);
        }
    }
    public function delete($userId, $productId) {
        $this->db->query('DELETE from carts WHERE user_id = :userId AND product_id = :productId');
        $this->db->bind(':userId', $userId);
        $this->db->bind(':productId', $productId);
        $this->db->execute();

        // if ($this->db->execute()) {
        //     return true;
        // } else {
        //     return false;
        // }
    }

    public function getCart($userId) {
        $this->db->query('SELECT * FROM carts WHERE user_id = :userId ORDER BY added_time ASC');
        $this->db->bind(':userId', $userId);

        $result = $this->db->resultAll();

        return $result;
    }

    public function checkProductExist($userId, $productId)
    {
        $this->db->query('SELECT * FROM carts WHERE user_id = :user_id AND product_id = :product_id');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':product_id', $productId);

        $row = $this->db->resultSingle();

        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateRows($userId, $rows) {
        foreach($rows as $row) {
            $this->update($userId, $row['productId'], $row['quantity']);
        }
    }
}
