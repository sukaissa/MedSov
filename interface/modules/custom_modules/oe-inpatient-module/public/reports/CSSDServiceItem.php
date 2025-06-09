<?php

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\CSSDServiceQuery;


require_once "../../../../../globals.php";
require_once "../components/sql/AuthQuery.php";
require_once "../components/sql/CSSDServiceQuery.php";


$cssd = [];
$authQuery = new AuthQuery();
$cssd_service_item = new CSSDServiceQuery();


$providers = $authQuery->getProviders();

if (isset($_GET['filters']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $provider = $_GET['provider'];
    $service_name = $_GET['service_name'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    $data = [
        'provider' => $provider,
        'service_name' =>  $service_name,
        'start_date' =>  $start_date,
        'end_date' =>  $end_date,
    ];
    $cssd =  $cssd_service_item->filterCSSDServiceItem($data);
}
// else {
//     $inpatients = $inpatientQuery->getInpatients();
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <title>Inpatient - CSSD Service Item Report</title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">


    <div class="search_container no_print">
        <form method="GET" style="display: flex; align-items: center;">
            <input type="hidden" name="filters">

            <div class="form-group" style="margin-right: 10px;">
                <label for="provider" style="margin-right: 5px;">User</label>
                <select class="form-control" id="provider" name="provider">
                    <option value="">Select User</option>
                    <?php foreach ($providers as $provider) { ?>
                        <option value="<?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?>"><?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?> </option>
                    <?php
                    }  ?>
                </select>
            </div>

            <div class="form-group" style="margin-right: 5px;">
                <label for="service_name" style="margin-right: 5px;">Service Name</label>
                <input type="text" name="service_name" id="service_name" class="form-control">
            </div>

            <div class="form-group" style="margin-right: 5px;">
                <label for="start_date" style="margin-right: 5px;">From</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="form-group" style="margin-right: 5px;">
                <label for="end_date" style="margin-right: 5px;">To</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 20px;">Search</button>
        </form>

        <form>
            <input type="button" value="Print" onclick="window.print()" />
        </form>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
        <h4 class="section-head">CSSD Service Item List</h4>
    </div>


    <table>
        <tr>
            <th>Service Name</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Request Date</th>
        </tr>

        <?php foreach ($cssd as $value) {
        ?>
            <tr>
                <td><?php echo $value['service_name']; ?></td>
                <td><?php echo $value['item_name']; ?></td>
                <td><?php echo $value['quantity']; ?></td>
                <td><?php echo $value['status']; ?></td>
                <td><?php echo $value['request_date']; ?></td>
            </tr>
        <?php
        } ?>
    </table>

    <script>
        window.onload = function() {

            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);

        };
    </script>
    <?php include_once "../components/footer.php"; ?>