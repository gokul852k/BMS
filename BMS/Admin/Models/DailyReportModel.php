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
                                    dr.report_id AS 'reportId',
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

    public function updateShift($shiftId, $shiftKM, $shiftAvgMilage, $shiftPassengers, $shiftCollection, $shiftSalary, $shiftCommission, $otherExpence, $fuelUsage, $shiftFuelAmount) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `total_km` = :shiftKM, `avg_milage` = :shiftAvgMilage, `total_passenger` = :shiftPassengers, `total_collection` = :shiftCollection, `salary` = :shiftSalary, `commission` = :shiftCommission, `expence` = :otherExpence,`fuel_usage` = :fuelUsage, `fuel_amount` = :shiftFuelAmount, `shift_status` = :status WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftKM", $shiftKM);
        $stmt->bindParam(":shiftAvgMilage", $shiftAvgMilage);
        $stmt->bindParam(":shiftPassengers", $shiftPassengers);
        $stmt->bindParam(":shiftCollection", $shiftCollection);
        $stmt->bindParam(":shiftSalary", $shiftSalary);
        $stmt->bindParam(":shiftCommission", $shiftCommission);
        $stmt->bindParam(":otherExpence", $otherExpence);
        $stmt->bindParam(":fuelUsage", $fuelUsage);
        $stmt->bindParam(":shiftFuelAmount", $shiftFuelAmount);
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

    //Edit Daily Report
    public function getDailyReport2($reportId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT dr.report_id, dr.company_id, dr.bus_id, b.bus_number, dr.date, DATE_FORMAT(dr.date, '%d-%m-%Y') AS 'format_date', dr.total_km, dr.total_passenger, dr.fuel, dr.avg_milage, dr.total_collection, dr.fuel_amount, dr.fuel_usage, dr.expenses, dr.salary, dr.commission FROM bms_daily_reports dr
                            INNER JOIN bms_bus b ON dr.bus_id = b.id
                            WHERE dr.report_id = :reportId AND dr.is_active = :isActive");
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getShift($reportId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `shift_id`, `company_id`, `report_id`, `shift_name_id`, `start_date`, `start_time`, `end_date`, `end_time`, `total_km`, `avg_milage`, `total_passenger`, `total_collection`, `salary`, `commission`, `expence`, `fuel_usage`, `fuel_amount` FROM `bms_shifts` WHERE `report_id` = :reportId AND `is_active` = :isActive");
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTrips($shiftId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `trip_id`, `company_id`, `shift_id`, `start_route_id`, `end_route_id`, `start_time`, `end_time`, `start_km`, `end_km`, `passenger`, `collection_amount` FROM `bms_trips` WHERE `shift_id` = :shiftId AND `is_active` = :isActive");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTripDrivers($tripId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `trip_driver_id`, `company_id`, `trip_id`, `driver_id` FROM `bms_trip_drivers` WHERE `trip_id` = :tripId AND `is_active` = :isActive");
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTripConductors($tripId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `trip_conductor_id`, `company_id`, `trip_id`, `conductor_id` FROM `bms_trip_conductors` WHERE `trip_id` = :tripId AND `is_active` = :isActive");
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function deleteShift($shiftId) {
        $isActive = false;
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `is_active` = :isActive WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->bindParam(":isActive", $isActive);

        return $stmt->execute() ? true : false;
    }

    function deleteTrip($tripId) {
        $isActive = false;
        $stmt = $this->db->prepare("UPDATE `bms_trips` SET `is_active` = :isActive WHERE `trip_id` = :tripId");
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":isActive", $isActive);

        return $stmt->execute() ? true : false;
    }

    function deleteConductor($conductorId) {
        $isActive = false;
        $stmt = $this->db->prepare("UPDATE `bms_trip_conductors` SET `is_active` = :isActive WHERE `trip_conductor_id` = :conductorId");
        $stmt->bindParam(":conductorId", $conductorId);
        $stmt->bindParam(":isActive", $isActive);

        return $stmt->execute() ? true : false;
    }

    function updateShift2($shiftId, $companyId, $reportId, $shiftNameId, $shiftStartDate, $shiftEndDate, $shiftStartTime, $shiftEndTime) {
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `shift_name_id` = :shiftNameId, `start_date` = :shiftStartDate, `start_time` = :shiftStartTime, `end_date` = :shiftEndDate,`end_time` = :shiftEndTime WHERE `shift_id` = :shiftId");
        
        $stmt->bindParam(":shiftNameId", $shiftNameId);
        $stmt->bindParam(":shiftStartDate", $shiftStartDate);
        $stmt->bindParam(":shiftStartTime", $shiftStartTime);
        $stmt->bindParam(":shiftEndDate", $shiftEndDate);
        $stmt->bindParam(":shiftEndTime", $shiftEndTime);
        $stmt->bindParam(":shiftId", $shiftId);

        return $stmt->execute() ? true : false;
    }

    function updateTrip2($tripId, $companyId, $shiftId, $startRoute, $endRoute) {
        $stmt = $this->db->prepare("UPDATE `bms_trips` SET `start_route_id` = :startRoute, `end_route_id` = :endRoute WHERE `trip_id` = :tripId");
        
        $stmt->bindParam(":startRoute", $startRoute);
        $stmt->bindParam(":endRoute", $endRoute);
        $stmt->bindParam(":tripId", $tripId);

        return $stmt->execute() ? true : false;
    }

    function updateTripDriver2($tripDriverId, $companyId, $tripId, $driverId) {
        $stmt = $this->db->prepare("UPDATE `bms_trip_drivers` SET `trip_id` = :tripId, `driver_id` = :driverId WHERE `trip_driver_id` = :tripDriverId");
        
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":driverId", $driverId);
        $stmt->bindParam(":tripDriverId", $tripDriverId);

        return $stmt->execute() ? true : false;
    }

    function updateTripConductor2($tripConductorId, $companyId, $tripId, $conductorId) {
        $stmt = $this->db->prepare("UPDATE `bms_trip_conductors` SET `trip_id` = :tripId, `conductor_id` = :conductorId WHERE `trip_conductor_id` = :tripConductorId");
        
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":conductorId", $conductorId);
        $stmt->bindParam(":tripConductorId", $tripConductorId);

        return $stmt->execute() ? true : false;
    }

    function updateShiftDriver2($shiftId, $driverId, $shiftStartDate, $shiftStartTime, $shiftEndDate, $shiftEndTime, $shiftDriverSalary, $shiftWorkerCommission, $shiftFuelUsage) {
        $isActive = true;
        $stmt = $this->db->prepare("UPDATE `bms_shift_driver` SET `start_date` = :shiftStartDate, `start_time` = :shiftStartTime, `end_date` = :shiftEndDate, `end_time` = :shiftEndTime, `salary` = :shiftDriverSalary, `commission` = :shiftWorkerCommission, `fuel_usage` = :shiftFuelUsage WHERE `shift_id` = :shiftId AND `driver_id` = :driverId AND `is_active` = :isActive");
        
        $stmt->bindParam(":shiftStartDate", $shiftStartDate);
        $stmt->bindParam(":shiftStartTime", $shiftStartTime);
        $stmt->bindParam(":shiftEndDate", $shiftEndDate);
        $stmt->bindParam(":shiftEndTime", $shiftEndTime);
        $stmt->bindParam(":shiftDriverSalary", $shiftDriverSalary);
        $stmt->bindParam(":shiftWorkerCommission", $shiftWorkerCommission);
        $stmt->bindParam(":shiftFuelUsage", $shiftFuelUsage);
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->bindParam(":driverId", $driverId);
        $stmt->bindParam(":isActive", $isActive);

        return $stmt->execute() ? true : false;
    }

    function updateShiftConductor2($shiftId, $conductorId, $shiftStartDate, $shiftStartTime, $shiftEndDate, $shiftEndTime, $shiftConductorSalary, $shiftWorkerCommission) {
        $isActive = true;
        $stmt = $this->db->prepare("UPDATE `bms_shift_conductor` SET `start_date` = :shiftStartDate, `start_time` = :shiftStartTime, `end_date` = :shiftEndDate, `end_time` = :shiftEndTime, `salary` = :shiftConductorSalary, `commission` = :shiftWorkerCommission WHERE `shift_id` = :shiftId AND `conductor_id` = :conductorId AND `is_active` = :isActive");
        
        $stmt->bindParam(":shiftStartDate", $shiftStartDate);
        $stmt->bindParam(":shiftStartTime", $shiftStartTime);
        $stmt->bindParam(":shiftEndDate", $shiftEndDate);
        $stmt->bindParam(":shiftEndTime", $shiftEndTime);
        $stmt->bindParam(":shiftConductorSalary", $shiftConductorSalary);
        $stmt->bindParam(":shiftWorkerCommission", $shiftWorkerCommission);
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->bindParam(":conductorId", $conductorId);
        $stmt->bindParam(":isActive", $isActive);

        return $stmt->execute() ? true : false;
    }

    //View Daily Report
    public function getTrips2($shiftId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT t.trip_id, t.shift_id, r1.route_name AS 'start_route_name', r2.route_name AS 'end_route_name', t.start_time, t.end_time, t.start_km, t.end_km, t.passenger, t.collection_amount FROM bms_trips t
                                INNER JOIN bms_routes r1 ON t.start_route_id = r1.id
                                INNER JOIN bms_routes r2 ON t.end_route_id = r2.id
                                WHERE t.shift_id = :shiftId AND t.is_active = :isActive
                                ");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTripDrivers2($tripId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT td.trip_driver_id, td.driver_id, d.fullname FROM bms_trip_drivers td
                                    INNER JOIN bms_drivers d ON td.driver_id = d.id
                                    WHERE td.trip_id = :tripId AND td.is_active = :isActive");
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTripConductors2($tripId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT tc.trip_conductor_id, tc.conductor_id, c.fullname FROM `bms_trip_conductors` tc
                                    INNER JOIN bms_conductors c ON tc.conductor_id = c.id
                                    WHERE tc.trip_id = :tripId AND tc.is_active = :isActive");
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFilterCardCount($filters, $companyId) {
        $isActive = true;
        $sql = "SELECT 
                FORMAT(SUM(dr.total_km), 0) AS 'totalKm',
                FORMAT(SUM(dr.fuel_usage), 1) AS 'fuelUsage',
                FORMAT(AVG(dr.avg_milage), 1) AS 'avgMilage',
                FORMAT(SUM(dr.total_passenger), 0) AS 'passengers',
                FORMAT(SUM(dr.total_collection), 0) AS 'collection',
                FORMAT(SUM(dr.expenses), 0) AS 'expenses',
                FORMAT(SUM(dr.fuel_amount), 0) AS 'fuelAmount',
                FORMAT(SUM(dr.salary), 0) AS 'salary',
                FORMAT(SUM(dr.commission), 0) AS 'commission',
                FORMAT(SUM(dr.total_collection - dr.fuel_amount - dr.expenses - dr.salary - dr.commission), 0) AS 'profit'
                FROM `bms_daily_reports` dr
                INNER JOIN bms_bus b ON dr.bus_id = b.id
                WHERE 1=1 ";
                //company_id = :companyId AND is_active = :isActive
        $params = [];

        if (!empty($filters['fromDate'])) {
            $sql .= "AND dr.date >= :fromDate ";
            $params[':fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= "AND dr.date <= :toDate ";
            $params[':toDate'] = $filters['toDate'];
        }

        if (!empty($filters['bus'])) {
            $sql .= "AND dr.bus_id = :bus ";
            $params[':bus'] = $filters['bus'];
        }

        if (!empty($filters['collectionFrom'])) {
            $sql .= "AND dr.total_collection >= :collectionFrom ";
            $params[':collectionFrom'] = $filters['collectionFrom'];
        }

        if (!empty($filters['collectionTo'])) {
            $sql .= "AND dr.total_collection <= :collectionTo ";
            $params[':collectionTo'] = $filters['collectionTo'];
        }

        if (!empty($filters['profitFrom'])) {
            $sql .= "AND (dr.total_collection - dr.fuel_amount - dr.expenses - dr.salary - dr.commission) >= :profitFrom ";
            $params[':profitFrom'] = $filters['profitFrom'];
        }
    
        if (!empty($filters['profitTo'])) {
            $sql .= "AND (dr.total_collection - dr.fuel_amount - dr.expenses - dr.salary - dr.commission) <= :profitTo ";
            $params[':profitTo'] = $filters['profitTo'];
        }

        if (!empty($filters['kmFrom'])) {
            $sql .= "AND dr.total_km >= :kmFrom ";
            $params[':kmFrom'] = $filters['kmFrom'];
        }

        if (!empty($filters['kmTo'])) {
            $sql .= "AND dr.total_km <= :kmTo ";
            $params[':kmTo'] = $filters['kmTo'];
        }

        $sql .= "AND dr.company_id = :companyId ";
        $params[':companyId'] = $companyId;

        $sql .= "AND dr.is_active = :isActive";
        $params[':isActive'] = $isActive;

        if (!empty($filters['orderBy'])) {
            // Ensure that the value is either ASC or DESC
            if ($filters['orderBy'] === "ASC" || $filters['orderBy'] === "DESC") {
                $sql .= " ORDER BY dr.date " . $filters['orderBy'];
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    function getFilterFuelReport($filters, $companyId) {
        $isActive = true;
        $sql = "SELECT 
                dr.report_id AS 'reportId',
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
                WHERE 1=1 ";
                //company_id = :companyId AND is_active = :isActive
        $params = [];

        if (!empty($filters['fromDate'])) {
            $sql .= "AND dr.date >= :fromDate ";
            $params[':fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= "AND dr.date <= :toDate ";
            $params[':toDate'] = $filters['toDate'];
        }

        if (!empty($filters['bus'])) {
            $sql .= "AND dr.bus_id = :bus ";
            $params[':bus'] = $filters['bus'];
        }

        if (!empty($filters['collectionFrom'])) {
            $sql .= "AND dr.total_collection >= :collectionFrom ";
            $params[':collectionFrom'] = $filters['collectionFrom'];
        }

        if (!empty($filters['collectionTo'])) {
            $sql .= "AND dr.total_collection <= :collectionTo ";
            $params[':collectionTo'] = $filters['collectionTo'];
        }

        if (!empty($filters['profitFrom'])) {
            $sql .= "AND (dr.total_collection - dr.fuel_amount - dr.expenses - dr.salary - dr.commission) >= :profitFrom ";
            $params[':profitFrom'] = $filters['profitFrom'];
        }
    
        if (!empty($filters['profitTo'])) {
            $sql .= "AND (dr.total_collection - dr.fuel_amount - dr.expenses - dr.salary - dr.commission) <= :profitTo ";
            $params[':profitTo'] = $filters['profitTo'];
        }

        if (!empty($filters['kmFrom'])) {
            $sql .= "AND dr.total_km >= :kmFrom ";
            $params[':kmFrom'] = $filters['kmFrom'];
        }

        if (!empty($filters['kmTo'])) {
            $sql .= "AND dr.total_km <= :kmTo ";
            $params[':kmTo'] = $filters['kmTo'];
        }

        $sql .= "AND dr.company_id = :companyId ";
        $params[':companyId'] = $companyId;

        $sql .= "AND dr.is_active = :isActive";
        $params[':isActive'] = $isActive;

        if (!empty($filters['orderBy'])) {
            // Ensure that the value is either ASC or DESC
            if ($filters['orderBy'] === "ASC" || $filters['orderBy'] === "DESC") {
                $sql .= " ORDER BY dr.date " . $filters['orderBy'];
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
}