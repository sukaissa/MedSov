<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Stanley kwamina Otabil <stanleyotabil10@gmail.com@gmail.com>
 * @author      Mohammed Awal Saeed <awalsaeed736@gmail.com@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

use OpenEMR\Modules\InpatientModule\AdmissionQueueQuery;
use OpenEMR\Modules\InpatientModule\ActionPlanQuery;
use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\FoodQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\ListsQuery;
use OpenEMR\Modules\InpatientModule\TreatmentQuery;
use OpenEMR\Modules\InpatientModule\NoteQuery;
use OpenEMR\Modules\InpatientModule\ReferralQuery;
use OpenEMR\Modules\InpatientModule\VitalQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;
use OpenEMR\Modules\InpatientModule\WardTransferQuery;
use OpenEMR\Modules\InpatientModule\ProcedureQuery;
use OpenEMR\Modules\InpatientModule\TheaterQuery;
use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use Ramsey\Uuid\Uuid;


require_once "../../../../globals.php";
require_once "./components/sql/ActionPlanQuery.php";
require_once "./components/sql/AdmissionQueueQuery.php";
require_once "./components/sql/AuthQuery.php";
require_once "./components/sql/FoodQuery.php";
require_once "./components/sql/BedQuery.php";
require_once "./components/sql/InpatientQuery.php";
require_once "./components/sql/ListsQuery.php";
require_once "./components/sql/TreatmentQuery.php";
require_once "./components/sql/NoteQuery.php";
require_once "./components/sql/ReferralQuery.php";
require_once "./components/sql/VitalQuery.php";
require_once "./components/sql/WardQuery.php";
require_once "./components/sql/WardTransferQuery.php";
require_once "./components/sql/ProcedureQuery.php";
require_once "./components/sql/TheaterQuery.php";
require_once "./components/sql/SurgeryQuery.php";


$inpatients = [];
$actionPlanQuery = new ActionPlanQuery();
$admissionQueuQuery = new AdmissionQueueQuery();
$authQuery = new AuthQuery();
$bedQuery = new BedQuery();
$inpatientQuery = new InpatientQuery();
$listQuery = new ListsQuery();
$treatmentQuery = new TreatmentQuery();
$noteQuery = new NoteQuery();
$referralQuery = new ReferralQuery();
$vitalQuery = new VitalQuery();
$wardQuery = new WardQuery();
$transferQuery = new WardTransferQuery();
$procedureQuery = new ProcedureQuery();
$theaterQuery = new TheaterQuery();
$surgeryQuery = new SurgeryQuery();
$foodQuery = new FoodQuery();


$wards = $wardQuery->getWards();
$issueList = $actionPlanQuery->getIssueList();
$users = $authQuery->getUsers();
$providers = $authQuery->getProviders();
$procedure = $procedureQuery->getProcedure();
$theater = $theaterQuery->getTheater();
$foodItems = $foodQuery->getMenuItems();
$calenderCat =  $surgeryQuery->getCalendarCat();

