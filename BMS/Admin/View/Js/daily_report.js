//Drivers as  globle variable
let routes;

//Route search select as globle variable
let routesSelect;

//Drivers as  globle variable
let drivers;

//Drivers search select as globle variable
let driversSelect;

//Drivers as  globle variable
let conductors;

//Drivers search select as globle variable
let conductorsSelect;

//buses as globel variable
let buses;

let shiftCounter = 1;
let tripCounters = {1: 1};
let driverCounters = {1: {1: 1}};
let conductorCounters = {1: {1: 1}};

$(document).ready(function(){

//Add Shift
$("#add-shift").click(async function(){
    //Driver
    if (!drivers) {
        await driverAjax();
    }

    if(!driversSelect) {

        // Add default "Select Bus" option
        driversSelect += '<option value="" selected>Select Driver</option>';

        drivers.forEach((driver) => {
            driversSelect += '<option value="' + driver.id + '">' + driver.fullname + '</option>';
        });
    }

    //Conductor
    if (!conductors) {
        await conductorAjax();
    }

    if(!conductorsSelect) {

        // Add default "Select Bus" option
        conductorsSelect += '<option value="" selected>Select Conductor</option>';

        conductors.forEach((conductor) => {
            conductorsSelect += '<option value="' + conductor.id + '">' + conductor.fullname + '</option>';
        });
    }

    //Routes
    if (!routes) {
        await routeAjax();
    }

    if(!routesSelect) {

        // Add default "Select Bus" option
        routesSelect += '<option value="" selected>Select Route</option>';

        routes.forEach((route) => {
            routesSelect += '<option value="' + route.routeId + '">' + route.routeName + '</option>';
        });
    }
    
    shiftCounter++;
    tripCounters[shiftCounter] = 1

    $('#bms-shifts').append(
        `
        <div class="bms-shift" id="bms-shift-${shiftCounter}">
            <div class="bms-shift-header">
                <p class="bms-shift-title">Shift</p>
                <button class="remove-button" title="Remove shift" onclick="remove('bms-shift-${shiftCounter}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-shift-body">
                <div class="bms-shift-details">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="" class="input-label">Shift End date</label>
                            <input type="date" class="input-field" name="shift[${shiftCounter}][shiftEndDate]" placeholder="" required />
                        </div>
                        <div class="col-sm-3">
                            <label for="" class="input-label">Shift Start Time</label>
                            <input type="time" class="input-field" name="shift[${shiftCounter}][shiftStartTime]" placeholder="" required />
                        </div>
                        <div class="col-sm-3">
                            <label for="" class="input-label">Shift End Time</label>
                            <input type="time" class="input-field" name="shift[${shiftCounter}][shiftEndTime]" placeholder="" required />
                        </div>
                    </div>
                </div>
                <div class="bms-shift-workers">
                    <div class="bms-trip-container">
                        <div class="bms-trips" id="bms-trips-${shiftCounter}">
                            <div class="bms-trip" id="bms-trips-${shiftCounter}-${tripCounters[shiftCounter]}">
                                <div class="bms-trip-header">
                                    <p class="bms-trip-title">Trip</p>
                                </div>
                                <div class="bms-trip-body">
                                    <div class="bms-trip-route">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="" class="input-label">Start Route</label>
                                                <select class="input-field" name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][startRoute]" required>
                                                    ${routesSelect}
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="" class="input-label">End Route</label>
                                                <select class="input-field" name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][endRoute]" required>
                                                    ${routesSelect}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bms-trip-driver-container">
                                        <div class="bms-trip-drivers" id=bms-trip-drivers-${shiftCounter}-${tripCounters[shiftCounter]}">
                                            <div class="bms-trip-driver" id="bms-trip-driver-${shiftCounter}-${tripCounters[shiftCounter]}-1">
                                                <div class="bms-trip-driver-header">
                                                    <p class="bms-trip-driver-title">Driver</p>
                                                    <button type="button" class="add-button" onclick="addDriver(${shiftCounter},${tripCounters[shiftCounter]})"><i class="fa-solid fa-circle-plus"></i></button>
                                                </div>
                                                <div class="bms-trip-driver-body">
                                                    <div class="bms-trip-driver-content">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label for="" class="input-label">Driver</label>
                                                                <select class="input-field" name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][driver][1][driver_id]" required>
                                                                    ${driversSelect}
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="input-label">Start Time</label>
                                                                <input type="time" class="input-field"
                                                                    name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][driver][1][start_time]" placeholder="" required />
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="input-label">End Time</label>
                                                                <input type="time" class="input-field"
                                                                    name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][driver][1][end_time]" placeholder="" required />
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="input-label">Start KM</label>
                                                                <input type="text" class="input-field"
                                                                    name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][driver][1][start_km]" placeholder="" required />
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="input-label">End KM</label>
                                                                <input type="text" class="input-field"
                                                                    name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][driver][1][end_km]" placeholder="" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bms-trip-conductor-container">
                                        <div class="bms-trip-conductors" id="bms-trip-conductors-${shiftCounter}-${tripCounters[shiftCounter]}">
                                            <div class="bms-trip-conductor" id="bms-trip-conductor-${shiftCounter}-${tripCounters[shiftCounter]}-1">
                                                <div class="bms-trip-conductor-header">
                                                    <p class="bms-trip-conductor-title">Conductor</p>
                                                    <button type="button" class="add-button" onclick="addConductor(${shiftCounter},${tripCounters[shiftCounter]})"><i class="fa-solid fa-circle-plus"></i></button>
                                                </div>
                                                <div class="bms-trip-conductor-body">
                                                    <div class="bms-trip-conductor-content">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label for="" class="input-label">Conductor</label>
                                                                <select class="input-field" name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][conductor][1][conductor_id]" required>
                                                                    ${conductorsSelect}
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="" class="input-label">Passangers</label>
                                                                <input type="text" class="input-field"
                                                                    name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][conductor][1][passangers]" placeholder="" required />
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="" class="input-label">Collection</label>
                                                                <input type="text" class="input-field"
                                                                    name="shift[${shiftCounter}][trip][${tripCounters[shiftCounter]}][conductor][1][collection]" placeholder="" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bms-trip-footer">
                            <div class="row">
                                <div class="col-sm-3">
                                    <label for="" class="input-label">Fuel Usage</label>
                                    <input type="number" class="input-field" name="shift[${shiftCounter}][fuelUsage]" placeholder="" required />
                                </div>
                                <div class="col-sm-3">
                                    <label for="" class="input-label">Othere Expence</label>
                                    <input type="text" class="input-field" name="shift[${shiftCounter}][otherExpence]" placeholder="" required />
                                </div>
                            </div>
                            <button type="button" class="button-2" onclick="addTrip(${shiftCounter})">Add Trip<i class="fa-solid fa-location-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    )
});

});

//Add Trips
async function addTrip(shiftNumber) {
    //Driver
    if (!drivers) {
        await driverAjax();
    }

    if(!driversSelect) {

        // Add default "Select Bus" option
        driversSelect += '<option value="" selected>Select Driver</option>';

        drivers.forEach((driver) => {
            driversSelect += '<option value="' + driver.id + '">' + driver.fullname + '</option>';
        });
    }

    //Conductor
    if (!conductors) {
        await conductorAjax();
    }

    if(!conductorsSelect) {

        // Add default "Select Bus" option
        conductorsSelect += '<option value="" selected>Select Conductor</option>';

        conductors.forEach((conductor) => {
            conductorsSelect += '<option value="' + conductor.id + '">' + conductor.fullname + '</option>';
        });
    }

    //Routes
    if (!routes) {
        await routeAjax();
    }

    if(!routesSelect) {

        // Add default "Select Bus" option
        routesSelect += '<option value="" selected>Select Route</option>';

        routes.forEach((route) => {
            routesSelect += '<option value="' + route.routeId + '">' + route.routeName + '</option>';
        });
    }

    tripCounters[shiftNumber]++

    if (!driverCounters[shiftNumber]) {
        driverCounters[shiftNumber] = {};
    } 

    if (!driverCounters[shiftNumber][tripCounters[shiftNumber]]) {
        driverCounters[shiftNumber][tripCounters[shiftNumber]] = 1;
    }

    if (!conductorCounters[shiftNumber]) {
        conductorCounters[shiftNumber] = {};
    } 

    if (!conductorCounters[shiftNumber][tripCounters[shiftNumber]]) {
        conductorCounters[shiftNumber][tripCounters[shiftNumber]] = 1;
    }
    $('#bms-trips-'+shiftNumber).append(
        `
         <div class="bms-trip" id="bms-trips-${shiftNumber}-${tripCounters[shiftNumber]}">
            <div class="bms-trip-header">
                <p class="bms-trip-title">Trip</p>
                <button type="button" class="remove-button" title="Remove Trip" onclick="remove('bms-trips-${shiftNumber}-${tripCounters[shiftNumber]}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-trip-body">
                <div class="bms-trip-route">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="" class="input-label">Start Route</label>
                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][startRoute]">
                                ${routesSelect}
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">End Route</label>
                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][endRoute]">
                                ${routesSelect}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bms-trip-driver-container">
                    <div class="bms-trip-drivers" id="bms-trip-drivers-${shiftNumber}-${tripCounters[shiftNumber]}">
                        <div class="bms-trip-driver" id="bms-trip-driver-${shiftNumber}-${tripCounters[shiftNumber]}-1">
                            <div class="bms-trip-driver-header">
                                <p class="bms-trip-driver-title">Driver</p>
                                <button type="button" class="add-button" onclick="addDriver(${shiftNumber},${tripCounters[shiftNumber]})"><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                            <div class="bms-trip-driver-body">
                                <div class="bms-trip-driver-content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="" class="input-label">Driver</label>
                                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][driver_id]" required>
                                                ${driversSelect}
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">Start Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][start_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][end_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">Start KM</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][start_km]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End KM</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][driver][1][end_km]" placeholder="" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bms-trip-conductor-container">
                    <div class="bms-trip-conductors" id="bms-trip-conductors-${shiftNumber}-${tripCounters[shiftNumber]}">
                        <div class="bms-trip-conductor" id="bms-trip-conductor-${shiftNumber}-${tripCounters[shiftNumber]}-1">
                            <div class="bms-trip-conductor-header">
                                <p class="bms-trip-conductor-title">Conductor</p>
                                <button type="button" class="add-button" onclick="addConductor(${shiftNumber},${tripCounters[shiftNumber]})"><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                            <div class="bms-trip-conductor-body">
                                <div class="bms-trip-conductor-content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="" class="input-label">Conductor</label>
                                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][conductor_id]" required>
                                                ${conductorsSelect}
                                            </select>
                                        </div>
                                        <!-- <div class="col-sm-2">
                                            <label for="" class="input-label">Start Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][start_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][conductor_id]" placeholder="" required />
                                        </div> -->
                                        <div class="col-sm-3">
                                            <label for="" class="input-label">Passangers</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][passangers]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="input-label">Collection</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCounters[shiftNumber]}][conductor][1][collection]" placeholder="" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    );
}

