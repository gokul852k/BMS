<?php
session_start();
// print_r($_SESSION);
require_once './header.php';
require_once './navbar.php';
require_once '../../../Common/Common file/search_select_cdn.php';
require_once '../Services/DailyReportService.php';

//Get translations labels
$serviceDR = new DailyReportService();

$tlabels = $serviceDR->getTranslationsLabels(1);
if (!$tlabels && empty($tlabels)) {
    $tlabels = [
        ["translation" => "Bus Duty"],
        ["translation" => "Hello"],
        ["translation" => "Please select bus"],
        ["translation" => "Start Work"],
        ["translation" => "Select bus"].
        ["translation" => "Select the trip"],
        ["translation" => "Start Location"],
        ["translation" => "End Location"],
        ["translation" => "Starting KM"],
        ["translation" => "Start Trip"],
        ["translation" => "Trip Details"],
        ["translation" => "End Trip"],
        ["translation" => "End KM"],
        ["translation" => "Passengers"],
        ["translation" => "Collection"],
        ["translation" => "Submit Collection"],
        ["translation" => "Start Duty"],
        ["translation" => "End Duty"],
        ["translation" => "Total Trips"],
        ["translation" => "Passengers"],
        ["translation" => "Collection"],
        ["translation" => "Total KM"],
        ["translation" => "Fuel Usage Litre"],
        ["translation" => "Description"],
        ["translation" => "Salary"],
        ["translation" => "Commission"],
        ["translation" => "Total"],
        ["translation" => "Amount"]
    ];
}

