<?php
use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\CSSDServiceQuery;


require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/AuthQuery.php";
require_once __DIR__ . "/../sql/CSSDServiceQuery.php";

$authQuery = new AuthQuery();
$cssd = new CSSDServiceQuery();


$providers = $authQuery->getProviders();
$getCssd = $cssd->getCSSDService();
$getCssdItem = $cssd->getCSSDServiceItem();
$getCssdRequest = $cssd->getCSSDServiceRequest();


$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    //$surgery = $surgeryQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');

} elseif (isset($_POST['new_service_request']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'service_id' => $_POST['service_id'],
        'item_id' => $_POST['item_id'],
        'surgery_id' => 1,
        // 'department_id' => $_POST['department_id'],
        'quantity' => $_POST['quantity'],
        'request_date' => $_POST['request_date'],
        'request_by' => $_POST['request_by'],
        'status' => "Pending",
        'request_processed_date' => $_POST['request_processed_date'],
        'request_processed_by' => $_POST['request_processed_by'],
        'quantity_returned' => $_POST['quantity_returned'],
        'receipt_date' => $_POST['receipt_date'],
        'received_by' => $_POST['received_by'],
    ];
    $cssd->insertCSSDServiceRequest($data);
    header('location:msv_cssd_request_content.php?status=success&message=CSSD Service Requested  Successfully');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'service_id' => $_POST['service_id'],
        'item_id' => $_POST['item_id'],
        // 'department_id' => $_POST['department_id'],
        'quantity' => $_POST['quantity'],
        'request_date' => $_POST['request_date'],
        'request_by' => $_POST['request_by'],
        'status' => $_POST['status'],
        'request_processed_date' => $_POST['request_processed_date'],
        'request_processed_by' => $_POST['request_processed_by'],
        'quantity_returned' => $_POST['quantity_returned'],
        'receipt_date' => $_POST['receipt_date'],
        'received_by' => $_POST['received_by'],
    ];

    $cssd->updateCSSDServiceRequest($data);
    header('location:msv_cssd_request_content.php?status=success&message=CSSD Service Request Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $cssd->destroyCSSDServiceRequest($_POST['deleteId']);
    header('location:msv_cssd_request_content.php?status=success&message=CSSD Service Request Deleted Successfully');
}

?>

<main class="flex-1">


    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <div class="flex justify-between items-center">
            <p class="text-[32px] font-[500] text-white ml-16">CSSD Service Request</p>

            <button class="flex mr-16 rounded-md items-center w-[36px] h-[36px] bg-white justify-center" onclick="showFormsModal('cssdServiceRequestForm')">
                +
            </button>
        </div>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">

                    <input type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                        placeholder="Enter service name" />
                </div>

                <button class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                    <img src="./assets/img/msv-search-icon.svg" alt="">
                </button>
            </div>


            <?php include_once __DIR__ . '/tables/cssd_request_table.php'; ?>


        </div>

</main>