<?php

require_once '../Services/DailyReportService.php';

class DailyReportController {
    private $service;
    public function __construct() {
        $this->service = new DailyReportService();

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
            echo json_encode(['status' => 'error', 'message' => 'Invalid request!', 'error' => $action . " this method is not exit"]);
        }
    }

    private function getBusCardDetails() {
        echo json_encode($this->service->getBusCardDetails());
    }

    private function getDailyReports() {
        echo json_encode($this->service->getDailyReports());
    }

    private function createDailyReport() {
        // echo json_encode($_POST);
        echo json_encode($this->service->createDailyReport($_POST));
    }

    private function getDailyReportForEdit() {
        $reportId = $_POST['reportId'];
        echo json_encode($this->service->getDailyReportForEdit($reportId));
    }

    private function updateDailyReport() {
        // echo json_encode($_POST);
        echo json_encode($this->service->updateDailyReport($_POST));
    }

    private function getDailyReportDetails() {
        $reportId = $_POST['reportId'];
        echo json_encode($this->service->getDailyReportDetails($reportId));
    }

    // private function reCalculateDailyReport() {
    //     $reportId = $_POST['reportId'];
    //     echo json_encode($this->service->reCalculateDailyReport($reportId));
    // }

    private function applyFilter() {

        $filterData = [
            'days' => $_POST['days'] ?? null,
            'fromDate' => $_POST['filter-from-date'] ?? null,
            'toDate' => $_POST['filter-to-date'] ?? null,
            'bus' => $_POST['filter-bus'] ?? null,
            'collectionFrom' => $_POST['filter-collection-from'] ?? null,
            'collectionTo' => $_POST['filter-collection-to'] ?? null,
            'profitFrom' => $_POST['filter-profit-from'] ?? null,
            'profitTo' => $_POST['filter-profit-to'] ?? null,
            'kmFrom' => $_POST['filter-km-from'] ?? null,
            'kmTo' => $_POST['filter-km-to'] ?? null,
            'orderBy' => $_POST['orderBy'] ?? null
        ];

        echo json_encode($this->service->applyFilter($filterData));

        // echo json_encode($_POST);
    }

}

new DailyReportController();