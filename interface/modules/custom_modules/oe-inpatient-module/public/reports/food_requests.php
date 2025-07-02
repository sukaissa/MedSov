<?php

use OpenEMR\Modules\InpatientModule\FoodQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;

require_once "../../../../../globals.php";
require_once "../components/sql/FoodQuery.php";
require_once "../components/sql/InpatientQuery.php";
require_once "../components/sql/WardQuery.php";

$requestList = [
    'results' => [],
    'total' => 0
];
$inpatientQuery = new InpatientQuery();
$foodRequest = new FoodQuery();
$wardQuery = new WardQuery();

$wards = $wardQuery->getWards();
$patients  = $inpatientQuery->getInpatients();

if (isset($_GET['filters']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $patient = $_GET['patient'];
    $status = $_GET['status'];
    $category = $_GET['category'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $data = [
        'patient' => $patient,
        'status' =>  $status,
        'category' =>  $category,
        'start_date' =>  $start_date,
        'end_date' =>  $end_date,
    ];

    $requestList = $foodRequest->filterFoodRequests($data);
}
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
    <title><?php echo xlt('Inpatient - Meal Request Report') ?></title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <div class="search_container no_print">
        <form method="GET" style="display: flex; align-items: center;">
            <input type="hidden" name="filters">

            <div class="form-group" style="margin-right: 10px;">
                <label for="patient" style="margin-right: 5px;"><?php echo xlt('Patient') ?></label>
                <select class="form-control" id="patient" name="patient">
                    <option value=""><?php echo xlt('Select patient') ?></option>
                    <?php foreach ($patients as $patient) { ?>
                        <option value="<?php echo $patient['id']; ?>"><?php echo $patient['fname'] . " " . $patient['lname']; ?> </option>
                    <?php
                    }  ?>
                </select>
            </div>
            <div class="form-group" style="margin-right: 10px;">
                <label for="status" style="margin-right: 5px;"> <?php echo xlt('Status') ?> </label>
                <select class="form-control" id="status" name="status">
                    <option value=""> <?php echo xlt('Select status') ?> </option>
                    <option value="Pending"> <?php echo xlt('Pending') ?> </option>
                    <option value="Delivered"> <?php echo xlt('Delivered') ?> </option>
                    <option value="Cancelled"> <?php echo xlt('Cancelled') ?> </option>
                </select>
            </div>
            <div class="form-group" style="margin-right: 10px;">
                <label for="category" style="margin-right: 5px;"> <?php echo xlt('Meal Types') ?> </label>
                <select class="form-control" id="category" name="category">
                    <option value=""> <?php echo xlt('Select category') ?> </option>
                    <option value="admitted"> <?php echo xlt('Admitted') ?> </option>
                    <option value="in-queue"> <?php echo xlt('In Queue') ?> </option>
                    <option value="discharged"> <?php echo xlt('Discharged') ?> </option>
                </select>
            </div>
            <div class="form-group" style="margin-right: 5px;">
                <label for="start_date" style="margin-right: 5px;"> <?php echo xlt('From') ?> </label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="form-group" style="margin-right: 5px;">
                <label for="end_date" style="margin-right: 5px;"> <?php echo xlt('To') ?> </label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 20px;"> <?php echo xlt('Search') ?> </button>
        </form>

        <form>
            <input type="button" value="Print" onclick="window.print()" />
        </form>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
        <h4 class="section-head"> <?php echo xlt('Meal Requests') ?> (<?php echo $requestList['total'] ?>)</h4>
    </div>


    <table>
        <tr>
            <th> <?php echo xlt('Patient') ?> </th>
            <th> <?php echo xlt('Status') ?> </th>
            <th> <?php echo xlt('Meal') ?> </th>
            <th> <?php echo xlt('Meal Types') ?> </th>
            <th> <?php echo xlt('Request date') ?></th>
        </tr>

        <?php foreach ($requestList['results'] as $value) {
        ?>
            <tr>
                <td><?php echo "$value[fname] $value[mname] $value[lname]"; ?></td>
                <td><?php echo $value['status']; ?></td>
                <td><?php echo $value['food_name']; ?></td>
                <td><?php echo $value['category']; ?></td>
                <td><?php echo $value['requested_date']; ?></td>
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