<?php

require_once '../Services/ConductorService.php';

class ConductorController {
    private $service;
    public function __construct() {
        $this->service = new ConductorService();

        // Check if the request is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            die('Invalid request');
        }

        // Get the action from the AJAX request
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        // Call the appropriate method based on the action
        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!', 'error' => $action . "this method is not exit". $_POST['driverId']]);
        }
    }

    private function createConductor() {
        $conductorImage = $_FILES['imageUpload'];
        $name = $_POST['fullname'];
        $mobile = $_POST['mobile'];
        $mail = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $language = $_POST['language'];
        $aadharCard = $_FILES['aadhar-card'];
        $aadharNo = $_POST['aadhar-no'];
        $panCard = $_FILES['pan-card'];
        $panNo = $_POST['pan-no'];

        echo json_encode($this->service->createConductor($conductorImage, $name, $mobile, $mail, $password, $address, $state, $district, $pincode, $language, $aadharCard, $aadharNo, $panCard, $panNo));
    }

    private function getConductor() {
        echo json_encode($this->service->getConductor($_POST['conductorId']));
    }

    private function getDriversCardDetails() {
        echo json_encode($this->service->getDriversCardDetails());
    }

    private function getConductors() {
        echo json_encode($this->service->getConductors());
    }

    private function updateConductor() {
        $conductorId = $_POST['conductor_id'];
        $name = $_POST['fullname'];
        $mobile = $_POST['mobile'];
        $language = $_POST['language'];
        // $mail = $_POST['mail'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $aadharNo = $_POST['aadhar_no'];
        $panNo = $_POST['pan_no'];

        $conductorImage = $_FILES['conductor_image_path'];
        $aadharCard = $_FILES['aadhar_path'];
        $panCard = $_FILES['pan_path'];

        echo json_encode($this->service->updateConductor($conductorId, $conductorImage, $name, $mobile, $language, $password, $address, $state, $district, $pincode, $aadharCard, $aadharNo, $panCard, $panNo));
    
    }

    private function deleteConductor() {
        echo json_encode($this->service->deleteConductor($_POST['conductorId']));
    }

    private function getConductorField() {
        echo json_encode($this->service->getConductorField());
    }
}

new ConductorController();