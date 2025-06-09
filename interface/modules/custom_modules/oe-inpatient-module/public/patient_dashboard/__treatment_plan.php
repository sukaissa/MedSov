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

use OpenEMR\Modules\InpatientModule\ActionPlanQuery;
use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\ListsQuery;
use OpenEMR\Modules\InpatientModule\TreatmentQuery;
use Ramsey\Uuid\Uuid;

require_once "../../../../../globals.php";
require_once "../components/sql/AuthQuery.php";
require_once "../components/sql/BedQuery.php";
require_once "../components/sql/ListsQuery.php";
require_once "../components/sql/TreatmentQuery.php";
require_once "../components/sql/ActionPlanQuery.php";

$actionPlanQuery = new ActionPlanQuery();
$authQuery = new AuthQuery();
$listQuery = new ListsQuery();
$bedQuery = new BedQuery();
$treatmentQuery = new TreatmentQuery();

$admission_id = $_GET['admission_id'];
$patient_id = $_GET['patient_id'];
$ward_id  = $_GET['ward_id'];
$bed_id = $_GET['bed_id'];

$users = $authQuery->getUsers();
$issueList = $actionPlanQuery->getIssueList();

$menuItems = [
    [
        'id' => 1,
        'name' => "Clinical Management Plan",
        'url' => '__treatment_plan.php',
        'active' => true,
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

if (isset($_POST['treatment_plan']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $uuid = Uuid::uuid4();

    $data = [
        'admission_id' => $_POST['mng_admission_id'],
        'patient_id' => $_POST['mng_patient_id'],
        'title' => $_POST['title'],
        'type' => $_POST['type'],
        'instructions' => $_POST['instructions'],
        'action_start_time' => $_POST['action_start_time'],
        'action_end_time' => $_POST['action_end_time'],
        'time_interval' => $_POST['time_interval'],
        'staff_id' => $_POST['staff_id'],
        'uuid' => $uuid,
    ];
    $treatmentQuery->insertTreatmentPlan($data);
    $listQuery->insertList($data);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['treatment_plan_edit']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'title' => $_POST['title'],
        'type' => $_POST['type'],
        'instructions' => $_POST['instructions'],
        'action_start_time' => $_POST['action_start_time'],
        'action_end_time' => $_POST['action_end_time'],
        'time_interval' => $_POST['time_interval'],
        'staff_id' => $_POST['staff_id'],
        'status' => $_POST['status'],
    ];
    $treatmentQuery->updateTreatmentPlan($data);
    $listQuery->insertList($data);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $treatmentQuery->destroyTreatmentPlan($_POST['deleteId']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
}


$patientManagement = $treatmentQuery->getPatientTreatmentPlan($admission_id);
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
    <title>Patient Dashboard - Clinical Management Plan</title>

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
                <h1>Clinical Management Plan</h1>
                <a href="#" style="margin-left: 10px; background-color: #40E0D0;" class="btn-md btn setTreatmBtn" data-toggle="modal" data-target="#setTreatment" data-pid="<?php echo $patient_id; ?>" data-admission_id="<?php echo $admission_id; ?>">
                    Set Treatment
                </a>
            </div>

            <!-- table to loop over management plan -->
            <table>
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type of Treatment</th>
                        <th scope="col">Instructions</th>
                        <th scope="col">Status</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Interval</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patientManagement as $key => $value) { ?>
                        <tr style="background-color: <?php echo $value['status'] == 'Inactive' ? '#ffd2d2' : '' ?>;">
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['title']; ?></td>
                            <td><?php echo $value['type']; ?></td>
                            <td><?php echo $value['instructions']; ?></td>
                            <td><?php echo $value['status']; ?></td>
                            <td><?php echo $value['action_start_time']; ?></td>
                            <td><?php echo $value['action_end_time']; ?></td>
                            <td><?php echo $value['time_interval']; ?></td>
                            <td>
                                <a href="#" class="btn btn-primary editBtn" data-toggle="modal" data-target="#setTreatmentEdit" data-id="<?php echo $value['id']; ?>" data-type="<?php echo $value['type']; ?>" data-title="<?php echo $value['title']; ?>" data-action_start_time="<?php echo $value['action_start_time']; ?>" data-action_end_time="<?php echo $value['action_end_time']; ?>" data-staff_id="<?php echo $value['staff_id']; ?>" data-time_interval="<?php echo $value['time_interval']; ?>" data-instructions="<?php echo $value['instructions']; ?>" data-status="<?php echo $value['status']; ?>">Edit</a>
                                <a href="#" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#itemDelete" data-id="<?php echo $value['id']; ?>">Delete</a>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>


    <?php include_once "../components/modals/inpatient/treatment_plan.php"; ?>
    <?php include_once "../components/modals/inpatient/treatment_plan_edit.php"; ?>
    <?php include_once "../components/modals/inpatient/delete.php"; ?>

    <?php
    $beds = $bedQuery->getAvailableBeds();
    ?>
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

            $(".setTreatmBtn").click(function() {
                console.log('treatment plan');
                var admission_id = $(this).data('admission_id');
                var patient_id = $(this).data('pid');

                $('#mng_admission_id').val(admission_id);
                $('#mng_patient_id').val(patient_id);
            });


            $(".deleteBtn").click(function() {
                var id = $(this).data('id');
                $('#deleteId').val(id);
            });

            $(".editBtn").click(function() {
                var id = $(this).data('id');
                var type = $(this).data('type');
                var title = $(this).data('title');
                var action_start_time = $(this).data('action_start_time');
                var staff_id = $(this).data('staff_id');
                var action_end_time = $(this).data('action_end_time');
                var time_interval = $(this).data('time_interval');
                var instructions = $(this).data('instructions');
                var status = $(this).data('status');

                console.log(id, type, title, action_start_time, staff_id, action_end_time, time_interval, instructions, status);
                $('input[name=id]').val(id);
                $('select[name=type]').val(type);
                $('input[id=title]').val(title);
                $('input[name=action_start_time]').val(action_start_time);
                $('select[name=staff_id]').val(staff_id);
                $('select[name=status]').val(status);
                $('input[name=action_end_time]').val(action_end_time);
                $('input[name=time_interval]').val(time_interval);
                $('textarea[name=instructions]').val(instructions);
            });

            $("#action_end_time").change(function() {
                var action_end_time = $('#action_end_time').val();
                var action_start_time = $('#action_start_time').val();
                var reslt = diff(action_start_time, action_end_time);
                console.log(reslt);
                $('#time_interval').empty();
                $('#time_interval').val(reslt);
            });

            $("#action_end_time_edit").change(function() {
                var action_end_time = $('#action_end_time_edit').val();
                var action_start_time = $('#action_start_time_edit').val();
                var reslt = diff(action_start_time, action_end_time);
                $('#time_interval_edit').empty();
                $('#time_interval_edit').val(reslt);
            });


            // search drug code and surgery code
            $('.select_plann').select2({
                dropdownParent: $('#setTreatment'),
                ajax: {
                    url: "../ajax_search.php",
                    dataType: 'json',
                    type: "GET",
                    data: function(params) {
                        let plans = [];
                        var action_id = $('#action_id').val();
                        console.log(action_id);
                        console.log('something...');



                        let thePlan = plans.filter(plan => plan.id == action_id);
                        console.log(thePlan[0]);
                        if (thePlan.length < 1) {
                            return false;
                        }

                        $('#mng_action_type').val(thePlan[0].type);

                        return {
                            q: params.term, // search term
                            page: params.page,
                            search: `search_for_${thePlan[0].type}`,
                        };
                    },

                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.results,
                            pagination: {
                                more: (params.page * 30) < data.total_count
                            }
                        };
                    },
                    cache: true
                },
                minimumInputLength: 3,
                templateResult: formatOpt,
                templateSelection: formatRepoSelection,
            });

            function formatOpt(repo) {
                if (repo.loading) {
                    return repo.text;
                }
                var $container = $(
                    "<option class='select_pat clearfix' value='" + repo.id + "'>" + repo.name + "</option>"
                );
                return $container;
            }

            function formatRepoSelection(repo) {
                return repo.name;
            }

            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);

        };
    </script>

    <?php include_once "../components/footer.php"; ?>