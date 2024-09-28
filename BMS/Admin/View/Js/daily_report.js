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

//Conductor search select as globle variable
let conductorsSelect;

//buses as globel variable
let buses;

//Bus search select as globle variable
let busSelect;

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
                <p class="bms-shift-title">Shift - ${shiftCounter}</p>
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
                                    <p class="bms-trip-title">Trip - ${tripCounters[shiftCounter]}</p>
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
                <p class="bms-trip-title">Trip - ${tripCounters[shiftNumber]}</p>
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

let deletedItems = [];

function deleteItem(id, itemId, name) {
    let type = name == 'shift' ? 'shift' : (name == 'trip') ? 'trip' : 'conductor';
    deletedItems.push({
        id: itemId,
        type: type
    });
    console.log(deletedItems);
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

let shiftCounterEdit = 1;
let tripCountersEdit = {1: 0};
let driverCountersEdit = {1: {1: 0}};
let conductorCountersEdit = {1: {1: 0}};

async function displayEdit(data) {
    shiftCounterEdit = 1;
    tripCountersEdit = {1: 0};
    driverCountersEdit = {1: {1: 0}};
    conductorCountersEdit = {1: {1: 0}};

    console.log(data);

    $("#edit-report-id").val(data.reportId);

    if (!buses) {
        await busesAjax();
    }

    if(!busSelect) {

        // Add default "Select Bus" option
        busSelect += '<option value="" selected>Select bus</option>';

        buses.forEach((bus) => {
            busSelect += '<option value="' + bus.id + '">' + bus.bus_number + '</option>';
        });
    }

    let busField = $("#edit-bus-no");

    busField.append(busSelect);

    busField.val(data.busId);

    $("#edit-date").val(data.date);

    $('#bms-edit-shifts').html('');

    let shifts = data.shift;
    // console.log(Object.keys(data.shift).length);
    for(let s = 1; s <= Object.keys(shifts).length; s++) {

        $('#bms-edit-shifts').append(
            `
            <div class="bms-shift" id="bms-shift-edit-${shiftCounterEdit}">
                <div class="bms-shift-header">
                    <p class="bms-shift-title">Shift - ${shiftCounterEdit}</p>
                    <button class="remove-button" title="Remove shift" onclick="deleteItem('bms-shift-edit-${shiftCounterEdit}', '${shifts[s]['shiftId']}', 'shift')"><i class="fa-solid fa-trash"></i></button>
                </div>
                <div class="bms-shift-body">
                    <div class="bms-shift-details">
                        <div class="row">
                            <input type="hidden" name="shift[${shiftCounterEdit}][shiftId]" value="${shifts[s]['shiftId']}">
                            <div class="col-sm-3">
                                <label for="" class="input-label">Shift End date</label>
                                <input type="date" class="input-field" name="shift[${shiftCounterEdit}][shiftEndDate]" value="${shifts[s]['shiftEndDate']}" placeholder="" required />
                            </div>
                            <div class="col-sm-3">
                                <label for="" class="input-label">Shift Start Time</label>
                                <input type="time" class="input-field" name="shift[${shiftCounterEdit}][shiftStartTime]" value="${shifts[s]['shiftStartTime']}" placeholder="" required />
                            </div>
                            <div class="col-sm-3">
                                <label for="" class="input-label">Shift End Time</label>
                                <input type="time" class="input-field" name="shift[${shiftCounterEdit}][shiftEndTime]" value="${shifts[s]['shiftEndTime']}" placeholder="" required />
                            </div>
                        </div>
                    </div>
                    <div class="bms-shift-workers">
                        <div class="bms-trip-container">
                            <div class="bms-trips" id="bms-trips-edit-${shiftCounterEdit}">
                                
                            </div>
                            <div class="bms-trip-footer">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="" class="input-label">Fuel Usage</label>
                                        <input type="number" class="input-field" name="shift[${shiftCounterEdit}][fuelUsage]" value="${shifts[s]['fuelUsage']}" placeholder="" required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="" class="input-label">Othere Expence</label>
                                        <input type="text" class="input-field" name="shift[${shiftCounterEdit}][otherExpence]" value="${shifts[s]['otherExpence']}" placeholder="" required />
                                    </div>
                                </div>
                                <button type="button" class="button-2" onclick="addEditTrip(${shiftCounterEdit})">Add Trip<i class="fa-solid fa-location-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `
        )

        let trips = shifts[s]['trip'];
        for (let t = 1; t <= Object.keys(trips).length; t++) {
            //Routes
            if (!routes) {
                await routeAjax();
            }

            // Add default "Select route" option
            let rs1 = '<option value="">Select Route</option>';

            routes.forEach((route) => {
                let isSelected = (trips[t]['startRoute'] == route.routeId) ? 'selected' : '';
                rs1 += '<option value="' + route.routeId + '"'+isSelected+'>' + route.routeName + '</option>';
            });

            let rs2 = '<option value="">Select Route</option>';

            routes.forEach((route) => {
                let isSelected = (trips[t]['endRoute'] == route.routeId) ? 'selected' : '';
                rs2 += '<option value="' + route.routeId + '"'+isSelected+'>' + route.routeName + '</option>';
            });

            if (!tripCountersEdit[shiftCounterEdit]) {
                tripCountersEdit[shiftCounterEdit] = 1;
            } else {
                tripCountersEdit[shiftCounterEdit]++;
            }

            let tripNumber = tripCountersEdit[shiftCounterEdit];
            $("#bms-trips-edit-"+shiftCounterEdit).append(
                `
                <div class="bms-trip" id="bms-trips-edit-${shiftCounterEdit}-${tripNumber}">
                    <div class="bms-trip-header">
                        <p class="bms-trip-title">Trip - ${tripNumber}</p>
                        <button type="button" class="remove-button" title="Remove Trip" onclick="deleteItem('bms-trips-edit-${shiftCounterEdit}-${tripNumber}', '${trips[t]['tripId']}', 'trip')"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="bms-trip-body">
                        <div class="bms-trip-route">
                            <div class="row">
                                <input type="hidden" name="shift[${shiftCounterEdit}][trip][${tripNumber}][tripId]" value="${trips[t]['tripId']}">
                                <div class="col-sm-4">
                                    <label for="" class="input-label">Start Route</label>
                                    <select class="input-field" name="shift[${shiftCounterEdit}][trip][${tripNumber}][startRoute]" value="${trips[t]['startRoute']}" required>
                                        ${rs1}
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="" class="input-label">End Route</label>
                                    <select class="input-field" name="shift[${shiftCounterEdit}][trip][${tripNumber}][endRoute]" value="${trips[t]['endRoute']}" required>
                                        ${rs2}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bms-trip-driver-container">
                            <div class="bms-trip-drivers" id="bms-trip-drivers-edit-${shiftCounterEdit}-${tripNumber}">
                                
                            </div>
                        </div>
                        <div class="bms-trip-conductor-container">
                            <div class="bms-trip-conductors" id="bms-trip-conductors-edit-${shiftCounterEdit}-${tripNumber}">
                                
                            </div>
                        </div>
                    </div>
                </div>
                `
            )

            // alert("bms-trip-drivers-edit-"+shiftCounterEdit+"-"+tripNumber);



            let tripDrivers = trips[t]['driver'];

            for (let d = 1; d <= Object.keys(tripDrivers); d++) {
                
                //Driver
                if (!drivers) {
                    await driverAjax();
                }

                

                // Add default "Select Bus" option
                let ds = '<option value="" selected>Select Driver</option>';

                drivers.forEach((driver) => {
                    let isSelected = (tripDrivers[d]['driverId'] == driver.id) ? 'selected' : '';
                    ds += '<option value="' + driver.id + '"'+isSelected+'>' + driver.fullname + '</option>';
                });
                

                if (!driverCountersEdit[shiftCounterEdit]) {
                    driverCountersEdit[shiftCounterEdit] = {};
                } 

                if (!driverCountersEdit[shiftCounterEdit][tripNumber]) {
                    driverCountersEdit[shiftCounterEdit][tripNumber] = 1;
                } else {
                    driverCountersEdit[shiftCounterEdit][tripNumber]++;
                }

                let driverNumber = driverCountersEdit[shiftCounterEdit][tripNumber];

                // let driverBtn = d == 1 ? `<button type="button" class="add-button" onclick="addEditDriver(${shiftCounterEdit},${tripNumber})"><i class="fa-solid fa-circle-plus"></i></button>` : `<button type="button" class="remove-button" title="Remove Driver" onclick="deleteItem('bms-trip-driver-${shiftCounterEdit}-${tripNumber}-${driverNumber}')"><i class="fa-solid fa-trash"></i></button>`;
                $("#bms-trip-drivers-edit-"+shiftCounterEdit+"-"+tripNumber).append(
                    `
                    <div class="bms-trip-driver" id="bms-trip-driver-edit-${shiftCounterEdit}-${tripNumber}-${driverNumber}">
                        <div class="bms-trip-driver-header">
                            <p class="bms-trip-driver-title">Driver</p>
                        </div>
                        <div class="bms-trip-driver-body">
                            <div class="bms-trip-driver-content">
                                <div class="row">
                                    <input type="hidden" name="shift[${shiftCounterEdit}][trip][${tripNumber}][driver][${driverNumber}][trip_driver_id]" value="${tripDrivers[d]['tripDriverId']}">
                                    <div class="col-sm-4">
                                        <label for="" class="input-label">Driver</label>
                                        <select class="input-field" name="shift[${shiftCounterEdit}][trip][${tripNumber}][driver][${driverNumber}][driver_id]" required>
                                            ${ds}
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="" class="input-label">Start Time</label>
                                        <input type="time" class="input-field"
                                            name="shift[${shiftCounterEdit}][trip][${tripNumber}][driver][${driverNumber}][start_time]" placeholder="" value="${tripDrivers[d]['startTime']}" required />
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="" class="input-label">End Time</label>
                                        <input type="time" class="input-field"
                                            name="shift[${shiftCounterEdit}][trip][${tripNumber}][driver][${driverNumber}][end_time]" placeholder="" value="${tripDrivers[d]['endTime']}" required />
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="" class="input-label">Start KM</label>
                                        <input type="text" class="input-field"
                                            name="shift[${shiftCounterEdit}][trip][${tripNumber}][driver][${driverNumber}][start_km]" placeholder="" value="${tripDrivers[d]['startKm']}" required />
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="" class="input-label">End KM</label>
                                        <input type="text" class="input-field"
                                            name="shift[${shiftCounterEdit}][trip][${tripNumber}][driver][${driverNumber}][end_km]" placeholder="" value="${tripDrivers[d]['endKm']}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `
                )
            }


            let tripconductors = trips[t]['conductor'];

            for (let c = 1; c <= Object.keys(tripconductors).length; c++) {
                // console.log(tripconductors[c]['tripConductorId']);
                //Conductor
                if (!conductors) {
                    await conductorAjax();
                }

                

                // Add default "Select Bus" option
                let cs = '<option value="">Select Conductor</option>';

                conductors.forEach((conductor) => {
                    let isSelected = (tripconductors[c]['conductorId'] == conductor.id) ? 'selected' : '';
                    cs += '<option value="' + conductor.id + '"'+isSelected+'>' + conductor.fullname + '</option>';
                });
                

                if (!conductorCountersEdit[shiftCounterEdit]) {
                    conductorCountersEdit[shiftCounterEdit] = {};
                } 

                if (!conductorCountersEdit[shiftCounterEdit][tripNumber]) {
                    conductorCountersEdit[shiftCounterEdit][tripNumber] = 1;
                } else {
                    conductorCountersEdit[shiftCounterEdit][tripNumber]++;
                }

                let conductorNumber = conductorCountersEdit[shiftCounterEdit][tripNumber];

                let conductorBtn = c == 1 ? `<button type="button" class="add-button" onclick="addEditConductor(${shiftCounterEdit},${tripNumber})"><i class="fa-solid fa-circle-plus"></i></button>` : `<button type="button" class="remove-button" title="Remove Conductor" onclick="deleteItem('bms-trip-conductor-edit-${shiftCounterEdit}-${tripNumber}-${conductorNumber}', '${tripconductors[c]['tripConductorId']}', 'conductor')"><i class="fa-solid fa-trash"></i></button>`;
                // alert("#bms-trip-conductors-edit-"+shiftCounterEdit+"-"+tripNumber);
                $("#bms-trip-conductors-edit-"+shiftCounterEdit+"-"+tripNumber).append(
                    `
                    <div class="bms-trip-conductor" id="bms-trip-conductor-edit-${shiftCounterEdit}-${tripNumber}-${conductorNumber}">
                        <div class="bms-trip-conductor-header">
                            <p class="bms-trip-conductor-title">Conductor</p>
                            ${conductorBtn}
                        </div>
                        <div class="bms-trip-conductor-body">
                            <div class="bms-trip-conductor-content">
                                <div class="row">
                                    <input type="hidden" name="shift[${shiftCounterEdit}][trip][${tripNumber}][conductor][${conductorNumber}][trip_conductor_id]" value="${tripconductors[c]['tripConductorId']}">
                                    <div class="col-sm-4">
                                        <label for="" class="input-label">Conductor</label>
                                        <select class="input-field" name="shift[${shiftCounterEdit}][trip][${tripNumber}][conductor][${conductorNumber}][conductor_id]" required>
                                            ${cs}
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="" class="input-label">Passangers</label>
                                        <input type="text" class="input-field"
                                            name="shift[${shiftCounterEdit}][trip][${tripNumber}][conductor][${conductorNumber}][passangers]" placeholder="" value="${tripconductors[c]['passangers']}" required />
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="" class="input-label">Collection</label>
                                        <input type="text" class="input-field"
                                            name="shift[${shiftCounterEdit}][trip][${tripNumber}][conductor][${conductorNumber}][collection]" placeholder="" value="${tripconductors[c]['collection']}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `
                )
            }
        }
        shiftCounterEdit++;
    }
}

async function addEditShift() {
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
    
    tripCountersEdit[shiftCounterEdit] = 1

    $('#bms-edit-shifts').append(
        `
        <div class="bms-shift" id="bms-shift-edit-${shiftCounterEdit}">
            <div class="bms-shift-header">
                <p class="bms-shift-title">Shift - ${shiftCounterEdit}</p>
                <button class="remove-button" title="Remove shift" onclick="remove('bms-shift-edit-${shiftCounterEdit}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-shift-body">
                <div class="bms-shift-details">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="" class="input-label">Shift End date</label>
                            <input type="date" class="input-field" name="shift[${shiftCounterEdit}][shiftEndDate]" placeholder="" required />
                        </div>
                        <div class="col-sm-3">
                            <label for="" class="input-label">Shift Start Time</label>
                            <input type="time" class="input-field" name="shift[${shiftCounterEdit}][shiftStartTime]" placeholder="" required />
                        </div>
                        <div class="col-sm-3">
                            <label for="" class="input-label">Shift End Time</label>
                            <input type="time" class="input-field" name="shift[${shiftCounterEdit}][shiftEndTime]" placeholder="" required />
                        </div>
                    </div>
                </div>
                <div class="bms-shift-workers">
                    <div class="bms-trip-container">
                        <div class="bms-trips" id="bms-trips-edit-${shiftCounterEdit}">
                            <div class="bms-trip" id="bms-trips-edit-${shiftCounterEdit}-${tripCountersEdit[shiftCounterEdit]}">
                                <div class="bms-trip-header">
                                    <p class="bms-trip-title">Trip - ${tripCountersEdit[shiftCounterEdit]}</p>
                                </div>
                                <div class="bms-trip-body">
                                    <div class="bms-trip-route">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="" class="input-label">Start Route</label>
                                                <select class="input-field" name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][startRoute]" required>
                                                    ${routesSelect}
                                                </select>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="" class="input-label">End Route</label>
                                                <select class="input-field" name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][endRoute]" required>
                                                    ${routesSelect}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bms-trip-driver-container">
                                        <div class="bms-trip-drivers" id=bms-trip-drivers-edit-${shiftCounterEdit}-${tripCountersEdit[shiftCounterEdit]}">
                                            <div class="bms-trip-driver" id="bms-trip-driver-edit-${shiftCounterEdit}-${tripCountersEdit[shiftCounterEdit]}-1">
                                                <div class="bms-trip-driver-header">
                                                    <p class="bms-trip-driver-title">Driver</p>
                                                </div>
                                                <div class="bms-trip-driver-body">
                                                    <div class="bms-trip-driver-content">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label for="" class="input-label">Driver</label>
                                                                <select class="input-field" name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][driver][1][driver_id]" required>
                                                                    ${driversSelect}
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="input-label">Start Time</label>
                                                                <input type="time" class="input-field"
                                                                    name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][driver][1][start_time]" placeholder="" required />
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="input-label">End Time</label>
                                                                <input type="time" class="input-field"
                                                                    name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][driver][1][end_time]" placeholder="" required />
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="input-label">Start KM</label>
                                                                <input type="text" class="input-field"
                                                                    name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][driver][1][start_km]" placeholder="" required />
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label for="" class="input-label">End KM</label>
                                                                <input type="text" class="input-field"
                                                                    name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][driver][1][end_km]" placeholder="" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bms-trip-conductor-container">
                                        <div class="bms-trip-conductors" id="bms-trip-conductors-edit-${shiftCounterEdit}-${tripCountersEdit[shiftCounterEdit]}">
                                            <div class="bms-trip-conductor" id="bms-trip-conductor-edit-${shiftCounterEdit}-${tripCountersEdit[shiftCounterEdit]}-1">
                                                <div class="bms-trip-conductor-header">
                                                    <p class="bms-trip-conductor-title">Conductor</p>
                                                    <button type="button" class="add-button" onclick="addEditConductor(${shiftCounterEdit},${tripCountersEdit[shiftCounterEdit]})"><i class="fa-solid fa-circle-plus"></i></button>
                                                </div>
                                                <div class="bms-trip-conductor-body">
                                                    <div class="bms-trip-conductor-content">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label for="" class="input-label">Conductor</label>
                                                                <select class="input-field" name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][conductor][1][conductor_id]" required>
                                                                    ${conductorsSelect}
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="" class="input-label">Passangers</label>
                                                                <input type="text" class="input-field"
                                                                    name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][conductor][1][passangers]" placeholder="" required />
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="" class="input-label">Collection</label>
                                                                <input type="text" class="input-field"
                                                                    name="shift[${shiftCounterEdit}][trip][${tripCountersEdit[shiftCounterEdit]}][conductor][1][collection]" placeholder="" required />
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
                                    <input type="number" class="input-field" name="shift[${shiftCounterEdit}][fuelUsage]" placeholder="" required />
                                </div>
                                <div class="col-sm-3">
                                    <label for="" class="input-label">Othere Expence</label>
                                    <input type="text" class="input-field" name="shift[${shiftCounterEdit}][otherExpence]" placeholder="" required />
                                </div>
                            </div>
                            <button type="button" class="button-2" onclick="addEditTrip(${shiftCounterEdit})">Add Trip<i class="fa-solid fa-location-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `
    )
    shiftCounterEdit++;
    
}


async function addEditTrip(shiftNumber) {
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

    tripCountersEdit[shiftNumber]++

    if (!driverCountersEdit[shiftNumber]) {
        driverCountersEdit[shiftNumber] = {};
    } 

    if (!driverCountersEdit[shiftNumber][tripCountersEdit[shiftNumber]]) {
        driverCountersEdit[shiftNumber][tripCountersEdit[shiftNumber]] = 1;
    }

    if (!conductorCountersEdit[shiftNumber]) {
        conductorCountersEdit[shiftNumber] = {};
    } 

    if (!conductorCountersEdit[shiftNumber][tripCountersEdit[shiftNumber]]) {
        conductorCountersEdit[shiftNumber][tripCountersEdit[shiftNumber]] = 1;
    }
    $('#bms-trips-edit-'+shiftNumber).append(
        `
         <div class="bms-trip" id="bms-trips-edit-${shiftNumber}-${tripCountersEdit[shiftNumber]}">
            <div class="bms-trip-header">
                <p class="bms-trip-title">Trip - ${tripCountersEdit[shiftNumber]}</p>
                <button type="button" class="remove-button" title="Remove Trip" onclick="remove('bms-trips-edit-${shiftNumber}-${tripCountersEdit[shiftNumber]}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-trip-body">
                <div class="bms-trip-route">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="" class="input-label">Start Route</label>
                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][startRoute]">
                                ${routesSelect}
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">End Route</label>
                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][endRoute]">
                                ${routesSelect}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bms-trip-driver-container">
                    <div class="bms-trip-drivers" id="bms-trip-drivers-edit-${shiftNumber}-${tripCountersEdit[shiftNumber]}">
                        <div class="bms-trip-driver" id="bms-trip-driver-edit-${shiftNumber}-${tripCountersEdit[shiftNumber]}-1">
                            <div class="bms-trip-driver-header">
                                <p class="bms-trip-driver-title">Driver</p>
                            </div>
                            <div class="bms-trip-driver-body">
                                <div class="bms-trip-driver-content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="" class="input-label">Driver</label>
                                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][driver][1][driver_id]" required>
                                                ${driversSelect}
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">Start Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][driver][1][start_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][driver][1][end_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">Start KM</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][driver][1][start_km]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End KM</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][driver][1][end_km]" placeholder="" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bms-trip-conductor-container">
                    <div class="bms-trip-conductors" id="bms-trip-conductors-edit-${shiftNumber}-${tripCountersEdit[shiftNumber]}">
                        <div class="bms-trip-conductor" id="bms-trip-conductor-edit-${shiftNumber}-${tripCountersEdit[shiftNumber]}-1">
                            <div class="bms-trip-conductor-header">
                                <p class="bms-trip-conductor-title">Conductor</p>
                                <button type="button" class="add-button" onclick="addEditConductor(${shiftNumber},${tripCountersEdit[shiftNumber]})"><i class="fa-solid fa-circle-plus"></i></button>
                            </div>
                            <div class="bms-trip-conductor-body">
                                <div class="bms-trip-conductor-content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="" class="input-label">Conductor</label>
                                            <select class="input-field" name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][conductor][1][conductor_id]" required>
                                                ${conductorsSelect}
                                            </select>
                                        </div>
                                        <!-- <div class="col-sm-2">
                                            <label for="" class="input-label">Start Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][conductor][1][start_time]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="" class="input-label">End Time</label>
                                            <input type="time" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][conductor][1][conductor_id]" placeholder="" required />
                                        </div> -->
                                        <div class="col-sm-3">
                                            <label for="" class="input-label">Passangers</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][conductor][1][passangers]" placeholder="" required />
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="" class="input-label">Collection</label>
                                            <input type="text" class="input-field"
                                                name="shift[${shiftNumber}][trip][${tripCountersEdit[shiftNumber]}][conductor][1][collection]" placeholder="" required />
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

async function addEditConductor(shiftNumber, tripNumber) {
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

    if (!conductorCountersEdit[shiftNumber]) {
        conductorCountersEdit[shiftNumber] = {};
    } 

    if (!conductorCountersEdit[shiftNumber][tripNumber]) {
        conductorCountersEdit[shiftNumber][tripNumber] = 1;
    } else {
        conductorCountersEdit[shiftNumber][tripNumber]++;
    }

    let conductorNumber = conductorCountersEdit[shiftNumber][tripNumber];

    $('#bms-trip-conductors-edit-'+shiftNumber+'-'+tripNumber).append(
        `
        <div class="bms-trip-conductor" id="bms-trip-conductor-edit-${shiftNumber}-${tripNumber}-${conductorNumber}">
            <div class="bms-trip-conductor-header">
                <p class="bms-trip-conductor-title">Conductor</p>
                <button type="button" class="remove-button" title="Remove Conductor" onclick="remove('bms-trip-conductor-edit-${shiftNumber}-${tripNumber}-${conductorNumber}')"><i class="fa-solid fa-trash"></i></button>
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

function displayView(data) {
    let view = data.busNumber + ' - ' + data.date;
    $('#View-title').html(view);
    $reportDetails = data['reportDetails'];
    $('#daily-report-view-content').html('');
    $('#daily-report-view-content').append(
        `
        <div class="report-summary">
            <div class="counter-cards-2 m-b-20">
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-1">
                        <i class="fa-duotone fa-solid fa-bus"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.totalKm}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Total Km</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-2">
                        <i class="fa-solid fa-gas-pump"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.fuelUsage}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Fuel Usage</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-3">
                        <i class="fa-solid fa-gauge-simple"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.avgMilage}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Avg Mileage</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-4">
                        <i class="fa-solid fa-people-group"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.totalPassengers}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Passangers</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-5">
                        <i class="fa-solid fa-sack"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.totalCollection}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Collection</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-6">
                        <i class="fa-solid fa-chart-simple-horizontal"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.expenses}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Expense</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-7">
                        <i class="fa-sharp fa-solid fa-gas-pump"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.fuelAmount}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Fuel Amount</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-8">
                        <i class="fa-solid fa-user-group-simple"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.salary}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Salary</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-9">
                        <i class="fa-solid fa-badge-percent"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.commission}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Commission</p>
                    </div>
                </div>
                <div class="counter-card-2">
                    <div class="counter-card-2-icon c-10">
                        <i class="fa-solid fa-chart-simple"></i>
                    </div>
                    <div class="counter-card-2-value">
                        <p>${$reportDetails.profit}</p>
                    </div>
                    <div class="counter-card-2-name">
                        <p>Profit</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="bms-shift-container">
            <div class="bms-shifts" id="daily-report-view-shifts">
                
            </div>
        </div>
        `
    );

    let shifts = data.shift;

    for (let s = 1; s <= Object.keys(shifts).length; s++) {

        let shiftDetails = shifts[s]['shiftDetails'];

        let trips = shifts[s]['trip'];

        let tripHTML = ``;

        for (let t = 1; t <= Object.keys(trips).length; t++) {
            let trip = trips[t];
    
            //Trip Drivers
            let drivers = trips[t]['driver'];
            let driverHTML = ``;
            for (let d = 1; d <= Object.keys(drivers).length; d++) {
                let driver = drivers[d];
                driverHTML += `
                <div class="trip-driver">
                    <div class="trip-worker-info">
                        <p class="trip-worker-head">${driver.driver}</p>
                        <p class="trip-worker-title">Driver</p>
                    </div>
                    <div class="trip-worker-info">
                        <p class="trip-worker-head">${driver.startKm}</p>
                        <p class="trip-worker-title">Start KM</p>
                    </div>
                    <div class="trip-worker-info">
                        <p class="trip-worker-head">${driver.endTime}</p>
                        <p class="trip-worker-title">End KM</p>
                    </div>
                    <div class="trip-worker-info">
                        <p class="trip-worker-head">${driver.totalKm}</p>
                        <p class="trip-worker-title">Total KM</p>
                    </div>
                </div>
                `;
            }

             //Trip Conductor
             let conductors = trips[t]['conductor'];
             let conductorHTML = ``;
             for (let c = 1; c <= Object.keys(conductors).length; c++) {
                 let conductor = conductors[c];
                 conductorHTML += `
                 <div class="trip-conductor">
                    <div class="trip-worker-info">
                        <p class="trip-worker-head">${conductor.conductor}</p>
                        <p class="trip-worker-title">Conductor</p>
                    </div>
                    <div class="trip-worker-info">
                        <p class="trip-worker-head">${conductor.passangers}</p>
                        <p class="trip-worker-title">Passangers</p>
                    </div>
                    <div class="trip-worker-info">
                        <p class="trip-worker-head">${conductor.collection}</p>
                        <p class="trip-worker-title">Collection</p>
                    </div>
                </div>
                 `;
             }

            tripHTML += `
            <div class="trip-card">
                <div class="trip-location">
                    <span class="mid-line"></span>
                    <div class="trip-location-from">
                        <p class="trip-route">${trip.startRoute}</p>
                        <p class="trip-label">From</p>
                        <p class="trip-time">${trip.tripStratTime}</p>
                    </div>
                    <div class="trip-location-mid">
                        <p class="trip-hours">${trip.tripTimeTaken}</p>
                    </div>
                    <div class="trip-location-to">
                        <p class="trip-route">${trip.endRoute}</p>
                        <p class="trip-label">To</p>
                        <p class="trip-time">${trip.tripEndTime}</p>
                    </div>
                </div>
                <div class="counter-cards-2 m-b-20">
                    <div class="counter-card-2">
                        <div class="counter-card-2-icon c-1">
                            <i class="fa-duotone fa-solid fa-bus"></i>
                        </div>
                        <div class="counter-card-2-value">
                            <p>${trip.tripKm}</p>
                        </div>
                        <div class="counter-card-2-name">
                            <p>Km</p>
                        </div>
                    </div>
                    <div class="counter-card-2">
                        <div class="counter-card-2-icon c-4">
                            <i class="fa-duotone fa-solid fa-bus"></i>
                        </div>
                        <div class="counter-card-2-value">
                            <p>${trip.tripPassangers}</p>
                        </div>
                        <div class="counter-card-2-name">
                            <p>Passangers</p>
                        </div>
                    </div>
                    <div class="counter-card-2">
                        <div class="counter-card-2-icon c-5">
                            <i class="fa-duotone fa-solid fa-bus"></i>
                        </div>
                        <div class="counter-card-2-value">
                            <p>${trip.tripCollection}</p>
                        </div>
                        <div class="counter-card-2-name">
                            <p>Collection</p>
                        </div>
                    </div>
                </div>
                <div class="trip-details">
                    <details>
                        <summary>
                            <span class="summary-title">Trip - ${t}</span>
                            <div class="summary-chevron-up">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </summary>

                        <div class="summary-content">
                            <div class="trip-drivers">
                                ${driverHTML}
                            </div>
                            <div class="trip-conductors">
                                ${conductorHTML}
                            </div>
                        </div>
                        <div class="summary-chevron-down">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            
                    </details>
                </div>
            </div>
            `;
        }

        $('#daily-report-view-shifts').append(
            `
            <div class="bms-shift" id="view-shift">
                <div class="bms-shift-header">
                    <p class="bms-shift-title">Shift - ${s}</p>
                    <p class="bms-shift-title">${shifts[s]['shiftStartTime']} - ${shifts[s]['shiftEndTime']}</p>
                </div>
                
                <div class="bms-shift-body">
                    <div class="bms-shift-details">
                        <div class="counter-cards-2 m-b-20">
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-1">
                                    <i class="fa-duotone fa-solid fa-bus"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.totalKm}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Total Km</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-2">
                                    <i class="fa-solid fa-gas-pump"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.fuelUsage}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Fuel Usage</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-3">
                                    <i class="fa-solid fa-gauge-simple"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.avgMilage}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Avg Mileage</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-4">
                                    <i class="fa-solid fa-people-group"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.totalPassengers}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Passangers</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-5">
                                    <i class="fa-solid fa-sack"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.totalCollection}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Collection</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-6">
                                    <i class="fa-solid fa-chart-simple-horizontal"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.expence}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Expense</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-7">
                                    <i class="fa-sharp fa-solid fa-gas-pump"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.fuelAmount}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Fuel Amount</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-8">
                                    <i class="fa-solid fa-user-group-simple"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.salary}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Salary</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-9">
                                    <i class="fa-solid fa-badge-percent"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.commission}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Commission</p>
                                </div>
                            </div>
                            <div class="counter-card-2">
                                <div class="counter-card-2-icon c-10">
                                    <i class="fa-solid fa-chart-simple"></i>
                                </div>
                                <div class="counter-card-2-value">
                                    <p>${shiftDetails.profit}</p>
                                </div>
                                <div class="counter-card-2-name">
                                    <p>Profit</p>
                                </div>
                            </div>
                        </div>
                        <div class="trip-cards" id="daily-report-view-trips">
                            ${tripHTML}
                        </div>
                    </div>
                </div>
            </div>
            `
        );

    }
}