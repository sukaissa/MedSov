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

use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\CSSDServiceQuery;


require_once "../../../../globals.php";
require_once "./components/sql/AuthQuery.php";
require_once "./components/sql/CSSDServiceQuery.php";

$authQuery = new AuthQuery();
$cssd = new CSSDServiceQuery();

$providers = $authQuery->getUsers();
$getCssd = $cssd->getCSSDService();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    //$surgery = $surgeryQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');

} elseif (isset($_POST['new_service']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'service_name' => $_POST['service_name'],
        'supervisor' => $_POST['supervisor'],
        'availability_status' => $_POST['availability_status'],
        'created_by' => $user['fname'],
    ];
    $cssd->insertCSSDService($data);
    header('location:CSSDService.php?status=success&message=CSSD Service Added Successfully');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'service_name' => $_POST['service_name'],
        'supervisor' => $_POST['supervisor'],
        'availability_status' => $_POST['availability_status'],
    ];
    $cssd->updateCSSDService($data);
    header('location:CSSDService.php?status=success&message=CSSD Service Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $cssd->destroyCSSDService($_POST['deleteId']);
    header('location:CSSDService.php?status=success&message=CSSD Service Deleted Successfully');
    // header('Refresh:0');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once(__DIR__ . "/include_files.php"); ?>
    
    <title> <?php echo xlt('CSSD Service') ?> </title>

</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <section class="main-containerx" style="flex-direction: column;">
        <div class="left-con">

            <div class="search_container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: flex;">
                    <input type="text" class="form-control" name="search" id="search" placeholder="search...">
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px;"> <?php echo xlt('Search') ?> </button>
                </form>
            </div>

            <?php if ($display_mesasge == 'block') { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    <strong><?php echo xlt('Success') ?>!</strong> <?php echo $message; ?>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>


            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <h4 class="section-head"><?php echo xlt('CSSD Service') ?></h4>
                <button type="button" class="btn new_surgeryBtn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#addModal">
                    <?php echo xlt('New Service') ?>
                </button>
            </div>


            <table>
                <tr>
                    <th><?php echo xlt('Service Name') ?></th>
                    <th><?php echo xlt('Supervisor Name') ?></th>
                    <th><?php echo xlt('Available') ?></th>
                    <th><?php echo xlt('Actions') ?></th>
                </tr>

                <?php foreach ($getCssd as $data) {
                ?>
                    <tr>
                        <td><?php echo $data['service_name']; ?></td>
                        <td><?php echo $data['supervisor']; ?></td>
                        <td><?php echo $data['availability_status']; ?></td>
                        <td style="display: flex;">
                            <button type="button" class="btn btn-primary updateBtn" style="" data-toggle="modal" data-target="#cssdModal" data-id="<?php echo $data['id']; ?>" data-service_name="<?php echo $data['service_name']; ?>" data-supervisor="<?php echo $data['supervisor']; ?>" data-availability_status="<?php echo $data['availability_status']; ?>">
                                <?php echo xlt('Update') ?>
                            </button>

                            <button type="button " class="btn btn-danger deleteBtn" style="" data-toggle="modal" data-target="#deleteBedModal" data-service_id="<?php echo $data['id']; ?>">
                                <?php echo xlt('Delete') ?>
                            </button>

                        </td>

                    </tr>
                <?php
                } ?>
            </table>

        </div>

    </section>

    <!-- cssd service-->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wardModal"><?php echo xlt('CSSD Service') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="new_service" id="new_service" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Service Name') ?></label>
                            <input type="text" class="form-control" name="service_name">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Service Supervisor') ?></label>
                            <select class="form-control" id="supervisor" name="supervisor">
                                <option value=""><?php echo xlt('Select Case Doctor') ?></option>
                                <?php foreach ($providers as $user) { ?>
                                    <option value="<?php echo $user['fname'] . " " . $user['lname']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?> </option>
                                <?php
                                }  ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Availability Status') ?></label>
                            <select class="form-control" style="width: 100%;" name="availability_status">
                                <option value=""> <?php echo xlt('Select Status') ?> </option>
                                <option value="Active"><?php echo xlt('Active') ?></option>
                                <option value="Inactive"><?php echo xlt('Inactive') ?></option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo xlt('Save') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- edit cssd -->
    <div class="modal fade" id="cssdModal" tabindex="-1" aria-labelledby="cssdModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cssdModal"><?php echo xlt('Update CSSD Service') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="id" name="id" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Servive Name') ?></label>
                            <input type="text" class="form-control" id="service_name" name="service_name">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Supervisor') ?></label>
                            <input type="text" class="form-control" id="supervisor" name="supervisor">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Availability Status') ?></label>
                            <select class="form-control" style="width: 100%;" name="availability_status" id="availability_status">
                                <option value="Active"><?php echo xlt('Active') ?></option>
                                <option value="Inactive"><?php echo xlt('Inactive') ?></option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                            <button type="submit" class="btn btn-primary"><?php echo xlt('Save') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal fade" id="deleteBedModal" tabindex="-1" aria-labelledby="deleteBedModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBedModal"><?php echo xlt('Confirm Delete') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo xlt('Are you sure you want to delete bed?') ?></p>

                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deleteId" id="deleteId" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                            <button type="submit" class="btn btn-danger"><?php echo xlt('Delete') ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <script defer>
        window.onload = function() {
            $(".updateBtn").click(function() {
                var id = $(this).data('id');
                var service_name = $(this).data('service_name');
                var supervisor = $(this).data('supervisor');
                var availability_status = $(this).data('availability_status');

                $('#id').val(id);
                $('#service_name').val(service_name);
                $('#supervisor').val(supervisor);
                $('#availability_status').val(availability_status);
            });

            $(".deleteBtn").click(function() {
                var service_id = $(this).data('service_id');
                $('#deleteId').val(service_id);
            });

            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);
        };
    </script>





    <?php include_once "./components/footer.php"; ?>