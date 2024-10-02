<?php
require_once './header.php';
require_once './navbar.php';
// require_once '../../../Common/Common file/search_select_cdn.php';
require_once '../Services/FuelReportService.php';

?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">
<link rel="stylesheet" href="./Style/chart.css">


<div class="register-driver">
    <div class="container box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="col-sm-2 row-head-div-1">
                <h4 class="heading">Fuel Report</h4>
            </div>
            <div class="col-sm-10 row-head-div-2">
                <button class="button-1 head-button2" onclick="popupOpen('filter'), getFilterField()"><i class="fa-solid fa-filter"></i>Filter</button>
                <button class="button-1 head-button3" onclick="popupOpen('add'), getBuses()"><i
                        class="fa-solid fa-bus"></i>Add</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>


    <div class="container d-chart">
        <div class="row">
            <div class="col-4 w3-animate-left d-chart-left">
                <div class="box-container tms-card">
                    <div class="tms-card-head">
                        <div><i class="fa-duotone fa-gas-pump"></i></div>
                        <div>Fuel</div>
                    </div>
                    <div class="container tms-card-body" style="margin:0;height: 100%;width: 100%;">
                        <div class="row row-head">
                            <div class="content num-card">
                                <div class="container-fluid">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                                        <div class="col card-col-d-r">
                                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                                <a href="#" class="no-underline">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="mb-0 text-secondary">Total Amount</p>
                                                                <h4 class="my-1 text-info t-c-4" id="total-amount">-
                                                                </h4>
                                                            </div>
                                                            <div
                                                                class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                                <i class="fa-solid fa-indian-rupee-sign"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col card-col-d-r">
                                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                                <a href="./social_media_leads.php" class="no-underline">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <p class="mb-0 text-secondary">Total liters</p>
                                                                <h4 class="my-1 text-info t-c-3" id="total-liters">-
                                                                </h4>
                                                            </div>
                                                            <div
                                                                class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                                <i class="fa-solid fa-chart-simple"></i>
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
                                                                <p class="mb-0 text-secondary">Vehicle refueled</p>
                                                                <h4 class="my-1 text-info t-c-2" id="re-fueled">-</h4>
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

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8 w3-animate-right d-chart-right">
                <div class="box-container tms-card">
                    <div class="tms-card-head">
                        <div><i class="fa-duotone fa-chart-line-up"></i></div>
                        <div>Fuel Cost</div>
                    </div>
                    <div class="container tms-card-body chart-container" style="margin:0;height: 100%;width: 100%;">
                        <div class="chart-body">
                            <div class="widget">
                                <canvas id="chart"></canvas>
                            </div>
                            <script>
                                const ctx = document.getElementById("chart");

                                Chart.defaults.color = "#272626";
                                // Chart.defaults.font.family = "Poppins";

                                new Chart(ctx, {
                                    type: "line",
                                    data: {
                                        labels: ,
                                        datasets: [
                                            {
                                                label: "",
                                                data: ,
                                                backgroundColor: "black",
                                                borderColor: "coral",
                                                borderRadius: 6,
                                                cubicInterpolationMode: 'monotone',
                                                fill: false,
                                                borderSkipped: false,
                                            },
                                        ],
                                    },
                                    options: {
                                        interaction: {
                                            intersect: false,
                                            mode: 'index'
                                        },
                                        elements: {
                                            point: {
                                                radius: 0
                                            }
                                        },
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: {
                                                display: false,
                                            },
                                            tooltip: {
                                                backgroundColor: "orange",
                                                bodyColor: "#272626",
                                                yAlign: "bottom",
                                                cornerRadius: 4,
                                                titleColor: "#272626",
                                                usePointStyle: true,
                                                callbacks: {
                                                    label: function (context) {
                                                        if (context.parsed.y !== null) {
                                                            const label = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'INR' }).format(context.parsed.y);
                                                            return label;
                                                        }
                                                        return null;
                                                    }
                                                }
                                            },
                                        },
                                        scales: {
                                            x: {
                                                border: {
                                                    dash: [4, 4],
                                                },
                                                title: {
                                                    text: "2023",
                                                },
                                            },
                                            y: {
                                                grid: {
                                                    color: "#27292D",
                                                },
                                                border: {
                                                    dash: [1, 2],
                                                }
                                            },
                                        },
                                    },
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container box-container w3-animate-bottom">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive" id="fuel-report-table">

                            <thead>
                                <tr>
                                    <th class="th">S.No</th>
                                    <th class="th">Bus Number</th>
                                    <th class="th">Date</th>
                                    <th class="th">Fuel Type</th>
                                    <th class="th">Liters</th>
                                    <th class="th">Amount</th>
                                    <th class="th">Bill</th>
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

