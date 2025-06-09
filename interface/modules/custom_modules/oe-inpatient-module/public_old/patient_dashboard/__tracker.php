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
use OpenEMR\Modules\InpatientModule\TreatmentQuery;

require_once "../../../../../globals.php";
require_once "../components/sql/AuthQuery.php";
require_once "../components/sql/TreatmentQuery.php";

$authQuery = new AuthQuery();
$treatmentQuery = new TreatmentQuery();

$admission_id = $_GET['admission_id'];
$patient_id = $_GET['patient_id'];
$ward_id  = $_GET['ward_id'];
$bed_id = $_GET['bed_id'];

$users = $authQuery->getUsers();

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
        'active' => true,
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
        'active' => false,
        'url' => '__bills.php'
    ],
    [
        'id' => 89,
        'name' => "Meal Requests",
        'active' => false,
        'url' => '__food_requests.php'
    ],

];


if (isset($_POST['tracker']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'plan_id' => $_POST['plan_id'],
        'admission_id' => $_POST['admission_id'],
        'action_time' => $_POST['action_time'],
        'staff_id' => $_POST['staff_id'],
    ];
    $treatmentQuery->insertTracker($data);
    // header('location:inpatient.php?status=success&message=Clinical Management Plan Tracker added successfully');
    // header('Refresh:0');
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['tracker_edit']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'plan_id' => $_POST['plan_id'],
        'action_time' => $_POST['action_time'],
        'staff_id' => $_POST['staff_id'],
    ];
    $treatmentQuery->updateTracker($data);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $treatmentQuery->destroyManagementTracker($_POST['deleteId']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
}

$patientTracker = $treatmentQuery->getPatientTracker($admission_id);
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
    <title>Patient Dashboard - Tracker</title>

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
                <h1>Follow up Treatments</h1>
                <a href="#" style="margin-left: 10px; background-color: #40E0D0;" class="btn-md btn trackerBtn" data-toggle="modal" data-target="#managementTracker" data-pid="<?php echo $patient_id; ?>" data-admission_id="<?php echo $admission_id; ?>">
                    New Entry
                </a>
            </div>

            <!-- table to loop over management plan -->
            <table>
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">User</th>
                        <th scope="col">Action Time</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patientTracker as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['title']; ?></td>
                            <td><?php echo "$value[fname] $value[fname] $value[fname]"; ?></td>
                            <td><?php echo $value['action_time']; ?></td>
                            <td>
                                <button class="btn btn-primary editBtn" data-toggle="modal" data-target="#managementTrackerEdit" data-id="<?php echo $value['id'] ?>" data-plan_id="<?php echo $value['plan_id'] ?>" data-action_time="<?php echo $value['action_time'] ?>" data-staff_id="<?php echo $value['staff_id'] ?>" data-admission_id="<?php echo $value['admission_id'] ?>">Edit</button>
                                <button class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#itemDelete" data-id="<?php echo $value['id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>


    <?php include_once "../components/modals/inpatient/tracker.php"; ?>
    <?php include_once "../components/modals/inpatient/tracker_edit.php"; ?>
    <?php include_once "../components/modals/inpatient/delete_tracker.php"; ?>

    <script>
        window.onload = function() {

            function diff(start, end) {
                start = start.split(":");
                end = end.split(":");
                var startDate = new Date(0, 0, 0, start[0], start[1], 0);
                var endDate = new Date(0, 0, 0, end[0], end[1], 0);
                var diff = endDate.getTime() - startDate.getTime();
                var hours = Math.floor(diff / 1000 / 60 / 60);
                diff -= hours * 1000 * 60 * 60;
                var minutes = Math.floor(diff / 1000 / 60);

                // If using time pickers with 24 hours format, add the below line get exact hours
                if (hours < 0)
                    hours = hours + 24;

                return (hours <= 9 ? "0" : "") + hours + ":" + (minutes <= 9 ? "0" : "") + minutes;
            }

            $(".editBtn").click(function() {
                var id = $(this).data('id');
                var plan_id = $(this).data('plan_id');
                var action_time = $(this).data('action_time');
                var staff_id = $(this).data('staff_id');

                var admission_id = $(this).data('admission_id');
                $('#tra_admission_id_edit').val(admission_id);

                // make ajax call to fetch plans with `admission_id`
                $.ajax({
                    url: '../ajax_search.php',
                    type: 'GET',
                    data: {
                        q: admission_id, // search term
                        search: "search_for_treatment_plan",
                    },
                    success: function(data) {
                        console.log(data);
                        $("#tracker_plan_id_edit").empty().append("<option>Select  Plan</option>");
                        JSON.parse(data).forEach(function(item) {
                            $("#tracker_plan_id_edit").append(`<option value='${item.id}'> ${item.name} | ${item.action_start_time} - ${item.action_end_time} </option>`)
                        });
                        $('#tracker_plan_id_edit').val(plan_id);
                    }
                });

                $('#id_edit').val(id);
                $('#action_time_edit').val(action_time);
                $('#staff_id_edit').val(staff_id);

            });

            $(".trackerBtn").click(function() {
                var admission_id = $(this).data('admission_id');
                $('#tra_admission_id').val(admission_id);

                // make ajax call to fetch plans with `admission_id`
                $.ajax({
                    url: '../ajax_search.php',
                    type: 'GET',
                    data: {
                        q: admission_id, // search term
                        search: "search_for_treatment_plan",
                    },
                    success: function(data) {
                        console.log(data);
                        $("select[name=plan_id]").empty().append("<option>Select  Plan</option>");
                        JSON.parse(data).forEach(function(item) {
                            $("select[name=plan_id]").append(`<option value='${item.id}'> ${item.type}  - ${item.title} | ${item.action_start_time} - ${item.action_end_time} </option>`)
                        });
                    }
                });

            });

            $(".deleteBtn").click(function() {
                var id = $(this).data('id');
                $('#deleteId').val(id);
            });

            $(".dischBtn").click(function() {
                var id = $(this).data('id');
                var bed_id = $(this).data('bed_id');
                $('#dis_admission_id').val(id);
                $('#dis_bed_id').val(bed_id);
            });

            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);

        };
    </script>

    <?php include_once "../components/footer.php"; ?>