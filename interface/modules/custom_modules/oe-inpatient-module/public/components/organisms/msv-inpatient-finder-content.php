<?php


/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Kenneth <kenneth@example.com>
 * @author      Mark Amoah <mcprah@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <info@medsov.com>
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
use OpenEMR\Modules\InpatientModule\PreDischargeChecklistQuery;

use Ramsey\Uuid\Uuid;

require_once __DIR__ . "/../../../../../../globals.php";

require_once __DIR__ . "/../sql/ActionPlanQuery.php";
require_once __DIR__ . "/../sql/AdmissionQueueQuery.php";
require_once __DIR__ . "/../sql/AuthQuery.php";
require_once __DIR__ . "/../sql/FoodQuery.php";
require_once __DIR__ . "/../sql/BedQuery.php";
require_once __DIR__ . "/../sql/InpatientQuery.php";
require_once __DIR__ . "/../sql/ListsQuery.php";
require_once __DIR__ . "/../sql/TreatmentQuery.php";
require_once __DIR__ . "/../sql/NoteQuery.php";
require_once __DIR__ . "/../sql/ReferralQuery.php";
require_once __DIR__ . "/../sql/VitalQuery.php";
require_once __DIR__ . "/../sql/WardQuery.php";
require_once __DIR__ . "/../sql/WardTransferQuery.php";
require_once __DIR__ . "/../sql/ProcedureQuery.php";
require_once __DIR__ . "/../sql/TheaterQuery.php";
require_once __DIR__ . "/../sql/SurgeryQuery.php";

// require_once "./components/sql/PreDischargeChecklistQuery.php";


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
// $preDischargeChecklist = new PreDischargeChecklistQuery();



$wards = $wardQuery->getWards();
$issueList = $actionPlanQuery->getIssueList();
$users = $authQuery->getUsers();
$providers = $authQuery->getProviders();
$procedure = $procedureQuery->getProcedure();
$theater = $theaterQuery->getTheater();
$foodItems = $foodQuery->getMenuItems();
$calenderCat =  $surgeryQuery->getCalendarCat();
// $checklistItems = $listQuery->getListItemsByListId('pre_discharge_items');


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

// if (isset($_POST['nurse_note']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'admission_id' => $_POST['note_admission_id'],
//         'patient_id' => $_POST['note_pid'],
//         'note' => $_POST['note'],
//     ];
//     $noteQuery->insertNote($data);
//     header('location:inpatient.php?status=success&message=Nurse note added successfully');
// } elseif (isset($_POST['treatment_plan']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $uuid = Uuid::uuid4();

//     $data = [
//         'admission_id' => $_POST['mng_admission_id'],
//         'patient_id' => $_POST['mng_patient_id'],
//         'title' => $_POST['title'],
//         'type' => $_POST['type'],
//         'instructions' => $_POST['instructions'],
//         'action_start_time' => $_POST['action_start_time'],
//         'action_end_time' => $_POST['action_end_time'],
//         'time_interval' => $_POST['time_interval'],
//         'staff_id' => $_POST['staff_id'],
//         'uuid' => $uuid,
//     ];
//     $treatmentQuery->insertTreatmentPlan($data);
//     $listQuery->insertList($data);
//     header('location:inpatient.php?status=success&message=Clinical Management Plan added successfully');
// } elseif (isset($_POST['food_req_new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'patient' => $_POST['pid'],
//         'food' => $_POST['food'],
//         'staff' => $_POST['staff'],
//         'requested_date' => $_POST['requested_date'],
//         'admission_id' => $_POST['admission_id']
//     ];
//     $foodQuery->insertFoodRequest($data);
//     header('location:inpatient.php?status=success&message=Meal Requested successfully');
// } elseif (isset($_POST['tracker']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'plan_id' => $_POST['plan_id'],
//         'admission_id' => $_POST['admission_id'],
//         'action_time' => $_POST['action_time'],
//         'staff_id' => $_POST['staff_id'],
//     ];
//     $treatmentQuery->insertTracker($data);
//     header('location:inpatient.php?status=success&message=Clinical Management Plan Tracker added successfully');
// } elseif (isset($_POST['transfer_ward']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'admission_id' => $_POST['admission_id'],
//         'admission_date' => $_POST['admission_date'],
//         'patient_id' => $_POST['patient_id'],
//         'old_ward' => $_POST['old_ward'],
//         'old_bed' => $_POST['old_bed'],
//         'ward_id' => $_POST['ward'],
//         'bed_id' => $_POST['bed'],
//         'transfer_date' => $_POST['transfer_date'],
//     ];
//     $transferQuery->transferWard($data);
//     header('location:inpatient.php?status=success&message=Patient ward transfer successfully');
// } elseif (isset($_POST['referral']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'billing_facility_id' => $_POST['billing_facility_id'],
//         'body' => $_POST['body'],
//         'refer_date' => $_POST['refer_date'],
//         'refer_diag' => $_POST['refer_diag'],
//         'refer_from' => $_POST['refer_from'],
//         'refer_external' => $_POST['refer_external'],
//         'refer_risk_level' => $_POST['refer_risk_level'],
//         'refer_to' => $_POST['refer_to'],
//         'pid' => $_POST['pid'],
//         // 'refer_vitals' => $_POST['refer_vitals'],
//     ];
//     // print_r(['id' => $_POST['ref_admission_id'], 'bed_id' => $_POST['ref_bed_id']]);
//     $referralQuery->insertReferral($data);
//     $inpatientQuery->dischargeInpatient([
//         'id' => $_POST['ref_admission_id'],
//         'bed_id' => $_POST['ref_bed_id'],
//     ]);
//     header('location:inpatient.php?status=success&message=Patient Referred successfully');
// } elseif (isset($_POST['inpatient_vitals']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'admission_id' => $_POST['vit_admission_id'],
//         'patient_id' => $_POST['vit_pid'],
//         'blood_pressure' => $_POST['blood_pressure'],
//         'pulse' => $_POST['pulse'],
//         'temperature' => $_POST['temperature'],
//         'respiratory_rate' => $_POST['respiratory_rate'],
//         'spo_2' => $_POST['spo_2'],
//         'height' => $_POST['height'],
//         'weight' => $_POST['weight'],
//         'fluid_input' => $_POST['fluid_input'],
//         'fluid_output' => $_POST['fluid_output'],
//         'staff_id' => $_POST['staff_id'],
//         'time_taken' => $_POST['time_taken'],
//     ];
//     $vitalQuery->insertVital($data);
//     header('location:inpatient.php?status=success&message=Vitals added successfully');
// } elseif (isset($_POST['discharge']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'id' => $_POST['dis_admission_id'],
//         'bed_id' => $_POST['dis_bed_id'],
//         'deceased' => $_POST['deceased'],
//         'deceased_date' => $_POST['deceased_date'],
//         'deceased_reason' => $_POST['deceased_reason'],
//     ];
//     $inpatientQuery->dischargeInpatient($data);
//     header('location:inpatient.php?status=success&message=Patient discharged successfully');
// } elseif (isset($_POST['prep_discharge']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'id' => $_POST['prep_admission_id'],
//         'patient_id' => $_POST['prep_patient_id'],
//         'encounter_id' => $_POST['prep_encounter_id'],
//         'checklistItems' => $_POST['checklist_items'] ?? [],
//         'checklistNotes' => $_POST['checklist_notes'] ?? [],
//     ];

