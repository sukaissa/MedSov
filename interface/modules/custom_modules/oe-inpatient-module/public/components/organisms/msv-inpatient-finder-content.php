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

?>
<main class="flex-1">
    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <p class="text-[32px] font-[500] text-white ml-12">Patient Finder</p>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                    <input type="hidden" name="search_by_ward">
                    <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                        <select class="flex-1 h-full focus:ring-0 focus:outline-none" placeholder="Select Ward" name="search_ward" id="search_ward">
                            <option value=""> <?php echo xlt("Select Ward") ?> </option>
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name']; ?> | <?php echo $ward['name']; ?></option>
                            <?php
                            }  ?>
                        </select>
                        <div class="border h-[30px]"></div>
                        <input name="word" id="word" type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                            placeholder="Enter patient’s name" />
                    </div>

                    <button type="submit" class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                        <img src="./assets/img/msv-search-icon.svg" alt="">
                    </button>
                </div>
            </form>


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