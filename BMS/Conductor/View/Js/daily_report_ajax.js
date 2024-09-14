// Create Daily Report

$(document).ready(function () {
    $('#select-bus').on('submit', function (e) {
        e.preventDefault();
        // Check if form is valid
        if ($("#bus-id").val() == "") {
            Swal.fire({
                title: "Oops!",
                text: "Please select bus",
                icon: "warning"
            });
            return;
        }

        var formData = new FormData(this);
        formData.append('action', 'createDailyReport');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    }).then((result) => {
                        window.location.reload();
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

// Trip Collection

$(document).ready(function () {
    $('#trip-collection').on('submit', function (e) {
        e.preventDefault();
        
        if ($("#start-route").val() == "") {
            $('#start-route').addClass('input-error');
            $('#start-route-error').html('Start route is required');
            return;
        }

        if ($("#end-route").val() == "") {
            $('#end-route').addClass('input-error');
            $('#end-route-error').html('End route is required');
            return;
        }

        if ($("#passengers").val() == "") {
            $('#passengers').addClass('input-error');
            $('#passengers-error').html('Passengers is required');
            return;
        }

        if ($("#collection").val() == "") {
            $('#collection').addClass('input-error');
            $('#collection-error').html('Collection is required');
            return;
        }

        var formData = new FormData(this);
        formData.append('action', 'tripCollection');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Continue Work",
                        cancelButtonText: "Stop Work"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        } else if (result.isDismissed) {
                            endDuty();
                        }
                    });
                }
                else if (data.status == "trip exist") {
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: "warning"
                    }).then((result) => {
                        window.location.reload();
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

// Trip Collection 2

$(document).ready(function () {
    $('#trip-collection-2').on('submit', function (e) {
        e.preventDefault();

        if ($("#passengers-2").val() == "") {
            $('#passengers-2').addClass('input-error');
            $('#passengers-2-error').html('Passengers is required');
            return;
        }

        if ($("#collection-2").val() == "") {
            $('#collection-2').addClass('input-error');
            $('#collection-2-error').html('Collection is required');
            return;
        }

        var formData = new FormData(this);
        formData.append('action', 'tripCollection2');

        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Continue Work",
                        cancelButtonText: "Stop Work"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        } else if (result.isDismissed) {
                            endDuty();
                        }
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

// End Trip

$(document).ready(function () {
    $('#end-trip').on('submit', function (e) {
        e.preventDefault();
        
        if ($("#end-km").val() == "") {
            $('#end-km').addClass('input-error');
            $('#end-km-error').html('End KM is required');
            return;
        }

        var formData = new FormData(this);
        formData.append('action', 'endTrip');
        
        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(JSON.stringify(response));
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Continue Work",
                        cancelButtonText: "Stop Work"
                      }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        } else if (result.isDismissed) {
                            endDuty();
                        }
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

function startDuty() {
    document.getElementsByClassName("duty-container-2")[0].style.display = 'none';
    document.getElementsByClassName("select-bus-container")[0].style.display = 'flex';
}

function endDuty() {
    popupOpen("user-model-1");

    //Fetching End duty Trip details
    var formData = {
        action: 'getTripsDetails'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if(response.status === 'success') {
                //set Card count for End duty
                let cardCounts = response.cardCounts;
                document.getElementById("ed-trip").innerHTML = parseInt(cardCounts.trips).toLocaleString('en-US');
                document.getElementById("ed-passengers").innerHTML = parseInt(cardCounts.passengers).toLocaleString('en-US');
                document.getElementById("ed-collection").innerHTML = parseInt(cardCounts.collections).toLocaleString('en-US');
                document.getElementById("ed-km").innerHTML = parseInt(cardCounts.km).toLocaleString('en-US');
                //Set Bus Number
                document.getElementById("ed-bus-no").innerHTML = response.busNumber;
                //Set trip details
                let tripDetails = response.tripDetails;
                let trips = "";
                $.each(tripDetails, function (index, item) {
                    // Check if the current item is the last one
                    let isLast = index === tripDetails.length - 1;
                    
                    // Conditionally set the r-line class
                    let rLineClass = isLast ? '' : 'r-line';

                    trips += `<div class="route-card ${rLineClass}">
                                <div class="route-location">
                                    <i class="fa-solid fa-location-pin"></i>
                                    <span class="route-count">${index + 1}</span>
                                </div>
                                <div class="route-card-left">
                                    <div class="route-card-from">
                                        <span class="r-c-h">${item.startRouteName}</span>
                                        <span class="r-c-p">From</span>
                                    </div>
                                    <div class="route-card-to">
                                        <span class="r-c-h">${item.endRouteName}</span>
                                        <span class="r-c-p">To</span>
                                    </div>
                                </div>
                                <div class="route-card-right">
                                    <div class="route-card-passanger">
                                        <span class="r-c-h">${parseInt(item.passengers).toLocaleString('en-US')}</span>
                                        <span class="r-c-p">Passangers</span>
                                    </div>
                                    <div class="route-card-collection">
                                        <span class="r-c-h">${parseInt(item.collection).toLocaleString('en-US')}</span>
                                        <span class="r-c-p">Collection</span>
                                    </div>
                                </div>
                            </div>`;
                });

                document.getElementById("route-cards").innerHTML = trips;

                //set salary and commission for hidden input
                document.getElementById("work-salary").value = response.salary;

                document.getElementById("work-commission").value = response.commission;

                document.getElementById("total-commission").value = response.totalCommission;

                //set salary summary
                document.getElementById("ed-salary").innerHTML = parseInt(response.salary).toLocaleString('en-US');

                document.getElementById("ed-commission").innerHTML = parseInt(response.commission).toLocaleString('en-US');

                document.getElementById("ed-total").innerHTML = parseInt(response.salary + response.commission).toLocaleString('en-US');
            }
            else if (response.status === 'error') {
                Swal.fire({
                    title: "Error",
                    text: response.message,
                    icon: "error"
                });
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
                title: "Error",
                text: "Something went wrong! Please try again.",
                icon: "error"
            });
        }
    })
}

// End Duty

$(document).ready(function () {
    $('#end-duty').on('submit', function (e) {
        e.preventDefault();

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }
        popupClose("user-model-1");
        var formData = new FormData(this);
        formData.append('action', 'endDuty2');
        $.ajax({
            type: 'POST',
            url: '../Controllers/DailyReportController.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                let data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    }).then((result) => {
                        window.location.reload();
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



//Backup

// End Trip

// $(document).ready(function () {
//     $('#end-trip').on('submit', function (e) {
//         e.preventDefault();
        
//         if ($("#end-km").val() == "") {
//             $('#end-km').addClass('input-error');
//             $('#end-km-error').html('End KM is required');
//             return;
//         }

//         var formData = new FormData(this);
//         formData.append('action', 'endTrip');
        
//         $.ajax({
//             type: 'POST',
//             url: '../Controllers/DailyReportController.php',
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function (response) {
//                 console.log(JSON.stringify(response));
//                 let data = JSON.parse(response);
//                 if (data.status === 'success') {
//                     Swal.fire({
//                         title: "Success",
//                         text: data.message,
//                         icon: "success",
//                         showCancelButton: true,
//                         confirmButtonColor: "#3085d6",
//                         cancelButtonColor: "#d33",
//                         confirmButtonText: "Continue Work",
//                         cancelButtonText: "Stop Work"
//                       }).then((result) => {
//                         if (result.isConfirmed) {
//                             window.location.reload();
//                         } else if (result.isDismissed) {
//                             var formData1 = {
//                                 action: 'endDuty',
//                                 tripId: data.tripId
//                             }
//                             $.ajax({
//                                 type: 'POST',
//                                 url: '../Controllers/DailyReportController.php',
//                                 data: formData1,
//                                 dataType: 'json',
//                                 success: function (response) {
//                                     if (response.status === 'success') {
//                                         Swal.fire({
//                                             title: "Success",
//                                             text: response.message,
//                                             icon: "success"
//                                         }).then((result) => {
//                                             window.location.reload();
//                                         });
//                                     }
//                                     else if (response.status === 'error') {
//                                         Swal.fire({
//                                             title: "Oops!",
//                                             text: response.message,
//                                             icon: "error"
//                                         });
//                                     } else {
//                                         Swal.fire({
//                                             title: "Oops!",
//                                             text: response.message,
//                                             icon: "error"
//                                         });
//                                     }
//                                 },
//                                 error: function (xhr, status, error) {
//                                     console.error(xhr.responseText);
//                                     Swal.fire({
//                                         title: "Oops!",
//                                         text: "Something went wrong! Please try again.",
//                                         icon: "error"
//                                     });
//                                 }
//                             });
//                         }
//                       });
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
//             error: function (xhr, status, error) {
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


// function endDuty() {
//     popupOpen("user-model-1");
//     Swal.fire({
//         title: "Are you sure?",
//         text: "You want to End Duty ",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#3085d6",
//         cancelButtonColor: "#d33",
//         confirmButtonText: "Yes, End Duty"
//     }).then((result) => {
//         if (result.isConfirmed) {
//             var formData = {
//                 action: 'endDuty2'
//             }
//             $.ajax({
//                 type: 'POST',
//                 url: '../Controllers/DailyReportController.php',
//                 data: formData,
//                 dataType: 'json',
//                 success: function (response) {
//                     if (response.status === 'success') {
//                         Swal.fire({
//                             title: "Success",
//                             text: response.message,
//                             icon: "success"
//                         }).then((result) => {
//                             window.location.reload();
//                         });
//                     }
//                     else if (response.status === 'error') {
//                         Swal.fire({
//                             title: "Oops!",
//                             text: response.message,
//                             icon: "error"
//                         });
//                     } else {
//                         Swal.fire({
//                             title: "Oops!",
//                             text: response.message,
//                             icon: "error"
//                         });
//                     }
//                 },
//                 error: function (xhr, status, error) {
//                     console.error(xhr.responseText);
//                     Swal.fire({
//                         title: "Oops!",
//                         text: "Something went wrong! Please try again.",
//                         icon: "error"
//                     });
//                 }
//             });
//         }
//     });
// }