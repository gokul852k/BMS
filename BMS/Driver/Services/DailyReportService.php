<?php

require_once '../../config.php';
require_once '../Models/DailyReportModel.php';
class DailyReportService {
    private $modelBMS;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        global $bmsDB;
        $this->modelBMS = new DailyReportModel($bmsDB);
    }

    public function getTranslationsLabels($pageId) {
        $response = $this->modelBMS->getTranslationsLabels($pageId, $_SESSION['languageCode']);
        if ($response) {
            return $response;
        } else {
            return null;
        }
    }

    public function getDisplay() {

        $currentDate = date('Y-m-d');

        $driverShift = $this->modelBMS->checkDriverShiftByDriverId($_SESSION['driverId']);

        if (!$driverShift) {
            return [
                'status' => 'success',
                'display' => 'SELECT BUS',
                'message' => 'Now we want to display the SELECT BUS'
            ];
        } else {
            return [
                'status' => 'success',
                'display' => 'SELECT TRIP',
                'message' => 'Now we want to display the SELECT TRIP'
            ];
        }
    }

    public function getDisplayTrip() {

        $shift = $this->modelBMS->getShiftIdByUserId($_SESSION['driverId']);

        if (!$shift) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong.',
                'error' => 'Error while get shift ID fromconductor table.'
            ];
        }

        $driverTrip = $this->modelBMS->getDisplayTrip($_SESSION['driverId'], $shift['shift_id']);

        if (!$driverTrip) {
            return [
                'status' => 'success',
                'display' => 'TRIP START',
                'message' => 'Now we want to display the TRIP START'
            ];
        } else {
            return [
                'status' => 'success',
                'display' => 'TRIP END',
                'tripId' => $driverTrip['trip_id'],
                'tripDriverId' => $driverTrip['trip_driver_id'],
                'message' => 'Now we want to display the TRIP END'
            ];
        }
    }

    public function getDisplayStartTrip($tripId) {
        $tripDetails = $this->modelBMS->getDisplayStartTrip($tripId);

        if ($tripDetails) {
            return [
                'status' => 'success',
                'message' => 'Now we want to display the Start KM'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Error while fetching trip data'
            ];
        }
    }

    public function getTripDetails($tripId) {
        $tripDetails = $this->modelBMS->getTripDetails($tripId, $_SESSION['languageCode']);

        if ($tripDetails) {
            return [
                'status' => 'success',
                'data' => $tripDetails,
                'message' => 'Now we want to display the SELECT BUS'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Error while fetching trip data'
            ];
        }
    }

    public function getBuses() {
        $response = $this->modelBMS->getBuses($_SESSION['companyId']);
        if($response) {
            return $response;
        } else {
            return null;
        }
    }

    public function createDailyReport($busId) {
        //1) -> Check if a daily report for the current date already exists for the given bus ID; if not, create a new daily report.
        //2) -> heck if the shift is open; if not, create a new shift.
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $dailyReport = $this->modelBMS->checkDateAndBusId($busId, $currentDate);

        if (!$dailyReport) {
            // If $dailyReport is have 0 row, This will create a new daily report and new shift.
            // Create daily report
            $responseDR = $this->modelBMS->setDailyReport($_SESSION['companyId'], $busId, $currentDate);

            if (!$responseDR['status'] == 'success') {
                return [
                    'status' => 'Oops!',
                    'message' => 'Something went wrong while start work',
                    'error' => 'Error while insert daily report in daily report table.'
                ];
            }

            $reportId = $responseDR['reportId'];
            $shiftNameId = $this->getCurrentShift();

            // Create Shift
            $responseSH = $this->modelBMS->setShift($_SESSION['companyId'], $reportId, $shiftNameId, $currentDate, $currentTime);

            if (!$responseSH['status'] == 'success') {
                return [
                    'status' => 'Oops!',
                    'message' => 'Something went wrong while start work',
                    'error' => 'Error while insert shift in shifts table.'
                ];
            }

            $shiftId = $responseSH['shiftId'];
            //Insert shift workers
            $responseSW = $this->modelBMS->setShiftWorker($_SESSION['companyId'], $_SESSION['driverId'], $shiftId, $currentDate, $currentTime);

            if ($responseSW['status'] == 'success') {
                return [
                    "status" => "success",
                    "message" => "Happy Journey."
                ];
            } else {
                return [
                    'status' => 'Oops!',
                    'message' => 'Something went wrong while start work',
                    'error' => 'Error while insert shift in shifts table.'
                ];
            }

        } else {
            // If $dailyReport is have row, this will check if a shift exists and, if shift currently open or closed.
            $reportId = $dailyReport[0]['report_id'];
            $shift = $this->modelBMS->checkShiftStatus($reportId);

            if (!$shift) {
                // If $shift is have no row, This will create a new shift.

                $shiftNameId = $this->getCurrentShift();

                // Create Shift
                $responseSH = $this->modelBMS->setShift($_SESSION['companyId'], $reportId, $shiftNameId, $currentDate, $currentTime);

                if (!$responseSH['status'] == 'success') {
                    return [
                        'status' => 'Oops!',
                        'message' => 'Something went wrong while start work',
                        'error' => 'Error while insert shift in shifts table.'
                    ];
                }

                $shiftId = $responseSH['shiftId'];

                //Insert shift workers
                $responseSW = $this->modelBMS->setShiftWorker($_SESSION['companyId'], $_SESSION['driverId'], $shiftId, $currentDate, $currentTime);

                if ($responseSW['status'] == 'success') {
                    return [
                        "status" => "success",
                        "message" => "Happy Journey."
                    ];
                } else {
                    return [
                        'status' => 'Oops!',
                        'message' => 'Something went wrong while start work',
                        'error' => 'Error while insert shift in shifts table.'
                    ];
                }
            } else {
                $driverShift = $this->modelBMS->checkDriverShift($shift['shift_id'], $_SESSION['driverId']);

                if (!$driverShift) {

                    //Insert shift workers
                    $responseSW = $this->modelBMS->setShiftWorker($_SESSION['companyId'], $_SESSION['driverId'], $shift['shift_id'], $currentDate, $currentTime);

                    //Insert Trip (While new conductor or driver is enter to shift we need to insert all the exiting trips in trip_conductor or trip_driver)
                    $exitTrips = $this->modelBMS->getTripByShiftId($shift['shift_id']);
                    
                    if ($exitTrips) {
                        foreach ($exitTrips as $exitTrip) {
                            $this->modelBMS->createTripDriver($_SESSION['companyId'], $exitTrip['trip_id'], $_SESSION['driverId']);
                        }
                    }
                    

                    if ($responseSW['status'] == 'success') {
                        return [
                            "status" => "success",
                            "message" => "Happy Journey."
                        ];
                    } else {
                        return [
                            'status' => 'Oops!',
                            'message' => 'Something went wrong while start work',
                            'error' => 'Error while insert shift in shifts table.'
                        ];
                    }
                } else {
                    return [
                        'status' => 'Oops!',
                        'message' => 'Something went wrong while start work',
                        'error' => 'Error daily report created and shift is created and shift driver created bus driver will see the select bus. The error in the view page.'
                    ];
                }
            }
        }

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

    public function getRoutes() {
        return $this->modelBMS->getRoutes($_SESSION['companyId'], $_SESSION['languageCode']);
    }

    public function startTrip($startRoute, $endRoute, $startKm) {
        $response1 = $this->modelBMS->getShiftIdByDriverId($_SESSION['driverId']);
        if (!$response1) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while select shift id from shift driver table.'
            ];
        }

        $conductorTrip = $this->modelBMS->getDisplayTrip($_SESSION['driverId'], $response1['shiftId']);

        if ($conductorTrip) {
            return [
                'status' => 'trip exist',
                'title' => 'Trip Already Exists',
                'message' => 'Please re-enter the starting KM.'
            ];
        }
        
        $trip = $this->modelBMS->createTrip($_SESSION['companyId'], $response1['shiftId'], $startRoute, $endRoute, $startKm);

        if ($trip['status'] != 'success') {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while insert trip from trip table.'
            ];
        }

        //Insert trip_driver
        $response3 = $this->modelBMS->createTripDriver($_SESSION['companyId'], $trip['tripId'], $_SESSION['driverId']);

        //Loop and insert trip_driver and trip_conductor
        //Get How many conductor assign for this shift & insert trip to those conductor
        $shiftConductor = $this->modelBMS->getConductorByShifId($response1['shiftId']);
        
        if ($shiftConductor) {
            foreach($shiftConductor as  $conductor) {
                $this->modelBMS->createTripConductor($_SESSION['companyId'], $trip['tripId'], $conductor['conductor_id']);
            }
        }

        //Get How many driver assign for this shift & insert trip to those driver
        $shiftDriver = $this->modelBMS->getDriverByShifId($response1['shiftId'], $_SESSION['driverId']);
        if ($shiftDriver) {
            foreach($shiftDriver as  $driver) {
                $this->modelBMS->createTripDriver($_SESSION['companyId'], $trip['tripId'], $driver['driver_id']);
            }
        }

        if ($trip['status'] != 'success') {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while insert driver from trip driver table.'
            ];
        } else {
            return [
                "status" => "success",
                "message" => "Trip Started."
            ];
        }
    }

    public function startTrip2($tripId, $startKm) {
        $response = $this->modelBMS->updateTripStartKm($tripId, $startKm);
        if ($response) {
            return [
                "status" => "success",
                "message" => "Trip Started."
            ];
        } else {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while select shift id from shift driver table.'
            ];
        }
        
    }

    public function endTrip($tripId, $tripDriverId, $endKm) {
        $tripStartKm = $this->modelBMS->getEndKm($tripId);
        if ($tripStartKm) {
            if ($tripStartKm['start_km'] > $endKm) {
                return [
                    "status" => "error",
                    "message" => "End KM is lower than Start KM."
                ];
            }
        }

        $updateTrip = $this->modelBMS->updateEndTrip($tripId, $endKm);
        $updateTripDriver = $this->modelBMS->updateTripDriverStatus($tripDriverId);

        //Check for change trip status
        if ($updateTrip && $updateTripDriver) {
            $checkTripStatus = $this->modelBMS->checkTripStatus($tripId);

            if ($checkTripStatus) {
                if ($checkTripStatus['passenger'] != 0 && $checkTripStatus['collection_amount'] !== 0) {
                    //Check for the passenger and collection amount is 0 than change the trip_status = false
                    $updateTripStatus = $this->modelBMS->updateTripStatus($tripId);
                }

                //Add and update the KM in bms_daily_report and bms_shift
                $totalKm = $endKm - $checkTripStatus['start_km'];

                //Update KM in bms_shift
                $updateKmInDailyReport = $this->modelBMS->updateKmInShift($checkTripStatus['shift_id'], $totalKm);

                //Update KM in bms_daily_report
                $dailyReport = $this->modelBMS->getDailyReport($checkTripStatus['shift_id']);

                if ($dailyReport) {
                    $updateKmInDailyReport = $this->modelBMS->updateKmInDailyReport($dailyReport['report_id'], $totalKm);
                }
                

                if ($updateKmInDailyReport && $dailyReport) {
                    return [
                        'status' => 'success',
                        'message' => 'Trip ended.',
                        'tripId' => $tripId
                    ];
                } else {
                    return [
                        'status' => 'success',
                        'message' => 'Trip ended.',
                        'tripId' => $tripId,
                        'error' => 'Error while updating KM'
                    ];
                }
            } else {
                return [
                    'status' => 'success',
                    'message' => 'Trip ended.',
                    'tripId' => $tripId,
                    'error' => 'Error while fetch trip from trip table'
                ];
            }
        } else {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while start trip',
                'error' => 'Error while updating trip and driver trip in table.'
            ];
        }
        
    }

    public function endDuty($tripId) {
        $shift = $this->modelBMS->getShiftId($tripId);

        if (!$shift) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while end duty',
                'error' => 'Error while fetch shift data in trip table.'
            ];
        }

        $shiftId = $shift['shift_id'];

        //Update shift driver

        $updateDriverStatus = $this->modelBMS->updateDriverShiftStatus($shiftId);

        if (!$updateDriverStatus) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while end duty',
                'error' => 'Error while update work_status in shift driver table.'
            ];
        }

        //check for conductor work status is true

        $conductors = $this->modelBMS->checkConductorsStatus($shiftId);

        $drivers = $this->modelBMS->checkDriversStatus($shiftId);

        if (!$conductors && !$drivers) {
            $updateShiftStatus = $this->modelBMS->updateShiftStatus($shiftId);

            if (!$updateShiftStatus) {
                return [
                    'status' => 'success',
                    'message' => 'Duty ended successfully.',
                    'error' => 'Error while update status in shift table.'
                ];
            }
            return [
                'status' => 'success',
                'message' => 'Duty ended successfully.',
                'error' => ''
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Duty ended successfully.'
        ];
    }

    public function endDuty2($fuelUsage, $salary, $commission, $totalCommission) {
        $driverShift = $this->modelBMS->getShiftIdByDriverId($_SESSION['driverId']);

        if (!$driverShift) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while end duty',
                'error' => 'Error while fetch driver shift data in trip table.'
            ];
        }

        $shiftId = $driverShift['shiftId'];

        //Update shift driver salary, commission, and work status

        $updateDriverWorkDetails = $this->modelBMS->updateDriverWorkDetails($shiftId, $salary, $commission, $fuelUsage);

        if (!$updateDriverWorkDetails) {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong while end duty',
                'error' => 'Error while update work_status in shift driver table.'
            ];
        }

        //Update shift salary, commission, and expence
        // Rules
        // 1) Salary -> Every time user end the duty we need add the priveious salary in shift table and than update the salary.
        // 2) Commission -> Every time user end the duty we will get the total commission. So we do not need to add we only update the commission in shift table.
        // 3) Expence -> We directly update the expence.

        $updateShiftDetails = $this->modelBMS->updateShiftDetails($shiftId, $salary, $fuelUsage);

        //check workers work status is true

        $conductors = $this->modelBMS->checkConductorsStatus($shiftId);

        $drivers = $this->modelBMS->checkDriversStatus($shiftId);

        if (!$conductors && !$drivers) {
            $updateShiftStatus = $this->modelBMS->updateShiftStatus($shiftId);

            //Update salary, commision, and expance in daily report as per shift
            //Get shift details
            $shiftDetails = $this->modelBMS->getShiftDetails($shiftId);
            
            if ($shiftDetails) {
                //First we need get Total KM and Fuel Usage in Daily Report
                $dailyReportId = $this->modelBMS->getDailyReport($shiftId);

                $avgMilage = 0;

                if($dailyReportId) {
                    $dailyReport = $this->modelBMS->getDailyReportDetails($dailyReportId['report_id']);
                    
                    if ($dailyReport) {
                        if ($shiftDetails['fuel_usage'] == 0 && $dailyReport['fuel_usage'] == 0) {
                            $avgMilage = 0;
                        } elseif ($shiftDetails['fuel_usage'] == 0) {
                            $avgMilage = $dailyReport['avg_milage'];
                        } else {
                            $totalFuelUsage = $shiftDetails['fuel_usage'] + $dailyReport['fuel_usage'];
                            $avgMilage = $dailyReport['total_km'] / $totalFuelUsage;
                        }
                    }
                }
                $this->modelBMS->updateDailyReportSCEM($shiftDetails['report_id'], $shiftDetails['salary'], $shiftDetails['commission'], $shiftDetails['expence'], $shiftDetails['fuel_usage'], $avgMilage);
            }

            if (!$updateShiftStatus || !$shiftDetails) {
                return [
                    'status' => 'success',
                    'message' => 'Duty ended successfully.',
                    'error' => 'Error while update status in shift table or updating in report table'
                ];
            }
            return [
                'status' => 'success',
                'message' => 'Duty ended successfully.',
                'error' => ''
            ];
        }

        return [
            'status' => 'success',
            'message' => 'Duty ended successfully.'
        ];
    }

    public function getTripsDetails() {
        //Get the trip details from BMS DB
        $tripDetails = $this->modelBMS->getTripsDetails($_SESSION['driverId'], $_SESSION['languageCode']);
        //Get the Card Count from BMS DB
        $cardCounts = $this->modelBMS->getTripsDetailsCardCount($_SESSION['driverId']);

        //Get the salary and commission
        $salary = $this->modelBMS->getSalary($_SESSION['driverId']);

        $busNumber = "";
        $workerSalary = 0;
        $workerCommission = 0;
        $totalCommission = 0;
        if($cardCounts && $salary) {

            $busNumber = $salary['bus_number'];
            $commission = $this->modelBMS->getCommissionDetails($cardCounts['collections'], $_SESSION['companyId']);

            $noOfWorkerInShift = $this->modelBMS->getWorkersInShift($salary['shift_id']);

            $workerSalary = (int)$salary['driver_salary'];

            if($commission && $noOfWorkerInShift) {
                $commissionAmt = (int)$commission['commission_amount'];
                $amountPerCommission = (int)$commission['amount_per_commission'];
                $collection = (int)$cardCounts['collections'];

                $workers = (int) $noOfWorkerInShift['conductors'] + (int) $noOfWorkerInShift['drivers'];

                $totalCommission = ($collection/$amountPerCommission) * $commissionAmt;

                $workerCommission = $totalCommission / $workers;
            }
            
        }

        if ($tripDetails && $cardCounts) {
            return [
                'status' => 'success',
                'busNumber' => $busNumber,
                'tripDetails' => $tripDetails,
                'cardCounts' => $cardCounts,
                'salary' => $workerSalary,
                'commission' => $workerCommission,
                'totalCommission' => $totalCommission
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Error while fetching trip details data'
            ];
        }
    }

    public function getEndKm($tripId) {
        $response = $this->modelBMS->getEndKm($tripId);
        if ($response) {
            return [
                "status" => "success",
                "data" => $response
            ];
        } else {
            return [
                'status' => 'Oops!',
                'message' => 'Something went wrong.',
                'error' => 'Error while select trip details from trip table'
            ];
        }
    }
}