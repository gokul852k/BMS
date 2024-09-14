//Get Daily Report Table data 
getDailyReports();

function getDailyReports() {
    let formData1 = {
        action: 'getBusCardDetails'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/BusController.php',
        data: formData1,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let cardDetails = response.data;
                document.getElementById("total-bus").innerHTML = cardDetails.total_bus;
                document.getElementById("total-km").innerHTML = cardDetails.total_km;
                document.getElementById("avg-mileage").innerHTML = cardDetails.avg_mileage;
                document.getElementById("cost-per-km").innerHTML = cardDetails.cost_per_km;
                document.getElementById("expitations").innerHTML = cardDetails.expired_licenses;
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
        action: 'getDailyReports'
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            if (response.status === 'success') {
                let busDetails = response.data;
                console.log(busDetails);

                let tableBody = $('#daily-report-table tbody');
                tableBody.empty();

                $.each(busDetails, function (index, item) {
                    let row = '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + item.date + '</td>' +
                        '<td>' + item.busNumber + '</td>' +
                        '<td>' + item.km + '</td>' +
                        '<td>' + item.fuel + '</td>' +
                        '<td>' + item.avgMilage + '</td>' +
                        '<td>' + item.passenger + '</td>' +
                        '<td>' + item.collection + '</td>' +
                        '<td>' + item.expenses + '</td>' +
                        '<td>' + item.fuelAmount + '</td>' +
                        '<td>' + item.salary + '</td>' +
                        '<td>' + item.commission + '</td>' +
                        '<td>' + item.profit + '</td>' +
                        `<td>
                            <div class="th-btn">
                                <button class="table-btn view" onclick="popupOpen('bus-view'); getBusDetails(`+ item.bus_id + `);"><i
                                                class="fa-duotone fa-eye"></i></button>
                                <button class="table-btn edit" onclick="popupOpen('bus-edit'); getBusDetailsForEdit(`+ item.bus_id + `);"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                <button class="table-btn delete" onclick="deleteBus(`+ item.bus_id + `, '` + item.bus_number + `')"><i class="fa-duotone fa-trash"></i></button>
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