<?php

use OpenEMR\Modules\InpatientModule\AdmissionQueueQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;

require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/AdmissionQueueQuery.php";
require_once __DIR__ . "/../sql/WardQuery.php";

$admissionQueueQuery = new AdmissionQueueQuery();
$wardQuery = new WardQuery();

$wards = iterator_to_array($wardQuery->getWards());

$selectedWard = isset($_GET['search_ward']) ? $_GET['search_ward'] : '';
$searchedWord = isset($_GET['word']) ? $_GET['word'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

if (
    ($_SERVER['REQUEST_METHOD'] == "GET") &&
    (isset($_GET['search_by_ward']) || isset($_GET['search_ward']) || isset($_GET['word']) || isset($_GET['status']))
) {
    $params = [];
    if ($selectedWard !== '') {
        $params['ward_id'] = $selectedWard;
    }
    if ($searchedWord !== '') {
        $params['word'] = $searchedWord;
    }
    if ($status !== '') {
        $params['status'] = $status;
    }
    $allAdmissions = iterator_to_array($admissionQueueQuery->searchAdmissionQueue($params));
    echo "<script>console.log('Search Results: " . json_encode($allAdmissions) . "');</script>";
} else {
    $allAdmissions = iterator_to_array($admissionQueueQuery->getAllAdmissions());
}

?>
<main class="flex-1">
    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <p class="text-[32px] font-[500] text-white ml-16">Admissions</p>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                    <input type="hidden" name="search_by_ward" value="1">
                    <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                        <select class="flex-1 h-full focus:ring-0 focus:outline-none" placeholder="Select Ward"
                            name="search_ward" id="search_ward">
                            <option value=""><?php echo xlt("All Wards") ?></option>
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"
                                    <?php echo ($selectedWard == $ward['id']) ? 'selected' : ''; ?>>
                                    <?php echo $ward['short_name']; ?> | <?php echo $ward['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="border h-[30px]"></div>
                        <select class="flex-1 h-full focus:ring-0 focus:outline-none" name="status" id="status">
                            <option value=""><?php echo xlt("All Statuses") ?></option>
                            <option value="in-queue" <?php echo (isset($_GET['status']) && $_GET['status'] === 'in-queue') ? 'selected' : ''; ?>><?php echo xlt("In Queue") ?></option>
                            <option value="admitted" <?php echo (isset($_GET['status']) && $_GET['status'] === 'admitted') ? 'selected' : ''; ?>><?php echo xlt("Admitted") ?></option>
                            <option value="discharged" <?php echo (isset($_GET['status']) && $_GET['status'] === 'discharged') ? 'selected' : ''; ?>><?php echo xlt("Discharged") ?></option>
                            <!-- Add more statuses as needed -->
                        </select>
                        <div class="border h-[30px]"></div>
                        <input name="word" id="word" type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                            placeholder="Enter patient's name" value="<?php echo htmlspecialchars($searchedWord); ?>" />
                    </div>


                    <button type="submit" class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                        <img src="./assets/img/msv-search-icon.svg" alt="">
                    </button>
                </div>
            </form>

            <?php include_once __DIR__ . '/tables/admissions_table.php'; ?>

        </div>
    </div>
</main>