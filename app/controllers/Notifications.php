<?php
    class Notifications extends Controller {
        public function __construct() {
            $this->notificationModel = $this->model('Notification');
        }

        public function getNotification() {
            $data = [];
            if (isLoggedIn()) {
                $result = $this->notificationModel->getUnreadNotifications($_SESSION['user_id']);
                echo json_encode($result);
                return $result;
                // $this->view('pages/getnotifications', $data);
            } else {
                die('Die');
            }
        }

        public function notifications() {
            if (isLoggedIn()) {
                $result = $this->notificationModel->getAllNotifications($_SESSION['user_id']);
                $data = [
                    "notifications" => $result,
                ];
                $this->view('notifications', $data);
            } else {
                flash('register_required', 'Please login to view notifications', 'alert alert-danger');
                redirect('users/login');
            }
        }

        public function getAllNotifications() {
            if (isLoggedIn()) {
                $result = $this->notificationModel->getAllNotifications($_SESSION['user_id']);
                $result = json_encode($result);
                echo $result;
            } else {
                die('Die');
            }
        }

        public function markAllAsRead() {
            if (isLoggedIn()) {
                echo 'MARK ALL AS READ';
                if($_SERVER['REQUEST_METHOD'] == 'PUT') {
                    $this->notificationModel->markAllAsRead($_SESSION['user_id']);
                }
            } else {
                die('Die');
            }
        }
    }