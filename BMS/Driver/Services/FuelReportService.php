<?php

require_once '../../config.php';
require_once '../Models/FuelReportModel.php';
require_once '../Services/FileUpload.php';
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
            $dailyReport = $this->calcFuelUsage($busNumber, $date, $fuelLiters, $fuelAmount);
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

    public function calcFuelUsage($busId, $date, $fuelLiters, $fuelAmount){
        $dailyReport = $this->modelBMS->getFuelUsage($busId, $date, $_SESSION['companyId']);
        
        if (!$dailyReport) {
            return [
                'status' => 'no data',
                'message' => 'No Daily Report found.',
            ];
        }

        $oneLiterAmount = $fuelAmount / $fuelLiters;

        $fuelUsageAmount = $dailyReport['fuel_usage'] * $oneLiterAmount;

        $response = $this->modelBMS->updateFuelUsage($dailyReport['report_id'], $fuelUsageAmount);

        //Update the Fuel Amount for shift

        $shifts = $this->modelBMS->getShiftsFuelUsage($dailyReport['report_id']);

        if (!$shifts) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while update Fuel amount',
                'error' => 'Error while select shifts.'
            ];
        }

        foreach ($shifts as $shift) {
            if ($shift['fuel_usage'] != 0) {
                $shiftFuelUsageAmount = $shift['fuel_usage'] * $oneLiterAmount;
                $this->modelBMS->updateShiftFuelUsage($shift['shift_id'], $shiftFuelUsageAmount);
            }
        }

        if ($response) {
            return [
                'status' => 'success',
                'message' => 'Fuel Amount Updated.'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while update Fuel amount',
                'error' => 'Error while update fuel amount in daily report table in bms DB.'
            ];
        }
    }
}