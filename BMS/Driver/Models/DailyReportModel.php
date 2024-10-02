<?php

class DailyReportModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTranslationsLabels($pageId, $languageCode) {
        $stmt = $this->db->prepare("SELECT lt.translation FROM `bms_pages` p INNER JOIN bms_labels l ON l.page_id = p.page_id INNER JOIN bms_label_translations lt ON lt.label_id = l.label_id INNER JOIN bms_languages la ON la.id = lt.language_id WHERE p.page_id = :pageId AND la.code = :languageCode ORDER BY lt.translation_id ASC");
        $stmt->bindParam("pageId", $pageId);
        $stmt->bindParam("languageCode", $languageCode);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    public function checkDateAndBusId($busId, $currentDate) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `report_id` FROM `bms_daily_reports` WHERE `date` = :currentDate AND `bus_id` = :busId AND `is_active` = :isActive");
        $stmt->bindParam("currentDate", $currentDate);
        $stmt->bindParam("busId", $busId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function checkShiftStatus($reportId) {
        $shiftSatatus = true;
        $stmt = $this->db->prepare("SELECT `shift_id` FROM `bms_shifts` WHERE `report_id` = :reportId AND `shift_status` = :shiftSatatus");
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("shiftSatatus", $shiftSatatus);
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

    public function setShift($companyId, $reportId, $shiftNameId, $currentDate, $currentTime) {

        $stmt = $this->db->prepare("INSERT INTO `bms_shifts` (`company_id`, `report_id`, `shift_name_id`, `start_date`, `start_time`) VALUES (:companyId, :reportId, :shiftNameId, :currentDate, :currentTime)");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("reportId", $reportId);
        $stmt->bindParam("shiftNameId", $shiftNameId);
        $stmt->bindParam("currentDate", $currentDate);
        $stmt->bindParam("currentTime", $currentTime);

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

    public function checkDriverShift($shiftId, $driverId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `shift_driver_id` FROM `bms_shift_driver` WHERE `shift_id` = :shiftId AND `driver_id` = :driverId AND `is_active` = :isActive");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setShiftWorker($companyId, $driverId, $shiftId, $currentDate, $currentTime) {
        $stmt = $this->db->prepare("INSERT INTO `bms_shift_driver`(`company_id`, `shift_id`, `driver_id`, `start_date`, `start_time`) VALUES (:companyId, :shiftId, :driverId, :currentDate, :currentTime)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("currentDate", $currentDate);
        $stmt->bindParam("currentTime", $currentTime); 

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

    public function checkDriverShiftByDriverId($driverId) {
        $status = true;
        $stmt = $this->db->prepare("SELECT `shift_driver_id` FROM `bms_shift_driver` WHERE `driver_id` = :driverId AND `work_status` = :status");
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("status", $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getShiftIdByUserId($driverId) {
        $status = true;
        $stmt = $this->db->prepare("SELECT shift_id FROM `bms_shift_driver` WHERE `driver_id` = :driverId AND `work_status` = :status ORDER BY shift_driver_id ASC LIMIT 1");
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("status", $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDisplayTrip($driverId, $shiftId) {
        $status = true;
        $stmt = $this->db->prepare("SELECT td.trip_driver_id, td.trip_id FROM bms_trip_drivers td
                                    INNER JOIN bms_trips t ON td.trip_id = t.trip_id
                                    WHERE t.shift_id = :shiftId AND td.driver_id = :driverId AND td.trip_driver_status = :status
                                    ORDER BY td.trip_driver_id ASC LIMIT 1");
        
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("status", $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDisplayStartTrip($tripId) {
        $status = true;
        $startKm = 0;
        $stmt = $this->db->prepare("SELECT trip_id FROM `bms_trips` WHERE trip_id = :tripId AND trip_status = :status AND start_km = :startKm ORDER BY trip_id ASC LIMIT 1");
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("status", $status);
        $stmt->bindParam("startKm", $startKm);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
    public function getTripDetails($tripId, $languageCode) {
        $stmt = $this->db->prepare("SELECT rt1.route_id AS 'startRouteId', rt1.route_name AS 'startRouteName', rt2.route_id AS 'endRouteId', rt2.route_name AS 'endRouteName' FROM `bms_trips` t
                                    INNER JOIN bms_routes r1 ON r1.id = t.start_route_id
                                    INNER JOIN bms_route_translations rt1 ON rt1.route_id = r1.id
                                    INNER JOIN bms_languages l1 ON l1.id = rt1.language_id
                                    INNER JOIN bms_routes r2 ON r2.id = t.end_route_id
                                    INNER JOIN bms_route_translations rt2 ON rt2.route_id = r2.id
                                    INNER JOIN bms_languages l2 ON l2.id = rt2.language_id
                                    WHERE t.trip_id = :tripId AND l1.code = :languageCode AND l2.code = :languageCode LIMIT 1");
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("languageCode", $languageCode);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateRoute($routeId, $route) {
        $stmt = $this->db->prepare("UPDATE `bms_routes` SET `route_name` = :route WHERE `id` = :routeId");
        $stmt->bindParam(":route", $route);
        $stmt->bindParam(":routeId", $routeId);

        return $stmt->execute() ? true : false;
    }

    public function getRoutes($companyId, $languageCode) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT r.id AS 'routeId', rt.route_name AS 'routeName' FROM bms_routes r
                                    INNER JOIN bms_route_translations rt ON rt.route_id = r.id
                                    INNER JOIN bms_languages l ON l.id = rt.language_id
                                    WHERE r.company_id = :companyId AND l.code = :languageCode AND r.is_active = :isActive
                                    ");
        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("languageCode", $languageCode);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getShiftIdByDriverId($driverId) {
        $workStatus = true;
        $isActive = true;
        // $stmt = $this->db->prepare("SELECT shift_id AS 'shiftId' FROM `bms_shift_driver` WHERE `driver_id` = :driverId AND `work_status` = :workStatus AND `is_active` = :isActive");
        $stmt = $this->db->prepare("SELECT sd.shift_id AS 'shiftId', s.start_date, dr.bus_id FROM bms_shift_driver sd
                                    INNER JOIN bms_shifts s ON sd.shift_id = s.shift_id
                                    INNER JOIN bms_daily_reports dr ON s.report_id = dr.report_id
                                    WHERE   sd.driver_id = :driverId AND sd.work_status = :workStatus AND sd.is_active = :isActive");
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function createTrip($companyId, $shiftId, $startRoute, $endRoute, $startKm) {
        $stmt = $this->db->prepare("INSERT INTO `bms_trips`(`company_id`, `shift_id`, `start_route_id`, `end_route_id`, `start_km`) VALUES (:companyId, :shiftId, :startRoute, :endRoute, :startKm)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("startRoute", $startRoute);
        $stmt->bindParam("endRoute", $endRoute);
        $stmt->bindParam("startKm", $startKm);

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

    public function createTripDriver($companyId, $tripId, $driverId) {
        $stmt = $this->db->prepare("INSERT INTO `bms_trip_drivers`(`company_id`, `trip_id`, `driver_id`) VALUES (:companyId, :tripId, :driverId)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("driverId", $driverId);

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

    public function updateTripStartKm($tripId, $startKm) {
        $stmt = $this->db->prepare("UPDATE `bms_trips` SET `start_km`=:startKm WHERE `trip_id` = :tripId");
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":startKm", $startKm);

        return $stmt->execute() ? true : false;
    }
    public function updateEndTrip($tripId, $endKm) {
        $stmt = $this->db->prepare("UPDATE `bms_trips` SET `end_km`=:endKm WHERE `trip_id` = :tripId");
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":endKm", $endKm);

        return $stmt->execute() ? true : false;
    }

    public function updateTripDriverStatus($tripDriverId) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_trip_drivers` SET `trip_driver_status`= :status WHERE `trip_driver_id` = :tripDriverId");
        $stmt->bindParam(":tripDriverId", $tripDriverId);
        $stmt->bindParam(":status", $status);

        return $stmt->execute() ? true : false;
    }

    public function checkTripStatus($tripId) {
        $status = true;
        // $isActive = true;
        // $passenger = 0;
        // $collectionAmount = 0;
        $stmt = $this->db->prepare("SELECT shift_id , trip_id, start_km, passenger, collection_amount FROM `bms_trips` WHERE `trip_id` = :tripId AND `trip_status` = :status");
        // $stmt = $this->db->prepare("SELECT trip_id FROM `bms_trips` WHERE `trip_id` = :tripId AND `trip_status` = :status AND (`passenger` = :passenger OR `collection_amount` = :collectionAmount) AND `is_active` = :isActive");
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("status", $status);
        // $stmt->bindParam("passenger", $passenger);
        // $stmt->bindParam("collectionAmount", $collectionAmount);
        // $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateTripStatus($tripId) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_trips` SET `trip_status`=:status WHERE `trip_id` = :tripId");
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":status", $status);

        return $stmt->execute() ? true : false;
    }

    public function getShiftId($tripId) {
        $stmt = $this->db->prepare("SELECT `shift_id` FROM `bms_trips` WHERE `trip_id` = :tripId");
        $stmt->bindParam("tripId", $tripId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateDriverWorkDetails($shiftId, $salary, $commission, $fuelUsage) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_shift_driver` SET `salary`= :salary, `commission`= :commission, `fuel_usage` = :fuelUsage, `work_status` = :status WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":salary", $salary);
        $stmt->bindParam(":commission", $commission);
        $stmt->bindParam(":fuelUsage", $fuelUsage);
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->bindParam(":status", $status);

        return $stmt->execute() ? true : false;
    }

    public function updateShiftDetails($shiftId, $salary, $fuelUsage, $fuelAmount) {
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `salary` = `salary` + :salary, `fuel_usage` = `fuel_usage` + :fuelUsage, `fuel_amount` = `fuel_amount` + :fuelAmount WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":salary", $salary);
        $stmt->bindParam(":fuelUsage", $fuelUsage);
        $stmt->bindParam(":fuelAmount", $fuelAmount);
        $stmt->bindParam(":shiftId", $shiftId);

        return $stmt->execute() ? true : false;
    }

    public function updateShiftStatus($shiftId) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `shift_status` = :status WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->bindParam(":status", $status);

        return $stmt->execute() ? true : false;

    }

    public function getShiftDetails($shiftId) {
        $stmt = $this->db->prepare("SELECT `start_date`, `report_id`, `salary`, `commission`, `expence`, `fuel_usage` FROM `bms_shifts` WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateDailyReportSCEM($reportId, $salary, $commission, $expence, $fuelusage, $avgMilage, $fuelAmount) {
        $stmt = $this->db->prepare("UPDATE `bms_daily_reports` SET `expenses` = `expenses` + :expence, `salary` = `salary` + :salary, `commission` = `commission` + :commission, `fuel_usage` = `fuel_usage` + :fuelusage, `avg_milage` = :avgMilage, `fuel_amount` = `fuel_amount` + :fuelAmount WHERE `report_id` = :reportId");
        $stmt->bindParam(":salary", $salary);
        $stmt->bindParam(":commission", $commission);
        $stmt->bindParam(":expence", $expence);
        $stmt->bindParam(":fuelusage", $fuelusage);
        $stmt->bindParam(":avgMilage", $avgMilage);
        $stmt->bindParam(":fuelAmount", $fuelAmount);
        $stmt->bindParam(":reportId", $reportId);

        return $stmt->execute() ? true : false;
    }

    public function updateKmInShift($shiftId, $totalKm) {
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `total_km` = `total_km` + :totalKm WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":totalKm", $totalKm);
        $stmt->bindParam(":shiftId", $shiftId);

        return $stmt->execute() ? true : false;

    }

    public function getDailyReport($shiftId) {
        $stmt = $this->db->prepare("SELECT `report_id` FROM `bms_shifts` WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDailyReportDetails($reportId) {
        $stmt = $this->db->prepare("SELECT `total_km`, `fuel_usage`, `avg_milage`, `fuel_amount` FROM `bms_daily_reports` WHERE `report_id` = :reportId");
        $stmt->bindParam(":reportId", $reportId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateKmInDailyReport($reportId, $totalKm) {
        $stmt = $this->db->prepare("UPDATE `bms_daily_reports` SET `total_km` = `total_km` + :totalKm WHERE `report_id` = :reportId");
        $stmt->bindParam(":totalKm", $totalKm);
        $stmt->bindParam(":reportId", $reportId);

        return $stmt->execute() ? true : false;
    }

    public function getConductorByShifId($shiftId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_shift_conductor` WHERE `shift_id` = :shiftId AND `work_status` = :workStatus");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function createTripConductor($companyId, $tripId, $conductorId) {
        $stmt = $this->db->prepare("INSERT INTO `bms_trip_conductors`(`company_id`, `trip_id`, `conductor_id`) VALUES (:companyId, :tripId, :conductorId)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("conductorId", $conductorId);

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

    public function getDriverByShifId($shiftId, $driverId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_shift_driver` WHERE `shift_id` = :shiftId AND `work_status` = :workStatus AND `driver_id` != :driverId");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->bindParam("driverId", $driverId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function checkConductorsStatus($shiftId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_shift_conductor` WHERE `shift_id` = :shiftId AND `work_status` = :workStatus");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function checkDriversStatus($shiftId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_shift_driver` WHERE `shift_id` = :shiftId AND `work_status` = :workStatus");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTripByShiftId($shiftId) {
        $stmt = $this->db->prepare("SELECT `trip_id` FROM `bms_trips` WHERE `shift_id` = :shiftId");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTripsDetails($driverId, $languageCode) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT 
                                        t.start_route_id AS 'startRouteId', 
                                        srt.route_name AS 'startRouteName', 
                                        t.end_route_id AS 'endRouteId', 
                                        ert.route_name AS 'endRouteName',
                                        t.end_km - t.start_km AS 'km'
                                    FROM 
                                        bms_shift_driver sd
                                    INNER JOIN 
                                        bms_trips t ON sd.shift_id = t.shift_id
                                    INNER JOIN 
                                        bms_route_translations srt ON t.start_route_id = srt.route_id
                                    INNER JOIN 
                                        bms_route_translations ert ON t.end_route_id = ert.route_id
                                    INNER JOIN 
                                        bms_languages l ON srt.language_id = l.id AND ert.language_id = l.id
                                    WHERE 
                                        sd.driver_id = :driverId
                                        AND sd.work_status = :workStatus 
                                        AND l.code = :languageCode;
                                  ");
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->bindParam("languageCode", $languageCode);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTripsDetailsCardCount($driverId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT s.total_km AS 'km', s.total_passenger AS 'passengers', s.total_collection AS 'collections', (SELECT COUNT(*) FROM bms_trips WHERE shift_id = s.shift_id) AS 'trips' FROM bms_shift_driver sd
                                    INNER JOIN bms_shifts s ON sd.shift_id = s.shift_id
                                    WHERE sd.driver_id = :driverId AND sd.work_status = :workStatus
                                    ");
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getSalary($driverId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT sd.shift_id, b.driver_salary, b.bus_number FROM bms_shift_driver sd
                                    INNER JOIN bms_shifts s ON sd.shift_id = s.shift_id
                                    INNER JOIN bms_daily_reports r ON s.report_id = r.report_id
                                    INNER JOIN bms_bus b ON r.bus_id = b.id
                                    WHERE sd.driver_id = :driverId AND sd.work_status = :workStatus
                                    ");
        $stmt->bindParam("driverId", $driverId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
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

    public function getWorkersInShift($shiftId) {
        $stmt = $this->db->prepare("SELECT (SELECT COUNT(*) FROM bms_shift_conductor WHERE shift_id = :shiftId) AS 'conductors', (SELECT COUNT(*) FROM bms_shift_driver WHERE shift_id = :shiftId) AS 'drivers'");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getEndKm($tripId) {
        $stmt = $this->db->prepare("SELECT `start_km` FROM `bms_trips` WHERE `trip_id` = :tripId");
        $stmt->bindParam("tripId", $tripId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }


    public function getFuelAmount($date, $busId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `fuel_quantity`, `fuel_cost` FROM `bms_fuel_reports` WHERE `fuel_date` = :date AND `bus_id` = :busId AND `is_active` = :isActive");
        $stmt->bindParam("date", $date);
        $stmt->bindParam("busId", $busId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getFuelAmount2($fromDate, $toDate, $busId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `fuel_quantity`, `fuel_cost` FROM `bms_fuel_reports` WHERE `fuel_date` >= :fromDate AND `fuel_date` <= :toDate AND `bus_id` = :busId AND `is_active` = :isActive ORDER BY `fuel_report_id` DESC");
        $stmt->bindParam("fromDate", $fromDate);
        $stmt->bindParam("toDate", $toDate);
        $stmt->bindParam("busId", $busId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }
}