//buses as globel variable
let buses;

//Fuel type as  globle variable
let fuelTypes;

//Drivers as  globle variable
let drivers;

//Chart as globle variable
let chartInstance = null;

//Get driver Table data 
getFuelReports();

async function getFuelReports() {  
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Loading..", 4000], ["please wait a moment..", 4000]];
        progressLoader(array);
        var formData = new FormData();
        formData.append('days', 7);
        formData.append('filter-from-date', '');
        formData.append('filter-to-date', '');
        formData.append('filter-bus', '');
        formData.append('filter-fuel-type', '');
        formData.append('filter-fuel-cost-from', '');
        formData.append('filter-fuel-cost-to', '');
        formData.append('orderBy', 'DESC');
        formData.append('action', 'applyFilter');

        $.ajax({
            type: 'POST',
            url: '../Controllers/FuelReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    //Card
                    let cardDetails = data.cardCount;
                    document.getElementById("total-amount").innerHTML = cardDetails.totalAmount;
                    document.getElementById("total-liters").innerHTML = cardDetails.totalLiters;
                    document.getElementById("re-fueled").innerHTML = cardDetails.reFueled;

                    //Fuel Report Table
                    let reports = data.fuelReport;

                    let table = $('#fuel-report-table').DataTable();

                    // Clear the DataTable
                    table.clear(); 

                    $.each(reports, function (index, item) {
                        let billUrl = "";
                        let billIcon = "-";
                        if (item.bill != "") {
                            billUrl = "../../Assets/User/"+item.bill;
                            billIcon = '<i class="fa-solid fa-receipt"></i>';
                        }
                        
                        let row = [
                            index + 1,
                            item.busNumber,
                            item.date,
                            item.fuelType,
                            item.liters,
                            item.amount,
                            `<div class="th-btn bill"><a href="${billUrl}" target="_blank">${billIcon}</a></div>`,
                            `<div class="th-btn">
                                <button class="table-btn edit" onclick="popupOpen('edit'); getFuelReportForEdit(${item.fuelReportId});"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteFuelReport(${item.fuelReportId}, '${item.busNumber}', '${item.date}')"><i class="fa-duotone fa-trash"></i></button>
                            </div>`
                        ]
                        table.row.add(row);
                    })
                    table.draw();

                    //Chart
                    let chartData = data.chartData;
                    const ctx = document.getElementById("chart");

                    if (chartInstance) {
                        chartInstance.destroy();
                    }

                    Chart.defaults.color = "#272626";
                    // Chart.defaults.font.family = "Poppins";

                    chartInstance = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: chartData.labels,
                            datasets: [
                                {
                                    label: "",
                                    data: chartData.data,
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
                }
                else if (data.status === 'error') {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function (response) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        });
}

// function getFuelReports() {
//     let formData1 = {
//         action: 'getFuelReportCardDetails'
//     }
//     $.ajax({
//         type: 'POST',
//         url: '../Controllers/FuelReportController.php',
//         data: formData1,
//         dataType: 'json',
//         success: function (response) {
//             console.log(response);
//             if (response.status === 'success') {
//                 let cardDetails = response.data;
//                 document.getElementById("total-amount").innerHTML = cardDetails.totalAmount;
//                 document.getElementById("total-liters").innerHTML = cardDetails.totalLiters;
//                 document.getElementById("re-fueled").innerHTML = cardDetails.reFueled;
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error(xhr.responseText);
//             // Swal.fire({
//             //     title: "Error",
//             //     text: "Something went wrong! Please try again.",
//             //     icon: "error"
//             // });
//         }
//     });
//     let formData2 = {
//         action: 'getFuelReports'
//     }
//     $.ajax({
//         type: 'POST',
//         url: '../Controllers/FuelReportController.php',
//         data: formData2,
//         dataType: 'json',
//         success: function (response) {
//             console.log(response);
//             if (response.status === 'success') {
//                 let reports = response.data;
//                 console.log(reports);

//                 let tableBody = $('#fuel-report-table tbody');
//                 tableBody.empty();

//                 $.each(reports, function (index, item) {
//                     let billUrl = "";
//                     let billIcon = "-";
//                     if (item.bill != "") {
//                         billUrl = "../../Assets/User/"+item.bill;
//                         billIcon = '<i class="fa-solid fa-receipt"></i>';
//                     }
                    
//                     let row = '<tr>' +
//                         '<td>' + (index + 1) + '</td>' +
//                         '<td>' + item.busNumber + '</td>' +
//                         '<td>' + item.date + '</td>' +
//                         '<td>' + item.fuelType + '</td>' +
//                         '<td>' + item.liters + '</td>' +
//                         '<td>' + item.amount + '</td>' +
//                         '<td class="th-btn bill"><a href="' + billUrl + '" target="_blank">' +billIcon+ '</a></td>' +
//                         `<td>
//                             <div class="th-btn">
//                                 <button class="table-btn edit" onclick="popupOpen('edit'); getFuelReportForEdit(`+ item.fuelReportId + `);"><i
//                                                 class="fa-duotone fa-pen-to-square"></i></button>
//                                 <button class="table-btn delete" onclick="deleteFuelReport(`+ item.fuelReportId + `, '` + item.busNumber + `', '` + item.date + `')"><i class="fa-duotone fa-trash"></i></button>
//                             </div>
//                         </td>`      
//                     '</tr>';
//                     tableBody.append(row);
//                 })
//                 DataTable();
//             }
//         },
//         error: function (xhr, status, error) {
//             popupClose('driver-view');
//             console.error(xhr.responseText);
//             // Swal.fire({
//             //     title: "Error",
//             //     text: "Something went wrong! Please try again.",
//             //     icon: "error"
//             // });
//         }
//     });
// }

async function getBuses() {
    if (!buses) {
        await busesAjax();
    }

    let select = $('#bus-no');
    select.empty();  // Clear existing options

    // Add default "Select Bus" option
    select.append('<option value="" disabled selected>Select Bus</option>');

    buses.forEach((bus) => {
        select.append('<option value="' + bus.id + '">' + bus.bus_number + '</option>');
    });

    // Refresh the selectpicker to apply the changes
    // select.selectpicker('refresh');


}

//Fuel type ajax
function busesAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getBuses'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/FuelReportController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    buses = response.data;
                    resolve();
                } else {
                    reject();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })
    
}

