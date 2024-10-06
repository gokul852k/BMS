<?php

require_once '../Services/SessionServices.php';
class SessionController {

    private $service;

    public function __construct() {

        if (!isset($_COOKIE['remember_me_tms_user'])) {
            $redirctUrl = '../../../Authentication/View/user_login.php';
            header('Location: ' . $redirctUrl);
            exit;
        }

        // echo $_COOKIE['remember_me_tms_user'];

        $this->service = new SessionServices();

        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            // Get the action from the AJAX request
            $action = isset($_POST['action']) ? $_POST['action'] : '';

            // Call the appropriate method based on the action
            if (method_exists($this, $action)) {
                $this->$action();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request!']);
            }
        } else {
            $this->storeSessionValue($_COOKIE['remember_me_tms_user']);
        }

    }

    private function storeSessionValue($token) {
        $response = $this->service->storeSessionValue($token);

        if ($response['status'] === 'success') {
            $redirectUrl = '../View/index.php';
            header('Location: ' . $redirectUrl);
            exit;
        } else {
            $redirectUrl = '../../../Authentication/View/user_login.php';
            header('Location: ' . $redirectUrl);
            exit;
        }
    }
    
    private function logout() {
        echo json_encode($this->service->logout());
    }

    private function changeLanguage() {
        $code = $_POST['code'];
        echo json_encode($this->service->changeLanguage($code));
    }
}

new SessionController();