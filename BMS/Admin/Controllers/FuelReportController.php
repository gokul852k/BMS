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

    private function getFuelReportCardDetails() {
        echo json_encode($this->service->getFuelReportCardDetails());
    }

    private function getBuses() {
        echo json_encode($this->service->getBuses());
    }

    private function getFuelReports() {
        echo json_encode($this->service->getFuelReports());
    }

    private function getFuelReport() {
        echo json_encode($this->service->getFuelReport($_POST['reportId']));
    }

    private function updateFuelReport() {
        // $fuelReportId = 2;
        $fuelReportId = $_POST['fuel_report_id'];
        $busId = $_POST['bus_id'];
        $fuelDate = $_POST['fuel_date'];
        $fuelQuantity = $_POST['fuel_quantity'];
        $fuelCost = $_POST['fuel_cost'];
        $fuelBill = $_FILES['fuel_bill_url'];

        echo json_encode($this->service->updateFuelReport($fuelReportId, $busId, $fuelDate, $fuelQuantity, $fuelCost, $fuelBill));
    
    }

    private function deleteFuelReport() {
        echo json_encode($this->service->deleteFuelReport($_POST['reportId']));
    }

    private function applyFilter() {

        $filterData = [
            'days' => $_POST['days'] ?? null,
            'fromDate' => $_POST['filter-from-date'] ?? null,
            'toDate' => $_POST['filter-to-date'] ?? null,
            'bus' => $_POST['filter-bus'] ?? null,
            'fuelType' => $_POST['filter-fuel-type'] ?? null,
            'costFrom' => $_POST['filter-fuel-cost-from'] ?? null,
            'costTo' => $_POST['filter-fuel-cost-to'] ?? null,
            'orderBy' => $_POST['orderBy'] ?? null
        ];

        echo json_encode($this->service->applyFilter($filterData));
    }
}

new FuelReportController();