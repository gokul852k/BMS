//Get driver Table data 
getDrivers();



function getDrivers() {
    let formData1 = {
        action: 'getDriversCardDetails'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DriverController.php',
        data: formData1,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let cardDetails = response.data;
                document.getElementById("total_drivers").innerHTML = cardDetails.total_drivers;
                document.getElementById("active_drivers").innerHTML = cardDetails.active_drivers;
                document.getElementById("expired_licenses").innerHTML = cardDetails.expired_licenses;
                document.getElementById("upcoming_expitations").innerHTML = cardDetails.upcoming_expirations;
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            // Swal.fire({
            //     title: "Error",
            //     text: "Something went wrong! Please try again.",
            //     icon: "error"
            // });
        }
    });
    let formData2 = {
        action: 'getDrivers'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DriverController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let driverDetails = response.data;
                console.log(driverDetails);

                let tableBody = $('#drivers-table tbody');
                tableBody.empty();

                $.each(driverDetails, function (index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.fullname + '</td>' +
                        '<td>' + item.mobile + '</td>' +
                        '<td>' + item.mail + '</td>' +
                        '<td>' + item.district + '</td>' +
                        '<td>' + item.licence_no + '</td>' +
                        '<td>' + convertDateFormat(item.licence_expiry) + '</td>' +
                        '<td><div class="btn-td"><span class="' + item.license_status + '">' + item.license_status + '</span></div></td>' +
                        `<td>
                            <div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('view'); getDriverDetails(`+ item.id + `);"><i
                                                class="fa-duotone fa-eye"></i></button>
                                <button class="table-btn edit" onclick="popupOpen('edit'); getDriverDetailsForEdit(`+ item.id + `);"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteDriver(`+ item.id + `, '` + item.fullname + `')"><i class="fa-duotone fa-trash"></i></button>
                            </div>
                        </td>`      
                    '</tr>';
                    tableBody.append(row);
                })
                DataTable();
            }
        },
        error: function (xhr, status, error) {
            popupClose('view');
            console.error(xhr.responseText);
            // Swal.fire({
            //     title: "Error",
            //     text: "Something went wrong! Please try again.",
            //     icon: "error"
            // });
        }
    });
}

// Create new driver