// Create Fuel Report

$(document).ready(function () {
    $('#add-fuel-report').on('submit', function (e) {
        // alert("yes");
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Adding fuel report. Please waite..", 4000], ["Uploading fuel bill..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createFuelReport');

        $.ajax({
            type: 'POST',
            url: '../Controllers/FuelReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getFuelReports();
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    });
                }
                else if (data.status === 'error') {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        });
    });
});


//Get Fuel details for edit

async function getFuelReportForEdit(reportId) {
    if(!buses) {
        await busesAjax();
    }
    let formData = {
        reportId: reportId,
        action: 'getFuelReport'
    }
    document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/FuelReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let report = response.data;
                console.log(report);
                document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("edit-info")[0].style.display = "block";
                document.getElementById("e-fuel_report_id").value = report.fuelReportId;

                //Bus
                let select = $('#e-bus_id');
                select.empty();  // Clear existing options

                // Add default "Select Bus" option
                select.append('<option value="" disabled>Select Bus</option>');

                buses.forEach((bus) => {
                    if (bus.id == report.busId) { 
                    select.append('<option value="' + bus.id + '" selected>' + bus.bus_number + '</option>');
                    } else {
                        select.append('<option value="' + bus.id + '">' + bus.bus_number + '</option>');
                    }
                });

                // Refresh the selectpicker to apply the changes
                // select.selectpicker('refresh');

                report.date != "" ? document.getElementById("e-fuel_date").value = report.date : document.getElementById("e-fuel_date").value = "";
                report.liters != "" ? document.getElementById("e-fuel_quantity").value = report.liters : document.getElementById("e-fuel_quantity").value = "";
                report.amount != "" ? document.getElementById("e-fuel_cost").value = report.amount : document.getElementById("e-fuel_cost").value = "";
                
                report.bill != "" ? document.getElementById("e-bill-path").href = "../../Assets/User/" + report.bill : document.getElementById("e-bill-path").href = "";
                report.bill != "" ? document.getElementById("e-bill-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("e-bill-path").innerHTML = "No bill";


            }
            else if (response.status === 'error') {
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("bus-info")[1].style.display = "block";
                popupClose('bus-edit');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('bus-edit');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("edit-info")[0].style.display = "block";
            popupClose('edit');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

//Update Fuel report

$(document).ready(function () {
    $('#edit-fuel-report').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Updating fuel report. Please wait..", 4000], ["please wait a moment..", 4000], ["Uploading fuel bill..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'updateFuelReport');

        $.ajax({
            type: 'POST',
            url: '../Controllers/FuelReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getFuelReports();
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    });
                }
                else if (data.status === 'error') {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: "Oops!",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function (response) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        });
    });
});

//Delete Fuel Report

