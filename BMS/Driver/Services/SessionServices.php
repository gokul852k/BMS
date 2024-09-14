<?php
require_once '../../config.php';
require_once '../Models/SessionModel.php';

class SessionServices {

    private $modelMA;
    private $modelA;
    private $modelBMS;
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $masterAdminDB;
        global $authenticationDB;
        global $bmsDB;
        $this->modelMA = new SessionModel($masterAdminDB);
        $this->modelA = new SessionModel($authenticationDB);
        $this->modelBMS = new SessionModel($bmsDB);
    }

    public function storeSessionValue($token) {
        $response1 = $this->modelA->getUser($token);
        $userId = $response1['id'];
        $companyId = $response1['company_id'];
        $response2 = $this->modelBMS->getUserDetails($userId);

        //Get user role from Authentication Database
        $response3 = $this->modelA->getUserRoleFromAuthentication($response1['id']);

        //Get User role ID from BMS Database

        $response4 = $this->modelBMS->getUserRoleIdFromBMS($response3['role_name']);



        //Storing value in session
        if($response1 && $response2 && $response3 && $response4) {
            $_SESSION['userId'] = $userId;
            $_SESSION['companyId'] = $companyId;
            $_SESSION['userName'] = $response2['fullname'];
            $_SESSION['languageCode'] = 'ta';
            $_SESSION['userRoleId'] = $response4['id'];
            $_SESSION['driverId'] = $response2['id'];

            //Yokesh you need to store session as per your need.

            return [
                "status" => "success",
                "message" => "Session value is stored."
            ];
        }

        return [
            "status" => "error",
            "message" => "Session value not stored."
        ];
    }

    public function isLoggedIn() {
        //check if session value is avilable.
        if (isset($_SESSION['userId'])) {
            return true;
        }

        //check if cookie value is avilable.
        if (isset($_COOKIE['remember_me_tms_user'])) {
            $reponse = $this->storeSessionValue($_COOKIE['remember_me_tms_user']);
            return ($reponse['status'] === 'success') ? true : false;
        }

        return false;
    }

    public function logout() {

        session_unset();

        session_destroy();

        // Delete the remember me cookie
        setcookie('remember_me_tms_user', '', time() - 3600, '/', 'localhost', false, true);

        return [
            "status" => "success"
        ];
    }
}