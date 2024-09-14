//Get conductor Table data 
getConductor();



function getConductor() {
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
        action: 'getConductors'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/ConductorController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let conductorDetails = response.data;
                console.log(conductorDetails);

                let tableBody = $('#conductors-table tbody');
                tableBody.empty();

                $.each(conductorDetails, function (index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.fullname + '</td>' +
                        '<td>' + item.mobile + '</td>' +
                        '<td>' + item.mail + '</td>' +
                        '<td>' + item.district + '</td>' +
                        '<td>' + item.state + '</td>' +
                        `<td>
                            <div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('view'); getConductorDetails(`+ item.id + `);"><i
                                                class="fa-duotone fa-eye"></i></button>
                                <button class="table-btn edit" onclick="popupOpen('edit'); getConductorDetailsForEdit(`+ item.id + `);"><i
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

// Create new conductor

$(document).ready(function () {
    $('#conductor-form').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }

        popupClose('add');
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Creating conductor. Please waite..", 4000], ["Uploading conductor documents..", 4000], ["Sending mail to conductor...", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'createConductor');

        $.ajax({
            type: 'POST',
            url: '../Controllers/ConductorController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getConductor();
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

//Get Conductor details

function getConductorDetails(conductorId) {
    let formData = {
        conductorId: conductorId,
        action: 'getConductor'
    }
    document.getElementsByClassName("loader-div")[0].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/ConductorController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let details = response.data;
                document.getElementsByClassName("loader-div")[0].style.display = "none";
                document.getElementsByClassName("conductor-info")[0].style.display = "block";
                details.conductor_image_path != "" ? document.getElementById("v-profile-img").src = "../../Assets/User/" + details.conductor_image_path : document.getElementById("v-profile-img").src = "../../Assets/Developer/image/manager.png";
                details.fullname != "" ? document.getElementById("v-name").innerHTML = details.fullname : document.getElementById("v-name").innerHTML = "-";
                details.mail != "" ? document.getElementById("v-mail").innerHTML = details.mail : document.getElementById("v-mail").innerHTML = "-";
                details.mobile != "" ? document.getElementById("v-mobile").innerHTML = details.mobile : document.getElementById("v-mobile").innerHTML = "-";
                details.aadhar_no != "" ? document.getElementById("v-aadhar-no").innerHTML = details.aadhar_no : document.getElementById("v-aadhar-no").innerHTML = "-";
                details.pan_no != "" ? document.getElementById("v-pan-no").innerHTML = details.pan_no : document.getElementById("v-pan-no").innerHTML = "-";
                details.aadhar_path != "" ? document.getElementById("v-aadhar-path").href = "../../Assets/User/" + details.aadhar_path : document.getElementById("v-aadhar-path").href = "";
                details.pan_path != "" ? document.getElementById("v-pan-path").href = "../../Assets/User/" + details.pan_path : document.getElementById("v-pan-path").href = "";
                details.aadhar_path != "" ? document.getElementById("v-aadhar-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("v-aadhar-path").innerHTML = "-";
                details.pan_path != "" ? document.getElementById("v-pan-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("v-pan-path").innerHTML = "-";
                details.address != "" ? document.getElementById("v-address").innerHTML = details.address : document.getElementById("v-address").innerHTML = "-";
                details.district != "" ? document.getElementById("v-district").innerHTML = details.district : document.getElementById("v-district").innerHTML = "-";
                details.state != "" ? document.getElementById("v-state").innerHTML = details.state : document.getElementById("v-state").innerHTML = "-";
                details.pan_no != "" ? document.getElementById("v-pincode").innerHTML = details.pincode : document.getElementById("v-pincode").innerHTML = "-";
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

function getConductorDetailsForEdit(conductorId) {
    let formData = {
        conductorId: conductorId,
        action: 'getconductor'
    }
    document.getElementsByClassName("loader-div")[1].style.display = "block";
    $.ajax({
        type: 'POST',
        url: '../Controllers/ConductorController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let details = response.data;
                console.log(response);
                document.getElementsByClassName("loader-div")[1].style.display = "none";
                document.getElementsByClassName("conductor-info")[1].style.display = "block";
                document.getElementById("e-conductor-id").value = details.id;
                details.conductor_image_path != "" ? document.getElementById("edit-v-profile-img").src = "../../Assets/User/" + details.conductor_image_path : document.getElementById("edit-v-profile-img").src = "../../Assets/Developer/image/manager.png";
                details.fullname != "" ? document.getElementById("e-name").value = details.fullname : document.getElementById("e-name").value = "";
                details.mail != "" ? document.getElementById("e-mail").value = details.mail : document.getElementById("e-mail").value = "";
                details.mobile != "" ? document.getElementById("e-mobile").value = details.mobile : document.getElementById("e-mobile").value = "";
                details.aadhar_no != "" ? document.getElementById("e-aadhar-no").value = details.aadhar_no : document.getElementById("e-aadhar-no").value = "";
                details.pan_no != "" ? document.getElementById("e-pan-no").value = details.pan_no : document.getElementById("e-pan-no").value = "";
                details.aadhar_path != "" ? document.getElementById("e-aadhar-path").href = "../../Assets/User/" + details.aadhar_path : document.getElementById("e-aadhar-path").href = "";
                details.pan_path != "" ? document.getElementById("e-pan-path").href = "../../Assets/User/" + details.pan_path : document.getElementById("e-pan-path").href = "";
                details.aadhar_path != "" ? document.getElementById("e-aadhar-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("e-aadhar-path").innerHTML = "-";
                details.pan_path != "" ? document.getElementById("e-pan-path").innerHTML = '<i class="fa-duotone fa-file-invoice"></i>' : document.getElementById("e-pan-path").innerHTML = "-";
                details.address != "" ? document.getElementById("e-address").value = details.address : document.getElementById("e-address").value = "";
                details.district != "" ? document.getElementById("e-district").value = details.district : document.getElementById("e-district").value = "";
                details.state != "" ? document.getElementById("e-state").value = details.state : document.getElementById("e-state").value = "";
                details.pincode != "" ? document.getElementById("e-pincode").value = details.pincode : document.getElementById("e-pincode").value = "";
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

//Update Conductor details

$(document).ready(function () {
    $('#conductor-edit-form').on('submit', function (e) {
        e.preventDefault();
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [["Updating conductor. Please wait..", 4000], ["please wait a moment..", 4000], ["Uploading conductor documents..", 4000]];
        progressLoader(array);
        var formData = new FormData(this);
        formData.append('action', 'updateConductor');

        $.ajax({
            type: 'POST',
            url: '../Controllers/ConductorController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                popupClose("progress-loader");
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    getConductor();
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

function deleteDriver(conductorId, conductorName) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete " + conductorName,
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
                conductorId: conductorId,
                action: 'deleteConductor'
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
                        getConductor();
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