?>
    <link rel="stylesheet" href="./Style/driver.css">
    <div class="duty-container">
        <div class="duty-row">
        <div class="duty-button active-duty-button" onclick="endDuty()">
            <!-- Global Variable for End Duty (Driver can't able to end duty without end trip) -->
            <input type="hidden" value="yes" id="now-end-duty"> 
            <div>
                <span><?= $tlabels[17]['translation'] ?></span>
            </div>
            <div>
                <div class="radius-btn active-radius-btn">
                    <span class="rount-btn active-rount-btn"></span>
                </div>
            </div>
        </div>
        </div>
    </div>
<?php

// This code will decide whether to display "SELECT BUS" or "SELECT TRIP"
$display = $serviceDR->getDisplay();
if ($display['display'] == "SELECT BUS") {
    //Display the SELECT BUS
    //Select bus
    $buses = $serviceDR->getBuses();
    ?>
    <script>
        document.getElementsByClassName("duty-container")[0].style.display = "none";
    </script>
    <div class="duty-container-2">
        <div class="duty-row">
        <div class="duty-button" onclick="startDuty()">
            <div>
                <span class="duty-text"><?= $tlabels[16]['translation'] ?></span>
            </div>
            <div>
                <div class="radius-btn">
                    <span class="rount-btn"></span>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="wrapper center-div select-bus-container w3-animate-bottom">
        <form id="select-bus" class="car centered p-10">
            <div class="container box-container">
                <h5 class="heading center"><?= $tlabels[0]['translation'] ?></h5>

                <p class="para"><?= $tlabels[1]['translation'] ?>, <span>
                        <?= $_SESSION['userName'] ?>
                    </span>, <?= $tlabels[2]['translation'] ?>.</p>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                            name="bus-id" id="bus-id">
                            <option value=""><?= $tlabels[4]['translation'] ?></option>
                            <?php
                            foreach ($buses as $bus) {
                                ?>
                                <option value="<?= $bus['id'] ?>"><?= $bus['bus_number'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12">
                        <div class="input-group button-center">
                            <button class="button-2" id="submit" name="btn"><?= $tlabels[3]['translation'] ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
} else if ($display['display'] == "SELECT TRIP") {
    //Display the SELECT TRIP
    $displayTrip = $serviceDR->getDisplayTrip();
    if ($displayTrip['display'] == 'TRIP START') {
        //select route
        $routes = $serviceDR->getRoutes();
        ?>
            <script>
                document.getElementById('now-end-duty').value = "yes";
            </script>
            <div class="wrapper center-div">
                <form id="start-trip" class="car centered p-10">
                    <div class="container box-container w3-animate-bottom">
                        <h5 class="heading center"><?= $tlabels[5]['translation'] ?></h5>

                        <div class="row selectpicker-row">
                            <div class="col-sm-12">
                                <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                    name="start-route" id="start-route">
                                    <option value=""><?= $tlabels[6]['translation'] ?></option>
                                    <?php
                                    foreach ($routes as $route) {
                                        ?>
                                        <option value="<?= $route['routeId'] ?>"><?= $route['routeName'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="error-message p-r-l-15" id="start-route-error"></span>
                            </div>
                        </div>

                        <div class="row selectpicker-row">
                            <div class="col-sm-12">
                                <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                    name="end-route" id="end-route">
                                    <option value=""><?= $tlabels[7]['translation'] ?></option>
                                    <?php
                                    foreach ($routes as $route) {
                                        ?>
                                        <option value="<?= $route['routeId'] ?>"><?= $route['routeName'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <span class="error-message p-r-l-15" id="end-route-error"></span>
                            </div>
                        </div>

                        <div class="row selectpicker-row">
                            <div class="col-sm-12">
                                <input type="number" class="input-field" name="start-km" id="start-km"
                                    placeholder="<?= $tlabels[8]['translation'] ?>">
                                <span class="error-message p-r-l-15" id="start-km-error"></span>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="input-group button-center">
                                    <button class="button-2" id="submit" name="btn"><?= $tlabels[9]['translation'] ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        <?php
    } else if ($displayTrip['display'] == 'TRIP END') {

        $displayStartTrip = $serviceDR->getDisplayStartTrip($displayTrip['tripId']);

        if ($displayStartTrip['status'] == 'success') {
            $tripDetails = $serviceDR->getTripDetails($displayTrip['tripId']);
            ?>
                <script>
                    document.getElementById('now-end-duty').value = "yes";
                </script>
                    <div class="wrapper center-div">
                        <form id="start-trip-2" class="car centered p-10">
                            <div class="container box-container w3-animate-bottom">
                                <h5 class="heading center"><?= $tlabels[5]['translation'] ?></h5>
                                <input type="hidden" name="trip-id-2" value="<?= $displayTrip['tripId'] ?>" />
                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                            name="start-route" id="start-route" disabled>
                                            <option value="<?= $tripDetails['data']['startRouteId'] ?>">
                                        <?= $tripDetails['data']['startRouteName'] ?>
                                            </option>
                                        </select>
                                        <span class="error-message p-r-l-15" id="start-route-error"></span>
                                    </div>
                                </div>

                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                            name="end-route" id="end-route" disabled>
                                            <option value="<?= $tripDetails['data']['endRouteId'] ?>">
                                        <?= $tripDetails['data']['endRouteName'] ?>
                                            </option>
                                        </select>
                                        <span class="error-message p-r-l-15" id="end-route-error"></span>
                                    </div>
                                </div>

                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <input type="number" class="input-field" name="start-km" id="start-km-2"
                                            placeholder="<?= $tlabels[8]['translation'] ?>">
                                        <span class="error-message p-r-l-15" id="start-km-2-error"></span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="input-group button-center">
                                            <button class="button-2" id="submit" name="btn"><?= $tlabels[9]['translation'] ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
        } else {
            $tripDetails = $serviceDR->getTripDetails($displayTrip['tripId']);
            ?>
            <script>
                document.getElementById('now-end-duty').value = "no";
            </script>
                    <div class="wrapper center-div">
                        <form id="end-trip" class="car centered p-10">
                            <div class="container box-container w3-animate-bottom">
                                <h5 class="heading center"><?= $tlabels[10]['translation'] ?></h5>
                                <input type="hidden" name="trip-id" id="end-km-trip-id" value="<?= $displayTrip['tripId'] ?>" />
                                <input type="hidden" name="trip-driver-id" value="<?= $displayTrip['tripDriverId'] ?>" />
                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                            name="start-route" disabled>
                                            <option value="<?= $tripDetails['data']['startRouteId'] ?>">
                                        <?= $tripDetails['data']['startRouteName'] ?>
                                            </option>
                                        </select>
                                        <span class="error-message p-r-l-15" id="start-route-error"></span>
                                    </div>
                                </div>

                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                                            name="end-route" disabled>
                                            <option value="<?= $tripDetails['data']['endRouteId'] ?>">
                                        <?= $tripDetails['data']['endRouteName'] ?>
                                            </option>
                                        </select>
                                        <span class="error-message p-r-l-15" id="end-route-error"></span>
                                    </div>
                                </div>

                                <div class="row selectpicker-row">
                                    <div class="col-sm-12">
                                        <input type="number" class="input-field" name="end-km" id="end-km"
                                            placeholder="<?= $tlabels[12]['translation'] ?>">
                                        <span class="error-message p-r-l-15" id="end-km-error"></span>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="input-group button-center">
                                            <button class="button-2" id="submit" name="btn"><?= $tlabels[11]['translation'] ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
            <?php
        }
    }
} else {

}
?>

<!--User Modal -->
<div class="user-modal" id="user-model-1">
    <div class="user-container">
        <div class="user-modal-bg" onclick="popupClose('user-model-1')"></div>
        <div class="user-modal-content">
            <form id="end-duty">
                <div class="user-modal-header">
                    <h5 class="user-modal-title" id="ed-bus-no"></h5>
                    <button type="button" class="user-modal-close" onclick="popupClose('user-model-1')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="user-modal-body">
                    <div class="counter-cards">
                        <div class="counter-card">
                            <div class="counter-card-top c-c-c-1">
                                <i class="fa-solid fa-location-dot"></i>
                                <span><?= $tlabels[18]['translation'] ?></span>
                            </div>
                            <div class="counter-card-bottom c-c-bc-1">
                                <span id="ed-trip">-</span>
                            </div>
                        </div>
                        <div class="counter-card">
                            <div class="counter-card-top c-c-c-2">
                                <i class="fa-solid fa-user-group-simple"></i>
                                <span><?= $tlabels[19]['translation'] ?></span>
                            </div>
                            <div class="counter-card-bottom c-c-bc-2">
                                <span id="ed-passengers">-</span>
                            </div>
                        </div>
                        <div class="counter-card">
                            <div class="counter-card-top c-c-c-3">
                                <i class="fa-solid fa-coins"></i>
                                <span><?= $tlabels[20]['translation'] ?></span>
                            </div>
                            <div class="counter-card-bottom c-c-bc-3">
                                <span id="ed-collection">-</span>
                            </div>
                        </div>
                        <div class="counter-card">
                            <div class="counter-card-top c-c-c-4">
                                <i class="fa-solid fa-bus"></i>
                                <span><?= $tlabels[21]['translation'] ?></span>
                            </div>
                            <div class="counter-card-bottom c-c-bc-4">
                                <span id="ed-km">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="route-cards" id="route-cards">
                        <!-- <div class="route-card r-line">
                            <div class="route-location">
                                <i class="fa-solid fa-location-pin"></i>
                                <span class="route-count">1</span>
                            </div>
                            <div class="route-card-left">
                                <div class="route-card-from">
                                    <span class="r-c-h">Taramangalam</span>
                                    <span class="r-c-p">From</span>
                                </div>
                                <div class="route-card-to">
                                    <span class="r-c-h">Salem</span>
                                    <span class="r-c-p">To</span>
                                </div>
                            </div>
                            <div class="route-card-right">
                                <div class="route-card-passanger">
                                    <span class="r-c-h">2,343</span>
                                    <span class="r-c-p">Passangers</span>
                                </div>
                                <div class="route-card-collection">
                                    <span class="r-c-h">5,984</span>
                                    <span class="r-c-p">Collection</span>
                                </div>
                            </div>
                        </div> -->
                    </div>

                    <div class="user-model-input">
                        <div class="">
                        <label for="" class="input-label"><?= $tlabels[22]['translation'] ?></label>
                            <input type="number" class="input-field" name="fuel-usage" id="fuel-usage" required>
                        </div>
                        <input type="hidden" name="work-salary" id="work-salary" value="0"/>
                        <input type="hidden" name="work-commission" id="work-commission" value="0"/>
                        <input type="hidden" name="total-commission" id="total-commission" value="0"/>
                    </div>

                    <div class="salary-card">
                        <div class="salary-card-left">
                            <div class="salary-card-row"><span><?= $tlabels[23]['translation'] ?></span></div>
                            <div class="salary-card-row"><span><?= $tlabels[24]['translation'] ?></span></div>
                            <div class="salary-card-row"><span><?= $tlabels[25]['translation'] ?></span></div>
                            <div class="salary-card-row"><span><?= $tlabels[26]['translation'] ?></span></div>
                        </div>
                        <div class="salary-card-right">
                            <div class="salary-card-row"><span><?= $tlabels[27]['translation'] ?></span></div>
                            <div class="salary-card-row"><span id="ed-salary">-</span></div>
                            <div class="salary-card-row"><span id="ed-commission">-</span></div>
                            <div class="salary-card-row"><span id="ed-total">-</span></div>
                        </div>
                    </div>
                </div>
                <div class="user-modal-footer">
                    <button type="submit" class="button-3" onclick="summaCall()"><?= $tlabels[17]['translation'] ?></button>
                    <!-- <button type="reset" class="button-2" onclick="popupClose('user-model-1')">Close</button> -->
                </div>
            </form>
        </div>
    </div>
</div>

<script src="./Js/daily_report_ajax.js"></script>
<script src="../../../Common/Common file/pop_up.js"></script>
<?php
require_once './footer.php';
?>