<?php
session_start();
// print_r($_SESSION);
require_once './header.php';
require_once './navbar.php';
require_once '../../../Common/Common file/search_select_cdn.php';
require_once '../Services/DailyReportService.php';

//Get translations labels
$serviceDR = new DailyReportService();

$tlabels = $serviceDR->getTranslationsLabels(1);
if (!$tlabels && empty($tlabels)) {
    $tlabels = [
        ["translation" => "Bus Duty"],
        ["translation" => "Hello"],
        ["translation" => "Please select bus"],
        ["translation" => "Start Work"],
        ["translation" => "Select bus"]
    ];
}

?>
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">

<?php
    //Select bus
    $buses = $serviceDR->getBuses();
?>
    <div class="wrapper m-t-40">
        <form id="add-fuel-report" class="car centered p-10">
            <div class="container box-container w3-animate-bottom">
                <h5 class="heading center"><?= $tlabels[0]['translation'] ?></h5>

                <div class="row selectpicker-row">
                    <div class="col-sm-12">
                        <label for="" class="input-label"><?= $tlabels[4]['translation'] ?></label>
                        <select class="selectpicker input-field" data-show-subtext="true" data-live-search="true"
                            name="bus-id" id="bus-id" required>
                            <option value=""><?= $tlabels[4]['translation'] ?></option>
                            <?php
                            foreach ($buses as $bus) {
                                ?>
                                <option value="<?= $bus['id'] ?>"><?= $bus['bus_number'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="error-message p-r-l-15" id="bus-id-error"></span>
                    </div>
                    <div class="col-sm-12">
                        <label for="" class="input-label">Date</label>
                        <input type="date" class="input-field" name="date" placeholder="" required />
                    </div>
                    <div class="col-sm-12">
                        <label for="" class="input-label">Total Liters</label>
                        <input type="text" class="input-field" name="fuel-liters" placeholder="" required />
                    </div>
                    <div class="col-sm-12">
                        <label for="" class="input-label">Amount</label>    
                        <input type="text" class="input-field" name="fuel-amount" placeholder="" required />
                    </div>
                    <div class="col-sm-12 m-b-20">
                        <label for="exampleFormControlFile1" class="drop-container input-label" id="dropcontainer">
                            <span class="drop-title">Upload Fuel Bill</span>
                            <br>
                            <input type="file" class="form-control-file" name="fuel-bill" accept="image/*,.pdf" />
                        </label>
                    </div>
                </div>

                <div class="row">

                    <div class="col-sm-12">
                        <div class="input-group button-center">
                            <button class="button-2" id="submit" name="btn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Progress loader -->
<div class="tms-pop-up" id="progress-loader">
    <div class="pop-up-bg"></div>
    <div class="progress-loader">
        <div class="loader"></div>
        <p class="progress-text" id="progress-text">Loading, please wait..</p>
    </div>
</div>

<script src="./Js/fuel_report_ajax.js"></script>
<script src="../../../Common/Common file/main.js"></script>
<script src="../../../Common/Common file/pop_up.js"></script>
<?php
require_once './footer.php';
?>