//Get Daily Report Table data 
getDailyReports();

function getDailyReports() {
    // let formData1 = {
    //     action: 'getBusCardDetails'
    // }
    // $.ajax({
    //     type: 'POST',
    //     url: '../Controllers/BusController.php',
    //     data: formData1,
    //     dataType: 'json',
    //     success: function (response) {
    //         console.log(response);
    //         if (response.status === 'success') {
    //             let cardDetails = response.data;
    //             document.getElementById("total-bus").innerHTML = cardDetails.total_bus;
    //             document.getElementById("total-km").innerHTML = cardDetails.total_km;
    //             document.getElementById("avg-mileage").innerHTML = cardDetails.avg_mileage;
    //             document.getElementById("cost-per-km").innerHTML = cardDetails.cost_per_km;
    //             document.getElementById("expitations").innerHTML = cardDetails.expired_licenses;
    //         }
    //     },
    //     error: function (xhr, status, error) {
    //         console.error(xhr.responseText);
    //         // Swal.fire({
    //         //     title: "Error",
    //         //     text: "Something went wrong! Please try again.",
    //         //     icon: "error"
    //         // });
    //     }
    // });
    // let formData2 = {
    //     action: 'getDailyReports'
    // }
    // $.ajax({
    //     type: 'POST',
    //     url: '../Controllers/DailyReportController.php',
    //     data: formData2,
    //     dataType: 'json',
    //     success: function (response) {
    //         console.log(response);
    //         if (response.status === 'success') {
    //             let busDetails = response.data;
    //             console.log(busDetails);

    //             let tableBody = $('#daily-report-table tbody');
    //             tableBody.empty();

    //             $.each(busDetails, function (index, item) {
    //                 let row = '<tr>' +
    //                     '<td>' + (index + 1) + '</td>' +
    //                     '<td>' + item.date + '</td>' +
    //                     '<td>' + item.busNumber + '</td>' +
    //                     '<td>' + item.km + '</td>' +
    //                     '<td>' + item.fuelUsage + '</td>' +
    //                     '<td>' + item.avgMilage + '</td>' +
    //                     '<td>' + item.passenger + '</td>' +
    //                     '<td>' + item.collection + '</td>' +
    //                     '<td>' + item.expenses + '</td>' +
    //                     '<td>' + item.fuelAmount + '</td>' +
    //                     '<td>' + item.salary + '</td>' +
    //                     '<td>' + item.commission + '</td>' +
    //                     '<td>' + item.profit + '</td>' +
    //                     `<td>
    //                         <div class="th-btn">
    //                             <button class="table-btn view" onclick="popupOpen('view'); getDailyReportDetails(`+ item.reportId + `);" title="View"><i
    //                                             class="fa-duotone fa-eye"></i></button>
    //                             <button class="table-btn edit" onclick="popupOpen('edit'); getDailyReportForEdit(`+ item.reportId + `);" title="Edit"><i
    //                                             class="fa-duotone fa-pen-to-square"></i></button>
    //                             <button class="table-btn delete" onclick="deleteBus(`+ item.reportId + `, '` + item.bus_number + `')" title="Delete"><i class="fa-duotone fa-trash"></i></button>
    //                         </div>
    //                     </td>`      
    //                 '</tr>';
    //                 tableBody.append(row);
    //             })
    //             DataTable();
    //         }
    //     },
    //     error: function (xhr, status, error) {
    //         popupClose('driver-view');
    //         console.error(xhr.responseText);
    //         // Swal.fire({
    //         //     title: "Error",
    //         //     text: "Something went wrong! Please try again.",
    //         //     icon: "error"
    //         // });
    //     }
    // });

    let formData1 = {
        days: 7,
        fromDate: '',
        toDate: '',
        bus: '',
        collectionFrom: '',
        collectionTo: '',
        profitFrom: '',
        profitTo: '',
        kmFrom: '',
        kmTo: '',
        orderBy: 'DESC',
        action: 'applyFilter'
    }

    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData1,
        dataType: 'json',
        success: function (data) {
            console.log(data);
            // let data = JSON.parse(response);
            if (data.status === 'success') {
                //Card
                let cardDetails = data.cardCount;
                document.getElementById("c-total-km").innerHTML = cardDetails.totalKm;
                document.getElementById("c-fuel-usage").innerHTML = cardDetails.fuelUsage;
                document.getElementById("c-avg-mileage").innerHTML = cardDetails.avgMilage;
                document.getElementById("c-passangers").innerHTML = cardDetails.passengers;
                document.getElementById("c-collection").innerHTML = cardDetails.collection;
                document.getElementById("c-expense").innerHTML = cardDetails.expenses;
                document.getElementById("c-fuel-amount").innerHTML = cardDetails.fuelAmount;
                document.getElementById("c-salary").innerHTML = cardDetails.salary;
                document.getElementById("c-commission").innerHTML = cardDetails.commission;
                document.getElementById("c-profit").innerHTML = cardDetails.profit;


                // Assuming DataTables is already initialized on '#daily-report-table'
                let table = $('#daily-report-table').DataTable(); // Initialize the DataTable

                // Clear the DataTable
                table.clear(); 

                // Daily Report Data
                let reports = data.dailyReport;

                // Iterate over reports and add rows to the DataTable
                $.each(reports, function (index, report) {
                    let row = [
                        index + 1, // Add index
                        report.date,
                        report.busNumber,
                        report.km,
                        report.fuelUsage,
                        report.avgMilage,
                        report.passenger,
                        report.collection,
                        report.expenses,
                        report.fuelAmount,
                        report.salary,
                        report.commission,
                        report.profit,
                        `<div class="th-btn">
                            <button class="table-btn view" onclick="popupOpen('view'); getDailyReportDetails(${report.reportId});" title="View">
                                <i class="fa-duotone fa-eye"></i>
                            </button>
                            <button class="table-btn edit" onclick="popupOpen('edit'); getDailyReportForEdit(${report.reportId});" title="Edit">
                                <i class="fa-duotone fa-pen-to-square"></i>
                            </button>
                            <button class="table-btn delete" onclick="deleteBus(${report.reportId}, '${report.busNumber}')" title="Delete">
                                <i class="fa-duotone fa-trash"></i>
                            </button>
                        </div>`
                    ];

                    // Add the new row to the DataTable
                    table.row.add(row);
                });

                // Redraw the DataTable to show the new data
                table.draw();

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

//Add Daily Report
$(document).ready(function () {
    $('#add-daily-report').on('submit', function (e) {
        // alert("yes");
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Adding Daily report. Please waite..", 4000], ["Calculating Daily report..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createDailyReport');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getDailyReports();
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

//Edit Daily Report

function getDailyReportForEdit(reportId) {
    let formData = {
        reportId: reportId,
        action: 'getDailyReportForEdit'
    }
    // document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                displayEdit(response.data);
            }
            else if (response.status === 'error') {
                popupClose('edit');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('edit');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('bus-view');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

//Update Daily Report
$(document).ready(function () {
    $('#edit-daily-report').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('edit');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Adding Daily report. Please waite..", 4000], ["Calculating Daily report..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('deletedItems', JSON.stringify(deletedItems));
        formData.append('action', 'updateDailyReport');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getDailyReports();
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

function getDailyReportDetails(reportId) {
    let formData = {
        reportId: reportId,
        action: 'getDailyReportDetails'
    }
    // document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                displayView(response.data);
            }
            else if (response.status === 'error') {
                popupClose('view');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('edit');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('bus-view');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}


// function reCalculateDailyReport(reportId) {
//     let formData = {
//         reportId: reportId,
//         action: 'reCalculateDailyReport'
//     }
//     //Calling progress bar
//     popupOpen("progress-loader");
//     let array = [["Calculating Daily report. Please waite..", 4000], ["wait a moment...", 4000]];
//     progressLoader(array);
//     $.ajax({
//         type: 'POST',
//         url: '../Controllers/DailyReportController.php',
//         data: formData,
//         dataType: 'json',
//         success: function (response) {
//             popupClose("progress-loader");
//             console.log(response);
//             if (response.status === 'success') {
//                 displayEdit(response.data);
//             }
//             else if (response.status === 'error') {
//                 popupClose('edit');
//                 Swal.fire({
//                     title: "Oops!",
//                     text: response.message,
//                     icon: "error"
//                 });
//             } else {
//                 popupClose('edit');
//                 Swal.fire({
//                     title: "Oops!",
//                     text: "Something went wrong! Please try again.",
//                     icon: "error"
//                 });
//             }
//         },
//         error: function (xhr, status, error) {
//             popupClose('bus-view');
//             console.error(xhr.responseText);
//             Swal.fire({
//                 title: "Oops!",
//                 text: "Something went wrong! Please try again.",
//                 icon: "error"
//             });
//         }
//     });
// }


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
}

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

$(document).ready(function () {
    $('#filter-form').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Applying filter..", 4000], ["please wait a moment..", 4000], ["Uploading fuel bill..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('orderBy', 'ASC');
        formData.append('action', 'applyFilter');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
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
                    document.getElementById("c-total-km").innerHTML = cardDetails.totalKm;
                    document.getElementById("c-fuel-usage").innerHTML = cardDetails.fuelUsage;
                    document.getElementById("c-avg-mileage").innerHTML = cardDetails.avgMilage;
                    document.getElementById("c-passangers").innerHTML = cardDetails.passengers;
                    document.getElementById("c-collection").innerHTML = cardDetails.collection;
                    document.getElementById("c-expense").innerHTML = cardDetails.expenses;
                    document.getElementById("c-fuel-amount").innerHTML = cardDetails.fuelAmount;
                    document.getElementById("c-salary").innerHTML = cardDetails.salary;
                    document.getElementById("c-commission").innerHTML = cardDetails.commission;
                    document.getElementById("c-profit").innerHTML = cardDetails.profit;


                    // Assuming DataTables is already initialized on '#daily-report-table'
                    let table = $('#daily-report-table').DataTable(); // Initialize the DataTable

                    // Clear the DataTable
                    table.clear(); 

                    // Daily Report Data
                    let reports = data.dailyReport;

                    // Iterate over reports and add rows to the DataTable
                    $.each(reports, function (index, report) {
                        let row = [
                            index + 1, // Add index
                            report.date,
                            report.busNumber,
                            report.km,
                            report.fuelUsage,
                            report.avgMilage,
                            report.passenger,
                            report.collection,
                            report.expenses,
                            report.fuelAmount,
                            report.salary,
                            report.commission,
                            report.profit,
                            `<div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('view'); getDailyReportDetails(${report.reportId});" title="View">
                                    <i class="fa-duotone fa-eye"></i>
                                </button>
                                <button class="table-btn edit" onclick="popupOpen('edit'); getDailyReportForEdit(${report.reportId});" title="Edit">
                                    <i class="fa-duotone fa-pen-to-square"></i>
                                </button>
                                <button class="table-btn delete" onclick="deleteBus(${report.reportId}, '${report.busNumber}')" title="Delete">
                                    <i class="fa-duotone fa-trash"></i>
                                </button>
                            </div>`
                        ];

                        // Add the new row to the DataTable
                        table.row.add(row);
                    });

                    // Redraw the DataTable to show the new data
                    table.draw();

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