//Add Driver

async function addDriver(shiftNumber, tripNumber) {

    //Driver
    if (!drivers) {
        await driverAjax();
    }

    if(!driversSelect) {

        // Add default "Select Bus" option
        driversSelect += '<option value="" selected>Select Driver</option>';

        drivers.forEach((driver) => {
            driversSelect += '<option value="' + driver.id + '">' + driver.fullname + '</option>';
        });
    }

    if (!driverCounters[shiftNumber]) {
        driverCounters[shiftNumber] = {};
    } 

    if (!driverCounters[shiftNumber][tripNumber]) {
        driverCounters[shiftNumber][tripNumber] = 1;
    } else {
        driverCounters[shiftNumber][tripNumber]++;
    }

    let driverNumber = driverCounters[shiftNumber][tripNumber];

    $('#bms-trip-drivers-'+shiftNumber+'-'+tripNumber).append(
        `
        <div class="bms-trip-driver" id="bms-trip-driver-${shiftNumber}-${tripNumber}-${driverNumber}">
            <div class="bms-trip-driver-header">
                <p class="bms-trip-driver-title">Driver</p>
                <button type="button" class="remove-button" title="Remove Driver" onclick="remove('bms-trip-driver-${shiftNumber}-${tripNumber}-${driverNumber}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-trip-driver-body">
                <div class="bms-trip-driver-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="" class="input-label">Driver</label>
                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][driver_id]" required>
                                ${driversSelect}
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="input-label">Start Time</label>
                            <input type="time" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][start_time]" placeholder="" required />
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="input-label">End Time</label>
                            <input type="time" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][end_time]" placeholder="" required />
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="input-label">Start KM</label>
                            <input type="text" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][start_km]" placeholder="" required />
                        </div>
                        <div class="col-sm-2">
                            <label for="" class="input-label">End KM</label>
                            <input type="text" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][driver][${driverNumber}][end_km]" placeholder="" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    )

    // Initialize or refresh selectpicker for newly added selects
    $('.selectpicker').selectpicker('refresh');
}

//Add Conductor

async function addConductor(shiftNumber, tripNumber) {

    //Conductor
    if (!conductors) {
        await conductorAjax();
    }

    if(!conductorsSelect) {

        // Add default "Select Bus" option
        conductorsSelect += '<option value="" selected>Select Conductor</option>';

        conductors.forEach((conductor) => {
            conductorsSelect += '<option value="' + conductor.id + '">' + conductor.fullname + '</option>';
        });
    }

    if (!conductorCounters[shiftNumber]) {
        conductorCounters[shiftNumber] = {};
    } 

    if (!conductorCounters[shiftNumber][tripNumber]) {
        conductorCounters[shiftNumber][tripNumber] = 1;
    } else {
        conductorCounters[shiftNumber][tripNumber]++;
    }

    let conductorNumber = conductorCounters[shiftNumber][tripNumber];

    $('#bms-trip-conductors-'+shiftNumber+'-'+tripNumber).append(
        `
        <div class="bms-trip-conductor" id="bms-trip-conductor-${shiftNumber}-${tripNumber}-${conductorNumber}">
            <div class="bms-trip-conductor-header">
                <p class="bms-trip-conductor-title">Conductor</p>
                <button type="button" class="remove-button" title="Remove Conductor" onclick="remove('bms-trip-conductor-${shiftNumber}-${tripNumber}-${conductorNumber}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-trip-conductor-body">
                <div class="bms-trip-conductor-content">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="row selectpicker-row p-0">
                                <div class="col-sm-12 search-select-1">
                                    <label for="" class="input-label">Conductor</label>
                                    <select class="input-field" name="shift[${shiftNumber}][trip][${tripNumber}][conductor][${conductorNumber}][conductor_id]" required>
                                        ${conductorsSelect}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label for="" class="input-label">Passangers</label>
                            <input type="text" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][conductor][${conductorNumber}][passangers]" placeholder="" required />
                        </div>
                        <div class="col-sm-3">
                            <label for="" class="input-label">Collection</label>
                            <input type="text" class="input-field"
                                name="shift[${shiftNumber}][trip][${tripNumber}][conductor][${conductorNumber}][collection]" placeholder="" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    )
}