<!--Add Fuel Report Pop ups-->
<div class="admin-modal model-sm" id="add">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('add')"></div>
        <div class="admin-modal-content">
            <form id="add-fuel-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Add Fuel Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('add')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="admin-modal-body">
                    <div class="row p-20">
                        <div class="col-sm-12">
                            <label for="" class="input-label">Bus No</label>
                            <select class="input-field" name="bus-id" id="bus-no">

                            </select>
                        </div>

                        <div class="col-sm-12">
                            <label for="" class="input-label">Date</label>
                            <input type="date" class="input-field" name="date" placeholder="" required />
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Total Liters</label>
                            <input type="text" class="input-field" name="fuel-liters" placeholder="" required />
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Amount</label>
                            <input type="text" class="input-field" name="fuel-amount" placeholder="" required />
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlFile1" class="drop-container input-label" id="dropcontainer">
                                <span class="drop-title">Upload Fuel Bill</span>
                                <br>
                                <input type="file" class="form-control-file" name="fuel-bill" accept="image/*,.pdf" />
                            </label>
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

<!--Edit Fuel Report Pop ups-->
<div class="admin-modal model-sm" id="edit">
    <div class="admin-container">
        <div class="admin-modal-bg" onclick="popupClose('edit')"></div>
        <div class="admin-modal-content">
            <form id="edit-fuel-report">
                <div class="admin-modal-header">
                    <h5 class="admin-modal-title">Edit Fuel Report</h5>
                    <button type="button" class="admin-modal-close" onclick="popupClose('edit')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="loader-div" style="display: none">
                    <div class="loader"></div>
                    <p class="loader-text">Loading</p>
                </div>
                <div class="admin-modal-body edit-info" style="display: none">
                    <div class="row p-20">
                        <input type="hidden" name="fuel_report_id" id="e-fuel_report_id">
                        <div class="col-sm-12">
                            <label for="" class="input-label">Bus No</label>
                            <select class="input-field" name="bus_id" id="e-bus_id">

                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Date</label>
                            <input type="date" class="input-field" name="fuel_date" id="e-fuel_date" placeholder=""
                                required />
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Total Liters</label>
                            <input type="text" class="input-field" name="fuel_quantity" id="e-fuel_quantity"
                                placeholder="" required />
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Amount</label>
                            <input type="text" class="input-field" name="fuel_cost" id="e-fuel_cost" placeholder=""
                                required />
                        </div>
                        <div class="col-sm-6">
                            <div class="infos">
                                <p class="info-heading-2">Bill</p>
                                <a href="" id="e-bill-path" class="document-view-2 d-v-2 m-t-10" target="_blank">

                                </a>
                                <div class="file-input m-t-20">
                                    <input type="file" name="fuel_bill_url" id="fuel_bill_url"
                                        class="reupload-file-input__input" />
                                    <label class="reupload-file-input__label" for="fuel_bill_url">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload"
                                            class="svg-inline--fa fa-upload fa-w-16" role="img"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path fill="currentColor"
                                                d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z">
                                            </path>
                                        </svg>
                                        <span>Re-upload Bill</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="admin-modal-footer">
                    <button type="submit" class="button-3" onclick="popupClose('edit')">Update Fuel</button>
                    <button type="reset" class="button-2" onclick="popupClose('edit')">Close</button>
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
                    <div class="row p-20">
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
                            <div class="form-group filter-date m-b-20">
                                <span>From</span>
                                <input type="date" name="filter-from-date" class="form-field" onchange="unSelect()">
                            </div>
                            <div class="form-group filter-date m-b-20">
                                <input type="date" name="filter-to-date" class="form-field" onchange="unSelect()">
                                <span>To</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Bus No</label>
                            <select class="input-field" name="filter-bus" id="filter-bus">

                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Fuel Type</label>
                            <select class="input-field" name="filter-fuel-type" id="filter-fuel-type">

                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="" class="input-label">Fuel Cost Range</label>
                            <div class="form-group filter-date m-b-20">
                                <span>From</span>
                                <input type="number" name="filter-fuel-cost-from" class="form-field">
                            </div>
                            <div class="form-group filter-date m-b-20">
                                <input type="number" name="filter-fuel-cost-to" class="form-field">
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
<script src="./Js/fuel_report_ajax.js"></script>
<?php
require_once './footer.php';
?>