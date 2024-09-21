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
        $this->modelBMS = new DailyReportModel($bmsDB);
        $this->modelA = new DailyReportModel($authenticationDB);
    }

    public function createDailyReport($postData) {

        $busId = $postData['bus-number'];
        $date = $postData['date'];

        $dailyKM = 0;
        $dailypassengers = 0;
        $dailyCollection = 0;
        $dailyFuelAmount = 0;
        $dailyFuelUsage = 0;
        $dailyExpense = 0;
        $dailySalary = 0;
        $dailyCommission = 0;

        //Check if the daily report is created or not
        $dailyReport = $this->modelBMS->getDailyReport($busId, $date, $_SESSION['companyId']);

        if ($dailyReport) {
            return [
                'status' => 'error',
                'message' => 'An already created daily report exists for this bus and date. Please edit that report.'
            ];
        }

        $setDailyReport = $this->modelBMS->setDailyReport($_SESSION['companyId'], $busId, $date);

        if ($setDailyReport['status'] == 'error') {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while add the daily report',
                'error' => 'Error while set daily report in daily report table.'
            ];
        }

        $reportId = $setDailyReport['reportId'];

        //Get Shift Data
        if (isset($postData['shift']) && is_array($postData['shift'])) {
            foreach ($postData['shift'] as $shift_data) {

                $shiftKM = 0;
                $shiftPassengers = 0;
                $shiftCollection = 0;

                $shiftStartDate = $date;
                $shiftEndDate = $shift_data['shiftEndDate'];
                $shiftStartTime = $shift_data['shiftStartTime'];
                $shiftEndTime = $shift_data['shiftEndTime'];
                $shiftNameId = $this->getCurrentShift();
                
                $setShift = $this->modelBMS->setShift($_SESSION['companyId'], $reportId, $shiftNameId, $shiftStartDate, $shiftEndDate, $shiftStartTime, $shiftEndTime);

                if ($setShift["status"] == "error") {
                    return [
                        'status' => 'error',
                        'message' => 'Something went wrong while add the daily report',
                        'error' => 'Error while set shift in shift table.'
                    ];
                }

                $shiftId = $setShift['shiftId'];
                $drivers = array();
                $conductors = array();

                //Get Trip Data
                if (isset($shift_data['trip']) && is_array($shift_data['trip'])) {
                    foreach ($shift_data['trip'] as $trip_data) {

                        $startRoute = $trip_data['startRoute'];
                        $endRoute = $trip_data['endRoute'];

                        $setTrip = $this->modelBMS->setTrip($_SESSION['companyId'], $shiftId, $startRoute, $endRoute);

                        if ($setTrip['status'] == "error") {
                            return [
                                'status' => 'error',
                                'message' => 'Something went wrong while add the daily report',
                                'error' => 'Error while set trip in trip table.'
                            ];
                        }

                        $tripId = $setTrip['tripId'];

                        $tripStartTime = 0;
                        $tripEndTime = 0;
                        $tripStartKM = 0;
                        $tripEndKM = 0;
                        $tripKM = 0;
                        $tripPassengers = 0;
                        $tripcollection = 0;

                        //Get Driver Data
                        if (isset($trip_data['driver']) && is_array($trip_data['driver'])) {
                            foreach ($trip_data['driver'] as $driver_data) {
                                $tripStartTime = $driver_data['start_time'];
                                $tripEndTime = $driver_data['end_time'];
                                $tripStartKM = (int) $driver_data['start_km'];
                                $tripEndKM = (int) $driver_data['end_km'];
                                $tripKM =  $tripEndKM - $tripStartKM;


                                if (!in_array($driver_data['driver_id'], $drivers)) {
                                    $drivers[] = $driver_data['driver_id'];
                                }
                                $this->modelBMS->setTripDriver($_SESSION['companyId'], $tripId, $driver_data['driver_id']);
                            }
                        }

                        //Get Conductor Data
                        if (isset($trip_data['conductor']) && is_array($trip_data['conductor'])) {
                            foreach ($trip_data['conductor'] as $conductor_data) {
                                $tripPassengers += $conductor_data['passangers'];
                                $tripcollection += $conductor_data['collection'];


                                if (!in_array($conductor_data['conductor_id'], $conductors)) {
                                    $conductors[] = $conductor_data['conductor_id'];
                                }
                                $this->modelBMS->setTripConductor($_SESSION['companyId'], $tripId, $conductor_data['conductor_id']);
                            }
                        }

                        $shiftKM += $tripKM;
                        $shiftPassengers += $tripPassengers;
                        $shiftCollection += $tripcollection;

                        //Set Trip data
                        $updateTrip = $this->modelBMS->updateTrip($tripId, $tripStartTime, $tripEndTime, $tripStartKM, $tripEndKM, $tripPassengers, $tripcollection);

                        if (!$updateTrip) {
                            return [
                                'status' => 'error',
                                'message' => 'Something went wrong while add the daily report',
                                'error' => 'Error while update trip in trip table.'
                            ];
                        }

                    }
                }

                $shiftFuelUsage = $shift_data['fuelUsage'];
                $shiftExpence = $shift_data['otherExpence'];

                //Calculate Commission
                $shiftCommission = 0;
                $shiftWorkerCommission = 0;

                $shiftworkers = count($drivers) + count($conductors);

                $commission = $this->modelBMS->getCommissionDetails($shiftCollection, $_SESSION['companyId']);

                if ($commission) {
                    $commissionAmt = (int)$commission['commission_amount'];
                    $amountPerCommission = (int)$commission['amount_per_commission'];

                    $shiftCommission = ($shiftCollection/$amountPerCommission) * $commissionAmt;

                    $shiftWorkerCommission = $shiftCommission / $shiftworkers;
                }

                //Get workers salary
                $shiftSalary = 0;
                $shiftDriverSalary = 0;
                $shiftConductorSalary = 0;

                $salary = $this->modelBMS->getSalary($busId);

                if ($salary) {
                    $shiftDriverSalary = $salary['driver_salary'];
                    $shiftConductorSalary = $salary['conductor_salary'];

                    $shiftSalary = (count($drivers) * (int) $shiftDriverSalary) + (count($conductors) * (int) $shiftConductorSalary);
                }

                //UpdateShift
                $updateShift = $this->modelBMS->updateShift($shiftId, $shiftKM, $shiftPassengers, $shiftCollection, $shiftSalary, $shiftCommission, $shiftExpence, $shiftFuelUsage);

                if (!$updateShift) {
                    return [
                        'status' => 'error',
                        'message' => 'Something went wrong while add the daily report',
                        'error' => 'Error while update shift in shift table.'
                    ];
                }

                //set driver shift
                foreach ($drivers as $driver) {
                    $this->modelBMS->setShiftDriver($_SESSION['companyId'], $shiftId, $driver, $shiftStartDate, $shiftStartTime, $shiftEndDate, $shiftEndTime, $shiftDriverSalary, $shiftWorkerCommission, $shiftFuelUsage);
                }

                //set conductor shift
                foreach ($conductors as $conductor) {
                    $this->modelBMS->setShiftConductor($_SESSION['companyId'], $shiftId, $conductor, $shiftStartDate, $shiftStartTime, $shiftEndDate, $shiftEndTime, $shiftConductorSalary, $shiftWorkerCommission);
                }

                $dailyKM += $shiftKM;
                $dailypassengers += $shiftPassengers;
                $dailyCollection += $shiftCollection;
                $dailyFuelUsage += $shiftFuelUsage;
                $dailyExpense += $shiftExpence;
                $dailySalary += $shiftSalary;
                $dailyCommission += $shiftCommission;

            }
        }
        $tempFuelAmount = $this->calcFuelUsage2($date);

        if ($tempFuelAmount != 0) {
            $dailyFuelAmount = $tempFuelAmount * $dailyFuelUsage;
        }

        $dailyAvgMilage = $dailyKM / $dailyFuelUsage;
        //Update Daily Report
        $updateDailyReport = $this->modelBMS->updateDailyReport($reportId, $dailyKM, $dailypassengers, $dailyAvgMilage, $dailyCollection, $dailyFuelAmount, $dailyFuelUsage, $dailyExpense, $dailySalary, $dailyCommission);

        if (!$updateDailyReport) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while add the daily report',
                'error' => 'Error while update Daily report in daily report table.'
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Daily Report Added Successfully.',
            'error' => 'Error while update Daily report in daily report table.'
        ];
    }

    public function getDailyReportForEdit($reportId) {

        //1:-> Get Daily Report
        $dailyReport = $this->modelBMS->getDailyReport2($reportId);

        if (!$dailyReport) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while get the daily report',
                'error' => 'Error while get daily report in daily report table.'
            ];
        }

        $response = [
            "reportId" => $dailyReport['report_id'],
            "busId" => $dailyReport['bus_id'],
            "date" => $dailyReport['date']
        ];


        //2:-> Get Shifts
        $shifts = $this->modelBMS->getShift($reportId);

        if (!$shifts) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong while get the daily report',
                'error' => 'Error while get shift in shift table.'
            ];
        }
        $shiftCount = 1;
        $shiftMainArray = array();
        foreach ($shifts as $shift) {
            $shiftId = $shift['shift_id'];
            $shiftArray = [
                "shiftId" => $shift['shift_id'],
                "shiftEndDate" => $shift['end_date'],
                "shiftStartTime" => $shift['start_time'],
                "shiftEndTime" => $shift['end_time'],
                "fuelUsage" => $shift['fuel_usage'],
                "otherExpence" => $shift['expence']
            ];

            //3:-> Get Trips

            $trips = $this->modelBMS->getTrips($shiftId);

            if (!$shifts) {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong while get the daily report',
                    'error' => 'Error while get trips in trips table.'
                ];
            }

            $tripCount = 1;
            $tripMainArray = array();
            foreach ($trips as $trip) {
                $tripId = $trip['trip_id'];

                $tripArray = [
                    "tripId" => $trip['trip_id'],
                    "startRoute" => $trip['start_route_id'],
                    "endRoute" => $trip['end_route_id']
                ];

                //4:-> Get Driver

                $drivers = $this->modelBMS->getTripDrivers($tripId);

                if ($drivers) {
                    $driverCount = 1;
                    $driverMainArray = array();
                    foreach ($drivers as $driver) {
                        $driverArray = [
                            "tripDriverId" => $driver['trip_driver_id'],
                            "driverId" => $driver['driver_id'],
                            "startTime" => $trip['start_time'],
                            "endTime" => $trip['end_time'],
                            "startKm" => $trip['start_km'],
                            "endKm" => $trip['end_km']
                        ];
                        $driverMainArray[$driverCount] = $driverArray;
                        $driverCount++;
                    }

                    $tripArray["driver"] = $driverMainArray;
                }

                //5:-> Get Conductor

                $conductors = $this->modelBMS->getTripConductors($tripId);

                if ($conductors) {
                    $conductorCount = 1;
                    $conductorMainArray = array();
                    foreach ($conductors as $conductor) {
                        $conductorArray = [
                            "tripConductorId" => $conductor['trip_conductor_id'],
                            "conductorId" => $conductor['conductor_id'],
                            "passangers" => $trip['passenger'],
                            "collection" => $trip['collection_amount']
                        ];
                        $conductorMainArray[$conductorCount] = $conductorArray;
                        $conductorCount++;
                    }

                    $tripArray["conductor"] = $conductorMainArray;
                }

                $tripMainArray[$tripCount] = $tripArray;
                $tripCount++;

            }

            $shiftArray['trip'] = $tripMainArray;

            $shiftMainArray[$shiftCount] = $shiftArray;
            $shiftCount++;
        }

        $response['shift'] = $shiftMainArray;

        return $response;

    }

    public function getCurrentShift() {
        $currentHour = date('H');

        if ($currentHour >= 1 && $currentHour <= 8) {
            return 1; //First Shift
        } elseif ($currentHour > 8 && $currentHour <= 16) {
            return 2; //Second Shift
        } else {
            return 3; //Third Shift
        }
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

    public function calcFuelUsage2($date) {
        $fuelAmount1 = $this->modelBMS->getFuelAmount($date);

        if ($fuelAmount1) {
            return $fuelAmount1['fuel_cost'] / $fuelAmount1['fuel_quantity'];
        }

        $date2 = new DateTime('2024-09-18'); // Current date

        // Subtract 10 days
        $date2->modify('-10 days');

        $fromDate = $date2->format('Y-m-d');

        $fuelAmount2 = $this->modelBMS->getFuelAmount2($fromDate, $date);

        if ($fuelAmount2) {
            return $fuelAmount2['fuel_cost'] / $fuelAmount2['fuel_quantity'];
        }

        return 0;
    }
}