<?php

require_once '../../config.php';
require_once '../Models/DailyReportModel.php';

class DailyReportService {
    private $modelBMS;

    private $modelA;
    private $mail;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $bmsDB;
        global $authenticationDB;
        $this->modelBMS = new BusModel($bmsDB);
        $this->modelA = new BusModel($authenticationDB);
    }

    public function getBusCardDetails() {
        $response = $this->modelBMS->getBusCardDetails($_SESSION['companyId']);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getDailyReports()
    {
        $currentDate = date("Y-m-d");
        $response = $this->modelBMS->getDailyReports($_SESSION['companyId'], $currentDate);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getBusEdit($busId)
    {
        $response = $this->modelBMS->getBus($busId);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function getBusView($busId) {
        $response = $this->modelBMS->getBusView($busId);
        if (!$response) {
            return [
                'status' => 'no data',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function deleteBus($busId) {
        $currentData = $this->modelBMS->getBus($busId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the driver',
                'error' => 'Error while select driver data in driver table.'
            ];
        }
        //Delete old file
        $oldRC = "../../Assets/User/" . $currentData['rcbook_path'];
        if (file_exists($oldRC) && is_file($oldRC)) {
            unlink($oldRC);
        }

        //Delete old file
        $oldInsurance = "../../Assets/User/" . $currentData['insurance_path'];
        if (file_exists($oldInsurance) && is_file($oldInsurance)) {
            unlink($oldInsurance);
        }

        $response = $this->modelBMS->deleteBus($busId);

        if ($response) {
            return [
                'status' => 'success',
                'message' => 'Bus deleted successfully.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the bus',
                'error' => 'Error while delete bus data in bus table in bms DB.'
            ];
        }
    }
}