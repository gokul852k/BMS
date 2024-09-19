<?php

require_once '../../config.php';
require_once '../Models/FuelReportModel.php';
require_once '../Services/FileUpload.php';
require_once '../Services/ChartService.php';
require_once '../Services/DailyReportService.php';

class FuelReportService {
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
        $this->modelBMS = new FuelReportModel($bmsDB);
        $this->modelA = new FuelReportModel($authenticationDB);
    }

    public function getFuelType() {
        $response = $this->modelBMS->getFuelType();

        if (!$response) {
            return [
                'status' => 'error',
                'message' => 'No data found'
            ];
        }

        return [
            'status' => 'success',
            'data' => $response
        ];
    }

    public function createFuelReport($busNumber, $date, $fuelLiters, $fuelAmount, $fuelBill)
    {


        $uploadService = new FileUpload();

        //Upload Fuel Bill

        $fuelBill_dir = "../../Assets/User/Fuel bill/";

        $fuelbill_filename = $uploadService->uploadFile($fuelBill, $fuelBill_dir);

        $fuelbill_path = $fuelbill_filename['status'] === 'success' ? 'Fuel bill/' . $fuelbill_filename['fileName'] : '';


        //Insert Fuel report in fuel_report table in bms DB

        $response = $this->modelBMS->setFuelReport($_SESSION['companyId'], $busNumber, $date, $fuelLiters, $fuelAmount, $fuelbill_path);

        if ($response['status'] == 'success') {
            $DRservice = new DailyReportService();
            $dailyReport = $DRservice->calcFuelUsage($busNumber, $date, $fuelLiters, $fuelAmount);
            return [
                "status" => "success",
                "message" => "The Fuel report added successfully."
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while insert fuel report',
                'error' => 'Error while insert data in bufuel_reports table.'
            ];
        }
    }


    public function updateFuelReport($fuelReportId, $busId, $fuelDate, $fuelQuantity, $fuelCost, $fuelBill) {
        $reportInfo = [
            "bus_id" => $busId,
            "fuel_date" => $fuelDate,
            "fuel_quantity" => $fuelQuantity,
            "fuel_cost" => $fuelCost
        ];

        $currentData = $this->modelBMS->getFuelReport2($fuelReportId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while updating the fuel report',
                'error' => 'Error while select fuel report from fuel report table.'
            ];
        }

        //Check for changes
        $changes = [];
        $fields = ['bus_id', 'fuel_date', 'fuel_quantity', 'fuel_cost'];

        //check & upload file changes
        $fileChanges = false;

        $uploadService = new FileUpload();

        //Upload RC Book
        if (isset($fuelBill) && $fuelBill['error'] === UPLOAD_ERR_OK) {
            $fuelbill_dir = "../../Assets/User/Fuel bill/";

            $fuelbill_filename = $uploadService->uploadFile($fuelBill, $fuelbill_dir);

            $fuelbill_path = $fuelbill_filename['status'] === 'success' ? 'Fuel bill/' . $fuelbill_filename['fileName'] : '';

            $fields[] = 'fuel_bill_url';
            $reportInfo['fuel_bill_url'] = $fuelbill_path;
            $fileChanges = true;
            //Delete old file
            $old1 = "../../Assets/User/" . $currentData['fuel_bill_url'];
            if (file_exists($old1) && is_file($old1)) {
                unlink($old1);
            }
        }



        foreach ($fields as $field) {
            if ($reportInfo[$field] != $currentData[$field]) {
                $changes[$field] = $reportInfo[$field];
            }
        }

        // Construct and execute dynamic SQL query if there are changes
        if (!empty($changes) || $fileChanges) {
            $update_fields = [];
            $update_values = [];

            foreach ($changes as $field => $new_value) {
                $update_fields[] = "$field = :$field";
                $update_values[":$field"] = $new_value;
            }

            $update_values['fuel_report_id'] = $fuelReportId;
            

            $final_response = $this->modelBMS->updateFuelReport($update_fields, $update_values);

            if ($final_response) {
                return [
                    'status' => 'success',
                    'message' => 'Fuel report updated successfully'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while updating the fuel report',
                    'error' => 'Error while update fuel report in fuel report table.'
                ];
            }

        } else {
            return [
                'status' => 'error',
                'message' => 'There are no changes in fuel report.',
                'error' => 'All values as in fuel report table'
            ];
        }
    }

    public function getFuelReportCardDetails() {
        $response = $this->modelBMS->getFuelReportCardDetails($_SESSION['companyId']);
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

    public function getBuses()
    {
        $response = $this->modelBMS->getBuses($_SESSION['companyId']);
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

    public function getFuelReports()
    {
        $response = $this->modelBMS->getFuelReports($_SESSION['companyId']);
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

    public function getFuelReport($reportId)
    {
        $response = $this->modelBMS->getFuelReport($reportId);
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

    public function deleteFuelReport($reportId) {
        $currentData = $this->modelBMS->getFuelReport2($reportId);

        if (!$currentData) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while deleting the fuel report',
                'error' => 'Error while select fuel report in fuel report table.'
            ];
        }
        //Delete old file
        $old = "../../Assets/User/" . $currentData['fuel_bill_url'];
        if (file_exists($old) && is_file($old)) {
            unlink($old);
        }


        $response = $this->modelBMS->deleteFuelReport($reportId);

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

    public function applyFilter($filterData) {
        // Validate and sanitize filters
        $filters = [];

        if (!empty($filterData['fromDate'])  && $this->isValidDate($filterData['fromDate'])) {
            $filters['fromDate'] = $filterData['fromDate'];
        }

        if (!empty($filterData['toDate'])  && $this->isValidDate($filterData['toDate'])) {
            $filters['toDate'] = $filterData['toDate'];
        }

        if (!empty($filterData['bus'])) {
            $filters['bus'] = $filterData['bus'];
        }

        if (!empty($filterData['fuelType'])) {
            $filters['fuelType'] = $filterData['fuelType'];
        }

        if (!empty($filterData['costFrom'])) {
            $filters['costFrom'] = $filterData['costFrom'];
        }

        if (!empty($filterData['costTo'])) {
            $filters['costTo'] = $filterData['costTo'];
        }

        //Featching card count based on filter
        $cardCount = $this->modelBMS->getFilterCardCount($filters, $_SESSION['companyId']);

        //Featching FuelReport on filter
        $fuelReport = $this->modelBMS->getFilterFuelReport($filters, $_SESSION['companyId']);

        //Featching Chart data on filter
        // $date1 = new DateTime($filterData['fromDate']);
        // $date2 = new DateTime($filterData['toDate']);

        // $interval = $date1->diff($date2);

        $chart = $this->modelBMS->getFilterChart($filters, $_SESSION['companyId']);

        $chartService = new ChartService();

        $chartData = $chartService->lineChartAggregation($chart);


        return [
            'status' => 'success',
            'cardCount' => $cardCount,
            'fuelReport' => $fuelReport,
            'chartData' => $chartData
        ];

    }

    private function isValidDate($date) {
        return (bool) strtotime($date);
    }
}