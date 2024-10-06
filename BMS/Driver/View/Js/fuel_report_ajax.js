// Get translations labels
let tlabels;
getTranslations();
function getTranslations () {
    var formData2 = {
        action: 'getTranslations',
        pageId: 4
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            
            if (response.status == "success") {
                tlabels = response.data;
                console.log(tlabels);
            }else {
                alert("yes");
                tlabels = [
                    {"translation": "Select Bus"},
                    {"translation": "Adding fuel report. Please wait.."},
                    {"translation": "Wait a moment.."},
                    {"translation": "Oops!"},
                    {"translation": "Something went wrong! Please try again."},
                    {"translation": "Success"},
                    {"translation": "The Fuel report added successfully."}
                ]
            }
            
        }
    });
}

// Create Fuel Report

$(document).ready(function () {
    $('#add-fuel-report').on('submit', function (e) {
        e.preventDefault();
        if ($("#bus-id").val() == "") {
            
            $('#bus-id').addClass('input-error');
            $('#bus-id-error').html(tlabels[0]['translation']);
            return;
        }

        // Check if form is valid
        if (!this.checkValidity()) {
            return;
        }
        //Calling progress bar
        popupOpen("progress-loader");
        let array = [[tlabels[1]['translation'], 4000], [tlabels[2]['translation'], 4000]];
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
                        title: tlabels[5]['translation'],
                        text: tlabels[6]['translation'],
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }
                else if (data.status === 'error') {
                    Swal.fire({
                        title: tlabels[3]['translation'],
                        text: tlabels[4]['translation'],
                        icon: "error"
                    });
                } else {
                    Swal.fire({
                        title: tlabels[3]['translation'],
                        text: tlabels[4]['translation'],
                        icon: "error"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire({
                    title: tlabels[3]['translation'],
                    text: tlabels[4]['translation'],
                    icon: "error"
                });
            }
        });
    });
});

