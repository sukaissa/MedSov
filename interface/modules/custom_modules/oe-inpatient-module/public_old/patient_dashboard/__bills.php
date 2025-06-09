<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Stanley kwamina Otabil <stanleyotabil10@gmail.com@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\BillQuery;
use OpenEMR\Modules\InpatientModule\TreatmentQuery;

require_once "../../../../../globals.php";
require_once "../components/sql/AuthQuery.php";
require_once "../components/sql/BillQuery.php";
require_once "../components/sql/TreatmentQuery.php";

$authQuery = new AuthQuery();
$treatmentQuery = new TreatmentQuery();
$billQuery = new BillQuery();

$admission_id = $_GET['admission_id'];
$patient_id = $_GET['patient_id'];
$ward_id  = $_GET['ward_id'];
$bed_id = $_GET['bed_id'];

$bills = $billQuery->getPatientBills($patient_id, $admission_id);

$menuItems = [
    [
        'id' => 1,
        'name' => "Clinical Management Plan",
        'url' => '__treatment_plan.php',
        'active' => false,
    ],
    [
        'id' => 7,
        'name' => "Follow up Treatment",
        'active' => false,
        'url' => '__tracker.php'
    ],
    [
        'id' => 6,
        'name' => "Ward Transfer",
        'active' => false,
        'url' => '__ward_transfer.php'
    ],
    [
        'id' => 3,
        'name' => "Bills",
        'active' => true,
        'url' => '__bills.php'
    ],
    [
        'id' => 89,
        'name' => "Meal Requests",
        'active' => false,
        'url' => '__food_requests.php'
    ],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <title>Patient Dashboard - Bills</title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">


    <div style="margin-top: 25px;">
        <a href="../inpatient.php">Back</a>
        <p></p>

    </div>

    <section class="main-containerx" style="">
        <div class="inp_left_menu">
            <?php
            foreach ($menuItems as $item) {
            ?>
                <a href="<?php echo $item['url'] . "?admission_id=" . $admission_id . "&patient_id=" . $patient_id . "&bed_id=" . $bed_id . "&ward_id=" . $ward_id; ?>" class="<?php echo $item['active'] == true ? 'inp__dash_menu_item_active' : 'inp__dash_menu_item' ?>"><?php echo $item['name']; ?></a>
            <?php
            }
            ?>
        </div>
        <div class="inp_right_contents">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h1>Bills</h1>
                <!-- <a href="#" style="margin-left: 10px;" class="btn-md btn btn-primary trackerBtn" data-toggle="modal" data-target="#managementTracker" data-pid="<?php echo $patient_id; ?>" data-admission_id="<?php echo $admission_id; ?>">
                    New Entry
                </a> -->
            </div>

            <!-- table to loop over management plan -->
            <table>
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Item/Service</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Provider</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bills as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php echo $value['fname']; ?></td>
                            <td><?php echo $value['action_start_time']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        window.onload = function() {
            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);

        };
    </script>

    <?php include_once "../components/footer.php"; ?>