<?php


/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Kenneth Nnopu <kennynnopu@gmail.com>
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


if (
    ($_SERVER['REQUEST_METHOD'] == "GET") &&
    (isset($_GET['search_by_ward']) || isset($_GET['search_ward']) || isset($_GET['word']))
) {
    $id = isset($_GET['search_ward']) && trim($_GET['search_ward']) !== '' ? $_GET['search_ward'] : null;
    $word = isset($_GET['word']) && trim($_GET['word']) !== '' ? $_GET['word'] : null;
    $data = [
        'ward_id' => $id,
        'word' => $word
    ];
    $searchResult = $inpatientQuery->searchInpatients($data);
    $inpatients = $searchResult['results'];
    echo "<script>console.log('Search Results: " . json_encode($inpatients) . "');</script>";
} else {
    $inpatients = $inpatientQuery->getInpatients();
}

$selectedWard = isset($_GET['search_ward']) ? $_GET['search_ward'] : '';
$searchedWord = isset($_GET['word']) ? $_GET['word'] : '';

?>
<main class="flex-1">
    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <p class="text-[32px] font-[500] text-white ml-16">Patient Finder</p>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                    <input type="hidden" name="search_by_ward" value="1">
                    <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                        <select class="flex-1 h-full focus:ring-0 focus:outline-none" placeholder="Select Ward"
                            name="search_ward" id="search_ward">
                            <option value=""><?php echo xlt("Select Ward") ?></option>
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"
                                    <?php echo ($selectedWard == $ward['id']) ? 'selected' : ''; ?>>
                                    <?php echo $ward['short_name']; ?> | <?php echo $ward['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="border h-[30px]"></div>
                        <input name="word" id="word" type="text"
                            class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                            placeholder="Enter patient’s name" value="<?php echo htmlspecialchars($searchedWord); ?>" />
                    </div>

                    <button type="submit"
                        class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                        <img src="./assets/img/msv-search-icon.svg" alt="">
                    </button>
                </div>
            </form>

            <form id="patientDetailsForm" method="GET" action="">
                <input type="hidden" name="pid" id="patientDetailsPid" value="">

                <?php include_once __DIR__ . '/tables/finder-table.php'; ?>
            </form>
        </div>

</main>