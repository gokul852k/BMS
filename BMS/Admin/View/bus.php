<?php
require_once './header.php';
require_once './navbar.php';
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">

<div class="register-driver">
    <div class="box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="row-head-div-1">
                <h4 class="heading">Bus Details</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('bus-add'); getFuelType()"><i
                        class="fa-solid fa-bus"></i>Add Bus</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="box-container w3-animate-top">
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
                                                <p class="mb-0 text-secondary">Total Bus</p>
                                                <h4 class="my-1 text-info t-c-4" id="total-bus">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                            <div class="card-bg bg-g-4">
                                                <i class="fa-solid fa-bus"></i>
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
                                                <p class="mb-0 text-secondary">Total KM</p>
                                                <h4 class="my-1 text-info t-c-5" id="total-km">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                            <div class="card-bg bg-g-5">
                                                <i class="fa-solid fa-gauge-max"></i>
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
                                                <p class="mb-0 text-secondary">Avg Mileage</p>
                                                <h4 class="my-1 text-info t-c-6" id="avg-mileage">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                            <div class="card-bg bg-g-6">
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
                                                <p class="mb-0 text-secondary">Cost per KM</p>
                                                <h4 class="my-1 text-info t-c-7" id="cost-per-km">-</h4>
                                            </div>
                                            <div class="text-white ms-auto">
                                            <div class="card-bg bg-g-7">
                                                <i class="fa-solid fa-receipt"></i>
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
                                                <p class="mb-0 text-secondary">Expired</p>
                                                <h4 class="my-1 text-info t-c-3" id="expitations">-</h4>
                                            </div>
                                            <div
                                                class="text-white ms-auto">
                                                <div class="card-bg bg-gradient-blooker">
                                                <i class="fa-solid fa-file-xmark"></i>
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
                            class="table table-bordered table-hover dt-responsive" id="bus-table">

                            <thead>
                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Bus Number</th>
                                    <th class="th">Fuel Type</th>
                                    <th class="th">Total KM</th>
                                    <th class="th">Avg Mileage</th>
                                    <th class="th">Cost per KM</th>
                                    <th class="th">RC Book Status</th>
                                    <th class="th">Insurance Status</th>
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

<!--Add Bus Pop ups-->
<div class="tms-pop-up" id="bus-add">
    <div class="pop-up-bg" onclick="popupClose('bus-add')"></div>
    <div class="pop-up-card-2 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Add Bus</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('bus-add')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="register-driver">
                <form enctype="multipart/form-data" id="bus-form">
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Bus Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="bus-number" placeholder="Bus Number"
                                    required />
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="bus-model" placeholder="Bus Model" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="number" class="input-field" name="seating-capacity"
                                    placeholder="Seating Capacity" />
                            </div>
                            <div class="col-sm-6">
                                <select class="input-field" id="fuel-type" name="fuel-type" required>
                                    <option value="">--Select Fuel Type--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="input-field" name="bus-status" required>
                                    <option value="" disabled selected>--Select Bus Status--</option>
                                    <option value="1">Running</option>
                                    <option value="0">Not Running</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input type="number" class="input-field" name="driver-salary"
                                    placeholder="Driver Salary" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="number" class="input-field" name="conductor-salary"
                                    placeholder="Conductor Salary" required/>
                            </div>
                        </div>
                    </div>

                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Documents</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">RC Book</span>
                                    <br>
                                    <input type="file" class="form-control-file" name="rc-book" accept="image/*,.pdf" />
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload Bus Insurance</span>
                                    <br>
                                    <input type="file" class="form-control-file" name="insurance"
                                        accept="image/*,.pdf" />
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="input-label">RC Book Number</label>
                                <input type="text" class="input-field" name="rc-book-number" />
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="input-label">Insurance Number</label>
                                <input type="text" class="input-field" name="insurance-number" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="input-label">RC Book Expiry Date</label>
                                <input type="date" class="input-field" name="rc-book-expiry" />
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="input-label">Insurance Expiry Date</label>
                                <input type="date" class="input-field" name="insurance-expiry" />
                            </div>
                        </div>
                    </div>

                    <div class="pop-up-button-div box-container box-head m-b-10">
                        <button type="submit" name="submit" class="button-2 box-shadow">Add Bus</button>
                        <button type="reset" name="submit" class="button-3 box-shadow"
                            onclick="popupClose('driver-add')">cancel</button>
                    </div>
                </form>
            </div>
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

