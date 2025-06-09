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
use OpenEMR\Modules\InpatientModule\PatientQuery;

require_once "../../../../globals.php";
require_once "./components/sql/InpatientQuery.php";
require_once "./components/sql/PatientQuery.php";

$inpatientQuery = new InpatientQuery();
$patientQuery = new PatientQuery();

$visitors = $patientQuery->getVisitors();
$inpatients = $inpatientQuery->getInpatients();


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['new'])) {
    $data = [
        'patient_id' => $_POST['patient'],
        'visitor_name' => $_POST['visitor_name'],
        'relationship_with_patient' => $_POST['relationship_with_patient'],
        'time_in' => $_POST['time_in'],
        'time_out' => $_POST['time_out'],
        'comment' => $_POST['comment'],
    ];
    $patientQuery->insertVisitor($data);
    header('Refresh:0');
} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    $data = [
        'id' => $_POST['id'],
        'patient_id' => $_POST['patient'],
        'visitor_name' => $_POST['visitor_name'],
        'relationship_with_patient' => $_POST['relationship_with_patient'],
        'time_in' => $_POST['time_in'],
        'time_out' => $_POST['time_out'],
        'comment' => $_POST['comment'],
    ];
    $patientQuery->updateVisitor($data);
    header('Refresh:0');
} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['deleteId'])) {
    $patientQuery->destroyVisitor($_POST['deleteId']);
    header('location:visits.php?status=success&message=Bed deleted successfully');
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    $visitors = $patientQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');
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
    <link rel="stylesheet" href="./assets/css/main.css">
    <title><?php echo xlt("Visitors - Inpatient") ?></title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <div style="margin-top: 25px;">
        <a href="./inpatient.php"><?php echo xlt("Back") ?></a>
        <p></p>
    </div>

    <section class="main-containerx" style="flex-direction: column;">
        <div class="left-con">

            <div class="search_container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: flex;">
                    <input type="text" class="form-control" name="search" id="search" placeholder="search...">
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px;"><?php echo xlt("Search") ?></button>
                </form>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <h4 class="section-head"><?php echo xlt("Visitor Registry") ?></h4>

                <button type="button" class="btn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#newVisitor">
                    <?php echo xlt("New Visitor") ?>
                </button>
            </div>


            <table>
                <tr>
                    <th> <?php echo xlt("Visitor Name") ?></th>
                    <th> <?php echo xlt("Patient Name") ?></th>
                    <th> <?php echo xlt("Relationship w/ patient") ?></th>
                    <th> <?php echo xlt("Action"); ?> </th>
                    <!-- <th>Bed</th> -->
                </tr>

                <?php foreach ($visitors as $value) {
                ?>
                    <tr>
                        <td><?php echo $value['visitor_name']; ?></td>
                        <td><?php echo $value['fname']; ?> <?php echo $value['mname']; ?> <?php echo $value['lname']; ?></td>
                        <td><?php echo $value['relationship_with_patient']; ?></td>
                        <td>
                            <a href="#" class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateVisitor" data-id="<?php echo $value['id']; ?>" data-relationship_with_patient="<?php echo $value['relationship_with_patient']; ?>" data-visitor_name="<?php echo $value['visitor_name']; ?>" data-patient_id="<?php echo $value['patient_id']; ?>" data-comment="<?php echo $value['comment']; ?>" data-time_in="<?php echo $value['time_in']; ?>" data-time_out="<?php echo $value['time_out']; ?>"><?php echo xlt("Edit") ?></a>
                            <a href="#" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#itemDelete" data-id="<?php echo $value['id']; ?>"><?php echo xlt("Delete") ?></a>
                        </td>
                    </tr>
                <?php
                } ?>
            </table>

        </div>

    </section>

    <?php include_once "./components/modals/visits/new.php"; ?>
    <?php include_once "./components/modals/visits/edit.php"; ?>
    <?php include_once "./components/modals/visits/delete.php"; ?>

    <script>
        window.onload = function() {
            $(".updateBtn").click(function() {
                var id = $(this).data('id');
                var patient_id = $(this).data('patient_id');
                var visitor_name = $(this).data('visitor_name');
                var relationship_with_patient = $(this).data('relationship_with_patient');
                var time_in = $(this).data('time_in');
                var time_out = $(this).data('time_out');
                var comment = $(this).data('comment');

                $('input[name=id]').val(id);
                $('select[name=patient]').val(patient_id);
                $('input[name=visitor_name]').val(visitor_name);
                $('input[name=relationship_with_patient]').val(relationship_with_patient);
                $('input[name=time_in]').val(time_in);
                $('input[name=time_out]').val(time_out);
                $('input[name=comment]').val(comment);
            });

            $(".deleteBtn").click(function() {
                var id = $(this).data('id');
                $('#deleteId').val(id);
            });


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
                    `<option class='clearfix' value='${repo.pid}'>${repo.fname} ${repo.mname} ${repo.lname}</option>`
                );
                return $container;
            }

            function formatRepoSelection(repo) {
                return repo.fname + " " + repo.mname + " " + repo.lname;
            }
        };
    </script>
    <?php include_once "./components/footer.php"; ?>