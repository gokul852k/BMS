<?php
require_once './header.php';
require_once './navbar.php';
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">

<div class="register-driver">
    <div class="container box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="row-head-div-1">
                <h4 class="heading">Driver Details</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('driver-add')"><i
                        class="fa-solid fa-user-plus"></i>Add Driver</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="container box-container w3-animate-top">
        <div class="row row-head">
            <div class="content">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Drivers</p>
                                                <h4 class="my-1 text-info" id="total_drivers">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
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
                                                <p class="mb-0 text-secondary">Active Drivers</p>
                                                <h4 class="my-1 text-info t-c-2" id="active_drivers">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                <i class="fa-solid fa-user-check"></i>
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
                                                <p class="mb-0 text-secondary">Expired Licenses</p>
                                                <h4 class="my-1 text-info t-c-4" id="expired_licenses">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                <i class="fa-solid fa-file-xmark"></i>
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
                                                <p class="mb-0 text-secondary">Upcoming Expirations</p>
                                                <h4 class="my-1 text-info t-c-3" id="upcoming_expitations">-</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                <i class="fa-solid fa-memo-circle-info"></i>
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
                    <div class="col-sm-12 table-responsive">
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
    <div class="pop-up-card scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Add new driver</h4>
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
                            <h4 class="heading">Driver Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" name="imageUpload"
                                            accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" title="Click plus to upload"
                                            style="background-image: url(../../Assets/Developer/image/manager.png);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="input-field" name="fullname"
                                            placeholder="Full Name" required/>
                                        <input type="number" class="input-field" name="mobile"
                                            placeholder="Mobile Number" required/>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" class="input-field" name="email" placeholder="Mail ID" required/>
                                        <input type="text" class="input-field" name="password" placeholder="Password" required/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="text" class="input-field" name="address" placeholder="Address" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" class="input-field" name="state" placeholder="State" />
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="input-field" name="district" placeholder="District" />
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="input-field" name="pincode" placeholder="Pin Code" />
                            </div>
                        </div>

                    </div>
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Documents</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 double-input">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload Driving Licence</span>
                                    <br>
                                    <input type="file" class="form-control-file" id="driving-licence"
                                        name="driving-licence" accept="image/*,.pdf" />
                                </label>
                                <input type="text" class="input-field" name="driving-licence-no"
                                    placeholder="Driving Licence Number" required/>
                                <label for="" class="input-label">Licence Expiry Date</label>
                                <input type="date" class="input-field" name="licence-expiry" required/>

                            </div>
                            <div class="col-sm-4 double-input">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload Aadhar Card</span>
                                    <br>
                                    <input type="file" class="form-control-file" id="aadhar-card" name="aadhar-card"
                                        accept="image/*,.pdf" />
                                </label>
                                <input type="number" class="input-field" name="aadhar-no" placeholder="Aadhar Number" />
                            </div>
                            <div class="col-sm-4 double-input">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload PAN Card</span>
                                    <br>
                                    <input type="file" class="form-control-file" id="pan-card" name="pan-card"
                                        accept="image/*,.pdf" />
                                </label>
                                <input type="text" class="input-field" name="pan-no" placeholder="PAN Number" />
                            </div>

                        </div>
                    </div>

                    <div class="pop-up-button-div box-container box-head m-b-10">
                        <button type="submit" name="submit" class="button-2 box-shadow">Create Driver</button>
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
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Driver Details</h4>
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
                    <div class="col-sm-3 p-r-0 m-b-10">
                        <div class="driver-info-left box-container-2 h-100">
                            <div class="row">
                                <div class="col-sm-12 info-profile-image-div">
                                    <img id="d-v-profile-img" src="../../Assets/Developer/image/manager.png"
                                        alt="profile image" class="info-profile-image">
                                </div>
                                <div class="col-sm-12">
                                    <div class="info-div">
                                        <p class="info-title">Personal information</p>
                                        <div class="infos">
                                            <p class="info-heading">Name</p>
                                            <p class="info-content" id="d-v-name"></p>
                                        </div>
                                        <div class="infos">
                                            <p class="info-heading">Email</p>
                                            <p class="info-content" id="d-v-mail"></p>
                                        </div>
                                        <div class="infos">
                                            <p class="info-heading">Mobile Number</p>
                                            <p class="info-content" id="d-v-mobile"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row row-head">
                                <div class="content">
                                    <div class="container-fluid">
                                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Total Kilometers</p>
                                                                    <h4 class="my-1 text-info">20</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
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
                                                                    <p class="mb-0 text-secondary">Fuel Efficiency
                                                                    </p>
                                                                    <h4 class="my-1 text-info t-c-2">15</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
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
                                                                    <p class="mb-0 text-secondary">Safety Score
                                                                    </p>
                                                                    <h4 class="my-1 text-info t-c-5">-</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                                    <i class="fa-solid fa-shield-check"></i>
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
                                <p class="info-title">Driver information</p>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Licence Number</p>
                                        <p class="info-content" id="d-v-licence-no"></p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Licence Expiry Date</p>
                                        <p class="info-content" id="d-v-licence-ex"></p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Aadhar Number</p>
                                        <p class="info-content" id="d-v-aadhar-no"></p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">PAN Number</p>
                                        <p class="info-content" id="d-v-pan-no"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Documents</p>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Licence</p>
                                        <a href="" id="d-v-licence-path" class="document-view d-v-1" target="_blank">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Aadhar card</p>
                                        <a href="" id="d-v-aadhar-path" class="document-view d-v-2" target="_blank">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">PAN card</p>
                                        <a href="" id="d-v-pan-path" class="document-view  d-v-3" target="_blank">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="driver-info-bottom box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Location information</p>
                                <div class="col-sm-6">
                                    <div class="infos">
                                        <p class="info-heading">Address</p>
                                        <p class="info-content" id="d-v-address"></p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">District</p>
                                        <p class="info-content" id="d-v-district"></p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">State</p>
                                        <p class="info-content" id="d-v-state"></p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="infos">
                                        <p class="info-heading">Pincode</p>
                                        <p class="info-content" id="d-v-pincode"></p>
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
    <div class="pop-up-card scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Update Driver Details</h4>
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
            <div class="container driver-info" style="display: none">
                <form enctype="multipart/form-data" id="driver-edit-form">
                    <input type="hidden" name="driver_id" id="d-e-driver-id">
                    <div class="row">
                        <div class="col-sm-3 p-r-0 m-b-10">
                            <div class="driver-info-left box-container-2 h-100">
                                <div class="row">
                                    <div class="col-sm-12 info-profile-image-div">
                                        <img id="edit-d-v-profile-img" src="../../Assets/Developer/image/manager.png"
                                            alt="profile image" class="info-profile-image-re-upload">
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="file-input m-t-10">
                                            <input type="file" name="driver_image_path" id="file-input"
                                                class="reupload-file-input__input" />
                                            <label class="reupload-file-input__label" for="file-input">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                    data-icon="upload" class="svg-inline--fa fa-upload fa-w-16"
                                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                    <path fill="currentColor"
                                                        d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                    </path>
                                                </svg>
                                                <span>Re-upload image</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="info-div">
                                            <p class="info-title">Personal information</p>
                                            <div class="infos">
                                                <p class="info-heading">Name</p>
                                                <input type="text" class="input-field m-0" name="fullname"
                                                    id="d-e-name" />
                                            </div>
                                            <div class="infos">
                                                <p class="info-heading">Email</p>
                                                <input type="text" class="input-field m-0" name="mail" id="d-e-mail"
                                                    disabled title="You cannot edit email address" />
                                            </div>
                                            <div class="infos">
                                                <p class="info-heading">Mobile Number</p>
                                                <input type="number" class="input-field m-0" name="mobile"
                                                    id="d-e-mobile" />
                                            </div>
                                            <div class="infos">
                                                <p class="info-heading">Password</p>
                                                <input type="text" class="input-field m-0" name="password" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Driver information</p>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Licence Number</p>
                                            <input type="text" class="input-field m-0" name="licence_no"
                                                id="d-e-licence-no" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Licence Expiry Date</p>
                                            <input type="date" class="input-field m-0" name="licence_expiry"
                                                id="d-e-licence-ex" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Aadhar Number</p>
                                            <input type="number" class="input-field m-0" name="aadhar_no"
                                                id="d-e-aadhar-no" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">PAN Number</p>
                                            <input type="text" class="input-field m-0" name="pan_no" id="d-e-pan-no" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Documents</p>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Licence</p>
                                            <a href="" id="d-e-licence-path" class="document-view d-v-1 m-t-10"
                                                target="_blank">
                                                <i class="fa-duotone fa-file-invoice"></i>
                                            </a>
                                            <div class="file-input m-t-20">
                                                <input type="file" name="licence_path" id="licence_path"
                                                    class="reupload-file-input__input" />
                                                <label class="reupload-file-input__label" for="licence_path">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                        data-icon="upload" class="svg-inline--fa fa-upload fa-w-16"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512">
                                                        <path fill="currentColor"
                                                            d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                        </path>
                                                    </svg>
                                                    <span>Re-upload Licence</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Aadhar card</p>
                                            <a href="" id="d-e-aadhar-path" class="document-view d-v-2" target="_blank">
                                                <i class="fa-duotone fa-file-invoice"></i>
                                            </a>
                                            <div class="file-input m-t-20">
                                                <input type="file" name="aadhar_path" id="aadhar_path"
                                                    class="reupload-file-input__input" />
                                                <label class="reupload-file-input__label" for="aadhar_path">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                        data-icon="upload" class="svg-inline--fa fa-upload fa-w-16"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512">
                                                        <path fill="currentColor"
                                                            d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                        </path>
                                                    </svg>
                                                    <span>Re-upload Aadhar</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">PAN card</p>
                                            <a href="" id="d-e-pan-path" class="document-view  d-v-3" target="_blank">
                                                <i class="fa-duotone fa-file-invoice"></i>
                                            </a>
                                            <div class="file-input m-t-20">
                                                <input type="file" name="pan_path" id="pan_path"
                                                    class="reupload-file-input__input" />
                                                <label class="reupload-file-input__label" for="pan_path">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                        data-icon="upload" class="svg-inline--fa fa-upload fa-w-16"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512">
                                                        <path fill="currentColor"
                                                            d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                                        </path>
                                                    </svg>
                                                    <span>Re-upload PAN</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Location information</p>
                                    <div class="col-sm-6">
                                        <div class="infos">
                                            <p class="info-heading">Address</p>
                                            <input type="text" class="input-field m-0" name="address"
                                                id="d-e-address" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">District</p>
                                            <input type="text" class="input-field m-0" name="district"
                                                id="d-e-district" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">State</p>
                                            <input type="text" class="input-field m-0" name="state" id="d-e-state" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">Pincode</p>
                                            <input type="text" class="input-field m-0" name="pincode"
                                                id="d-e-pincode" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pop-up-button-div box-container-sm m-b-10">
                                <button type="submit" name="submit" class="button-2 box-shadow"
                                    onclick="popupClose('driver-edit')">Update Driver</button>
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
<script src="./Js/driver.js"></script>
<script src="./Js/drivers_ajax.js"></script>
<?php
require_once './footer.php';
?>