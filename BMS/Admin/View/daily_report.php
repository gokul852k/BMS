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
    <div class="box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="row-head-div-1">
                <h4 class="heading">Daily Report</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button2" onclick="popupOpen('filter'), getFilterField()"><i
                        class="fa-solid fa-filter"></i>Filter</button>
                <button class="button-1 head-button3" onclick="popupOpen('add'); getDetails()"><i
                        class="fa-solid fa-chart-simple"></i>Add Report</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="box-container w3-animate-top">
        <div class="row row-head c-5 m m-b-20">
            <div class="content">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Km</p>
                                                <h4 class="my-1 text-info t-c-4" id="c-total-km">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-4">
                                                    <i class="fa-duotone fa-solid fa-bus"></i>
                                                </div>
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
                                                <p class="mb-0 text-secondary">Fuel Usage</p>
                                                <h4 class="my-1 text-info t-c-5" id="c-fuel-usage">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-5">
                                                    <i class="fa-solid fa-gas-pump"></i>
                                                </div>
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
                                                <p class="mb-0 text-secondary">Passangers</p>
                                                <h4 class="my-1 text-info t-c-7" id="c-passangers">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-7">
                                                    <i class="fa-solid fa-people-group"></i>
                                                </div>
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
                                                <h4 class="my-1 text-info t-c-3" id="c-collection">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-gradient-blooker">
                                                    <i class="fa-solid fa-sack"></i>
                                                </div>
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
                                                <p class="mb-0 text-secondary">Expense</p>
                                                <h4 class="my-1 text-info t-c-9" id="c-expense">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-9">
                                                    <i class="fa-solid fa-chart-simple-horizontal"></i>
                                                </div>
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
                                                <p class="mb-0 text-secondary">Fuel Amount</p>
                                                <h4 class="my-1 text-info t-c-10" id="c-fuel-amount">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-10">
                                                    <i class="fa-sharp fa-solid fa-gas-pump"></i>
                                                </div>
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
                                                <p class="mb-0 text-secondary">Salary</p>
                                                <h4 class="my-1 text-info t-c-11" id="c-salary">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-11">
                                                    <i class="fa-solid fa-user-group-simple"></i>
                                                </div>
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
                                                <p class="mb-0 text-secondary">Commission</p>
                                                <h4 class="my-1 text-info t-c-12" id="c-commission">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-12">
                                                    <i class="fa-solid fa-badge-percent"></i>
                                                </div>
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
                                                <p class="mb-0 text-secondary">Loss</p>
                                                <h4 class="my-1 text-info t-c-8" id="c-loss">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-8">
                                                    <i class="fa-solid fa-chart-line-down"></i>
                                                </div>
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
                                                <p class="mb-0 text-secondary">Profit</p>
                                                <h4 class="my-1 text-info t-c-6" id="c-profit">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                                <div class="card-bg bg-g-6">
                                                    <i class="fa-solid fa-chart-simple"></i>
                                                </div>
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

    <div class="box-container w3-animate-bottom" onload="getDrivers()">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="daily-report-table">

                            <thead>
                                <tr>
                                    <th class="th">#</th>
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
                        <div class="row">
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
                                    <p class="bms-shift-title">Shift - 1</p>
                                    <!-- <button type="button" class="remove-button" title="Remove shift" onclick="remove('bms-shift-1')"><i class="fa-solid fa-trash"></i></button> -->
                                </div>
                                <div class="bms-shift-body">
                                    <div class="bms-shift-details">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label for="" class="input-label">Shift End date</label>
                                                <input type="date" class="input-field" name="shift[1][shiftEndDate]"
                                                    placeholder="" required />
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="" class="input-label">Shift Start Time</label>
                                                <input type="time" class="input-field" name="shift[1][shiftStartTime]"
                                                    placeholder="" required />
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="" class="input-label">Shift End Time</label>
                                                <input type="time" class="input-field" name="shift[1][shiftEndTime]"
                                                    placeholder="" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bms-shift-workers">
                                        <div class="bms-trip-container">
                                            <div class="bms-trips" id="bms-trips-1">
                                                <div class="bms-trip" id="bms-trips-1-1">
                                                    <div class="bms-trip-header">
                                                        <p class="bms-trip-title">Trip - 1</p>
                                                        <!-- <button type="button" class="remove-button" title="Remove shift" onclick="remove('bms-trips-1-1')"><i class="fa-solid fa-trash"></i></button> -->
                                                    </div>
                                                    <div class="bms-trip-body">
                                                        <div class="bms-trip-route">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label for="" class="input-label">Start
                                                                        Route</label>
                                                                    <select class="input-field"
                                                                        name="shift[1][trip][1][startRoute]"
                                                                        id="start-route" required>

                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="" class="input-label">End Route</label>
                                                                    <select class="input-field"
                                                                        name="shift[1][trip][1][endRoute]"
                                                                        id="end-route" required>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bms-trip-driver-container">
                                                            <div class="bms-trip-drivers" id="bms-trip-drivers-1-1">
                                                                <div class="bms-trip-driver" id="bms-trip-driver-1-1-1">
                                                                    <div class="bms-trip-driver-header">
                                                                        <p class="bms-trip-driver-title">Driver</p>
                                                                        <button type="button" class="add-button"
                                                                            onclick="addDriver(1,1)"><i
                                                                                class="fa-solid fa-circle-plus"></i></button>
                                                                    </div>
                                                                    <div class="bms-trip-driver-body">
                                                                        <div class="bms-trip-driver-content">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label for=""
                                                                                        class="input-label">Driver</label>
                                                                                    <select class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][driver_id]"
                                                                                        id="driver-1-1-1" required>

                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for=""
                                                                                        class="input-label">Start
                                                                                        Time</label>
                                                                                    <input type="time"
                                                                                        class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][start_time]"
                                                                                        placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for=""
                                                                                        class="input-label">End
                                                                                        Time</label>
                                                                                    <input type="time"
                                                                                        class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][end_time]"
                                                                                        placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for=""
                                                                                        class="input-label">Start
                                                                                        KM</label>
                                                                                    <input type="text"
                                                                                        class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][start_km]"
                                                                                        placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-2">
                                                                                    <label for=""
                                                                                        class="input-label">End
                                                                                        KM</label>
                                                                                    <input type="text"
                                                                                        class="input-field"
                                                                                        name="shift[1][trip][1][driver][1][end_km]"
                                                                                        placeholder="" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="bms-trip-conductor-container">
                                                            <div class="bms-trip-conductors"
                                                                id="bms-trip-conductors-1-1">
                                                                <div class="bms-trip-conductor"
                                                                    id="bms-trip-conductor-1-1-1">
                                                                    <div class="bms-trip-conductor-header">
                                                                        <p class="bms-trip-conductor-title">Conductor
                                                                        </p>
                                                                        <button type="button" class="add-button"
                                                                            onclick="addConductor(1,1)"><i
                                                                                class="fa-solid fa-circle-plus"></i></button>
                                                                    </div>
                                                                    <div class="bms-trip-conductor-body">
                                                                        <div class="bms-trip-conductor-content">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label for=""
                                                                                        class="input-label">Conductor</label>
                                                                                    <select class="input-field"
                                                                                        name="shift[1][trip][1][conductor][1][conductor_id]"
                                                                                        id="conductor-1-1-1" required>

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
                                                                                    <label for=""
                                                                                        class="input-label">Passangers</label>
                                                                                    <input type="text"
                                                                                        class="input-field"
                                                                                        name="shift[1][trip][1][conductor][1][passangers]"
                                                                                        placeholder="" required />
                                                                                </div>
                                                                                <div class="col-sm-3">
                                                                                    <label for=""
                                                                                        class="input-label">Collection</label>
                                                                                    <input type="text"
                                                                                        class="input-field"
                                                                                        name="shift[1][trip][1][conductor][1][collection]"
                                                                                        placeholder="" required />
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
                                                        <input type="number" class="input-field"
                                                            name="shift[1][fuelUsage]" placeholder="" required />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="" class="input-label">Othere Expence</label>
                                                        <input type="text" class="input-field"
                                                            name="shift[1][otherExpence]" placeholder="" required />
                                                    </div>
                                                </div>
                                                <button type="button" class="button-2" onclick="addTrip(1)">Add Trip<i
                                                        class="fa-solid fa-location-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bms-shift-footer">
                            <button type="button" class="button-2" id="add-shift">Add Shift<i
                                    class="fa-solid fa-circle-plus"></i></button>
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
            <form id="edit-daily-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Edit Daily Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('edit')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div>
                        <input type="hidden" name="report_id" id="edit-report-id">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="" class="input-label">Bus No</label>
                                <select class="input-field" name="bus-number" id="edit-bus-no" required>

                                </select>
                            </div>

                            <div class="col-sm-3">
                                <label for="" class="input-label">Date</label>
                                <input type="date" class="input-field" name="date" id="edit-date" placeholder=""
                                    required />
                            </div>
                        </div>
                    </div>
                    <div class="bms-shift-container">
                        <div class="bms-shifts" id="bms-edit-shifts">

                        </div>
                        <div class="bms-shift-footer">
                            <button type="button" class="button-2" onclick="addEditShift()">Add Shift<i
                                    class="fa-solid fa-circle-plus"></i></button>
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

