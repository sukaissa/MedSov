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

use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\WardTransferQuery;

require_once "../../../../../globals.php";
require_once "../components/sql/WardTransferQuery.php";
require_once "../components/sql/InpatientQuery.php";

$inpatientQuery = new InpatientQuery();
$wardTransfer = new WardTransferQuery();
$patients  = $inpatientQuery->getInpatients();
$patientTransfer = [
    'results' => [],
    'total' => 0
];

if (isset($_GET['patient']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $data = [
        'patient' => $_GET['patient'] ?  $_GET['patient'] : null,
        'start_date' => $_GET['start_date'] ? $_GET['start_date'] : null,
        'end_date' => $_GET['end_date'] ? $_GET['end_date'] : null,
    ];
    $patientTransfer = $wardTransfer->filterPatientTransfer($data);
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
    <title> <?php echo xlt("Inpatient - Ward Transfer Report") ?></title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">
    <div class="search_container no_print">
        <form method="GET" style="display: flex; align-items: center;">
            <div class="form-group" style="margin-right: 10px;">
                <label for="patient" style="margin-right: 5px;"> <?php echo xlt("Patient") ?></label>
                <select class="form-control" id="patient" name="patient">
                    <option value=""> <?php echo xlt("Select patient") ?></option>
                    <?php foreach ($patients as $patient) { ?>
                        <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['fname'] . " " . $patient['lname']; ?> </option>
                    <?php
                    }  ?>
                </select>
            </div>
            <div class="form-group" style="margin-right: 5px;">
                <label for="start_date" style="margin-right: 5px;"> <?php echo xlt("From") ?></label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="form-group" style="margin-right: 5px;">
                <label for="end_date" style="margin-right: 5px;"> <?php echo xlt("To") ?></label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-left: 20px;"> <?php echo xlt("Search") ?></button>
        </form>

        <form>
            <input type="button" value="Print" onclick="window.print()" />
        </form>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
        <h4 class="section-head"> <?php echo xlt("Ward Transfer") ?> (<?php echo $patientTransfer['total'] ?>)</h4>
    </div>


    <table>
        <thead>
            <tr>
                <th scope="col"> <?php echo xlt("No") ?></th>
                <th scope="col"> <?php echo xlt("Patient") ?></th>
                <th scope="col"> <?php echo xlt("Old Ward") ?></th>
                <th scope="col"> <?php echo xlt("Old Bed") ?></th>
                <th scope="col"> <?php echo xlt("New Ward") ?></th>
                <th scope="col"> <?php echo xlt("New Bed") ?></th>
                <th scope="col"> <?php echo xlt("Days") ?></th>
                <th scope="col"> <?php echo xlt("Transfer Date") ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patientTransfer['results'] as $key => $value) { ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value['fname'] . " " . $value['mname'] . " " . $value['lname']; ?></td>
                    <td><?php echo $value['old_ward_name']; ?></td>
                    <td><?php echo $value['old_bed_number']; ?></td>
                    <td><?php echo $value['new_ward_name']; ?></td>
                    <td><?php echo $value['new_bed_number']; ?></td>
                    <td><?php echo $value['days']; ?></td>
                    <td><?php echo $value['transfer_date']; ?></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            $('.select_pat').select2({
                dropdownParent: $('#newVisitor'),
                ajax: {
                    url: "ajax_search.php",
                    dataType: 'json',
                    type: "GET",
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            search: "search_for_patients",
                        };
                    },

                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.patients,
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
                    "<option class='select_pat clearfix' value='" + repo.id + "'>" + repo.fname + " " + repo.mname + " " + repo.lname + "</option>"
                );
                return $container;
            }

            function formatRepoSelection(repo) {
                return repo.fname + " " + repo.mname + " " + repo.lname;
            }

        };
    </script>
    <?php include_once "../components/footer.php"; ?>