function remove(id) {
    $('#'+id).remove();
}

async function getDetails() {
    if (!buses) {
        await busesAjax();
    }

    let select = $('#bus-no');
    select.empty();  // Clear existing options

    // Add default "Select Bus" option
    select.append('<option value="" selected>Select Bus</option>');

    buses.forEach((bus) => {
        select.append('<option value="' + bus.id + '">' + bus.bus_number + '</option>');
    });

    //Driver
    if (!drivers) {
        await driverAjax();
    }
    let select2 = $('#driver-1-1-1');
    select2.empty();  // Clear existing options

    // Add default "Select Bus" option
    select2.append('<option value="" selected>Select Driver</option>');

    drivers.forEach((driver) => {
        select2.append('<option value="' + driver.id + '">' + driver.fullname + '</option>');
    });


    //Driver
    if (!conductors) {
        await conductorAjax();
    }

    console.log(conductors);
    let select3 = $('#conductor-1-1-1');
    select3.empty();  // Clear existing options

    // Add default "Select Bus" option
    select3.append('<option value="" selected>Select Conductor</option>');

    conductors.forEach((conductor) => {
        select3.append('<option value="' + conductor.id + '">' + conductor.fullname + '</option>');
    });


    //Routes
    if (!routes) {
        await routeAjax();
    }
    let select4 = $('#start-route');
    select4.empty();  // Clear existing options

    // Add default "Select Bus" option
    select4.append('<option value="" selected>Select Route</option>');

    routes.forEach((route) => {
        select4.append('<option value="' + route.routeId + '">' + route.routeName + '</option>');
    });


    //Routes
    if (!routes) {
        await routeAjax();
    }
    let select5 = $('#end-route');
    select5.empty();  // Clear existing options

    // Add default "Select Bus" option
    select5.append('<option value="" selected>Select Route</option>');

    routes.forEach((route) => {
        select5.append('<option value="' + route.routeId + '">' + route.routeName + '</option>');
    });

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

//Driver ajax
function conductorAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getConductorField'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/ConductorController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    conductors = response.data;
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

//Bus ajax
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

//Route ajax
function routeAjax() {
    return new Promise((resolve, reject) => {
        let formData = {
            action: 'getRouteField'
        }
        $.ajax({
            type: 'POST',
            url: '../Controllers/RouteController.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    routes = response.data;
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

