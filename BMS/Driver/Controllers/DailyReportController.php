<?php

require_once '../Services/DailyReportService.php';
class DailyReportController {
    private $serviceDR;
    public function __construct() {
        $this->serviceDR = new DailyReportService();

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

    private function createDailyReport() {
        echo json_encode($this->serviceDR->createDailyReport($_POST['bus-id']));
    }

    private function startTrip() {
        echo json_encode($this->serviceDR->startTrip($_POST['start-route'], $_POST['end-route'], $_POST['start-km']));
    }

    private function startTrip2() {
        echo json_encode($this->serviceDR->startTrip2($_POST['trip-id-2'], $_POST['start-km']));
    }
    private function endTrip() {
        echo json_encode($this->serviceDR->endTrip($_POST['trip-id'], $_POST['trip-driver-id'], $_POST['end-km']));
    }

    private function endDuty() {
        echo json_encode($this->serviceDR->endDuty($_POST['tripId']));
    }

    private function getTripsDetails() {
        echo json_encode($this->serviceDR->getTripsDetails());
    }

    private function endDuty2() {
        echo json_encode($this->serviceDR->endDuty2($_POST['fuel-usage'], $_POST['work-salary'], $_POST['work-commission'], $_POST['total-commission']));
    }

    private function getEndKm() {
        echo json_encode($this->serviceDR->getEndKm($_POST['tripId']));
    }
}

new DailyReportController();