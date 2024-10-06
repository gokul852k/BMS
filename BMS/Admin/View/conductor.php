<?php
require_once './header.php';
require_once './navbar.php';
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">

<div class="register-conductor">
    <div class="box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="row-head-div-1">
                <h4 class="heading">Conductor Details</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('add'), getLanguageField()"><i
                        class="fa-solid fa-user-nurse"></i>Add Conductor</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="box-container w3-animate-top">
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
                                                <p class="mb-0 text-secondary">Total Conductor</p>
                                                <h4 class="my-1 text-info" id="total_drivers">-</h4>
                                            </div>
                                            <div
                                                class="text-white ms-auto">
                                                <div class="card-bg bg-gradient-scooter">
                                                <i class="fa-solid fa-user-pilot"></i>
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
                                                <p class="mb-0 text-secondary">Active Drivers</p>
                                                <h4 class="my-1 text-info t-c-2" id="active_drivers">-</h4>
                                            </div>
                                            <div
                                                class="text-white ms-auto">
                                                <div class="card-bg bg-gradient-ohhappiness">
                                                <i class="fa-solid fa-user-check"></i>
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
                                                <p class="mb-0 text-secondary">Expired Licenses</p>
                                                <h4 class="my-1 text-info t-c-4" id="expired_licenses">-</h4>
                                            </div>
                                            <div
                                                class="text-white ms-auto">
                                                <div class="card-bg bg-gradient-bloody">
                                                <i class="fa-solid fa-file-xmark"></i>
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
                                                <p class="mb-0 text-secondary">Upcoming Expirations</p>
                                                <h4 class="my-1 text-info t-c-3" id="upcoming_expitations">-</h4>
                                            </div>
                                            <div
                                                class="text-white ms-auto">
                                                <div class="card-bg bg-gradient-blooker">
                                                <i class="fa-solid fa-memo-circle-info"></i>
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
                    <div class="col-sm-12 table-responsive">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="conductors-table">

                            <thead>
                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Name</th>
                                    <th class="th">Mobile</th>
                                    <th class="th">Mail ID</th>
                                    <th class="th">District</th>
                                    <th class="th">State</th>
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

<!--Add Conductor Pop ups-->
<div class="admin-modal model-m w3-animate-top" id="add">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('add')"></div>
        <div class="admin-modal-content">
            <form enctype="multipart/form-data" id="conductor-form">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Add new conductor</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('add')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Conductor Details</h4>
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
                                        <input type="text" class="input-field" name="fullname" placeholder="Full Name"
                                            required />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" class="input-field" name="email" placeholder="Mail ID"
                                            required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="number" class="input-field" name="mobile"
                                            placeholder="Mobile Number" required />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="input-field" name="password" placeholder="Password"
                                            required />
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
                            <div class="col-sm-3">
                                <input type="text" class="input-field" name="state" placeholder="State" />
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="input-field" name="district" placeholder="District" />
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="input-field" name="pincode" placeholder="Pin Code" />
                            </div>
                            <div class="col-sm-3">
                                <select class="input-field" name="language" placeholder="language" id="language"
                                    required>

                                </select>
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
                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3">Create Conductor</button>
                    <button type="reset" class="button-2" onclick="popupClose('add')">cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--View Conductor Pop ups-->

<div class="admin-modal model-l w3-animate-top" id="view">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('view')"></div>
        <div class="admin-modal-content">
            <div class="admin-modal-header">
                <h5 class="admin-modal-title">Conductor Details</h5>
                <button type="button" class="admin-modal-close" onclick="popupClose('view')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="admin-modal-body admin-view-body">
                <div class="loader-div" style="display: none">
                    <div class="loader"></div>
                    <p class="loader-text">Loading</p>
                </div>
                <div class="container conductor-info" style="display: none">
                    <div class="row">
                        <div class="col-sm-3 p-r-0 m-b-10">
                            <div class="driver-info-left box-container-2 h-100">
                                <div class="row">
                                    <div class="col-sm-12 info-profile-image-div">
                                        <img id="v-profile-img" src="../../Assets/Developer/image/manager.png"
                                            alt="profile image" class="info-profile-image">
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="info-div">
                                            <p class="info-title">Personal information</p>
                                            <div class="infos">
                                                <p class="info-heading">Name</p>
                                                <p class="info-content" id="v-name"></p>
                                            </div>
                                            <div class="infos">
                                                <p class="info-heading">Email</p>
                                                <p class="info-content" id="v-mail"></p>
                                            </div>
                                            <div class="infos">
                                                <p class="info-heading">Mobile Number</p>
                                                <p class="info-content" id="v-mobile"></p>
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
                                                    <div
                                                        class="card radius-10 border-start border-0 border-3 border-info">
                                                        <a href="#" class="no-underline">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <p class="mb-0 text-secondary">Total Collection
                                                                        </p>
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
                                                    <div
                                                        class="card radius-10 border-start border-0 border-3 border-info">
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
                                                    <div
                                                        class="card radius-10 border-start border-0 border-3 border-info">
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
                                    <p class="info-title">Conductor information</p>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Aadhar Number</p>
                                            <p class="info-content" id="v-aadhar-no"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">PAN Number</p>
                                            <p class="info-content" id="v-pan-no"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="driver-info-right box-container-2 m-b-10">
                                <div class="row">
                                    <p class="info-title">Documents</p>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">Aadhar card</p>
                                            <a href="" id="v-aadhar-path" class="document-view d-v-2" target="_blank">
                                                <i class="fa-duotone fa-file-invoice"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="infos">
                                            <p class="info-heading">PAN card</p>
                                            <a href="" id="v-pan-path" class="document-view  d-v-3" target="_blank">
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
                                            <p class="info-content" id="v-address"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">District</p>
                                            <p class="info-content" id="v-district"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">State</p>
                                            <p class="info-content" id="v-state"></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="infos">
                                            <p class="info-heading">Pincode</p>
                                            <p class="info-content" id="v-pincode"></p>
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

