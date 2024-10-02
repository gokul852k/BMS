<?php

class FuelReportModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function setFuelReport($companyId, $busNumber, $date, $fuelLiters, $fuelAmount, $fuelbill_path) {
        $stmt = $this->db->prepare("INSERT INTO `bms_fuel_reports`(`company_id`, `bus_id`, `fuel_date`, `fuel_quantity`, `fuel_cost`, `fuel_bill_url`) VALUES (:companyId, :busNumber, :date, :fuelLiters, :fuelAmount, :fuelbill_path)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("busNumber", $busNumber);
        $stmt->bindParam("date", $date);
        $stmt->bindParam("fuelLiters", $fuelLiters);
        $stmt->bindParam("fuelAmount", $fuelAmount);
        $stmt->bindParam("fuelbill_path", $fuelbill_path);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'busId' => $lastId
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Insert failed.',
                    'error' => 'No reason'
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Insert failed.',
                'error' => $stmt->errorInfo()
            ];
        }
    }


    function getFuelUsage($busId, $date, $companyId) {
        $isActive = true;
        $fuelUsage = 0;
        $stmt = $this->db->prepare("SELECT `report_id`, `fuel_usage` FROM `bms_daily_reports` WHERE `bus_id` = :busId AND `date` = :date AND `company_id` = :companyId AND `fuel_usage` != :fuelUsage AND `is_active` = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":busId", $busId);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":fuelUsage", $fuelUsage);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function updateFuelUsage($reportId, $fuelUsageAmount) {
        $stmt = $this->db->prepare("UPDATE `bms_daily_reports` SET `fuel_amount`= :fuelUsageAmount WHERE `report_id` = :reportId");
        $stmt->bindParam(":fuelUsageAmount", $fuelUsageAmount);
        $stmt->bindParam(":reportId", $reportId);

        return $stmt->execute() ? true : false;
    }

    public function getShiftsFuelUsage($reportId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `shift_id`, `fuel_usage` FROM `bms_shifts` WHERE `report_id` = :reportId AND `is_active` = :isActive");
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateShiftFuelUsage($shiftId, $shiftFuelUsageAmount) {
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `fuel_amount` = :shiftFuelUsageAmount WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftFuelUsageAmount", $shiftFuelUsageAmount);
        $stmt->bindParam(":shiftId", $shiftId);

        return $stmt->execute() ? true : false;
    }

}