<!--View Daily Report Pop ups-->
<div class="admin-modal model-l" id="view">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('view')"></div>
        <div class="admin-modal-content daily-report-view">
            <form id="view-daily-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title" id="View-title">View Daily Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('view')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body admin-view-body" id="daily-report-view-content">

                </div>
            </form>
        </div>
    </div>
</div>


<!--Filter Pop ups-->
<div class="admin-modal model-sm" id="filter">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('filter')"></div>
        <div class="admin-modal-content">
            <form id="filter-form">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Add Filter</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('filter')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div class="row">
                        <div class="col-sm-12 filter-btn-list">
                            <div class="btn_check">
                                <input type="radio" id="check1" name="days" value="1" onchange="uncheck()">
                                <label class="btn btn-default" for="check1">Today</label>
                            </div>
                            <div class="btn_check">
                                <input type="radio" id="check2" name="days" value="7" onchange="uncheck()">
                                <label class="btn btn-default" for="check2">Last 7 Days</label>
                            </div>
                            <div class="btn_check">
                                <input type="radio" id="check3" name="days" value="30" onchange="uncheck()">
                                <label class="btn btn-default" for="check3">Last 30 Days</label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="" class="input-label">Date</label>
                            <div class="form-group filter-date m-b-20" onchange="unSelect()">
                                <span>From</span>
                                <input type="date" name="filter-from-date" class="form-field">
                            </div>
                            <div class="form-group filter-date m-b-20" onchange="unSelect()">
                                <input type="date" name="filter-to-date" class="form-field">
                                <span>To</span>
                            </div>
                        </div>

                        <div class="col-sm-12 search-select-1">
                            <label for="" class="input-label">Bus No</label>
                            <select class="input-field" name="filter-bus" id="filter-bus">

                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Collection</label>
                            <div class="form-group filter-date m-b-20">
                                <span>From</span>
                                <input type="number" name="filter-collection-from" class="form-field">
                            </div>
                            <div class="form-group filter-date m-b-20">
                                <input type="number" name="filter-collection-to" class="form-field">
                                <span>To</span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="" class="input-label">Profit</label>
                            <div class="form-group filter-date m-b-20">
                                <span>From</span>
                                <input type="number" name="filter-profit-from" class="form-field">
                            </div>
                            <div class="form-group filter-date m-b-20">
                                <input type="number" name="filter-profit-to" class="form-field">
                                <span>To</span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="" class="input-label">KM</label>
                            <div class="form-group filter-date m-b-20">
                                <span>From</span>
                                <input type="number" name="filter-km-from" class="form-field">
                            </div>
                            <div class="form-group filter-date m-b-20">
                                <input type="number" name="filter-km-to" class="form-field">
                                <span>To</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3" onclick="popupClose('filter')">Apply Filter</button>
                    <button type="reset" class="button-2">Clear</button>
                </div>
            </form>
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
<?php
require_once './footer.php';
?>