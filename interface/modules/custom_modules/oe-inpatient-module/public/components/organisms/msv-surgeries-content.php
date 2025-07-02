<?php

use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use OpenEMR\Modules\InpatientModule\ProcedureQuery;
use OpenEMR\Modules\InpatientModule\TheaterQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\AuthQuery;

require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/ActionPlanQuery.php";
require_once __DIR__ . "/../sql/SurgeryQuery.php";
require_once __DIR__ . "/../sql/procedureQuery.php";
require_once __DIR__ . "/../sql/TheaterQuery.php";
require_once __DIR__ . "/../sql/InpatientQuery.php";
require_once __DIR__ . "/../sql/AuthQuery.php";

$surgeryQuery = new SurgeryQuery();
$procedureQuery = new ProcedureQuery();
$theaterQuery = new TheaterQuery();
$inpatientQuery = new InpatientQuery();
$authQuery = new AuthQuery();

$procedure = $procedureQuery->getProcedure();
$theater = $theaterQuery->getTheater();
$providers = $authQuery->getProviders();
$surgery = $surgeryQuery->getSurgery();
$inpatients = $inpatientQuery->getInpatients();
$calenderCat =  $surgeryQuery->getCalendarCat();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    //$surgery = $surgeryQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');
} elseif (isset($_POST['surgery_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'surgery_id' => $_POST['surgery_id'],
        'theater_id' => $_POST['theater_id'],
        'procedure_id' => $_POST['procedure_id'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status'],
        'code' => $_POST['code'],
        'updated_by' => 1,
    ];
    $surgeryQuery->updateSurgery($data);
    header('location:surgery.php?status=success&message=Patient Surgery Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $surgeryQuery->destroySurgery($_POST['deleteId']);
    header('location:surgery.php?status=success&message=Surgery Deleted Successfully');
} elseif (isset($_POST['new_surgery']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'procedure_id' => $_POST['procedure_id'],
        'theater_id' => $_POST['theater_id'],
        'patient_id' => $_POST['patient_id'],
        'admission_id' => $_POST['admission_id'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status'],
        'created_by' => $_POST['created_by'],
        'code' => $_POST['code'],
    ];
    $surgeryQuery->insertSurgery($data);
    header('location:surgery.php?status=success&message=Patient Surgery Added Successfully');
}

?>

<main class="flex-1">
    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <p class="text-[32px] font-[500] text-white ml-16">Scheduled Surgeries</p>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                    <input type="hidden" name="search_by_ward" value="1">
                    <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                        <select class="flex-1 h-full focus:ring-0 focus:outline-none" name="status" id="status">
                            <option value=""><?php echo xlt("All Statuses") ?></option>
                            <option value="completed" <?php echo (isset($_GET['status']) && $_GET['status'] === 'completed') ? 'selected' : ''; ?>><?php echo xlt("Completed") ?></option>
                            <option value="scheduled" <?php echo (isset($_GET['status']) && $_GET['status'] === 'scheduled') ? 'selected' : ''; ?>><?php echo xlt("Scheduled") ?></option>
                            <!-- Add more statuses as needed -->
                        </select>
                        <div class="border h-[30px]"></div>
                        <input name="search" id="search" type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full" placeholder="Search" />
                    </div>

                    <button class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                        <img src="./assets/img/msv-search-icon.svg" alt="">
                    </button>
                </div>
            </form>

            <?php include_once __DIR__ . '/tables/surgeries-table.php'; ?>


        </div>

</main>