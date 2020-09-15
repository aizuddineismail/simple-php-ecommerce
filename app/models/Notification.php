<?php 
    class Notification {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function addNotification($userId, $message) {
            $this->db->query('INSERT INTO notifications (user_id, message, status) VALUES (:user_id, :message, "unread")');
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':message', $message);

            $this->db->execute();
        }

        public function getUnreadNotifications($userId) {
            $this->db->query('SELECT * FROM notifications WHERE user_id=:user_id AND status="unread"');
            $this->db->bind(':user_id', $userId);

            $result = $this->db->resultAll();
            return $result;
        }

        public function getAllNotifications($userId) {
            $this->db->query('SELECT * FROM notifications WHERE user_id=:user_id ORDER BY created_at DESC');
            $this->db->bind(':user_id', $userId);

            $result = $this->db->resultAll();
            return $result;
        }

        public function markAllAsRead($userId) {
            $this->db->query('UPDATE notifications SET status="read" WHERE user_id = :user_id');
            $this->db->bind(':user_id', $userId);
            $this->db->execute();
        }

    }