$sidebar_status =  'none';
$current_list = '';

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if (isset($_GET['search_by_ward']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $id = $_GET['search_ward'];
    $word = $_GET['word'];
    $data = [
        'ward_id' => $id,
        'word' =>  $word
    ];
    $inpatients = $inpatientQuery->searchInpatients($data);
} else {
    $inpatients = $inpatientQuery->getInpatients();
}

if (isset($_POST['nurse_note']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['note_admission_id'],
        'patient_id' => $_POST['note_pid'],
        'note' => $_POST['note'],
    ];
    $noteQuery->insertNote($data);
    header('location:inpatient.php?status=success&message=Nurse note added successfully');
} elseif (isset($_POST['treatment_plan']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $uuid = Uuid::uuid4();

    $data = [
        'admission_id' => $_POST['mng_admission_id'],
        'patient_id' => $_POST['mng_patient_id'],
        'title' => $_POST['title'],
        'type' => $_POST['type'],
        'instructions' => $_POST['instructions'],
        'action_start_time' => $_POST['action_start_time'],
        'action_end_time' => $_POST['action_end_time'],
        'time_interval' => $_POST['time_interval'],
        'staff_id' => $_POST['staff_id'],
        'uuid' => $uuid,
    ];
    $treatmentQuery->insertTreatmentPlan($data);
    $listQuery->insertList($data);
    header('location:inpatient.php?status=success&message=Clinical Management Plan added successfully');
} elseif (isset($_POST['food_req_new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'patient' => $_POST['pid'],
        'food' => $_POST['food'],
        'staff' => $_POST['staff'],
        'requested_date' => $_POST['requested_date'],
        'admission_id' => $_POST['admission_id']
    ];
    $foodQuery->insertFoodRequest($data);
    header('location:inpatient.php?status=success&message=Meal Requested successfully');
} elseif (isset($_POST['tracker']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'plan_id' => $_POST['plan_id'],
        'admission_id' => $_POST['admission_id'],
        'action_time' => $_POST['action_time'],
        'staff_id' => $_POST['staff_id'],
    ];
    $treatmentQuery->insertTracker($data);
    header('location:inpatient.php?status=success&message=Clinical Management Plan Tracker added successfully');
} elseif (isset($_POST['transfer_ward']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['admission_id'],
        'admission_date' => $_POST['admission_date'],
        'patient_id' => $_POST['patient_id'],
        'old_ward' => $_POST['old_ward'],
        'old_bed' => $_POST['old_bed'],
        'ward_id' => $_POST['ward'],
        'bed_id' => $_POST['bed'],
        'transfer_date' => $_POST['transfer_date'],
    ];
    $transferQuery->transferWard($data);
    header('location:inpatient.php?status=success&message=Patient ward transfer successfully');
} elseif (isset($_POST['referral']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'billing_facility_id' => $_POST['billing_facility_id'],
        'body' => $_POST['body'],
        'refer_date' => $_POST['refer_date'],
        'refer_diag' => $_POST['refer_diag'],
        'refer_from' => $_POST['refer_from'],
        'refer_external' => $_POST['refer_external'],
        'refer_risk_level' => $_POST['refer_risk_level'],
        'refer_to' => $_POST['refer_to'],
        'pid' => $_POST['pid'],
        // 'refer_vitals' => $_POST['refer_vitals'],
    ];
    // print_r(['id' => $_POST['ref_admission_id'], 'bed_id' => $_POST['ref_bed_id']]);
    $referralQuery->insertReferral($data);
    $inpatientQuery->dischargeInpatient([
        'id' => $_POST['ref_admission_id'],
        'bed_id' => $_POST['ref_bed_id'],
    ]);
    header('location:inpatient.php?status=success&message=Patient Referred successfully');
} elseif (isset($_POST['inpatient_vitals']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['vit_admission_id'],
        'patient_id' => $_POST['vit_pid'],
        'blood_pressure' => $_POST['blood_pressure'],
        'pulse' => $_POST['pulse'],
        'temperature' => $_POST['temperature'],
        'respiratory_rate' => $_POST['respiratory_rate'],
        'spo_2' => $_POST['spo_2'],
        'height' => $_POST['height'],
        'weight' => $_POST['weight'],
        'fluid_input' => $_POST['fluid_input'],
        'fluid_output' => $_POST['fluid_output'],
        'staff_id' => $_POST['staff_id'],
        'time_taken' => $_POST['time_taken'],
    ];
    $vitalQuery->insertVital($data);
    header('location:inpatient.php?status=success&message=Vitals added successfully');
} elseif (isset($_POST['discharge']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['dis_admission_id'],
        'bed_id' => $_POST['dis_bed_id'],
    ];
    $inpatientQuery->dischargeInpatient($data);
    header('location:inpatient.php?status=success&message=Patient discharged successfully');
} elseif (isset($_POST['prep_discharge']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['prep_admission_id'],
        'patient_id' => $_POST['prep_patient_id'],
        'encounter_id' => $_POST['prep_encounter_id'],
    ];
    $inpatientQuery->prepareDischarge($data);
    // header('location:inpatient.php?status=success&message=Patient discharge preparation successfully');
} elseif (isset($_POST['undo_admission']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['undo_admission_id'],
        'bed_id' => $_POST['undo_bed_id'],
    ];
    $inpatientQuery->undoAdmission($data);
    header('location:inpatient.php?status=success&message=Admission Undone');
} elseif (isset($_POST['new_surgery']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'code' => $_POST['code'],
        'patient_id' => $_POST['patient_id'],
        'procedure_id' => $_POST['procedure_id'],
        'theater_id' => $_POST['theater_id'],
        'admission_id' => $_POST['admission_id'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status'],
        'created_by' => $_POST['created_by'],

        'pc_title' => $_POST['pc_title'],
        'pc_hometext' => $_POST['pc_hometext'],

        'duration' => $_POST['duration'],
        'pc_alldayevent' => $_POST['pc_alldayevent'] == 'on' ? 1 : 0,

    ];
    $surgeryQuery->insertSurgery($data);
    header('location:inpatient.php?status=success&message=Patient Booked for Surgery successfully');
}

if (isset($_GET['show_treatment_plans']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $sidebar_status = 'display';
    $current_list = 'treatment_plansx';
    $patientManagement = $treatmentQuery->getPatientTreatmentPlan($_GET['admission_id']);
} elseif (isset($_GET['show_vitals']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $sidebar_status = 'display';
    $current_list = 'vitals';
    $patientVitals = $vitalQuery->getAdmissionVitals($_GET['admission_id']);
} elseif (isset($_GET['show_notes']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $sidebar_status = 'display';
    $current_list = 'notes';
    $patientNotes = $noteQuery->getAdmissionNote($_GET['admission_id']);
}

include_once "./components/head.php";
?>


<!-- check condition of display message -->
<?php if ($display_mesasge == 'block') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
        <strong><?php echo xlt("Success") ?> !</strong> <?php echo $message; ?>
    </div>
<?php } ?>

<div>
    <div class="search_container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" style="display: flex;">
            <input type="hidden" name="search_by_ward">
            <div style="display: flex; justify-items: center; align-items: center; flex: 1;">
                <select class="form-control" style="width: 100%;" name="search_ward" id="search_ward">
                    <option value=""> <?php echo xlt("Select Ward") ?> </option>
                    <?php foreach ($wards as $ward) { ?>
                        <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name']; ?> | <?php echo $ward['name']; ?></option>
                    <?php
                    }  ?>
                </select>
            </div>

            <input type="text" class="form-control" style="margin-left: 10px; flex: 2;" name="word" id="word" placeholder="search... fname, lname">
            <button type="submit" class="btn btn-primary" style="margin-left: 20px;"> <?php echo xlt("Search") ?> </button>
        </form>
    </div>
</div>

<section class="main-containerx" style="flex-direction: row; display: flex;">

    <div style="margin-right: 10px; flex: 2;">

        <?php foreach ($inpatients as $value) {
        ?>
            <div class="inpatient-item">
                <div style="display: flex;">
                    <div style="margin-right: 60px;">
                        <p> <?php echo xlt("Name") ?> : <b> <a href=<?php echo "./patient_dashboard/__treatment_plan.php?admission_id=$value[id]&patient_id=$value[patient_id]&bed_id=$value[bed_id]&ward_id=$value[ward_id]" ?>> <?php echo "$value[fname] $value[mname] $value[lname]" ?> </a> </b></p>
                        <p> <?php echo xlt("Ward") ?> : <b><?php echo $value['ward_name']; ?></b></p>
                        <p> <?php echo xlt("Bed No") ?>: <b><?php echo $value['bed_number']; ?></b></p>
                    </div>
                    <div>
                        <p> <?php echo xlt("Admission Date") ?>: <b><?php echo $value['admission_date']; ?></b></p>
                        <p> <?php echo xlt("Bill") ?> : <?php $GLOBALS['gbl_currency_symbol'] ?> <b><?php echo $value['total_bed_bill'] + $value['total_bill'] + $value['total_food_price']; ?></b></p>
                        <p> <?php echo xlt("Days spent") ?> : <b><?php echo round((time() - strtotime($value['admission_date'])) / (60 * 60 * 24)); ?></b></p>
                        <!-- <p>Discharged Date: <b><?php echo $value['discharge_date']; ?></b></p> -->
                    </div>
                    <div style="margin-left: auto; display: flex;">
                        <form style=" margin-right: 8px;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                            <input type="hidden" name="show_vitals" value="">
                            <input type="hidden" name="admission_id" value="<?php echo $value['id']; ?>">
                            <input type="submit" class="btn btn-md btn-secondary" value="Show Vitals">
                        </form>

                        <form style="" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                            <input type="hidden" name="show_notes" value="">
                            <input type="hidden" name="admission_id" value="<?php echo $value['id']; ?>">
                            <input type="submit" class="btn btn-md btn-secondary" value="Show Notes">
                        </form>
                    </div>
                </div>

                <div class="inpatient-item-bottom">
                    <div class="dropdown" style='margin-top: 5px;'>
                        <button class="btn btn-md btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <?php echo xlt("Clinical Management Plan") ?>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item setTreatmBtn" href="#" data-toggle="modal" data-target="#setTreatment" data-pid="<?php echo $value['patient_id']; ?>" data-admission_id="<?php echo $value['id']; ?>"> <?php echo xlt("New Treatment Entry") ?> </a>
                            <a class="dropdown-item trackerBtn" href="#" data-toggle="modal" data-target="#managementTracker" data-admission_id="<?php echo $value['id']; ?>"><?php echo xlt("Follow up Treatment") ?> </a>
                            <form style="margin-bottom: 5px;" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                <input type="hidden" name="show_treatment_plans" value="">
                                <input type="hidden" name="admission_id" value="<?php echo $value['id']; ?>">
                                <input type="submit" class="dropdown-item" href="#" value="View Logs" />
                            </form>
                        </div>
                    </div>

                    <!-- <div class="dropdown" style="margin-left: 10px;">
                        <button class="btn btn-md btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            Medical Assessment
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item vitalBtn" href="#" data-toggle="modal" data-target="#inpatientVitals" data-pid="<?php echo $value['patient_id']; ?>" data-admission_id="<?php echo $value['id']; ?>">Vitals</a>
                        </div>
                    </div> -->

                    <div class="dropdown" style="margin-left: 10px; margin-top: 5px;">
                        <button class="btn btn-md btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                            <?php echo xlt("Patient Transfer") ?>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item transferBtn" href="#" data-toggle="modal" data-target="#wardTransfer" data-pid="<?php echo $value['patient_id']; ?>" data-bed="<?php echo $value['bed_id']; ?>" data-ward="<?php echo $value['ward_id']; ?>" data-admission_id="<?php echo $value['id']; ?>" data-admission_date="<?php echo $value['admission_date']; ?>"><?php echo xlt("Ward Transfer") ?> </a>
                            <a class="dropdown-item referralBtn" href="#" data-toggle="modal" data-target="#wardReferral" data-pid="<?php echo $value['patient_id']; ?>" data-bed="<?php echo $value['bed_id']; ?>" data-ward="<?php echo $value['ward_id']; ?>" data-admission_id="<?php echo $value['id']; ?>"><?php echo xlt("Referral") ?> </a>
                        </div>
                    </div>

                    <button type="button" style="margin-left: 10px; margin-top: 5px;" class="btn-md btn btn-primary nurseNoteBtn" data-toggle="modal" data-target="#inpatientNursesNote" data-pid="<?php echo $value['patient_id']; ?>" data-admission_id="<?php echo $value['id']; ?>">
                        <?php echo xlt("Nurse Note") ?>
                    </button>

                    <button type="button" style="margin-left: 10px; margin-top: 5px;" class="btn-md btn btn-primary foodReqBtn" data-toggle="modal" data-target="#newFoodRequest" data-pid="<?php echo $value['patient_id']; ?>" data-admission_id="<?php echo $value['id']; ?>">
                        <?php echo xlt("Meal Request") ?>
                    </button>

                    <a type="button" style='margin-top: 5px; margin-left: 10px;' onclick='window.open("./components/modals/print_handband.php?pid=<?php echo $value['patient_id']; ?>", "_self").opener = null' onsubmit='return top.restoreSession()' style="margin-left: 10px;" class="btn-md btn btn-primary" data-toggle="modal" data-id="<?php echo $value['id']; ?>" data-bed_id="<?php echo $value['bed_id']; ?>">
                        <?php echo xlt("Print Hand Band") ?>
                    </a>

                    <button type="button" style="margin-left: 10px; margin-top: 5px;" class="btn-md btn btn-primary new_surgeryBtn" data-toggle="modal" data-target="#neSurgeryModal" data-pid="<?php echo $value['patient_id']; ?>" data-admission_id="<?php echo $value['id']; ?>">
                        <?php echo xlt("Schedule Surgery") ?>
                    </button>
                    <button type="button" style="margin-left: 10px; margin-top: 5px;" class="btn-md btn btn-warning undoAdmissionBtn" data-toggle="modal" data-target="#undoAdmission" data-id="<?php echo $value['id']; ?>" data-bed_id="<?php echo $value['bed_id']; ?>">
                        <?php echo xlt("Undo Admission") ?>
                    </button>

                    <?php

                    if ($value['status'] == 'admitted') {  ?>
                        <button type="button" style="margin-left: 10px; margin-top: 5px;" class="btn-md btn btn-success prepdischBtn" data-toggle="modal" data-target="#prepdischargePatient" data-id="<?php echo $value['id']; ?>" data-patient_id="<?php echo $value['patient_id']; ?>" data-encounter_id="<?php echo $value['encounter_id']; ?>">
                            <?php echo xlt("Prepare for Discharge") ?>
                        </button>
                    <?php  } else {   ?>
                        <button type="button" style="margin-left: 10px; margin-top: 5px;" class="btn-md btn btn-danger dischBtn" data-toggle="modal" data-target="#dischargePatient" data-id="<?php echo $value['id']; ?>" data-bed_id="<?php echo $value['bed_id']; ?>">
                            <?php echo xlt("Discharge") ?>
                        </button>
                    <?php  }   ?>
                </div>
            </div>
        <?php
        } ?>
    </div>

    <?php
    if ($sidebar_status == 'display') {
    ?>
        <div class="side_details_container">

            <?php
            if ($current_list == 'vitals') {
            ?>
                <h3><?php echo xlt("Patient Vitals") ?></h3>
                <a class="btn btn-secondary" href="./inpatient.php">Hide</a>

                <?php foreach ($patientVitals as $value) {
                ?>
                    <div class="vital_card">
                        <div>
                            <p><b><?php echo xlt("Blood Pressure") ?>: </b> <?php echo $value['blood_pressure']; ?></p>
                            <p><b><?php echo xlt("Pulse") ?>:</b> <?php echo $value['pulse']; ?></p>
                            <p><b><?php echo xlt("Temperature") ?>:</b> <?php echo $value['temperature']; ?></p>
                            <p><b><?php echo xlt("Respiratory Rate") ?>:</b> <?php echo $value['respiratory_rate']; ?></p>
                            <p><b>SPO 2:</b> <?php echo $value['spo_2']; ?></p>
                            <p><b><?php echo xlt("Height") ?>:</b> <?php echo $value['height']; ?></p>
                        </div>
                        <div>
                            <p><b><?php echo xlt("Weight") ?>:</b> <?php echo $value['weight']; ?></p>
                            <p><b><?php echo xlt("Fluid Input") ?>: </b><?php echo $value['fluid_input']; ?></p>
                            <p><b><?php echo xlt("Fluid Output") ?>: </b><?php echo $value['fluid_output']; ?></p>
                            <p><b><?php echo xlt("Staff Id") ?>:</b> <?php echo $value['staff_id']; ?></p>
                            <p><b><?php echo xlt("Time Taken") ?>:</b> <?php echo $value['time_taken']; ?></p>
                        </div>
                    </div>
                <?php
                } ?>
            <?php
            } elseif ($current_list == 'notes') {
            ?>
                <h3><?php echo xlt("Nurses Notes") ?> </h3>
                <a class="btn btn-secondary" href="./inpatient.php">Hide</a>

                <?php foreach ($patientNotes as $value) {
                ?>
                    <div class="vital_card">
                        <div style="display: flex; flex-direction: column;">
                            <p><b><?php echo xlt("Note") ?>: </b> <?php echo $value['note']; ?></p>
                            <p style="margin-left: auto;"><b><?php echo xlt("Time Taken") ?> :</b> <?php echo $value['time_taken']; ?></p>
                        </div>
                    </div>
                <?php
                } ?>
            <?php
            } elseif ($current_list == 'treatment_plansx') {
            ?>
                <h3><?php echo xlt("Management Plans") ?> </h3>
                <a class="btn btn-secondary" href="./inpatient.php">Hide</a>

                <?php foreach ($patientManagement as $value) {
                ?>
                    <div class="vital_card">
                        <div style="display: flex; flex-direction: column;">
                            <p><b><?php echo xlt("Type") ?> : </b> <?php echo $value['type']; ?></p>
                            <p><b><?php echo xlt("Name") ?> : </b> <?php echo $value['title']; ?></p>
                        </div>
                    </div>
                <?php
                } ?>
            <?php
            }
            ?>

        </div>
    <?php
    }
    ?>

</section>

<?php include_once "./components/modals/inpatient/prep_discharge.php"; ?>
<?php include_once "./components/modals/inpatient/discharge.php"; ?>
<?php include_once "./components/modals/inpatient/undo_admission.php"; ?>
<?php include_once "./components/modals/inpatient/treatment_plan.php"; ?>
<?php include_once "./components/modals/inpatient/tracker.php"; ?>
<?php include_once "./components/modals/inpatient/nurse_note.php"; ?>
<?php include_once "./components/modals/inpatient/vitals.php"; ?>
<?php include_once "./components/modals/inpatient/ward_transfer.php"; ?>
<?php include_once "./components/modals/inpatient/referral.php"; ?>
<?php include_once "./components/modals/inpatient/surgery.php"; ?>

<?php require_once "./components/sql/ProcedureQuery.php"; ?>

<!-- new Modal -->
<div class="modal fade" id="newFoodRequest" tabindex="-1" aria-labelledby="newFoodRequest" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo xlt("New Request") ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="admission_id" id="food_admission_id" value="">
                    <input type="hidden" name="food_req_new" id="food_req_new" value="">
                    <input type="hidden" name="pid" id="food_req_pid" value="">

                    <div class="form-group">
                        <label for="food"><?php echo xlt("Meal") ?> </label>
                        <select class="form-control" id="food" name="food">
                            <option value=""><?php echo xlt("Select food") ?> </option>
                            <?php foreach ($foodItems as $food) { ?>
                                <option value="<?php echo $food['id']; ?>"><?php echo $food['category']; ?> | <?php echo $food['price']; ?> | <?php echo $food['name']; ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="staff"><?php echo xlt("Staff") ?> </label>
                        <select class="form-control" name="staff" id="staff">
                            <option value=""><?php echo xlt("Select Staff") ?> </option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="requested_date"><?php echo xlt("Request Date") ?> </label>
                        <input type="date" class="form-control" name="requested_date">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt("Close") ?> </button>
                        <button type="submit" class="btn btn-primary"><?php echo xlt("Save") ?> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
$beds = $bedQuery->getAvailableBeds();
?>
<script>
    window.onload = function() {

        function diff(start, end) {
            start = start.split(":");
            end = end.split(":");
            var startDate = new Date(0, 0, 0, start[0], start[1], 0);
            var endDate = new Date(0, 0, 0, end[0], end[1], 0);
            var diff = endDate.getTime() - startDate.getTime();
            var hours = Math.floor(diff / 1000 / 60 / 60);
            diff -= hours * 1000 * 60 * 60;
            var minutes = Math.floor(diff / 1000 / 60);

            // If using time pickers with 24 hours format, add the below line get exact hours
            if (hours < 0)
                hours = hours + 24;

            return (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
        }

        $(".foodReqBtn").click(function() {
            var admission_id = $(this).data('admission_id');
            var pid = $(this).data('pid');
            $('#food_req_pid').val(pid);
            $('#food_admission_id').val(admission_id);
        });

        $(".nurseNoteBtn").click(function() {
            var admission_id = $(this).data('admission_id');
            var pid = $(this).data('pid');
            $('#note_admission_id').val(admission_id);
            $('#note_pid').val(pid);
        });


        $(".vitalBtn").click(function() {
            var admission_id = $(this).data('admission_id');
            var pid = $(this).data('pid');
            $('#vit_admission_id').val(admission_id);
            $('#vit_pid').val(pid);
        });

        $(".setTreatmBtn").click(function() {
            console.log('treatment plan');
            var admission_id = $(this).data('admission_id');
            var patient_id = $(this).data('pid');

            $('#mng_admission_id').val(admission_id);
            $('#mng_patient_id').val(patient_id);
        });

        $(".new_surgeryBtn").click(function() {
            var admission_id = $(this).data('admission_id');
            var pid = $(this).data('pid');
            $('#surg_admission_id').val(admission_id);
            $('#surg_pid').val(pid);
        });

        $(".trackerBtn").click(function() {
            var admission_id = $(this).data('admission_id');
            $('#tra_admission_id').val(admission_id);

            console.log(admission_id);
            // make ajax call to fetch plans with `admission_id`
            $.ajax({
                url: './ajax_search.php',
                type: 'GET',
                data: {
                    q: admission_id, // search term
                    search: "search_for_treatment_plan",
                },
                success: function(data) {
                    console.log(data);
                    $("select[name=plan_id]").empty().append("<option>Select  Plan</option>");
                    JSON.parse(data).forEach(function(item) {
                        $("select[name=plan_id]").append(`<option value='${item.id}'> ${item.type} - ${item.title} | ${item.action_start_time} - ${item.action_end_time} </option>`)
                    });
                }
            });

        });

        $(".transferBtn").click(function() {
            var admission_id = $(this).data('admission_id');
            var admission_date = $(this).data('admission_date');
            var patient_id = $(this).data('pid');
            var old_ward = $(this).data('ward');
            var old_bed = $(this).data('bed');
            $('#trs_admission_id').val(admission_id);
            $('#trs_admission_date').val(admission_date);
            $('#trs_patient_id').val(patient_id);
            $('#trs_old_ward').val(old_ward);
            $('#trs_old_bed').val(old_bed);
        });

        $(".referralBtn").click(function() {
            var patient_id = $(this).data('pid');
            var admission_id = $(this).data('admission_id');
            var bed_id = $(this).data('bed');

            $('#ref_patient_id').val(patient_id);
            $('#ref_admission_id').val(admission_id);
            $('#ref_bed_id').val(bed_id);
        });

        $(".deleteBtn").click(function() {
            var id = $(this).data('id');
            $('#deleteId').val(id);
        });

        $(".changeStatusBtn").click(function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            $('#deleteId').val(id);
        });


        $(".undoAdmissionBtn").click(function() {
            var id = $(this).data('id');
            var bed_id = $(this).data('bed_id');
            $('#undo_admission_id').val(id);
            $('#undo_bed_id').val(bed_id);
        });

        $(".dischBtn").click(function() {
            var id = $(this).data('id');
            var bed_id = $(this).data('bed_id');
            $('#dis_admission_id').val(id);
            $('#dis_bed_id').val(bed_id);
        });


        $(".prepdischBtn").click(function() {
            var id = $(this).data('id');
            var patient_id = $(this).data('patient_id');
            var encounter_id = $(this).data('encounter_id');
            $('#prep_admission_id').val(id);
            $('#prep_patient_id').val(patient_id);
            $('#prep_encounter_id').val(encounter_id);
        });

        $('#ward').on('change', function(e) {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            let beds = [];

            <?php foreach ($beds as $bed) { ?>
                beds.push(<?php echo json_encode([
                                'id' => $bed['id'],
                                'number' => $bed['number'],
                                'bed_type' => $bed['bed_type'],
                                'ward_id' => $bed['ward_id'],
                                'price_per_day' => $bed['price_per_day'],
                                'availability' => $bed['availability'],
                            ]);
                            ?>);
            <?php
            }  ?>

            let filteredBeds = beds.filter(bed => bed.ward_id == valueSelected)
            $("#bed").empty().append("<option>Select  Bed</option>");
            $(filteredBeds).each(function(i) {
                $("#bed").append(`<option value='${filteredBeds[i].id}'> ${filteredBeds[i].number} | ${filteredBeds[i].bed_type} | ${filteredBeds[i].price_per_day} </option>`)
            });
        });

        $("#action_end_time").change(function() {
            var action_end_time = $('#action_end_time').val();
            var action_start_time = $('#action_start_time').val();
            var reslt = diff(action_start_time, action_end_time);
            $("#time_interval").empty();
            $('#time_interval').val(reslt);
        });

        // search drug code and surgery code
        $('.select_plann').select2({
            dropdownParent: $('#setTreatment'),
            ajax: {
                url: "ajax_search.php",
                dataType: 'json',
                type: "GET",
                data: function(params) {
                    let plans = [];
                    var action_id = $('#action_id').val();
                    console.log(action_id);


                    let thePlan = plans.filter(plan => plan.id == action_id);
                    console.log(thePlan[0]);
                    if (thePlan.length < 1) {
                        return false;
                    }

                    $('#mng_action_type').val(thePlan[0].type);

                    return {
                        q: params.term, // search term
                        page: params.page,
                        search: `search_for_${thePlan[0].type}`,
                    };
                },

                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 3,
            templateResult: formatOpt,
            templateSelection: formatRepoSelection,
        });

        function formatOpt(repo) {
            if (repo.loading) {
                return repo.text;
            }
            var $container = $(
                "<option class='select_plann clearfix' value='" + repo.id + "'>" + repo.name + "</option>"
            );
            return $container;
        }

        function formatRepoSelection(repo) {
            return repo.name;
        }

        setTimeout(function() {
            $('#alert').hide();
        }, 3000);
        
        $('#surgery_code').select2({
            dropdownParent: $('.surgery-modal'),
            // width: '100%',
            id: function(item) { return source.procedure_code; },
            ajax: {
            url: 'ajax_search.php',
            dataType: 'json',
            data: function(params){
                return {
                term: params.term,
                search: 'surgery_code',
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
            }
            },
            minimumInputLength: 3,
            templateResult: formatOpt,
            templateSelection: formatOptSelection
        });
        
        function formatOpt(source) {
            if (source.loading) {
                return source.text;
            }
            var $container = $(
                `<option class='clearfix' value='${source.id}'>${source.procedure_code} ${source.name} </option>`
            );
            return $container;
        }

        function formatOptSelection(source) {
            return source.procedure_code + " " + source.name;
        }

    };
</script>
<?php include_once "./components/footer.php"; ?>