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

use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\ListsQuery;
use OpenEMR\Modules\InpatientModule\TreatmentQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;
use OpenEMR\Modules\InpatientModule\WardTransferQuery;

require_once "../../../../../globals.php";
require_once "../components/sql/BedQuery.php";
require_once "../components/sql/ListsQuery.php";
require_once "../components/sql/TreatmentQuery.php";
require_once "../components/sql/WardQuery.php";
require_once "../components/sql/WardTransferQuery.php";

$listQuery = new ListsQuery();
$bedQuery = new BedQuery();
$treatmentQuery = new TreatmentQuery();
$wardQuery = new WardQuery();
$transferQuery = new WardTransferQuery();

$admission_id = $_GET['admission_id'];
$patient_id = $_GET['patient_id'];
$ward_id  = $_GET['ward_id'];
$bed_id = $_GET['bed_id'];

$wards = $wardQuery->getWards();
$transfers = $transferQuery->getWardTransfers($admission_id);

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
        'active' => true,
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


if (isset($_POST['transfer_ward']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['admission_id'],
        'patient_id' => $_POST['patient_id'],
        'old_ward' => $_POST['old_ward'],
        'old_bed' => $_POST['old_bed'],
        'ward_id' => $_POST['ward'],
        'bed_id' => $_POST['bed'],
        'transfer_date' => $_POST['transfer_date'],
    ];
    $transferQuery->transferWard($data);
    // header('location:inpatient.php?status=success&message=Patient ward transfer successfully');
    // header('Refresh:0');
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
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
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <title>Patient Dashboard - Ward Transfer</title>

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
                <h1>Ward Transfer</h1>

                <a href="#" style="margin-left: 10px; background-color: #40E0D0;" class="btn-md btn transferBtn" data-toggle="modal" data-target="#wardTransfer" data-pid="<?php echo $patient_id; ?>" data-bed="<?php echo $bed_id; ?>" data-ward="<?php echo $ward_id; ?>" data-admission_id="<?php echo $admission_id; ?>">
                    Ward Transfer
                </a>
            </div>

            <!-- table to loop over management plan -->
            <table>
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Bed No.</th>
                        <th scope="col">User</th>
                        <th scope="col">Transfer Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transfers as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['name']; ?></td>
                            <td><?php echo $value['number']; ?></td>
                            <td><?php echo $value['fname']; ?></td>
                            <td><?php echo $value['transfer_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>


    <?php include_once "../components/modals/inpatient/treatment_plan.php"; ?>
    <?php include_once "../components/modals/inpatient/ward_transfer.php"; ?>
    <?php include_once "../components/modals/inpatient/tracker.php"; ?>

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
                var admission_id = $(this).data('admission_id');
                var patient_id = $(this).data('pid');
                $('#mng_admission_id').val(admission_id);
                $('#mng_patient_id').val(patient_id);
            });

            $(".transferBtn").click(function() {
                var admission_id = $(this).data('admission_id');
                var patient_id = $(this).data('pid');
                var old_ward = $(this).data('ward');
                var old_bed = $(this).data('bed');
                $('#trs_admission_id').val(admission_id);
                $('#trs_patient_id').val(patient_id);
                $('#trs_old_ward').val(old_ward);
                $('#trs_old_bed').val(old_bed);
            });


            $(".trackerBtn").click(function() {
                var admission_id = $(this).data('admission_id');
                // make ajax call to fetch plans with `admission_id`
                $.ajax({
                    url: 'ajax_search.php',
                    type: 'GET',
                    data: {
                        q: admission_id, // search term
                        search: "search_for_treatment_plan",
                    },
                    success: function(data) {
                        $("#tracker_plan_id").empty().append("<option>Select  Plan</option>");
                        JSON.parse(data).forEach(function(item) {
                            $("#tracker_plan_id").append(`<option value='${item.id}'> ${item.drug_name} | ${item.action_start_time} - ${item.action_end_time} </option>`)
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

            $('#ward').on('change', function(e) {
                var optionSelected = $("option:selected", this);
                var valueSelected = this.value;
                let beds = [];

                <?php foreach ($beds as $bed) { ?>
                    beds.push(<?php echo json_encode([
                                    'id' => $bed['id'],
                                    'number' => $bed['number'],
                                    'bed_type' => $bed['bed_type'],
                                    'ward_id' => $bed['ward_id'],
                                    'price_per_day' => $bed['price_per_day'],
                                    'availability' => $bed['availability'],
                                ]);
                                ?>);
                <?php
                }  ?>

                let filteredBeds = beds.filter(bed => bed.ward_id == valueSelected)
                $("#bed").empty().append("<option>Select  Bed</option>");
                $(filteredBeds).each(function(i) {
                    $("#bed").append(`<option value='${filteredBeds[i].id}'> ${filteredBeds[i].number} | ${filteredBeds[i].bed_type} | ${filteredBeds[i].price_per_day} </option>`)
                });
            });

            $("#action_end_time").change(function() {
                var action_end_time = $('#action_end_time').val();
                var action_start_time = $('#action_start_time').val();
                var reslt = diff(action_start_time, action_end_time);
                $("#time_interval").empty();
                $('#time_interval').val(reslt);
            });

            // search drug code
            $('.select_pat').select2({
                dropdownParent: $('#setTreatment'),
                ajax: {
                    url: "ajax_search.php",
                    dataType: 'json',
                    type: "GET",
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            search: "search_for_drugs",
                        };
                    },

                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.drugs,
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