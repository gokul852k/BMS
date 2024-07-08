<?php
require_once './header.php';
require_once './navbar.php';
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">
<style>
    h2 {
        text-align: center;
        padding: 20px 0;
    }
</style>

<div class="register-driver">
    <div class="container box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="">
                <h4 class="heading">Bus Details</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('driver-add')"><i
                        class="fa-solid fa-bus"></i>Add Bus</button>
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
                                                <p class="mb-0 text-secondary">Total Bus</p>
                                                <h4 class="my-1 text-info t-c-4" id="total_drivers">-</h4>
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
                                                <p class="mb-0 text-secondary">Total KM</p>
                                                <h4 class="my-1 text-info t-c-5" id="expired_licenses">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-g-5 text-white ms-auto">
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
                                                <h4 class="my-1 text-info t-c-6" id="active_drivers">-</h4>
                                            </div>
                                            <div class="widgets-icons-2 rounded-circle bg-g-6 text-white ms-auto">
                                                <i class="fa-solid fa-gas-pump"></i>
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
                                                <h4 class="my-1 text-info t-c-7" id="upcoming_expitations">-</h4>
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
                                                <p class="mb-0 text-secondary">Expired</p>
                                                <h4 class="my-1 text-info t-c-3" id="upcoming_expitations">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                <i class="fa-solid fa-file-xmark"></i>
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
                    <div class="col-xs-12">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="drivers-table">

                            <thead>
                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Name</th>
                                    <th class="th">Mobile</th>
                                    <th class="th">Mail ID</th>
                                    <th class="th">District</th>
                                    <th class="th">License No</th>
                                    <th class="th">License Expiry</th>
                                    <th class="th">License Status</th>
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

<!--Add Driver Pop ups-->
<div class="tms-pop-up" id="driver-add">
    <div class="pop-up-bg" onclick="popupClose('driver-add')"></div>
    <div class="pop-up-card-2 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Add Bus</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('driver-add')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="register-driver">
                <form enctype="multipart/form-data" id="driver-form">
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
                                <input type="text" class="input-field" name="bus-model" placeholder="Bus Model"
                                    required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="number" class="input-field" name="seating-capacity"
                                    placeholder="Seating Capacity" required />
                            </div>
                            <div class="col-sm-6">
                                <select class="input-field" name="fuel-type">
                                    <option value="">--Select Fuel Type--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="input-field" name="bus-status">
                                    <option value="">--Select Bus Status</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="insurance-no"
                                    placeholder="Insurance Number" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="input-label">Year of Manufacture</label>
                                <input type="date" class="input-field" name="year-of-manufacture" required />
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="input-label">Insurance Expiry Date</label>
                                <input type="date" class="input-field" name="insurance-expiry" required />
                            </div>
                        </div>
                        <div class="row h-center-div">
                            <div class="col-sm-6">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload Bus Insurance</span>
                                    <br>
                                    <input type="file" class="form-control-file" id="driving-licence"
                                        name="driving-licence" accept="image/*,.pdf" />
                                </label>
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
<div class="tms-pop-up" id="driver-view">
    <div class="pop-up-bg" onclick="popupClose('driver-view')"></div>
    <div class="pop-up-card scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Bus Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('driver-view')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container driver-info" style="display: none">
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
                                                                    <p class="mb-0 text-secondary">Fuel Cost</p>
                                                                    <h4 class="my-1 text-info t-c-4" id="total_drivers">
                                                                        -</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-g-4 text-white ms-auto">
                                                                    <i class="fa-solid fa-gas-pump"></i>
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
                                                                    <p class="mb-0 text-secondary">Maintenance</p>
                                                                    <h4 class="my-1 text-info t-c-3"
                                                                        id="upcoming_expitations">-</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                                    <i class="fa-solid fa-wrench-simple"></i>
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
                                                                    <h4 class="my-1 text-info t-c-5"
                                                                        id="expired_licenses">-</h4>
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
                                                                        id="active_drivers">-</h4>
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
                                                                        id="upcoming_expitations">-</h4>
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
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Bus information</p>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Bus Number</p>
                                        <p class="info-content" id="d-v-licence-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Bus Model</p>
                                        <p class="info-content" id="d-v-licence-ex">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Seating Capacity</p>
                                        <p class="info-content" id="d-v-aadhar-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Fuel Type</p>
                                        <p class="info-content" id="d-v-pan-no">-</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Bus Status</p>
                                        <p class="info-content" id="d-v-licence-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Year of Manufacture</p>
                                        <p class="info-content" id="d-v-licence-ex">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Insurance Number</p>
                                        <p class="info-content" id="d-v-aadhar-no">-</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Insurance Expiry Date</p>
                                        <p class="info-content" id="d-v-pan-no">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Documents</p>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Insurance</p>
                                        <a href="" id="d-v-aadhar-path" class="document-view d-v-2" target="_blank">
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

<!--Edit Driver Pop ups-->

<div class="tms-pop-up" id="driver-edit">
    <div class="pop-up-bg" onclick="popupClose('driver-edit')"></div>
    <div class="pop-up-card-2 scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Update Bus Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('driver-edit')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="loader-div" style="display: none">
                <div class="loader"></div>
                <p class="loader-text">Loading</p>
            </div>
            <div class="container driver-info p-0" style="display: none">
                <form enctype="multipart/form-data" id="driver-edit-form">
                    <input type="hidden" name="driver_id" id="d-e-driver-id">
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
                                <input type="text" class="input-field" name="bus-model" placeholder="Bus Model"
                                    required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="number" class="input-field" name="seating-capacity"
                                    placeholder="Seating Capacity" required />
                            </div>
                            <div class="col-sm-6">
                                <select class="input-field" name="fuel-type">
                                    <option value="">--Select Fuel Type--</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <select class="input-field" name="bus-status">
                                    <option value="">--Select Bus Status</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="input-field" name="insurance-no"
                                    placeholder="Insurance Number" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="" class="input-label">Year of Manufacture</label>
                                <input type="date" class="input-field" name="year-of-manufacture" required />
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="input-label">Insurance Expiry Date</label>
                                <input type="date" class="input-field" name="insurance-expiry" required />
                            </div>
                        </div>
                        <div class="row h-center-div">
                            <div class="col-sm-6">
                                <div class="infos h-center-div-c">
                                    <p class="info-heading">Insurance</p>
                                    <a href="" id="d-e-licence-path" class="document-view d-v-1 m-t-10" target="_blank">
                                        <i class="fa-duotone fa-file-invoice"></i>
                                    </a>
                                    <div class="file-input m-t-20">
                                        <input type="file" name="licence_path" id="licence_path"
                                            class="reupload-file-input__input" />
                                        <label class="reupload-file-input__label" for="licence_path">
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
                                    onclick="popupClose('driver-edit')">Update Bus</button>
                                <button type="button" class="button-3 box-shadow"
                                    onclick="popupClose('driver-edit')">cancel</button>
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
<script src="./js/driver.js"></script>
<script src="./js/drivers_ajax.js"></script>
<?php
require_once './footer.php';
?>