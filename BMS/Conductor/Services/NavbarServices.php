<?php
require_once '../Services/SessionServices.php';
require_once '../Models/NavbarModel.php';
require_once '../../config.php';

class NavbarServices {

    private $model;

    private $sesion;

    public function __construct() {
        $this->sesion = new SessionServices();

        if (!$this->sesion->isLoggedIn()) {
            // Handle the case where the user is not logged in
            $redirectUrl = '../../../Authentication/View/user_login.php';
            header('Location: '.$redirectUrl);
            exit();
        }
        global $bmsDB;
        $this->model = new NavbarModel($bmsDB);
    }

    public function userNavbar() {

        $roleId = $_SESSION['userRoleId'];
        $languageCode = $_SESSION['languageCode'];
        $response = $this->model->getUserNavbar($roleId, $languageCode);

        if ($response) {
            return $response;
        } else {
            return null;
        }
    }
}