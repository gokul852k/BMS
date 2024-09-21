<?php
require_once './header.php';
require_once './navbar.php';
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">
<link rel="stylesheet" href="./Style/daily_report.css">

<div class="register-driver">
    <div class="container box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="row-head-div-1">
                <h4 class="heading">Daily Report</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('add'); getDetails()"><i
                        class="fa-solid fa-chart-simple"></i>Add Report</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="container box-container w3-animate-top">
        <div class="row row-head c-5">
            <div class="content">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Bus</p>
                                                <h4 class="my-1 text-info t-c-4" id="total-bus">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-g-4 text-white ms-auto">
                                                <i class="fa-solid fa-bus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Driver</p>
                                                <h4 class="my-1 text-info t-c-5" id="total-km">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-g-5 text-white ms-auto">
                                                <i class="fa-solid fa-user-pilot"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Conductor</p>
                                                <h4 class="my-1 text-info t-c-6" id="avg-mileage">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-g-6 text-white ms-auto">
                                                <i class="fa-solid fa-user-vneck-hair"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Collection</p>
                                                <h4 class="my-1 text-info t-c-7" id="cost-per-km">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle  bg-g-7 text-white ms-auto">
                                                <i class="fa-solid fa-receipt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">KM</p>
                                                <h4 class="my-1 text-info t-c-3" id="expitations">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                <i class="fa-solid fa-gauge-max"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container box-container w3-animate-bottom" onload="getDrivers()">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="daily-report-table">

                            <thead>
                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Date</th>
                                    <th class="th">Bus No</th>
                                    <th class="th">KM</th>
                                    <th class="th">Fuel Usage</th>
                                    <th class="th">Avg Mileage</th>
                                    <th class="th">Passangers</th>
                                    <th class="th">Collection</th>
                                    <th class="th">Expense</th>
                                    <th class="th">Fuel Amount</th>
                                    <th class="th">Salary</th>
                                    <th class="th">Commission</th>
                                    <th class="th">Profit</th>
                                    <th class="th">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add Daily Report Pop ups-->