function deleteFuelReport(reportId, busNo, date) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + busNo + " from the " + date + " fuel report?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            //Calling progress bar
            popupOpen("progress-loader");
            let array = [["Deleting bus. Please wait..", 4000], ["Deleting bus documents..", 4000], ["Please wait a moment..", 4000]];
            progressLoader(array);
            let formData = {
                reportId: reportId,
                action: 'deleteFuelReport'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/FuelReportController.php',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    popupClose("progress-loader");
                    // let data = JSON.parse(response);
                    if (data.status === 'success') {
                        getFuelReports();
                        Swal.fire({
                            title: "Deleted!",
                            text: data.message,
                            icon: "success"
                        });
                    }
                    else if (data.status === 'error') {
                        Swal.fire({
                            title: "Oops!",
                            text: data.message,
                            icon: "error"
                        });
                    } else {
                        Swal.fire({
                            title: "Oops!",
                            text: data.message,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        title: "Oops!",
                        text: "Something went wrong! Please try again.",
                        icon: "error"
                    });
                }
            });
        }
    });
}

//Get Field for Filter
async function getFilterField() {
    if(!buses) {
        await busesAjax();
    }

    //Bus
    let select = $('#filter-bus');
    select.empty();  // Clear existing options

    // Add default "Select Bus" option
    select.append('<option value="" disabled selected>Select Bus</option>');

    buses.forEach((bus) => {
        select.append('<option value="' + bus.id + '">' + bus.bus_number + '</option>');
    });

    // Refresh the selectpicker to apply the changes
    // select.selectpicker('refresh');

    //Fuel Type
    if (!fuelTypes) {
        await fuelTypeAjax();
    }
    let select2 = $('#filter-fuel-type');
    select2.empty();
    select2.append('<option value="" disabled selected>Select Fuel Type</option>');

    fuelTypes.forEach(fuelType => {
        select2.append('<option value="' + fuelType.id + '">' + fuelType.fuel + '</option>');
    });

    // Refresh the selectpicker to apply the changes
    // select2.selectpicker('refresh');

    //Driver
    // if (!drivers) {
    //     await driverAjax();
    // }
    // let select3 = $('#filter-driver');
    // select3.empty();  // Clear existing options

    // // Add default "Select Bus" option
    // select3.append('<option value="" disabled selected>Select Driver</option>');

    // drivers.forEach((driver) => {
    //     select3.append('<option value="' + driver.id + '">' + driver.fullname + '</option>');
    // });

    // // Refresh the selectpicker to apply the changes
    // select3.selectpicker('refresh');
}

//Fuel type ajax
function fuelTypeAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getFuelType'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/BusController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    fuelTypes = response.data;
                    resolve();
                } else {
                    reject();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })
    
}

//Driver ajax
function driverAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getDriverField'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/DriverController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    drivers = response.data;
                    resolve();
                } else {
                    reject();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                reject();
                // Swal.fire({
                //     title: "Error",
                //     text: "Something went wrong! Please try again.",
                //     icon: "error"
                // });
            }
        });
    })
    
}

$('#filter').on('reset', function() {
    // Reset the selectpicker
    $('#filter-bus').selectpicker('val', '');  // Reset Bus selectpicker
    $('#filter-driver').selectpicker('val', '');  // Reset Driver selectpicker

    // Refresh the selectpicker to reflect the changes in the UI
    $('#filter-bus').selectpicker('refresh');
    $('#filter-driver').selectpicker('refresh');
});

function unSelect() {
    document.querySelectorAll('[name="days"]').forEach(function(radio) {
        radio.checked = false;
    });
}

function uncheck() {
    document.querySelector('input[name="filter-from-date"]').value = '';
    document.querySelector('input[name="filter-to-date"]').value = '';
}

//Add Filter

// $(document).ready(function () {
//     $('#filter-form').on('submit', function (e) {
//         e.preventDefault();
//         //Calling progress bar
//         popupOpen("progress-loader");
//         let array = [["Applying filter..", 4000], ["please wait a moment..", 4000], ["Uploading fuel bill..", 4000]];
//         progressLoader(array);
//         var formData = new FormData(this);
//         formData.append('orderBy', 'ASC');
//         formData.append('action', 'applyFilter');

