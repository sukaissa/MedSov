<?php

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;

require_once "../../../../../globals.php";
require_once "../components/sql/AuthQuery.php";
require_once "../components/sql/InpatientQuery.php";
require_once "../components/sql/WardQuery.php";

$inpatients = [];
$inpatientQuery = new InpatientQuery();
$authQuery = new AuthQuery();
$wardQuery = new WardQuery();

$wards = $wardQuery->getWards();
$users = $authQuery->getUsers();
$providers = $authQuery->getProviders();

if (isset($_GET['filters']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $provider = $_GET['provider'];
    $ward = $_GET['ward'];
    $gender = $_GET['gender'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $data = [
        'provider' => $provider,
        'ward' =>  $ward,
        'gender' =>  $gender,
        'start_date' =>  $start_date,
        'end_date' =>  $end_date,
    ];
    $inpatients = $inpatientQuery->filterDischargedPatients($data);
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
    <title><?php echo xlt('Inpatient - Discharged Report') ?></title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <div class="search_container no_print">
        <form method="GET" style="display: flex; align-items: center;">
            <input type="hidden" name="filters">
            <div class="form-group" style="margin-right: 10px;">
                <label for="provider" style="margin-right: 5px;"><?php echo xlt('User') ?></label>
                <select class="form-control" id="provider" name="provider">
                    <option value=""><?php echo xlt('Select User') ?></option>
                    <?php foreach ($providers as $provider) { ?>
                        <option value="<?php echo $provider['id']; ?>"><?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname']; ?> </option>
                    <?php
                    }  ?>
                </select>
            </div>
            <div class="form-group" style="margin-right: 10px;">
                <label for="ward" style="margin-right: 5px;"><?php echo xlt('Ward') ?></label>
                <select class="form-control" id="ward" name="ward">
                    <option value=""><?php echo xlt('Select ward') ?></option>
                    <?php foreach ($wards as $ward) { ?>
                        <option value="<?php echo $ward['id']; ?>"><?php echo $ward['name']; ?> </option>
                    <?php
                    }  ?>
                </select>
            </div>
            <div class="form-group" style="margin-right: 10px;">
                <label for="gender" style="margin-right: 5px;"><?php echo xlt('Gender') ?></label>
                <select class="form-control" id="gender" name="gender">
                    <option value=""><?php echo xlt('Select gender') ?></option>
                    <option value="male"><?php echo xlt('Male') ?></option>
                    <option value="female"><?php echo xlt('Female') ?></option>
                </select>
            </div>
            <div class="form-group" style="margin-right: 5px;">
                <label for="start_date" style="margin-right: 5px;"><?php echo xlt('Visits From') ?></label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="form-group" style="margin-right: 5px;">
                <label for="end_date" style="margin-right: 5px;"><?php echo xlt('To') ?></label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 20px;"><?php echo xlt('Search') ?></button>
        </form>

        <form>
            <input type="button" value="Print" onclick="window.print()" />
        </form>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
        <h4 class="section-head"><?php echo xlt('Discharged Patients') ?></h4>
    </div>


    <table>
        <tr>
            <th> <?php echo xlt('Name') ?> </th>
            <th> <?php echo xlt('Ward') ?> </th>
            <th> <?php echo xlt('Bed No') ?></th>
            <th> <?php echo xlt('Admission date') ?> </th>
            <th> <?php echo xlt('Discharge date') ?> </th>
        </tr>

        <?php foreach ($inpatients as $value) {
        ?>
            <tr>
                <td><?php echo "$value[fname] $value[mname] $value[lname]"; ?></td>
                <td><?php echo $value['ward_name']; ?></td>
                <td><?php echo $value['bed_number']; ?></td>
                <td><?php echo $value['admission_date']; ?></td>
                <td><?php echo $value['discharge_date']; ?></td>

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