<!--Edit Conductor Pop ups-->
<div class="admin-modal model-l w3-animate-top" id="edit">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('edit')"></div>
        <div class="admin-modal-content">
            <form enctype="multipart/form-data" id="conductor-edit-form">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Update Conductor Details</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('edit')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div class="loader-div" style="display: none">
                        <div class="loader"></div>
                        <p class="loader-text">Loading</p>
                    </div>
                    <div class="container conductor-info" style="display: none">
                        <input type="hidden" name="conductor_id" id="e-conductor-id">
                        <div class="row">
                            <div class="col-sm-3 p-r-0 m-b-10">
                                <div class="driver-info-left box-container-2 h-100">
                                    <div class="row">
                                        <div class="col-sm-12 info-profile-image-div">
                                            <img id="edit-v-profile-img" src="../../Assets/Developer/image/manager.png"
                                                alt="profile image" class="info-profile-image-re-upload">
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="file-input m-t-10">
                                                <input type="file" name="conductor_image_path" id="file-input"
                                                    class="reupload-file-input__input" />
                                                <label class="reupload-file-input__label" for="file-input">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                        data-icon="upload" class="svg-inline--fa fa-upload fa-w-16"
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512">
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
                                                        id="e-name" />
                                                </div>
                                                <div class="infos">
                                                    <p class="info-heading">Email</p>
                                                    <input type="text" class="input-field m-0" name="mail" id="e-mail"
                                                        disabled title="You cannot edit email address" />
                                                </div>
                                                <div class="infos">
                                                    <p class="info-heading">Mobile Number</p>
                                                    <input type="number" class="input-field m-0" name="mobile"
                                                        id="e-mobile" />
                                                </div>
                                                <div class="infos">
                                                    <p class="info-heading">Language</p>
                                                    <select class="input-field m-0" name="language" id="e-language"
                                                        required>

                                                    </select>
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
                                        <p class="info-title">Conductor information</p>
                                        <div class="col-sm-3">
                                            <div class="infos">
                                                <p class="info-heading">Aadhar Number</p>
                                                <input type="number" class="input-field m-0" name="aadhar_no"
                                                    id="e-aadhar-no" />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="infos">
                                                <p class="info-heading">PAN Number</p>
                                                <input type="text" class="input-field m-0" name="pan_no"
                                                    id="e-pan-no" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="driver-info-right box-container-2 m-b-10">
                                    <div class="row">
                                        <p class="info-title">Documents</p>
                                        <div class="col-sm-3">
                                            <div class="infos">
                                                <p class="info-heading">Aadhar card</p>
                                                <a href="" id="e-aadhar-path" class="document-view d-v-2"
                                                    target="_blank">
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
                                                <a href="" id="e-pan-path" class="document-view  d-v-3" target="_blank">
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
                                                    id="e-address" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="infos">
                                                <p class="info-heading">District</p>
                                                <input type="text" class="input-field m-0" name="district"
                                                    id="e-district" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="infos">
                                                <p class="info-heading">State</p>
                                                <input type="text" class="input-field m-0" name="state" id="e-state" />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="infos">
                                                <p class="info-heading">Pincode</p>
                                                <input type="text" class="input-field m-0" name="pincode"
                                                    id="e-pincode" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3" onclick="popupClose('edit')">Update</button>
                    <button type="reset" class="button-2" onclick="popupClose('add')">Close</button>
                </div>
            </form>
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
<script src="./Js/conductor_ajax.js"></script>
<?php
require_once './footer.php';
?>