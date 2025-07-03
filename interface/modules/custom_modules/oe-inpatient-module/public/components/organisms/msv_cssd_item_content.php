<?php

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\CSSDServiceQuery;

require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/AuthQuery.php";
require_once __DIR__ . "/../sql/CSSDServiceQuery.php";

$authQuery = new AuthQuery();
$cssd = new CSSDServiceQuery();

$users = $authQuery->getUsers();
$providers = $authQuery->getProviders();
$getCssd = $cssd->getCSSDService();
$getCssdItems = $cssd->getCSSDServiceItem();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
} elseif (isset($_POST['new_service_item']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'item_name' => $_POST['item_name'],
        'created_by' => $user['fname'],
    ];
    $cssd->insertCSSDServiceItem($data);
    header('location:cssd_item.php?status=success&message=CSSD Service Item Added Successfully');
} elseif (isset($_POST['service_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['service_id'],
        'item_name' => $_POST['item_name'],
        'updated_by' => $user['fname'],
    ];
    $cssd->updateCSSDServiceItem($data);
    header('location:cssd_item.php?status=success&message=CSSD Service Item Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $cssd->destroyCSSDServiceItem($_POST['deleteId']);
    header('location:cssd_item.php?status=success&message=CSSD Service Item Deleted Successfully');
}


if (isset($_GET['search']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $searchedWord = $_GET['search'];
    // $getCssdItem = $cssd->searchCSSDServiceItem($searchedWord);
} else {
    $getCssdItem = $cssd->getCSSDServiceItem();
}

?>

<main class="flex-1">


    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <div class="flex justify-between items-center">
            <p class="text-[32px] font-[500] text-white ml-16">CSSD Item</p>

            <button class="flex mr-16 rounded-md items-center w-[36px] h-[36px] bg-white justify-center" onclick="showFormsModal('cssdItemForm')">
                +
            </button>
        </div>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">
                    <input type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                        placeholder="Enter name" />
                </div>

                <button class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                    <img src="./assets/img/msv-search-icon.svg" alt="">
                </button>
            </div>


            <?php include_once __DIR__ . '/tables/cssd_item_table.php'; ?>


        </div>

</main>