<div class="admin-modal model-m" id="add">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('add')"></div>
        <div class="admin-modal-content">
            <form id="add-daily-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Add Daily Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('add')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div>
                        <div class="row p-20">
                            <div class="col-sm-3">
                                <label for="" class="input-label">Bus No</label>
                                <select class="input-field" name="bus-number" id="bus-no" required>

                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Date</label>
                                <input type="date" class="input-field" name="date" placeholder="" required />
                            </div>
                        </div>
                    </div>
                    <div class="bms-shift-container">
                        <div class="bms-shifts" id="bms-shifts">
                            <div class="bms-shift" id="bms-shift">
                                <div class="bms-shift-header">
                                    <p class="bms-shift-title">Shift</p>
                                    <!-- <button type="button" class="remove-button" title="Remove shift" onclick="remove('bms-shift-1')"><i class="fa-solid fa-trash"></i></button> -->
                                </div>
                                <div class="bms-shift-body">
                                    <div class="bms-shift-details">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label for="" class="input-label">Shift End date</label>
                                                <input type="date" class="input-field" name="shift[1][shiftEndDate]" placeholder="" required />
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="" class="input-label">Shift Start Time</label>
                                                <input type="time" class="input-field" name="shift[1][shiftStartTime]" placeholder="" required />
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="" class="input-label">Shift End Time</label>
                                                <input type="time" class="input-field" name="shift[1][shiftEndTime]" placeholder="" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bms-shift-workers">
                                        <div class="bms-trip-container">
                                            <div class="bms-trips" id="bms-trips-1">
                                                <div class="bms-trip" id="bms-trips-1-1">
                                                    <div class="bms-trip-header">
                                                        <p class="bms-trip-title">Trip</p>
                                                        <!-- <button type="button" class="remove-button" title="Remove shift" onclick="remove('bms-trips-1-1')"><i class="fa-solid fa-trash"></i></button> -->
                                                    </div>
                                                    <div class="bms-trip-body">
                                                        <div class="bms-trip-route">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label for="" class="input-label">Start Route</label>
                                                                    <select class="input-field" name="shift[1][trip][1][startRoute]" id="start-route" required>

                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="" class="input-label">End Route</label>
                                                                    <select class="input-field" name="shift[1][trip][1][endRoute]" id="end-route" required>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bms-trip-driver-container">
                                                            <div class="bms-trip-drivers" id="bms-trip-drivers-1-1">
                                                                <div class="bms-trip-driver" id="bms-trip-driver-1-1-1">
                                                                    <div class="bms-trip-driver-header">
                                                                        <p class="bms-trip-driver-title">Driver</p>
                                                                        <button type="button" class="add-button" onclick="addDriver(1,1)"><i class="fa-solid fa-circle-plus"></i></button>
                                                                    </div>
                                                                    <div class="bms-trip-driver-body">
                                                                        <div class="bms-trip-driver-content">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label for="" class="input-label">Driver</label>
                                                                                    <select class="input-field" name="shift[1][trip][1][driver][1][driver_id]" id="driver-1-1-1" required>

                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for="" class="input-label">Start Time</label>
                                                                                    <input type="time" class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][start_time]" placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for="" class="input-label">End Time</label>
                                                                                    <input type="time" class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][end_time]" placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for="" class="input-label">Start KM</label>
                                                                                    <input type="text" class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][start_km]" placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for="" class="input-label">End KM</label>
                                                                                    <input type="text" class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][end_km]" placeholder="" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bms-trip-conductor-container">
                                                            <div class="bms-trip-conductors" id="bms-trip-conductors-1-1">
                                                                <div class="bms-trip-conductor" id="bms-trip-conductor-1-1-1">
                                                                    <div class="bms-trip-conductor-header">
                                                                        <p class="bms-trip-conductor-title">Conductor</p>
                                                                        <button type="button" class="add-button" onclick="addConductor(1,1)"><i class="fa-solid fa-circle-plus"></i></button>
                                                                    </div>
                                                                    <div class="bms-trip-conductor-body">
                                                                        <div class="bms-trip-conductor-content">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label for="" class="input-label">Conductor</label>
                                                                                    <select class="input-field" name="shift[1][trip][1][conductor][1][conductor_id]" id="conductor-1-1-1" required>

                                                                                    </select>
                                                                                </div>
                                                                                <!-- <div class="col-sm-2">
                                                                                    <label for="" class="input-label">Start Time</label>
                                                                                    <input type="time" class="input-field"
                                                                                        name="shift[1][trip][1][conductor][1][start_time]" placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for="" class="input-label">End Time</label>
                                                                                    <input type="time" class="input-field"
                                                                                        name="shift[1][trip][1][conductor][1][conductor_id]" placeholder="" required />
                                                                                </div> -->
                                                                                <div class="col-sm-3">
                                                                                    <label for="" class="input-label">Passangers</label>
                                                                                    <input type="text" class="input-field"
                                                                                        name="shift[1][trip][1][conductor][1][passangers]" placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <label for="" class="input-label">Collection</label>
                                                                                    <input type="text" class="input-field"
                                                                                        name="shift[1][trip][1][conductor][1][collection]" placeholder="" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bms-trip-footer">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label for="" class="input-label">Fuel Usage</label>
                                                        <input type="number" class="input-field" name="shift[1][fuelUsage]" placeholder="" required />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="" class="input-label">Othere Expence</label>
                                                        <input type="text" class="input-field" name="shift[1][otherExpence]" placeholder="" required />
                                                    </div>
                                                </div>
                                                <button type="button" class="button-2" onclick="addTrip(1)">Add Trip<i class="fa-solid fa-location-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bms-shift-footer">
                            <button type="button" class="button-2" id="add-shift">Add Shift<i class="fa-solid fa-circle-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3">Submit</button>
                    <button type="reset" class="button-2" onclick="popupClose('add')">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Edit Daily Report Pop ups-->