<!--Edit Driver Pop ups-->

<div class="tms-pop-up" id="bus-edit">
    <div class="pop-up-bg" onclick="popupClose('bus-edit')"></div>
    <div class="pop-up-card-2 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Update Bus Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('bus-edit')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container bus-info p-0" style="display: none">
                <form enctype="multipart/form-data" id="bus-edit-form">
                    <input type="hidden" name="bus_id" id="b-e-bus-id">
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Bus Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Bus Number</label>
                                <input type="text" class="input-field" name="bus_number" id="b-e-bus-no"
                                    placeholder="Bus Number" required />
                            </div>
                            <div class="col-sm-6">
                            <label for="" class="input-label">Bus Model</label>
                                <input type="text" class="input-field" name="bus_model" id="b-e-bus-model"
                                    placeholder="Bus Model" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Seating Capacity</label>
                                <input type="number" class="input-field" name="seating_capacity"
                                    id="b-e-seating-capacity" placeholder="Seating Capacity" required />
                            </div>
                            <div class="col-sm-6">
                            <label for="" class="input-label">Fuel Type</label>
                                <select class="input-field" name="fuel_type_id" id="b-e-fuel-type">
                                    <option value="">--Select Fuel Type--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Driver Salary</label>
                                <input type="number" class="input-field" name="driver_salary"
                                    id="b-e-driver-salary" placeholder="Driver Salary" required />
                            </div>
                            <div class="col-sm-6">
                            <label for="" class="input-label">Conductor Salary</label>
                                <input type="number" class="input-field" name="conductor_salary"
                                    id="b-e-conductor-salary" placeholder="Conductor Salary" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Bus Status</label>
                                <select class="input-field" name="bus_status" id="b-e-bus-status">
                                    <option value="">--Select Bus Status--</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                            <label for="" class="input-label">Rc Book Number</label>
                                <input type="text" class="input-field" name="rcbook_no" id="b-e-rc-no"
                                    placeholder="Rc Book Number" required />
                            </div>
                            <div class="col-sm-6">
                            <label for="" class="input-label">Insurance Number</label>
                                <input type="text" class="input-field" name="insurance_no" id="b-e-insurance-no"
                                    placeholder="Insurance Number" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="input-label">RC Book Expiry Date</label>
                                <input type="date" class="input-field" name="rcbook_expiry" id="b-e-rcbook-expiry"
                                    required />
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="input-label">Insurance Expiry Date</label>
                                <input type="date" class="input-field" name="insurance_expiry" id="b-e-insurance-expiry"
                                    required />
                            </div>
                        </div>
                        <div class="row h-center-div">
                            <div class="col-sm-6">
                                <div class="infos">
                                    <p class="info-heading">RC Book</p>
                                    <a href="" id="b-e-rcbook-path" class="document-view d-v-2 m-t-10" target="_blank">
                                        <i class="fa-duotone fa-file-invoice"></i>
                                    </a>
                                    <div class="file-input m-t-20">
                                        <input type="file" name="rcbook_path" id="rcbook_path"
                                            class="reupload-file-input__input" />
                                        <label class="reupload-file-input__label" for="rcbook_path">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                    d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                </path>
                                            </svg>
                                            <span>Re-upload RC Book</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="infos">
                                    <p class="info-heading">Insurance</p>
                                    <a href="" id="b-e-insurance-path" class="document-view d-v-3 m-t-10"
                                        target="_blank">
                                        <i class="fa-duotone fa-file-invoice"></i>
                                    </a>
                                    <div class="file-input m-t-20">
                                        <input type="file" name="insurance_path" id="insurance_path"
                                            class="reupload-file-input__input" />
                                        <label class="reupload-file-input__label" for="insurance_path">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path fill="currentColor"
                                                    d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                </path>
                                            </svg>
                                            <span>Re-upload Insurance</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pop-up-button-div box-container box-head  m-b-10 m-t-0">
                                <button type="submit" name="submit" class="button-2 box-shadow"
                                    onclick="popupClose('bus-edit')">Update Bus</button>
                                <button type="button" class="button-3 box-shadow"
                                    onclick="popupClose('bus-edit')">cancel</button>
                            </div>
                        </div>
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
<script src="./Js/bus_ajax.js"></script>
<?php
require_once './footer.php';
?>