//Fuel type as  globle variable
let fuelTypes;

//Get driver Table data 
getCommission();



function getCommission() {

    let formData = {
        action: 'getCommission'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/CommissionController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let busDetails = response.data;
                console.log(busDetails);

                let tableBody = $('#commission-table tbody');
                tableBody.empty();

                $.each(busDetails, function (index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.collection_range_from + '</td>' +
                        '<td>' + item.collection_range_to + '</td>' +
                        '<td>' + item.amount_per_commission + '</td>' +
                        '<td>' + item.commission_amount + '</td>' +
                        `<td>
                            <div class="th-btn">
                                <button class="table-btn edit" onclick="popupOpen('edit'); getCommissionForEdit(`+ item.commission_id + `);"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteBus(`+ item.commission_id + `, '` + (index + 1) + `')"><i class="fa-duotone fa-trash"></i></button>
                            </div>
                        </td>`      
                    '</tr>';
                    tableBody.append(row);
                })
                DataTable();
            }
        },
        error: function (xhr, status, error) {
            popupClose('driver-view');
            console.error(xhr.responseText);
            // Swal.fire({
            //     title: "Error",
            //     text: "Something went wrong! Please try again.",
            //     icon: "error"
            // });
        }
    });
}

async function getFuelType() {
    if (!fuelTypes) {
        await fuelTypeAjax();
    }
    let select = $('#fuel-type');
    select.empty();
    select.append('<option value="" disabled selected>Select Fuel Type</option>');

    fuelTypes.forEach(fuelType => {
        select.append('<option value="' + fuelType.id + '">' + fuelType.fuel + '</option>');
    });

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
                popupClose('driver-view');
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

// Create new commission

$(document).ready(function () {
    $('#commission-form').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["adding commission. Please waite..", 4000], ["wait a moment...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createCommission');

        $.ajax({
            type: 'POST',
            url: '../Controllers/CommissionController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getCommission();
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

//Get Bus details

function getBusDetails(busId) {
    let formData = {
        busId: busId,
        action: 'getBusView'
    }
    document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/BusController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let busDetails = response.data;
                console.log(busDetails);
                document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("bus-info")[0].style.display = "block";

                console.log(typeof busDetails.fuel_cost);
                //Card details
                document.getElementById("b-v-profit").innerHTML = 0;
                document.getElementById("b-v-cost").innerHTML = parseFloat(busDetails.fuel_cost) + parseFloat(busDetails.maintenance_cost);
                document.getElementById("b-v-total-km").innerHTML = busDetails.total_km;
                document.getElementById("b-v-avg-mileage").innerHTML = busDetails.avg_mileage;
                document.getElementById("b-v-cost-per-km").innerHTML = busDetails.cost_per_km;

                busDetails.bus_number != "" ? document.getElementById("b-v-bus-no").innerHTML = busDetails.bus_number : document.getElementById("b-e-bus-no").innerHTML = "-";
                busDetails.bus_model != "" ? document.getElementById("b-v-bus-model").innerHTML = busDetails.bus_model : document.getElementById("b-v-bus-model").innerHTML = "-";
                busDetails.seating_capacity != "" ? document.getElementById("b-v-seating-capacity").innerHTML = busDetails.seating_capacity : document.getElementById("b-v-seating-capacity").innerHTML = "-";
                busDetails.fuel_type != "" ? document.getElementById("b-v-fuel-type").innerHTML = busDetails.fuel_type : document.getElementById("b-v-fuel-type").innerHTML = "-";
                busDetails.driver_salary != "" ? document.getElementById("b-v-driver-salary").innerHTML = busDetails.driver_salary : document.getElementById("b-v-driver-salary").innerHTML = "-";
                busDetails.conductor_salary != "" ? document.getElementById("b-v-conductor-salary").innerHTML = busDetails.conductor_salary : document.getElementById("b-v-conductor-salary").innerHTML = "-";
                busDetails.bus_status != "" ? document.getElementById("b-v-bus-status").innerHTML = (busDetails.bus_status == 1) ? "Running" : "Not Running" : document.getElementById("b-v-bus-status").innerHTML = "-";
                
                busDetails.rcbook_no != "" ? document.getElementById("b-v-rc-no").innerHTML = busDetails.rcbook_no : document.getElementById("b-v-rc-no").innerHTML = "-";
                busDetails.insurance_no != "" ? document.getElementById("b-v-insurance-no").innerHTML = busDetails.insurance_no : document.getElementById("b-v-insurance-no").value = "-";
                busDetails.rcbook_expiry != "" ? document.getElementById("b-v-rcbook-expiry").innerHTML = convertDateFormat(busDetails.rcbook_expiry) : document.getElementById("b-v-rcbook-expiry").innerHTML = "-";
                busDetails.insurance_expiry != "" ? document.getElementById("b-v-insurance-expiry").innerHTML = convertDateFormat(busDetails.insurance_expiry) : document.getElementById("b-v-insurance-expiry").innerHTML = "-";
                
                busDetails.rcbook_path != "" ? document.getElementById("b-v-rcbook-path").href = "../../Assets/User/" + busDetails.rcbook_path : document.getElementById("b-v-rcbook-path").href = "";
                busDetails.insurance_path != "" ? document.getElementById("b-v-insurance-path").href = "../../Assets/User/" + busDetails.insurance_path : document.getElementById("b-v-insurance-path").href = "";

                busDetails.rcbook_path != "" ? document.getElementById("b-v-rcbook-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("b-v-rcbook-path").innerHTML = "-";
                busDetails.insurance_path != "" ? document.getElementById("b-v-insurance-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("b-v-insurance-path").innerHTML = "-";

                //Bar chart
                var options = {
                    series: [{
                    data: [40000, 30000, 8000, 5000]
                  }],
                    chart: {
                    type: 'bar',
                    height: 350
                  },
                  plotOptions: {
                    bar: {
                      borderRadius: 4,
                      borderRadiusApplication: 'end',
                      horizontal: true,
                    }
                  },
                  dataLabels: {
                    enabled: false
                  },
                  xaxis: {
                    categories: ['Collection', 'Profit', 'Fuel Cost', 'Maintenance Cost'
                    ],
                  }
                  };
          
                  var chart = new ApexCharts(document.querySelector("#chart-1"), options);
                  chart.render();

                //Pie chart
                var options = {
                    series: [30000, 13000],
                    chart: {
                    type: 'donut',
                  },
                  responsive: [{
                    breakpoint: 480,
                    options: {
                      chart: {
                        width: 200
                      },
                      legend: {
                        position: 'bottom'
                      }
                    }
                  }]
                  };
          
                  var chart = new ApexCharts(document.querySelector("#chart-2"), options);
                  chart.render();
            }
            else if (response.status === 'error') {
                popupClose('bus-view');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('bus-view');
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

//Get Driver details for edit

async function getBusDetailsForEdit(BusId) {
    if(!fuelTypes) {
        await fuelTypeAjax();
    }
    let formData = {
        busId: BusId,
        action: 'getBusEdit'
    }
    document.getElementsByClassName("loader-div")[1].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/BusController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let busDetails = response.data;
                console.log(busDetails);
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("bus-info")[1].style.display = "block";
                document.getElementById("b-e-bus-id").value = busDetails.id;
                busDetails.bus_number != "" ? document.getElementById("b-e-bus-no").value = busDetails.bus_number : document.getElementById("b-e-bus-no").value = "";
                busDetails.bus_model != "" ? document.getElementById("b-e-bus-model").value = busDetails.bus_model : document.getElementById("b-e-bus-model").value = "";
                busDetails.seating_capacity != "" ? document.getElementById("b-e-seating-capacity").value = busDetails.seating_capacity : document.getElementById("b-e-seating-capacity").value = "";
                //FuelType
                let select = $('#b-e-fuel-type');
                select.empty();
                select.append('<option value="" disabled>--Select Fuel Type--</option>');

                fuelTypes.forEach(fuelType => {
                    if (fuelType.id == busDetails.fuel_type_id) {
                        select.append('<option value="' + fuelType.id + '" selected>' + fuelType.fuel + '</option>');
                    } else {
                        select.append('<option value="' + fuelType.id + '">' + fuelType.fuel + '</option>');
                    }
                });
                busDetails.driver_salary != "" ? document.getElementById("b-e-driver-salary").value = busDetails.driver_salary : document.getElementById("b-e-driver-salary").value = "";
                busDetails.conductor_salary != "" ? document.getElementById("b-e-conductor-salary").value = busDetails.conductor_salary : document.getElementById("b-e-conductor-salary").value = "";
                //bus satatus
                let select2 = $('#b-e-bus-status');
                select2.empty();
                select2.append('<option value="" disabled>--Select Bus Status--</option>');
                if (busDetails.bus_status) {
                    select2.append('<option value="1" selected>Running</option>');
                    select2.append('<option value="0">Not Running</option>');
                } else {
                    select2.append('<option value="1">Running</option>');
                    select2.append('<option value="0" selected>Not Running</option>');
                }
                
                busDetails.rcbook_no != "" ? document.getElementById("b-e-rc-no").value = busDetails.rcbook_no : document.getElementById("b-e-rc-no").value = "";
                busDetails.insurance_no != "" ? document.getElementById("b-e-insurance-no").value = busDetails.insurance_no : document.getElementById("b-e-insurance-no").value = "";
                busDetails.rcbook_expiry != "" ? document.getElementById("b-e-rcbook-expiry").value = busDetails.rcbook_expiry : document.getElementById("b-e-rcbook-expiry").value = "";
                busDetails.insurance_expiry != "" ? document.getElementById("b-e-insurance-expiry").value = busDetails.insurance_expiry : document.getElementById("b-e-insurance-expiry").value = "";
                
                busDetails.rcbook_path != "" ? document.getElementById("b-e-rcbook-path").href = "../../Assets/User/" + busDetails.rcbook_path : document.getElementById("b-e-rcbook-path").href = "";
                busDetails.insurance_path != "" ? document.getElementById("b-e-insurance-path").href = "../../Assets/User/" + busDetails.insurance_path : document.getElementById("b-e-insurance-path").href = "";

                busDetails.rcbook_path != "" ? document.getElementById("b-e-rcbook-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("b-e-rcbook-path").innerHTML = "-";
                busDetails.insurance_path != "" ? document.getElementById("b-e-insurance-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("b-e-insurance-path").innerHTML = "-";

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
            document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("bus-info")[1].style.display = "block";
            popupClose('bus-edit');
            console.error(xhr.responseText);
            Swal.fire({
                title: "Oops!",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    });
}

//Update driver details

$(document).ready(function () {
    $('#bus-edit-form').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Updating bus. Please wait..", 4000], ["please wait a moment..", 4000], ["Uploading bus documents..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'updateBus');

        $.ajax({
            type: 'POST',
            url: '../Controllers/BusController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getBuses();
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

//Delete Driver

function deleteBus(busId, busName) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + busName,
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
                busId: busId,
                action: 'deleteBus'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/BusController.php',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    popupClose("progress-loader");
                    // let data = JSON.parse(response);
                    if (data.status === 'success') {
                        getBuses();
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