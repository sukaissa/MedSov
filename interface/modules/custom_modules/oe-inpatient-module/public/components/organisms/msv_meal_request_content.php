<?php

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\FoodQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;

require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/FoodQuery.php";
require_once __DIR__ . "/../sql/AuthQuery.php";
require_once __DIR__ . "/../sql/FoodQuery.php";
require_once __DIR__ . "/../sql/InpatientQuery.php";

$authQuery = new AuthQuery();
$foodQuery = new FoodQuery();
$inpatientQuery = new InpatientQuery();


if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'patient' => $_POST['patient'],
        'food' => $_POST['food'],
        'staff' => $_POST['staff'],
        'requested_date' => $_POST['requested_date'],
        'admission_id' => $_POST['admission_id'] ?? 0,
    ];
    echo '<script>console.log(' . json_encode($data) . ');</script>';
    $foodQuery->insertFoodRequest($data);
    header('Refresh:0');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'patient' => $_POST['patient'],
        'food' => $_POST['food'],
        'staff' => $_POST['staff'],
        'requested_date' => $_POST['requested_date'],
    ];
    $foodQuery->updateFoodRequest($data);
    header('Refresh:0');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->destroyFoodItem($_POST['deleteId']);
    header('Refresh:0');
} elseif (isset($_POST['deliver_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->deliverFood($_POST['deliver_id']);
    header('Refresh:0');
} elseif (isset($_POST['cancel_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->cancelFood($_POST['cancel_id']);
    header('Refresh:0');
} elseif (isset($_POST['search']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $search = $_POST['search'];
    // $mealRequests = $foodQuery->advancedSearchFoodRequests([
    //     'search' => 'John',           // General search term
    //     'category' => 'Breakfast',    // Specific category
    //     'status' => 'Pending',        // Specific status
    //     'start_date' => '2024-01-01', // Date range
    //     'end_date' => '2024-12-31'
    // ]);
    $mealRequests = $foodQuery->searchFoodRequests($search);
    // header('Refresh:0');
} else {
    $mealRequests = $foodQuery->getFoodRequests();
}

$patients = $inpatientQuery->getInpatients();
$foodItems = $foodQuery->getMenuItems();
$users = $authQuery->getUsers();

?>
<main class="flex-1">
    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <div class="flex justify-between items-center">
            <p class="text-[32px] font-[500] text-white ml-16">Requested Meals</p>

            <button class="flex mr-16 rounded-md items-center w-[36px] h-[36px] bg-white justify-center" onclick="showFormsModal('mealRequestForm')">
                +
            </button>
        </div>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="mealRequestForm">
                <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                    <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                        <input type="text" name="search" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                            placeholder="Enter patient name" />
                    </div>

                    <button type="submit" class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                        <img src="./assets/img/msv-search-icon.svg" alt="">
                    </button>
                </div>
            </form>


            <?php include_once __DIR__ . '/tables/meal_request_table.php'; ?>


        </div>

</main>