//     // Insert the new predischarge form entry
//     $preDischargeChecklist->insertForm($data['id'], $data['checklistItems'], $data['checklistNotes']);
//     $inpatientQuery->prepareDischarge($data);

//     header('location:inpatient.php?status=success&message=Patient discharge preparation successfully');
// } elseif (isset($_POST['undo_admission']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'id' => $_POST['undo_admission_id'],
//         'bed_id' => $_POST['undo_bed_id'],
//     ];
//     $inpatientQuery->undoAdmission($data);
//     header('location:inpatient.php?status=success&message=Admission Undone');
// } elseif (isset($_POST['new_surgery']) && $_SERVER['REQUEST_METHOD'] == "POST") {
//     $data = [
//         'code' => $_POST['code'],
//         'patient_id' => $_POST['patient_id'],
//         'procedure_id' => $_POST['procedure_id'],
//         'theater_id' => $_POST['theater_id'],
//         'admission_id' => $_POST['admission_id'],
//         'start_date' => $_POST['start_date'],
//         'end_date' => $_POST['end_date'],
//         'status' => $_POST['status'],
//         'created_by' => $_POST['created_by'],

//         'pc_title' => $_POST['pc_title'],
//         'pc_hometext' => $_POST['pc_hometext'],

//         'duration' => $_POST['duration'],
//         'pc_alldayevent' => $_POST['pc_alldayevent'] == 'on' ? 1 : 0,

//     ];

//     $surgeryQuery->insertSurgery($data);
//     header('location:inpatient.php?status=success&message=Patient Booked for Surgery successfully');
// }

// if (isset($_GET['show_treatment_plans']) && $_SERVER['REQUEST_METHOD'] == "GET") {
//     $sidebar_status = 'display';
//     $current_list = 'treatment_plansx';
//     $patientManagement = $treatmentQuery->getPatientTreatmentPlan($_GET['admission_id']);
// } elseif (isset($_GET['show_vitals']) && $_SERVER['REQUEST_METHOD'] == "GET") {
//     $sidebar_status = 'display';
//     $current_list = 'vitals';
//     $patientVitals = $vitalQuery->getAdmissionVitals($_GET['admission_id']);
// } elseif (isset($_GET['show_notes']) && $_SERVER['REQUEST_METHOD'] == "GET") {
//     $sidebar_status = 'display';
//     $current_list = 'notes';
//     $patientNotes = $noteQuery->getAdmissionNote($_GET['admission_id']);
// }

?>
<main class="flex-1">
    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <p class="text-[32px] font-[500] text-white ml-12">Patient Finder</p>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                    <select class="flex-1 h-full focus:ring-0 focus:outline-none" placeholder="Select Ward">
                        <option value="" class="text-[#8C898A] font-[300]">Select Ward</option>
                    </select>
                    <div class="border h-[30px]"></div>
                    <input type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                        placeholder="Enter patient’s name" />
                </div>

                <button class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                    <img src="./assets/img/msv-search-icon.svg" alt="">
                </button>
            </div>


            <?php include_once __DIR__ . '/tables/finder-table.php'; ?>


        </div>
        <div class="w-[1100px] mx-10 flex px-4 items-center h-[60px] bg-white rounded-md justify-between">
            <div>Lily Cho • 123456789</div>


            <div class="flex gap-4 items-center">
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-treatment-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Treatments</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-surgery-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Surgeries</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-meals-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Meals</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-vitals-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Vitals</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2 items-center">
                    <img src="./assets/img/msv-note-icon.svg" alt="treatment">
                    <p class="text-[14px] text-[#282224]">Notes</p>
                </button>
                <div class="border border-[#E7E7E7] h-[30px]"> </div>
                <button class="flex gap-2">
                    <button class="flex gap-2">
                        <img src="./assets/img/msv-menu-icon.svg" alt="treatment">
                    </button>
                </button>
            </div>

        </div>
</main>