<div class="admin-modal model-m" id="edit">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('edit')"></div>
        <div class="admin-modal-content">
            <form id="add-daily-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Edit Daily Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('edit')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div>
                        <div class="row p-20">
                            <div class="col-sm-3">
                                <label for="" class="input-label">Bus No</label>
                                <select class="input-field" name="bus-number" id="bus-no" required>

                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Date</label>
                                <input type="date" class="input-field" name="date" placeholder="" required />
                            </div>
                        </div>
                    </div>
                    <div class="bms-shift-container">
                        <div class="bms-shifts" id="bms-shifts">
                        
                        </div>
                        <div class="bms-shift-footer">
                            <button type="button" class="button-2" id="add-shift">Add Shift<i class="fa-solid fa-circle-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3">Submit</button>
                    <button type="reset" class="button-2" onclick="popupClose('edit')">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--View Driver Pop ups-->
<div class="tms-pop-up" id="bus-view">
    <div class="pop-up-bg" onclick="popupClose('bus-view')"></div>
    <div class="pop-up-card scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Bus Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('bus-view')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container bus-info" style="display: none">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row row-head c-5">
                                <div class="content">
                                    <div class="container-fluid">
                                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Profit</p>
                                                                    <h4 class="my-1 text-info t-c-4" id="b-v-profit">
                                                                        -</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-g-4 text-white ms-auto">
                                                                    <i class="fa-solid fa-receipt"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Cost</p>
                                                                    <h4 class="my-1 text-info t-c-3" id="b-v-cost">-
                                                                    </h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                                    <i class="fa-solid fa-money-check-pen"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Total KM</p>
                                                                    <h4 class="my-1 text-info t-c-5" id="b-v-total-km">-
                                                                    </h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-g-5 text-white ms-auto">
                                                                    <i class="fa-solid fa-gauge-max"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Avg Mileage</p>
                                                                    <h4 class="my-1 text-info t-c-6"
                                                                        id="b-v-avg-mileage">-</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-g-6 text-white ms-auto">
                                                                    <i class="fa-sharp fa-solid fa-gas-pump"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Cost per KM</p>
                                                                    <h4 class="my-1 text-info t-c-7"
                                                                        id="b-v-cost-per-km">-</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle  bg-g-7 text-white ms-auto">
                                                                    <i class="fa-solid fa-receipt"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-7 p-r-0 m-b-10">
                                <div class="driver-info-left box-container-2 h-100">
                                    <div class="chart-1" id="chart-1">

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="driver-info-right box-container-2 m-b-10">
                                    <div class="chart-2" id="chart-2">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Bus information</p>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Bus Number</p>
                                        <p class="info-content" id="b-v-bus-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Bus Model</p>
                                        <p class="info-content" id="b-v-bus-model">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Seating Capacity</p>
                                        <p class="info-content" id="b-v-seating-capacity">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Fuel Type</p>
                                        <p class="info-content" id="b-v-fuel-type">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Driver Salary</p>
                                        <p class="info-content" id="b-v-driver-salary">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Conductor Salary</p>
                                        <p class="info-content" id="b-v-conductor-salary">-</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Bus Status</p>
                                        <p class="info-content" id="b-v-bus-status">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">RC Book Number</p>
                                        <p class="info-content" id="b-v-rc-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">RC Book Expiry Date</p>
                                        <p class="info-content" id="b-v-rcbook-expiry">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Insurance Number</p>
                                        <p class="info-content" id="b-v-insurance-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Insurance Expiry Date</p>
                                        <p class="info-content" id="b-v-insurance-expiry">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Documents</p>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">RC Book</p>
                                        <a href="" id="b-v-rcbook-path" class="document-view d-v-2" target="_blank">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Insurance</p>
                                        <a href="" id="b-v-insurance-path" class="document-view  d-v-3" target="_blank">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>


<!-- Progress loader -->
<div class="tms-pop-up" id="progress-loader">
    <div class="pop-up-bg"></div>
    <div class="progress-loader">
        <div class="loader"></div>
        <p class="progress-text" id="progress-text">Loading, please wait..</p>
    </div>
</div>

<script src="../../../Common/Common file/pop_up.js"></script>
<script src="../../../Common/Common file/data_table.js"></script>
<script src="../../../Common/Common file/main.js"></script>
<script src="./Js/daily_report_ajax.js"></script>
<script src="./Js/daily_report.js"></script>
<script src="./Js/bus_ajax.js"></script>
<?php
require_once './footer.php';
?>