<?php

class DailyReportModel {
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
                                    dr.fuel_usage AS 'fuelUsage',
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
                                    WHERE dr.company_id = :companyId AND dr.is_active = :isActive ORDER BY dr.report_id DESC
                                    ");
        $stmt->bindParam(":companyId", $companyId);
        // $stmt->bindParam(":currentDate", $currentDate);
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


    //-----Add Daily Report Functions Start-----//

    public function getDailyReport($busId, $date, $companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `report_id` FROM `bms_daily_reports` WHERE `bus_id` = :busId AND `date` = :date AND `company_id` = :companyId AND `is_active` = :isActive");
        $stmt->bindParam("busId", $busId);
        $stmt->bindParam("date", $date);
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setDailyReport($companyId, $busId, $currentDate) {
        $stmt = $this->db->prepare("INSERT INTO `bms_daily_reports` (`company_id`, `bus_id`, `date`) VALUES (:companyId, :busId, :currentDate)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("busId", $busId);
        $stmt->bindParam("currentDate", $currentDate);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Get the last inserted ID
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'reportId' => $lastId
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

    public function setShift($companyId, $reportId, $shiftNameId, $shiftStartDate, $shiftEndDate, $shiftStartTime, $shiftEndTime) {

        $stmt = $this->db->prepare("INSERT INTO `bms_shifts` (`company_id`, `report_id`, `shift_name_id`, `start_date`, `start_time`, `end_date`, `end_time`) VALUES (:companyId, :reportId, :shiftNameId, :shiftStartDate, :shiftStartTime, :shiftEndDate, :shiftEndTime)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("shiftNameId", $shiftNameId);
        $stmt->bindParam("shiftStartDate", $shiftStartDate);
        $stmt->bindParam("shiftEndDate", $shiftEndDate);
        $stmt->bindParam("shiftStartTime", $shiftStartTime);
        $stmt->bindParam("shiftEndTime", $shiftEndTime);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                // Get the last inserted ID
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'shiftId' => $lastId
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

    public function setTrip($companyId, $shiftId, $startRoute, $endRoute) {
        $stmt = $this->db->prepare("INSERT INTO `bms_trips`(`company_id`, `shift_id`, `start_route_id`, `end_route_id`) VALUES (:companyId, :shiftId, :startRoute, :endRoute)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("startRoute", $startRoute);
        $stmt->bindParam("endRoute", $endRoute);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'tripId' => $lastId
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

    public function setTripDriver($companyId, $tripId, $driverId) {
        $status = false;
        $stmt = $this->db->prepare("INSERT INTO `bms_trip_drivers`(`company_id`, `trip_id`, `driver_id`, `trip_driver_status`) VALUES (:companyId, :tripId, :driverId, :status)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("status", $status);

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

    public function setTripConductor($companyId, $tripId, $conductorId) {
        $status = false;
        $stmt = $this->db->prepare("INSERT INTO `bms_trip_conductors`(`company_id`, `trip_id`, `conductor_id`, `trip_conductor_status`) VALUES (:companyId, :tripId, :conductorId, :status)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("status", $status);

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

    public function updateTrip($tripId, $tripStartTime, $tripEndTime, $tripStartKM, $tripEndKM, $tripPassenger, $tripcollection) {
        $status = true;
        $stmt = $this->db->prepare("UPDATE `bms_trips` SET `start_time` = :tripStartTime, `end_time` = :tripEndTime, `start_km` = :tripStartKM, `end_km` = :tripEndKM, `passenger` = :tripPassenger, `collection_amount` = :tripcollection, `trip_status` = :status WHERE `trip_id` = :tripId");
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":tripStartTime", $tripStartTime);
        $stmt->bindParam(":tripEndTime", $tripEndTime);
        $stmt->bindParam(":tripStartKM", $tripStartKM);
        $stmt->bindParam(":tripEndKM", $tripEndKM);
        $stmt->bindParam(":tripPassenger", $tripPassenger);
        $stmt->bindParam(":tripcollection", $tripcollection);
        $stmt->bindParam(":status", $status);

        return $stmt->execute() ? true : false;
    }

    public function getCommissionDetails($collections, $companyId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `commission_id`, `amount_per_commission`, `commission_amount` 
                                    FROM bms_commission
                                    WHERE :collections BETWEEN collection_range_from AND collection_range_to AND company_id = :companyId AND is_active = :isActive ORDER BY `commission_id` DESC LIMIT 1;
                                    ");
        $stmt->bindParam("collections", $collections);
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getSalary($busId) {
        $stmt = $this->db->prepare("SELECT b.driver_salary, b.conductor_salary, b.bus_number FROM bms_bus b WHERE b.id = :busId");
        $stmt->bindParam("busId", $busId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateShift($shiftId, $shiftKM, $shiftPassengers, $shiftCollection, $shiftSalary, $shiftCommission, $otherExpence, $fuelUsage) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `total_km` = :shiftKM, `total_passenger` = :shiftPassengers, `total_collection` = :shiftCollection, `salary` = :shiftSalary, `commission` = :shiftCommission, `expence` = :otherExpence,`fuel_usage` = :fuelUsage, `shift_status` = :status WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftKM", $shiftKM);
        $stmt->bindParam(":shiftPassengers", $shiftPassengers);
        $stmt->bindParam(":shiftCollection", $shiftCollection);
        $stmt->bindParam(":shiftSalary", $shiftSalary);
        $stmt->bindParam(":shiftCommission", $shiftCommission);
        $stmt->bindParam(":otherExpence", $otherExpence);
        $stmt->bindParam(":fuelUsage", $fuelUsage);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":shiftId", $shiftId);

        return $stmt->execute() ? true : false;
    }

    public function setShiftDriver($companyId, $shiftId, $driver, $shiftStartDate, $shiftStartTime, $shiftEndDate, $shiftEndTime, $shiftDriverSalary, $shiftWorkerCommission, $shiftFuelUsage) {
        $status = false;
        $stmt = $this->db->prepare("INSERT INTO `bms_shift_driver`(`company_id`, `shift_id`, `driver_id`, `start_date`, `start_time`, `end_date`, `end_time`, `salary`, `commission`, `fuel_usage`, `work_status`) VALUES (:companyId, :shiftId, :driver, :shiftStartDate, :shiftStartTime, :shiftEndDate, :shiftEndTime, :shiftDriverSalary, :shiftWorkerCommission, :shiftFuelUsage, :status)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("driver", $driver);
        $stmt->bindParam("shiftStartDate", $shiftStartDate); 
        $stmt->bindParam("shiftStartTime", $shiftStartTime);
        $stmt->bindParam("shiftEndDate", $shiftEndDate);
        $stmt->bindParam("shiftEndTime", $shiftEndTime);
        $stmt->bindParam("shiftDriverSalary", $shiftDriverSalary); 
        $stmt->bindParam("shiftWorkerCommission", $shiftWorkerCommission);
        $stmt->bindParam("shiftFuelUsage", $shiftFuelUsage);
        $stmt->bindParam("status", $status); 

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

    public function setShiftConductor($companyId, $shiftId, $conductor, $shiftStartDate, $shiftStartTime, $shiftEndDate, $shiftEndTime, $shiftConductorSalary, $shiftWorkerCommission) {
        $status = false;
        $stmt = $this->db->prepare("INSERT INTO `bms_shift_conductor`(`company_id`, `shift_id`, `conductor_id`, `start_date`, `start_time`, `end_date`, `end_time`, `salary`, `commission`, `work_status`) VALUES (:companyId, :shiftId, :conductor, :shiftStartDate, :shiftStartTime, :shiftEndDate, :shiftEndTime, :shiftConductorSalary, :shiftWorkerCommission, :status)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("conductor", $conductor);
        $stmt->bindParam("shiftStartDate", $shiftStartDate); 
        $stmt->bindParam("shiftStartTime", $shiftStartTime);
        $stmt->bindParam("shiftEndDate", $shiftEndDate);
        $stmt->bindParam("shiftEndTime", $shiftEndTime);
        $stmt->bindParam("shiftConductorSalary", $shiftConductorSalary); 
        $stmt->bindParam("shiftWorkerCommission", $shiftWorkerCommission);
        $stmt->bindParam("status", $status); 

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

    public function getFuelAmount($date) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `fuel_quantity`, `fuel_cost` FROM `bms_fuel_reports` WHERE `fuel_date` = :date AND `is_active` = :isActive");
        $stmt->bindParam("date", $date);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getFuelAmount2($fromDate, $toDate) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `fuel_quantity`, `fuel_cost` FROM `bms_fuel_reports` WHERE `fuel_date` >= :fromDate AND `fuel_date` <= :toDate AND `is_active` = :isActive ORDER BY `fuel_report_id` DESC");
        $stmt->bindParam("fromDate", $fromDate);
        $stmt->bindParam("toDate", $toDate);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateDailyReport($reportId, $dailyKM, $dailypassengers, $dailyAvgMilage, $dailyCollection, $dailyFuelAmount, $dailyFuelUsage, $dailyExpense, $dailySalary, $dailyCommission) {
        $stmt = $this->db->prepare("UPDATE `bms_daily_reports` SET `total_km` = :dailyKM, `total_passenger` = :dailypassengers, `avg_milage` = :dailyAvgMilage, `total_collection` = :dailyCollection, `fuel_amount` = :dailyFuelAmount, `fuel_usage` = :dailyFuelUsage, `expenses` = :dailyExpense, `salary` = :dailySalary, `commission` = :dailyCommission WHERE `report_id` = :reportId");
        $stmt->bindParam(":dailyKM", $dailyKM);
        $stmt->bindParam(":dailypassengers", $dailypassengers);
        $stmt->bindParam(":dailyAvgMilage", $dailyAvgMilage);
        $stmt->bindParam(":dailyCollection", $dailyCollection);
        $stmt->bindParam(":dailyFuelAmount", $dailyFuelAmount);
        $stmt->bindParam(":dailyFuelUsage", $dailyFuelUsage);
        $stmt->bindParam(":dailyExpense", $dailyExpense);
        $stmt->bindParam(":dailySalary", $dailySalary);
        $stmt->bindParam(":dailyCommission", $dailyCommission);
        $stmt->bindParam(":reportId", $reportId);

        return $stmt->execute() ? true : false;
    }
}