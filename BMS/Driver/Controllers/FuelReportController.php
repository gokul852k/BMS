<?php

require_once '../Services/FuelReportService.php';

class FuelReportController {
    private $service;
    public function __construct() {
        $this->service = new FuelReportService();

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
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!', 'error' => $action . "this method is not exit"]);
        }
    }

    private function createFuelReport() {
        $busNumber = $_POST['bus-id'];
        $date = $_POST['date'];
        $fuelLiters = $_POST['fuel-liters'];
        $fuelAmount = $_POST['fuel-amount'];
        $fuelBill = $_FILES['fuel-bill'];

        echo json_encode($this->service->createFuelReport($busNumber, $date, $fuelLiters, $fuelAmount, $fuelBill));
    }

    
}

new FuelReportController();