$(document).ready(function () {
    $('#driver-form').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Creating driver. Please waite..", 4000], ["Uploading driver documents..", 4000], ["Sending mail to driver...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createDriver');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DriverController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    document.getElementById('driver-form').reset();
                    getDrivers();
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

//Get Driver details

function getDriverDetails(driverId) {
    let formData = {
        driverId: driverId,
        action: 'getDriver'
    }
    document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/DriverController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let driverDetails = response.data;
                document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("driver-info")[0].style.display = "block";
                driverDetails.driver_image_path != "" ? document.getElementById("d-v-profile-img").src = "../../Assets/User/" + driverDetails.driver_image_path : document.getElementById("d-v-profile-img").src = "../../Assets/Developer/image/manager.png";
                driverDetails.fullname != "" ? document.getElementById("d-v-name").innerHTML = driverDetails.fullname : document.getElementById("d-v-name").innerHTML = "-";
                driverDetails.mail != "" ? document.getElementById("d-v-mail").innerHTML = driverDetails.mail : document.getElementById("d-v-mail").innerHTML = "-";
                driverDetails.mobile != "" ? document.getElementById("d-v-mobile").innerHTML = driverDetails.mobile : document.getElementById("d-v-mobile").innerHTML = "-";
                driverDetails.licence_no != "" ? document.getElementById("d-v-licence-no").innerHTML = driverDetails.licence_no : document.getElementById("d-v-licence-no").innerHTML = "-";
                driverDetails.licence_expiry != "" ? document.getElementById("d-v-licence-ex").innerHTML = driverDetails.licence_expiry : document.getElementById("d-v-licence-ex").innerHTML = "-";
                driverDetails.aadhar_no != "" ? document.getElementById("d-v-aadhar-no").innerHTML = driverDetails.aadhar_no : document.getElementById("d-v-aadhar-no").innerHTML = "-";
                driverDetails.pan_no != "" ? document.getElementById("d-v-pan-no").innerHTML = driverDetails.pan_no : document.getElementById("d-v-pan-no").innerHTML = "-";
                driverDetails.licence_path != "" ? document.getElementById("d-v-licence-path").href = "../../Assets/User/" + driverDetails.licence_path : document.getElementById("d-v-licence-path").href = "";
                driverDetails.aadhar_path != "" ? document.getElementById("d-v-aadhar-path").href = "../../Assets/User/" + driverDetails.aadhar_path : document.getElementById("d-v-aadhar-path").href = "";
                driverDetails.pan_path != "" ? document.getElementById("d-v-pan-path").href = "../../Assets/User/" + driverDetails.pan_path : document.getElementById("d-v-pan-path").href = "";
                driverDetails.licence_path != "" ? document.getElementById("d-v-licence-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-v-licence-path").innerHTML = "-";
                driverDetails.aadhar_path != "" ? document.getElementById("d-v-aadhar-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-v-aadhar-path").innerHTML = "-";
                driverDetails.pan_path != "" ? document.getElementById("d-v-pan-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-v-pan-path").innerHTML = "-";
                driverDetails.address != "" ? document.getElementById("d-v-address").innerHTML = driverDetails.address : document.getElementById("d-v-address").innerHTML = "-";
                driverDetails.district != "" ? document.getElementById("d-v-district").innerHTML = driverDetails.district : document.getElementById("d-v-district").innerHTML = "-";
                driverDetails.state != "" ? document.getElementById("d-v-state").innerHTML = driverDetails.state : document.getElementById("d-v-state").innerHTML = "-";
                driverDetails.pan_no != "" ? document.getElementById("d-v-pincode").innerHTML = driverDetails.pincode : document.getElementById("d-v-pincode").innerHTML = "-";
            }
            else if (response.status === 'error') {
                popupClose('view');
                Swal.fire({
                    title: "Oops!",
                    text: response.message,
                    icon: "error"
                });
            } else {
                popupClose('view');
                Swal.fire({
                    title: "Oops!",
                    text: "Something went wrong! Please try again.",
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            popupClose('view');
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

async function getDriverDetailsForEdit(driverId) {
    if(!languages) {
        await languageAjax();
    }
    let formData = {
        driverId: driverId,
        action: 'getDriver'
    }
    document.getElementsByClassName("loader-div")[1].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/DriverController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let driverDetails = response.data;
                console.log(response);
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("driver-info")[1].style.display = "block";
                document.getElementById("d-e-driver-id").value = driverDetails.id;
                driverDetails.driver_image_path != "" ? document.getElementById("edit-d-v-profile-img").src = "../../Assets/User/" + driverDetails.driver_image_path : document.getElementById("edit-d-v-profile-img").src = "../../Assets/Developer/image/manager.png";
                driverDetails.fullname != "" ? document.getElementById("d-e-name").value = driverDetails.fullname : document.getElementById("d-e-name").value = "";
                driverDetails.mail != "" ? document.getElementById("d-e-mail").value = driverDetails.mail : document.getElementById("d-e-mail").value = "";
                driverDetails.mobile != "" ? document.getElementById("d-e-mobile").value = driverDetails.mobile : document.getElementById("d-e-mobile").value = "";
            
                //Language
                let select = $('#d-e-language');
                select.empty();  // Clear existing options
            
                // Add default "Select Bus" option
                select.append('<option value="" disabled>Select Language</option>');
            
                languages.forEach((language) => {
                    if (driverDetails.language == language.code) {
                        select.append('<option value="' + language.code + '" selected>' + language.name + '</option>');
                    } else {
                        select.append('<option value="' + language.code + '">' + language.name + '</option>');
                    }
                    
                });


                driverDetails.licence_no != "" ? document.getElementById("d-e-licence-no").value = driverDetails.licence_no : document.getElementById("d-e-licence-no").value = "";
                driverDetails.licence_expiry != "" ? document.getElementById("d-e-licence-ex").value = driverDetails.licence_expiry : document.getElementById("d-e-licence-ex").value = "";
                driverDetails.aadhar_no != "" ? document.getElementById("d-e-aadhar-no").value = driverDetails.aadhar_no : document.getElementById("d-e-aadhar-no").value = "";
                driverDetails.pan_no != "" ? document.getElementById("d-e-pan-no").value = driverDetails.pan_no : document.getElementById("d-e-pan-no").value = "";
                driverDetails.licence_path != "" ? document.getElementById("d-e-licence-path").href = "../../Assets/User/" + driverDetails.licence_path : document.getElementById("d-e-licence-path").href = "";
                driverDetails.aadhar_path != "" ? document.getElementById("d-e-aadhar-path").href = "../../Assets/User/" + driverDetails.aadhar_path : document.getElementById("d-e-aadhar-path").href = "";
                driverDetails.pan_path != "" ? document.getElementById("d-e-pan-path").href = "../../Assets/User/" + driverDetails.pan_path : document.getElementById("d-e-pan-path").href = "";
                driverDetails.licence_path != "" ? document.getElementById("d-e-licence-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-e-licence-path").innerHTML = "-";
                driverDetails.aadhar_path != "" ? document.getElementById("d-e-aadhar-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-e-aadhar-path").innerHTML = "-";
                driverDetails.pan_path != "" ? document.getElementById("d-e-pan-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("d-e-pan-path").innerHTML = "-";
                driverDetails.address != "" ? document.getElementById("d-e-address").value = driverDetails.address : document.getElementById("d-e-address").value = "";
                driverDetails.district != "" ? document.getElementById("d-e-district").value = driverDetails.district : document.getElementById("d-e-district").value = "";
                driverDetails.state != "" ? document.getElementById("d-e-state").value = driverDetails.state : document.getElementById("d-e-state").value = "";
                driverDetails.pincode != "" ? document.getElementById("d-e-pincode").value = driverDetails.pincode : document.getElementById("d-e-pincode").value = "";
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

//Update driver details

$(document).ready(function () {
    $('#driver-edit-form').on('submit', function (e) {
        e.preventDefault();
        popupClose('edit');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Updating driver. Please wait..", 4000], ["please wait a moment..", 4000], ["Uploading driver documents..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'updateDriver');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DriverController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                document.getElementById('driver-edit-form').reset();
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getDrivers();
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

function deleteDriver(driverId, driverName) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + driverName,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            //Calling progress bar
            popupOpen("progress-loader");
            let array = [["Deleting driver. Please wait..", 4000], ["Deleting driver documents..", 4000], ["Please wait a moment..", 4000]];
            progressLoader(array);
            let formData = {
                driverId: driverId,
                action: 'deleteDriver'
            }
            $.ajax({
                type: 'POST',
                url: '../Controllers/DriverController.php',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    popupClose("progress-loader");
                    // let data = JSON.parse(response);
                    if (data.status === 'success') {
                        getDrivers();
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

let languages;

async function getLanguageField() {
    if(!languages) {
        await languageAjax();
    }

    //Bus
    let select = $('#language');
    select.empty();  // Clear existing options

    // Add default "Select Bus" option
    select.append('<option value="" disabled selected>Select Language</option>');

    languages.forEach((language) => {
        select.append('<option value="' + language.code + '">' + language.name + '</option>');
    });
}

function languageAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getLanguage'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    languages = response.data;
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