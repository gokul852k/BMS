// Create Fuel Report

$(document).ready(function () {
    $('#add-fuel-report').on('submit', function (e) {
        e.preventDefault();
        if ($("#bus-id").val() == "") {
            
            $('#bus-id').addClass('input-error');
            $('#bus-id-error').html('Please select bus.');
            return;
        }

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }
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
                    Swal.fire({
                        title: "Success",
                        text: data.message,
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
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

