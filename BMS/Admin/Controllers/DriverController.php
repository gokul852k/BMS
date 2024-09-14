<?php

require_once '../Services/DriverService.php';

class DriverController {
    private $service;
    public function __construct() {
        $this->service = new DriverService();

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

    private function createDriver() {
        $driverImage = $_FILES['imageUpload'];
        $name = $_POST['fullname'];
        $mobile = $_POST['mobile'];
        $mail = $_POST['email'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $drivingLicence = $_FILES['driving-licence'];
        $licenceNo = $_POST['driving-licence-no'];
        $licenceExpiry = $_POST['licence-expiry'];
        $aadharCard = $_FILES['aadhar-card'];
        $aadharNo = $_POST['aadhar-no'];
        $panCard = $_FILES['pan-card'];
        $panNo = $_POST['pan-no'];

        echo json_encode($this->service->createDriver($driverImage, $name, $mobile, $mail, $password, $address, $state, $district, $pincode, $drivingLicence, $licenceNo, $licenceExpiry, $aadharCard, $aadharNo, $panCard, $panNo));
    }

    private function getDriver() {
        echo json_encode($this->service->getDriver($_POST['driverId']));
    }

    private function getDriversCardDetails() {
        echo json_encode($this->service->getDriversCardDetails());
    }

    private function getDrivers() {
        echo json_encode($this->service->getDrivers());
    }

    private function updateDriver() {
        $driverId = $_POST['driver_id'];
        $name = $_POST['fullname'];
        $mobile = $_POST['mobile'];
        // $mail = $_POST['mail'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $licenceNo = $_POST['licence_no'];
        $licenceExpiry = $_POST['licence_expiry'];
        $aadharNo = $_POST['aadhar_no'];
        $panNo = $_POST['pan_no'];

        $driverImage = $_FILES['driver_image_path'];
        $drivingLicence = $_FILES['licence_path'];
        $aadharCard = $_FILES['aadhar_path'];
        $panCard = $_FILES['pan_path'];

        echo json_encode($this->service->updateDriver($driverId, $driverImage, $name, $mobile, $password, $address, $state, $district, $pincode, $drivingLicence, $licenceNo, $licenceExpiry, $aadharCard, $aadharNo, $panCard, $panNo));
    
    }

    private function deleteDriver() {
        echo json_encode($this->service->deleteDriver($_POST['driverId']));
    }

    private function getDriverField() {
        echo json_encode($this->service->getDriverField());
    }
}

new DriverController();