//         $.ajax({
//             type: 'POST',
//             url: '../Controllers/FuelReportController.php',
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function (response) {
//                 console.log(response);
//                 popupClose("progress-loader");
//                 let data = JSON.parse(response);
//                 if (data.status === 'success') {
//                     //Card
//                     let cardDetails = data.cardCount;
//                     document.getElementById("total-amount").innerHTML = cardDetails.totalAmount;
//                     document.getElementById("total-liters").innerHTML = cardDetails.totalLiters;
//                     document.getElementById("re-fueled").innerHTML = cardDetails.reFueled;

//                     //Fuel Report Table
//                     let reports = data.fuelReport;

//                     let table = $('#fuel-report-table').DataTable();

//                     // Clear the DataTable
//                     table.clear(); 

//                     $.each(reports, function (index, item) {
//                         let billUrl = "";
//                         let billIcon = "-";
//                         if (item.bill != "") {
//                             billUrl = "../../Assets/User/"+item.bill;
//                             billIcon = '<i class="fa-solid fa-receipt"></i>';
//                         }
                        
//                         let row = [
//                             index + 1,
//                             item.busNumber,
//                             item.date,
//                             item.fuelType,
//                             item.liters,
//                             item.amount,
//                             `<div class="th-btn bill"><a href="${billUrl}" target="_blank">${billIcon}</a></div>`,
//                             `<div class="th-btn">
//                                 <button class="table-btn edit" onclick="popupOpen('edit'); getFuelReportForEdit(${item.fuelReportId});"><i
//                                                 class="fa-duotone fa-pen-to-square"></i></button>
//                                 <button class="table-btn delete" onclick="deleteFuelReport(${item.fuelReportId}, '${item.busNumber}', '${item.date}')"><i class="fa-duotone fa-trash"></i></button>
//                             </div>`
//                         ]
//                         table.row.add(row);
//                     })
//                     table.draw();

//                     //Chart
//                     let chartData = data.chartData;
//                     const ctx = document.getElementById("chart");

//                     if (chartInstance) {
//                         chartInstance.destroy();
//                     }

//                     Chart.defaults.color = "#272626";
//                     // Chart.defaults.font.family = "Poppins";

//                     chartInstance = new Chart(ctx, {
//                         type: "line",
//                         data: {
//                             labels: chartData.labels,
//                             datasets: [
//                                 {
//                                     label: "",
//                                     data: chartData.data,
//                                     backgroundColor: "black",
//                                     borderColor: "coral",
//                                     borderRadius: 6,
//                                     cubicInterpolationMode: 'monotone',
//                                     fill: false,
//                                     borderSkipped: false,
//                                 },
//                             ],
//                         },
//                         options: {
//                             interaction: {
//                                 intersect: false,
//                                 mode: 'index'
//                             },
//                             elements: {
//                                 point: {
//                                     radius: 0
//                                 }
//                             },
//                             responsive: true,
//                             maintainAspectRatio: false,
//                             plugins: {
//                                 legend: {
//                                     display: false,
//                                 },
//                                 tooltip: {
//                                     backgroundColor: "orange",
//                                     bodyColor: "#272626",
//                                     yAlign: "bottom",
//                                     cornerRadius: 4,
//                                     titleColor: "#272626",
//                                     usePointStyle: true,
//                                     callbacks: {
//                                         label: function (context) {
//                                             if (context.parsed.y !== null) {
//                                                 const label = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'INR' }).format(context.parsed.y);
//                                                 return label;
//                                             }
//                                             return null;
//                                         }
//                                     }
//                                 },
//                             },
//                             scales: {
//                                 x: {
//                                     border: {
//                                         dash: [4, 4],
//                                     },
//                                     title: {
//                                         text: "2023",
//                                     },
//                                 },
//                                 y: {
//                                     grid: {
//                                         color: "#27292D",
//                                     },
//                                     border: {
//                                         dash: [1, 2],
//                                     }
//                                 },
//                             },
//                         },
//                     });
//                 }
//                 else if (data.status === 'error') {
//                     Swal.fire({
//                         title: "Oops!",
//                         text: data.message,
//                         icon: "error"
//                     });
//                 } else {
//                     Swal.fire({
//                         title: "Oops!",
//                         text: data.message,
//                         icon: "error"
//                     });
//                 }
//             },
//             error: function (response) {
//                 console.error(xhr.responseText);
//                 Swal.fire({
//                     title: "Oops!",
//                     text: "Something went wrong! Please try again.",
//                     icon: "error"
//                 });
//             }
//         });
//     });
// });


// Function to get the start of the month for a given date
function getStartOfMonth(date) {
    return new Date(date.getFullYear(), date.getMonth(), 1);
}

// Function to add days to a given date
function addDays(date, days) {
    const newDate = new Date(date);
    newDate.setDate(newDate.getDate() + days);
    return newDate;
}

function getSixMonthsAgoDate() {
    return new Promise((resolve, reject) => {
        // Get the current date
        const currentDate = new Date();

        // Create a new date object for 6 months ago
        const sixMonthsAgo = new Date(currentDate);
        sixMonthsAgo.setMonth(currentDate.getMonth() - 6);

        // Get the start of the month for the date 6 months ago
        const startOfSixMonthsAgo = getStartOfMonth(sixMonthsAgo);

        // Add 1 day to the start of the month
        const adjustedDate = addDays(startOfSixMonthsAgo, 1);

        // Resolve the promise with the adjusted date
        resolve(adjustedDate.toISOString().split('T')[0]);
    });
}

// Example usage with async/await
// async function example() {
//     try {
//         const result = await getSixMonthsAgoDate();
//         console.log(result);
//     } catch (error) {
//         console.error("Error:", error);
//     }
// }

// // Run the example function
// example();

