<?php

class FuelReportModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getFuelType() {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `fuel` FROM bms_fuel_type WHERE is_active = :isActive");
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
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

    public function setBusSummary($companyId, $busId) {
        $stmt = $this->db->prepare("INSERT INTO `bms_bus_summary` (`company_id`, `bus_id`) VALUES (:companyId, :busId)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("busId", $busId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.'
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

    public function getFuelReportCardDetails($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT  SUM(fuel_cost) AS 'totalAmount', SUM(fuel_quantity) AS 'totalLiters', COUNT(*) AS 'reFueled' FROM bms_fuel_reports WHERE company_id = :companyId AND is_active = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getBuses($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `id`, `bus_number` FROM `bms_bus` WHERE `company_id` = :companyId AND `is_active` = :isActive");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFuelReports($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT FR.fuel_report_id AS 'fuelReportId',
                                    b.bus_number AS 'busNumber',
                                    DATE_FORMAT(fr.fuel_date, '%d-%m-%Y') AS 'date',
                                    ft.fuel AS 'fuelType',
                                    fr.fuel_quantity AS 'liters',
                                    fr.fuel_cost AS 'amount',
                                    fr.fuel_bill_url AS 'bill'
                                    FROM bms_fuel_reports fr
                                    INNER JOIN bms_bus b ON fr.bus_id = b.id
                                    INNER JOIN bms_fuel_type ft ON b.fuel_type_id = ft.id
                                    WHERE fr.company_id = :companyId AND fr.is_active = :isActive");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFuelReport($reportId) {
        $stmt = $this->db->prepare("SELECT FR.fuel_report_id AS 'fuelReportId',
                                    fr.bus_id AS 'busId',
                                    fr.fuel_date AS 'date',
                                    fr.fuel_quantity AS 'liters',
                                    fr.fuel_cost AS 'amount',
                                    fr.fuel_bill_url AS 'bill'
                                    FROM bms_fuel_reports fr
                                    WHERE fr.fuel_report_id = :reportId");
        $stmt->bindParam(":reportId", $reportId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFuelReport2($reportId) {
        $stmt = $this->db->prepare("SELECT *
                                    FROM bms_fuel_reports
                                    WHERE fuel_report_id = :reportId");
        $stmt->bindParam(":reportId", $reportId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function updateFuelReport($update_fields, $update_values) {
        $sql = "UPDATE bms_fuel_reports SET ". implode(", ", $update_fields) . " WHERE fuel_report_id = :fuel_report_id";
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute($update_values)) {
            return true;
        } else {
            return false;
        }
    }

    function getBusView($busId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT 
                                    b.bus_number,
                                    b.bus_model,
                                    b.seating_capacity,
                                    ft.fuel AS 'fuel_type',
                                    b.rcbook_no,
                                    b.rcbook_expiry,
                                    b.rcbook_path,
                                    b.insurance_no,
                                    b.insurance_expiry,
                                    b.insurance_path,
                                    b.driver_salary,
                                    b.conductor_salary,
                                    b.bus_status,
                                    COALESCE(bs.total_km, 0) AS 'total_km',
                                    COALESCE(bs.avg_mileage, 0) AS 'avg_mileage',
                                    COALESCE(bs.cost_per_km, 0) AS 'cost_per_km',
                                    COALESCE(bs.fuel_cost, 0) AS 'fuel_cost',
                                    COALESCE(bs.maintenance_cost, 0) AS 'maintenance_cost'
                                FROM bms_bus b
                                INNER JOIN bms_fuel_type ft ON b.fuel_type_id = ft.id
                                LEFT JOIN bms_bus_summary bs ON b.id = bs.bus_id
                                WHERE b.id=:busId AND b.is_active=:isActive");
        $stmt->bindParam(":busId", $busId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function deleteFuelReport($reportId) {
        $isActive = false;
        $stmt = $this->db->prepare("UPDATE `bms_fuel_reports` SET `is_active` = :isActive WHERE `fuel_report_id` = :reportId");
        $stmt->bindParam(":isActive", $isActive);
        $stmt->bindParam(":reportId", $reportId);

        return $stmt->execute() ? true : false;
    }

    function getFilterCardCount($filters, $companyId) {
        $isActive = true;
        $sql = "SELECT  FORMAT(SUM(fr.fuel_cost), 0) AS 'totalAmount', FORMAT(SUM(fr.fuel_quantity), 1) AS 'totalLiters', COUNT(*) AS 'reFueled'
                FROM bms_fuel_reports fr
                INNER JOIN bms_bus b ON fr.bus_id = b.id
                WHERE 1=1 ";
                //company_id = :companyId AND is_active = :isActive
        $params = [];

        if (!empty($filters['fromDate'])) {
            $sql .= "AND fr.fuel_date >= :fromDate ";
            $params[':fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= "AND fr.fuel_date <= :toDate ";
            $params[':toDate'] = $filters['toDate'];
        }

        if (!empty($filters['bus'])) {
            $sql .= "AND fr.bus_id = :bus ";
            $params[':bus'] = $filters['bus'];
        }

        if (!empty($filters['fuelType'])) {
            $sql .= "AND b.fuel_type_id = :fuelType ";
            $params[':fuelType'] = $filters['fuelType'];
        }

        if (!empty($filters['costFrom'])) {
            $sql .= "AND fr.fuel_cost >= :costFrom ";
            $params[':costFrom'] = $filters['costFrom'];
        }

        if (!empty($filters['costTo'])) {
            $sql .= "AND fr.fuel_cost <= :costTo ";
            $params[':costTo'] = $filters['costTo'];
        }

        $sql .= "AND fr.company_id = :companyId ";
        $params[':companyId'] = $companyId;

        $sql .= "AND fr.is_active = :isActive";
        $params[':isActive'] = $isActive;

        if (!empty($filters['orderBy'])) {
            // Ensure that the value is either ASC or DESC
            if ($filters['orderBy'] === "ASC" || $filters['orderBy'] === "DESC") {
                $sql .= " ORDER BY fr.fuel_date " . $filters['orderBy'];
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFilterFuelReport($filters, $companyId) {
        $isActive = true;
        $sql = "SELECT fr.fuel_report_id AS 'fuelReportId',
                b.bus_number AS 'busNumber',
                DATE_FORMAT(fr.fuel_date, '%d-%m-%Y') AS 'date',
                ft.fuel AS 'fuelType',
                fr.fuel_quantity AS 'liters',
                fr.fuel_cost AS 'amount',
                fr.fuel_bill_url AS 'bill'
                FROM bms_fuel_reports fr
                INNER JOIN bms_bus b ON fr.bus_id = b.id
                INNER JOIN bms_fuel_type ft ON b.fuel_type_id = ft.id
                WHERE 1=1 ";
                //company_id = :companyId AND is_active = :isActive
        $params = [];

        if (!empty($filters['fromDate'])) {
            $sql .= "AND fr.fuel_date >= :fromDate ";
            $params[':fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= "AND fr.fuel_date <= :toDate ";
            $params[':toDate'] = $filters['toDate'];
        }

        if (!empty($filters['bus'])) {
            $sql .= "AND fr.bus_id = :bus ";
            $params[':bus'] = $filters['bus'];
        }

        if (!empty($filters['fuelType'])) {
            $sql .= "AND b.fuel_type_id = :fuelType ";
            $params[':fuelType'] = $filters['fuelType'];
        }

        if (!empty($filters['costFrom'])) {
            $sql .= "AND fr.fuel_cost >= :costFrom ";
            $params[':costFrom'] = $filters['costFrom'];
        }

        if (!empty($filters['costTo'])) {
            $sql .= "AND fr.fuel_cost <= :costTo ";
            $params[':costTo'] = $filters['costTo'];
        }

        $sql .= "AND fr.company_id = :companyId ";
        $params[':companyId'] = $companyId;

        $sql .= "AND fr.is_active = :isActive";
        $params[':isActive'] = $isActive;

        if (!empty($filters['orderBy'])) {
            // Ensure that the value is either ASC or DESC
            if ($filters['orderBy'] === "ASC" || $filters['orderBy'] === "DESC") {
                $sql .= " ORDER BY fr.fuel_date " . $filters['orderBy'];
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFilterChart($filters, $companyId) {
        $isActive = true;
        $sql = "SELECT fr.fuel_date AS 'date',
                fr.fuel_cost AS 'value'
                FROM bms_fuel_reports fr
                INNER JOIN bms_bus b ON fr.bus_id = b.id
                WHERE 1=1 ";
                //company_id = :companyId AND is_active = :isActive
        $params = [];

        if (!empty($filters['fromDate'])) {
            $sql .= "AND fr.fuel_date >= :fromDate ";
            $params[':fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= "AND fr.fuel_date <= :toDate ";
            $params[':toDate'] = $filters['toDate'];
        }

        if (!empty($filters['bus'])) {
            $sql .= "AND fr.bus_id = :bus ";
            $params[':bus'] = $filters['bus'];
        }

        if (!empty($filters['fuelType'])) {
            $sql .= "AND b.fuel_type_id = :fuelType ";
            $params[':fuelType'] = $filters['fuelType'];
        }

        if (!empty($filters['costFrom'])) {
            $sql .= "AND fr.fuel_cost >= :costFrom ";
            $params[':costFrom'] = $filters['costFrom'];
        }

        if (!empty($filters['costTo'])) {
            $sql .= "AND fr.fuel_cost <= :costTo ";
            $params[':costTo'] = $filters['costTo'];
        }

        $sql .= "AND fr.company_id = :companyId ";
        $params[':companyId'] = $companyId;

        $sql .= "AND fr.is_active = :isActive";
        $params[':isActive'] = $isActive;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
}