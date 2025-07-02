<?php

use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;

require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/BedQuery.php";
require_once __DIR__ . "/../sql/WardQuery.php";


$wardQuery = new WardQuery();
$bedQuery = new BedQuery();

$wards = $wardQuery->getWards();

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'bed_type' => trim($_POST['bed_type']),
        'price_per_day' => trim($_POST['price_per_day']),
        'number' => trim($_POST['number']),
        'ward_id' => trim($_POST['ward_id']),
        'availability' => trim($_POST['availability']),
    ];
    $bedQuery->insertBed($data);
    header('location:beds.php?status=success&message=Bed added successfully');
    // header('Refresh:0');
} else if (isset($_GET['search_by_ward']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $ward_id = isset($_GET['search_ward']) && trim($_GET['search_ward']) !== '' ? $_GET['search_ward'] : null;
    $beds = $bedQuery->filterBeds($ward_id);
    // $inpatients = $inpatientQuery->searchInpatients($data);
} else {
    $beds = $bedQuery->getBeds();
}

$selectedWard = isset($_GET['search_ward']) ? $_GET['search_ward'] : '';


?>
<main class="flex-1">

    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <div class="flex justify-between items-center">
            <p class="text-[32px] font-[500] text-white ml-16">Beds</p>

            <button class="flex mr-16 rounded-md items-center w-[36px] h-[36px] bg-white justify-center" onclick="showFormsModal('bedsForm')">
                +
            </button>
        </div>
    </div>
    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                <input type="hidden" name="search_by_ward">
                <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                    <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                        <select class="flex-1 h-full focus:ring-0 focus:outline-none" placeholder="Select Ward" name="search_ward" id="search_ward">
                            <option value=""><?php echo xlt("Select Ward") ?></option>
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"
                                    <?php echo ($selectedWard == $ward['id']) ? 'selected' : ''; ?>>
                                    <?php echo $ward['short_name']; ?> | <?php echo $ward['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <div class="border h-[30px]"></div>
                        <input name="word" id="word" type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                            placeholder="Enter patient's name" />
                    </div>

                    <button class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                        <img src="./assets/img/msv-search-icon.svg" alt="">
                    </button>
                </div>
            </form>

            <?php include_once __DIR__ . '/tables/bed-table.php'; ?>

        </div>

</main>