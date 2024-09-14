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

    public function checkConductorShift($shiftId, $conductorId) {
        $isActive = true;
        $stmt = $this->db->prepare("SELECT `shift_conductor_id` FROM `bms_shift_conductor` WHERE `shift_id` = :shiftId AND `conductor_id` = :conductorId AND `is_active` = :isActive");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function setShiftWorker($companyId, $conductorId, $shiftId, $currentDate, $currentTime) {
        $stmt = $this->db->prepare("INSERT INTO `bms_shift_conductor`(`company_id`, `shift_id`, `conductor_id`, `start_date`, `start_time`) VALUES (:companyId, :shiftId, :conductorId, :currentDate, :currentTime)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("conductorId", $conductorId);
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

    public function checkDriverShiftByConductorId($conductorId) {
        $status = true;
        $stmt = $this->db->prepare("SELECT `shift_conductor_id` FROM `bms_shift_conductor` WHERE `conductor_id` = :conductorId AND `work_status` = :status");
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("status", $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getShiftIdByUserId($conductorId) {
        $status = true;
        $stmt = $this->db->prepare("SELECT shift_id FROM `bms_shift_conductor` WHERE `conductor_id` = :conductorId AND `work_status` = :status ORDER BY shift_conductor_id ASC LIMIT 1");
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("status", $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDisplayTrip($conductorId, $shiftId) {
        $status = true;
        $stmt = $this->db->prepare("SELECT tc.trip_conductor_id, tc.trip_id FROM bms_trip_conductors tc
                                    INNER JOIN bms_trips t ON tc.trip_id = t.trip_id
                                    WHERE t.shift_id = :shiftId AND tc.conductor_id = :conductorId AND tc.trip_conductor_status = :status
                                    ORDER BY tc.trip_conductor_id ASC LIMIT 1");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("status", $status);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDisplayStartTrip($tripId) {
        $status = true;
        $passangers = 0;
        $collection = 0;
        $stmt = $this->db->prepare("SELECT trip_id FROM `bms_trips` WHERE trip_id = :tripId AND trip_status = :status AND passenger = :passangers AND collection_amount = :collection ORDER BY trip_id ASC LIMIT 1");
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("status", $status);
        $stmt->bindParam("passangers", $passangers);
        $stmt->bindParam("collection", $collection);
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

    public function getShiftIdByConductorId($conductorId) {
        $workStatus = true;
        $isActive = true;
        $stmt = $this->db->prepare("SELECT shift_id AS 'shiftId' FROM `bms_shift_conductor` WHERE `conductor_id` = :conductorId AND `work_status` = :workStatus AND `is_active` = :isActive");
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->bindParam("isActive", $isActive);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function createtripCollection($companyId, $shiftId, $startRoute, $endRoute, $passengers, $collection) {
        $stmt = $this->db->prepare("INSERT INTO `bms_trips`(`company_id`, `shift_id`, `start_route_id`, `end_route_id`, `passenger`, `collection_amount`) VALUES (:companyId, :shiftId, :startRoute, :endRoute, :passengers, :collection)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("startRoute", $startRoute);
        $stmt->bindParam("endRoute", $endRoute);
        $stmt->bindParam("passengers", $passengers);
        $stmt->bindParam("collection", $collection);

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

    public function createTripConductor2($companyId, $tripId, $conductorId) {
        $conductorStatus = false;
        $stmt = $this->db->prepare("INSERT INTO `bms_trip_conductors`(`company_id`, `trip_id`, `conductor_id`, `trip_conductor_status`) VALUES (:companyId, :tripId, :conductorId, :conductorStatus)");

        $stmt->bindParam("companyId", $companyId);
        $stmt->bindParam("tripId", $tripId);
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("conductorStatus", $conductorStatus);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $lastId = $this->db->lastInsertId();
                return [
                    'status' => 'success',
                    'message' => 'Inserted successfully.',
                    'tripConductorId' => $lastId
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

    public function getConductorByShifId($shiftId, $conductorId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_shift_conductor` WHERE `shift_id` = :shiftId AND `work_status` = :workStatus AND `conductor_id` != :conductorId");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDriverByShifId($shiftId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT * FROM `bms_shift_driver` WHERE `shift_id` = :shiftId AND `work_status` = :workStatus");
        $stmt->bindParam("shiftId", $shiftId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateTripCollection($tripId, $passengers, $collection) {
        $stmt = $this->db->prepare("UPDATE `bms_trips` SET `passenger` = :passengers, `collection_amount` = :collection WHERE `trip_id` = :tripId");
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":passengers", $passengers);
        $stmt->bindParam(":collection", $collection);

        return $stmt->execute() ? true : false;
    }
    public function updateEndTrip($tripId, $endKm) {
        $stmt = $this->db->prepare("UPDATE `bms_trips` SET `end_km`=:endKm WHERE `trip_id` = :tripId");
        $stmt->bindParam(":tripId", $tripId);
        $stmt->bindParam(":endKm", $endKm);

        return $stmt->execute() ? true : false;
    }

    public function updateTripConductorStatus($tripConductorId) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_trip_conductors` SET `trip_conductor_status`= :status WHERE `trip_conductor_id` = :tripConductorId");
        $stmt->bindParam(":tripConductorId", $tripConductorId);
        $stmt->bindParam(":status", $status);

        return $stmt->execute() ? true : false;
    }

    public function checkTripStatus($tripId) {
        $status = true;
        // $isActive = true;
        // $passenger = 0;
        // $collectionAmount = 0;
        $stmt = $this->db->prepare("SELECT shift_id , trip_id, start_km, end_km, passenger, collection_amount FROM `bms_trips` WHERE `trip_id` = :tripId AND `trip_status` = :status");
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

    public function updateConductorWorkDetails($shiftId, $salary, $commission) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_shift_conductor` SET `salary`= :salary, `commission`= :commission, `work_status` = :status WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":salary", $salary);
        $stmt->bindParam(":commission", $commission);
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->bindParam(":status", $status);

        return $stmt->execute() ? true : false;
    }

    public function updateShiftDetails($shiftId, $salary, $othereExpence) {
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `salary` = `salary` + :salary, `expence` = `expence` + :othereExpence WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":salary", $salary);
        $stmt->bindParam(":othereExpence", $othereExpence);
        $stmt->bindParam(":shiftId", $shiftId);

        return $stmt->execute() ? true : false;
    }

    public function updateShiftDetails2($shiftId, $totalCommission) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `commission` = `commission` + :totalCommission, `shift_status` = :status WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->bindParam(":totalCommission", $totalCommission);
        $stmt->bindParam(":status", $status);

        return $stmt->execute() ? true : false;
    }

    function updateConductorCommission($shiftConductorId, $commission) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_shift_conductor` SET `commission` = :commission WHERE `shift_conductor_id` = :shiftConductorId");
        $stmt->bindParam(":shiftConductorId", $shiftConductorId);
        $stmt->bindParam(":commission", $commission);

        return $stmt->execute() ? true : false;
    }

    function updateDriverCommission($shiftDriverId, $commission) {
        $status = false;
        $stmt = $this->db->prepare("UPDATE `bms_shift_driver` SET `commission` = :commission WHERE `shift_driver_id` = :shiftDriverId");
        $stmt->bindParam(":shiftDriverId", $shiftDriverId);
        $stmt->bindParam(":commission", $commission);

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
        $stmt = $this->db->prepare("SELECT `report_id`, `salary`, `commission`, `expence`, `fuel_usage` FROM `bms_shifts` WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":shiftId", $shiftId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getDailyReportDetails($reportId) {
        $stmt = $this->db->prepare("SELECT `total_km`, `fuel_usage`, `avg_milage` FROM `bms_daily_reports` WHERE `report_id` = :reportId");
        $stmt->bindParam(":reportId", $reportId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function updateDailyReportSCEM($reportId, $salary, $commission, $expence, $fuelusage, $avgMilage) {
        $stmt = $this->db->prepare("UPDATE `bms_daily_reports` SET `expenses` = `expenses` + :expence, `salary` = `salary` + :salary, `commission` = `commission` + :commission, `fuel_usage` = `fuel_usage` + :fuelusage, `avg_milage` = :avgMilage WHERE `report_id` = :reportId");
        $stmt->bindParam(":salary", $salary);
        $stmt->bindParam(":commission", $commission);
        $stmt->bindParam(":expence", $expence);
        $stmt->bindParam(":fuelusage", $fuelusage);
        $stmt->bindParam(":avgMilage", $avgMilage);
        $stmt->bindParam(":reportId", $reportId);

        return $stmt->execute() ? true : false;
    }

    public function updateCollectionInShift($shiftId, $passengers, $collection) {
        $stmt = $this->db->prepare("UPDATE `bms_shifts` SET `total_passenger` = `total_passenger` + :passengers, `total_collection` = `total_collection` + :collection WHERE `shift_id` = :shiftId");
        $stmt->bindParam(":passengers", $passengers);
        $stmt->bindParam(":collection", $collection);
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

    public function updateCollectionInDailyReport($reportId,  $passengers, $collection) {
        $stmt = $this->db->prepare("UPDATE `bms_daily_reports` SET `total_passenger` = `total_passenger` + :passengers, `total_collection` = `total_collection` + :collection WHERE `report_id` = :reportId");
        $stmt->bindParam(":passengers", $passengers);
        $stmt->bindParam(":collection", $collection);
        $stmt->bindParam(":reportId", $reportId);

        return $stmt->execute() ? true : false;
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

    public function getTripsDetails($conductorId, $languageCode) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT 
                                        t.start_route_id AS 'startRouteId', 
                                        srt.route_name AS 'startRouteName', 
                                        t.end_route_id AS 'endRouteId', 
                                        ert.route_name AS 'endRouteName',
                                        t.passenger AS 'passengers',
                                        t.collection_amount AS 'collection'
                                    FROM 
                                        bms_shift_conductor sc
                                    INNER JOIN 
                                        bms_trips t ON sc.shift_id = t.shift_id
                                    INNER JOIN 
                                        bms_route_translations srt ON t.start_route_id = srt.route_id
                                    INNER JOIN 
                                        bms_route_translations ert ON t.end_route_id = ert.route_id
                                    INNER JOIN 
                                        bms_languages l ON srt.language_id = l.id AND ert.language_id = l.id
                                    WHERE 
                                        sc.conductor_id = :conductorId
                                        AND sc.work_status = :workStatus 
                                        AND l.code = :languageCode;
                                  ");
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->bindParam("languageCode", $languageCode);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getTripsDetailsCardCount($conductorId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT s.total_km AS 'km', s.total_passenger AS 'passengers', s.total_collection AS 'collections', (SELECT COUNT(*) FROM bms_trips WHERE shift_id = s.shift_id) AS 'trips' FROM bms_shift_conductor sc
                                    INNER JOIN bms_shifts s ON sc.shift_id = s.shift_id
                                    WHERE sc.conductor_id = :conductorId AND sc.work_status = :workStatus
                                    ");
        $stmt->bindParam("conductorId", $conductorId);
        $stmt->bindParam("workStatus", $workStatus);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function getSalary($conductorId) {
        $workStatus = true;
        $stmt = $this->db->prepare("SELECT sc.shift_id, b.conductor_salary, b.bus_number FROM bms_shift_conductor sc
                                    INNER JOIN bms_shifts s ON sc.shift_id = s.shift_id
                                    INNER JOIN bms_daily_reports r ON s.report_id = r.report_id
                                    INNER JOIN bms_bus b ON r.bus_id = b.id
                                    WHERE sc.conductor_id = :conductorId AND sc.work_status = :workStatus
                                    ");
        $stmt->bindParam("conductorId", $conductorId);
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
}