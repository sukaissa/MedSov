<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Mohammed Awal Saeed <awalsaeed736@gmail.com@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use OpenEMR\Modules\InpatientModule\ProcedureQuery;
use OpenEMR\Modules\InpatientModule\TheaterQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\AuthQuery;

require_once "../../../../globals.php";
require_once "./components/sql/SurgeryQuery.php";
require_once "./components/sql/procedureQuery.php";
require_once "./components/sql/TheaterQuery.php";
require_once "./components/sql/InpatientQuery.php";
require_once "./components/sql/AuthQuery.php";

$surgeryQuery = new SurgeryQuery();
$procedureQuery = new ProcedureQuery();
$theaterQuery = new TheaterQuery();
$inpatientQuery = new InpatientQuery();
$authQuery = new AuthQuery();

$procedure = $procedureQuery->getProcedure();
$theater = $theaterQuery->getTheater();
$providers = $authQuery->getProviders();
$surgery = $surgeryQuery->getSurgeries();
$inpatients = $inpatientQuery->getInpatients();
$calenderCat =  $surgeryQuery->getCalendarCat();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    //$surgery = $surgeryQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');
} elseif (isset($_POST['surgery_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'surgery_id' => $_POST['surgery_id'],
        'theater_id' => $_POST['theater_id'],
        'procedure_id' => $_POST['procedure_id'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status'],
        'code' => $_POST['code'],
        'updated_by' => 1,
    ];
    $surgeryQuery->updateSurgery($data);
    header('location:surgery.php?status=success&message=Patient Surgery Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $surgeryQuery->destroySurgery($_POST['deleteId']);
    header('location:surgery.php?status=success&message=Surgery Deleted Successfully');
} elseif (isset($_POST['new_surgery']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'procedure_id' => $_POST['procedure_id'],
        'theater_id' => $_POST['theater_id'],
        'patient_id' => $_POST['patient_id'],
        'admission_id' => $_POST['admission_id'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status'],
        'created_by' => $_POST['created_by'],
        'code' => $_POST['code'],
    ];
    $surgeryQuery->insertSurgery($data);
    header('location:surgery.php?status=success&message=Patient Surgery Addedd Successfully');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once(__DIR__ . "/include_files.php"); ?>
    
    <title><?php echo xlt("Surgery Dashboard") ?></title>

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

            <?php if ($display_mesasge == 'block') { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    <strong><?php echo xlt("Success") ?>!</strong> <?php echo $message; ?>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>


            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <h4 class="section-head"><?php echo xlt("Scheduled Surgery") ?></h4>
                <!-- <button type="button" class="button new_surgeryBtn"  data-toggle="modal" data-target="#addModal" data-admission_id="<?php // echo $value['id'];                                                                                                                                                                  
                                                                                                                                            ?>">
                    New Surgery
                </button> -->
            </div>


            <table>
                <tr>
                    <th><?php echo xlt("Patient Name") ?> </th>
                    <th><?php echo xlt("Procedure Name") ?> </th>
                    <th><?php echo xlt("Theater Name") ?> </th>
                    <th><?php echo xlt("Start Date") ?> </th>
                    <th><?php echo xlt("End Date") ?> </th>
                    <th><?php echo xlt("Status") ?> </th>
                    <th><?php echo xlt("Action") ?> </th>
                </tr>

                <?php foreach ($surgery as $value) {
                ?>
                    <tr>
                        <td> <a href='<?php echo "surgery_details.php?admission_id=$value[admission_id]&patient_id=$value[patient_id]" ?>'> <?php echo $value['fname']; ?> <?php echo $value['mname']; ?> <?php echo $value['lname']; ?> </a></td>
                        <td> <?php echo $value['procedure_name']; ?></td>
                        <td><?php echo $value['theater_name']; ?></td>
                        <td><?php echo $value['start_date']; ?></td>
                        <td><?php echo $value['end_date']; ?></td>
                        <td><?php echo $value['status']; ?></td>
                        <td style="display: flex;">
                            <!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> -->
                            <!-- <input type="hidden" name="id" value="<?php echo $value['id']; ?>"> -->
                            <button type="button" class="btn btn-primary surgery_updateBtn" style="" data-toggle="modal" data-target="#bedModal" data-surgery_id="<?php echo $value['id']; ?>" data-procedure_id="<?php echo $value['procedure_id']; ?>" data-start_date="<?php echo $value['start_date']; ?>" data-end_date="<?php echo $value['end_date']; ?>" data-status="<?php echo $value['status']; ?>" data-theater_id="<?php echo $value['theater_id']; ?>" data-code="<?php echo $value['code']; ?>">
                                <?php echo xlt("Update") ?>
                            </button>
                            <!-- </form> -->

                            <button type="button " class="btn btn-danger surgery_deleteBtn" style="" data-toggle="modal" data-target="#deleteSurgeryModal" data-surgery_id="<?php echo $value['id']; ?>">
                                <?php echo xlt("Delete") ?>
                            </button>

                        </td>

                    </tr>
                <?php
                } ?>
            </table>

        </div>

    </section>


    <!-- edit Modal -->
    <div class="modal fade" id="bedModal" tabindex="-1" aria-labelledby="bedModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bedModal"><?php echo xlt("Edit Scheduled Surgeries") ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="surgery_id" id="surgery_id" value="">

                        <div class="form-group">
                            <label for="code"><?php echo xlt("Code") ?></label>
                            <input type="text" class="form-control" name="code" id="code">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("Theater Name") ?></label>
                            <select class="form-control" id="theater_id" name="theater_id">
                                <option value=""><?php echo xlt("Select Theater") ?></option>
                                <?php foreach ($theater as $theaters) { ?>
                                    <option value="<?php echo $theaters['id'] ?>"><?php echo $theaters['theater_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("Surgical Procedure") ?> </label>
                            <select class="form-control" style="width: 100%;" id="procedure_id" name="procedure_id">
                                <option value=""><?php echo xlt("Select Procedure") ?> </option>
                                <?php foreach ($procedure as $pro) { ?>
                                    <option value="<?php echo $pro['id'] ?>"><?php echo $pro['procedure_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("Start Date") ?> </label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("End Date") ?> </label>
                            <input type="date" class="form-control" id="end_date" name="end_date">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("Surgery Status") ?> </label>
                            <select class="form-control" style="width: 100%;" name="status" id="status">
                                <option value="Awaiting"><?php echo xlt("Awaiting") ?> </option>
                                <option value="Completed"><?php echo xlt("Completed") ?> </option>
                                <option value="Canceled"><?php echo xlt("Canceled") ?> </option>
                            </select>
                        </div>

                        <!-- surgery part -->
                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("Category") ?> </label>
                            <select class="form-control" style="width: 100%;" name="pc_title" id="pc_title">
                                <?php
                                foreach ($calenderCat as $cat) {
                                ?>
                                    <option value="<?php echo $cat['pc_catname'] ?>"><?php echo $cat['pc_catname'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label for="pc_hometext">Comment</label>
                            <input type="text" class="form-control" name="pc_hometext" id="pc_hometext">
                        </div> -->

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt("Close") ?> </button>
                            <button type="submit" class="btn btn-primary"><?php echo xlt("Save") ?> </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- schudule surgury-->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wardModal"><?php echo xlt("Schedule Surgery") ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">

                        <input type="hidden" name="admission_id" id="surg_admission_id" value="">
                        <input type="hidden" name="created_by" value="<?php echo $_SESSION['authUserID']; ?>">
                        <input type="hidden" name="new_surgery" id="new_surgery" value="">

                        <div class="form-group">
                            <label for="code"><?php echo xlt("Code") ?></label>
                            <select name="code" class="form-control w-100" id="surgery_code"></select>
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("Theater Name") ?></label>
                            <select class="form-control" style="width: 100%;" name="theater_id" id="theater_id">
                                <option value=""><?php echo xlt("Select Theater") ?></option>
                                <?php foreach ($theater as $theaters) { ?>
                                    <option value="<?php echo $theaters['id'] ?>"><?php echo $theaters['theater_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("Surgical Procedure") ?></label>
                            <select class="form-control" style="width: 100%;" name="procedure_id" id="procedure_id">
                                <option value=""><?php echo xlt("Select Procedure") ?></option>
                                <?php foreach ($procedure as $pro) { ?>
                                    <option value="<?php echo $pro['id'] ?>"><?php echo $pro['procedure_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("Start Date") ?></label>
                            <input type="date" class="form-control" name="start_date" id="start_date">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt("End Date") ?></label>
                            <input type="date" class="form-control" name="end_date" id="end_date">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt("Surgery Status") ?> </label>
                            <select class="form-control" style="width: 100%;" name="status" id="status" required>
                                <option value=""> <?php echo xlt("Select Status") ?> </option>
                                <option value="Awaiting"> <?php echo xlt("Awaiting") ?> </option>
                                <option value="Completed"> <?php echo xlt("Completed") ?> </option>
                                <option value="Canceled"> <?php echo xlt("Canceled") ?> </option>
                            </select>
                        </div>

                        <!-- surgery part -->
                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt("Category") ?> </label>
                            <select class="form-control" style="width: 100%;" name="pc_title" id="pc_title">
                                <option value="No Show"> <?php echo xlt("No Show") ?> </option>
                                <option value="Office Visit"> <?php echo xlt("Office Visit") ?> </option>
                                <option value="Established Patient"> <?php echo xlt("Established Patient") ?> </option>
                                <option value="New Patient"> <?php echo xlt("New Patient") ?> </option>
                                <option value="Health and Behavioral Assessment"> <?php echo xlt("Health and Behavioral Assessment") ?> </option>
                                <option value="Preventive Care Services"> <?php echo xlt("Preventive Care Services") ?> </option>
                                <option value="Ophthalmological Services"> <?php echo xlt("Ophthalmological Services") ?> </option>
                                <option value="Surgical Appointment "> <?php echo xlt("Surgical Appointment") ?> </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="pc_hometext"><?php echo xlt("Comment") ?></label>
                            <input type="text" class="form-control" name="pc_hometext" id="pc_hometext">
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt("Close") ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo xlt("Save") ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- delete surgery -->
    <div class="modal fade" id="deleteSurgeryModal" tabindex="-1" aria-labelledby="deleteSurgeryModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSurgeryModal">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete Suregery Schedule?</p>

                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deleteId" id="deleteId" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <script defer>
        window.onload = function() {
            $(".surgery_updateBtn").click(function() {
                var code = $(this).data('code');
                var surgery_id = $(this).data('surgery_id');
                var procedure_id = $(this).data('procedure_id');
                var start_date = $(this).data('start_date');
                var end_date = $(this).data('end_date');
                var status = $(this).data('status');
                var theater_id = $(this).data('theater_id');

                console.log(surgery_id, procedure_id, name, start_date);

                $('input[name=code]').val(code);
                $('input[name=surgery_id]').val(surgery_id);
                $('select[name=procedure_id]').val(procedure_id);
                $('input[name=start_date]').val(start_date);
                $('input[name=end_date]').val(end_date);
                $('select[name=status]').val(status);
                $('select[name=theater_id]').val(theater_id);
            });

            $(".new_surgeryBtn").click(function() {
                var admission_id = $(this).data('admission_id');
                var pid = $(this).data('pid');
                $('#surg_admission_id').val(admission_id);
                $('#surg_pid').val(pid);
            });


            $(".surgery_deleteBtn").click(function() {
                var surgery_id = $(this).data('surgery_id');
                $('#deleteId').val(surgery_id);
            });

            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);
            
        };
    </script>
    <?php include_once "./components/footer.php"; ?>