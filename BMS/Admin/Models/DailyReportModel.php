<?php

class BusModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getBusCardDetails($companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT
                                    (SELECT COUNT(*) FROM bms_bus WHERE company_id=:companyId AND is_active=:isActive) AS 'total_bus',
                                    (SELECT SUM(total_km) FROM bms_bus_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'total_km',
                                    (SELECT AVG(avg_mileage) FROM bms_bus_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'avg_mileage',
                                    (SELECT AVG(cost_per_km) FROM bms_bus_summary WHERE company_id=:companyId AND is_active=:isActive) AS 'cost_per_km',
                                    (SELECT COUNT(*) FROM bms_drivers WHERE licence_expiry<CURRENT_DATE() AND company_id=:companyId AND is_active=:isActive) AS 'expired_licenses'
                                ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDailyReports($companyId, $currentDate) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT 
                                    DATE_FORMAT(dr.date, '%d-%m-%Y') AS 'date',
                                    b.bus_number AS 'busNumber',
                                    dr.total_km AS 'km',
                                    dr.fuel AS 'fuel',
                                    dr.avg_milage AS 'avgMilage',
                                    dr.total_passenger AS 'passenger',
                                    dr.total_collection AS 'collection',
                                    dr.expenses AS 'expenses',
                                    dr.fuel_amount AS 'fuelAmount',
                                    dr.salary AS 'salary',
                                    dr.commission AS 'commission',
                                    (dr.total_collection - dr.fuel_amount - dr.expenses - dr.salary - dr.commission) AS 'profit'
                                    FROM `bms_daily_reports` dr
                                    INNER JOIN bms_bus b ON dr.bus_id = b.id
                                    WHERE dr.company_id = :companyId AND dr.date = :currentDate AND dr.is_active = :isActive
                                    ");
        $stmt->bindParam(":companyId", $companyId);
        $stmt->bindParam(":currentDate", $currentDate);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getBus($busId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT * FROM bms_bus WHERE id=:busId AND is_active=:isActive");
        $stmt->bindParam(":busId", $busId);
        $stmt->bindParam(":isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
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

    function deleteBus($busId) {
        $stmt = $this->db->prepare("DELETE FROM `bms_bus` WHERE `id`=:busId");
        $stmt->bindParam("busId", $busId);
        return $stmt->execute();
    }
}