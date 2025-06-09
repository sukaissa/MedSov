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


$providers = $authQuery->getProviders();
$getCssd = $cssd->getCSSDService();
$getCssdItem = $cssd->getCSSDServiceItem();
$getCssdRequest = $cssd->getCSSDServiceRequest();


$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    //$surgery = $surgeryQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');

} elseif (isset($_POST['new_service_request']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'service_id' => $_POST['service_id'],
        'item_id' => $_POST['item_id'],
        'surgery_id' => 1,
        // 'department_id' => $_POST['department_id'],
        'quantity' => $_POST['quantity'],
        'request_date' => $_POST['request_date'],
        'request_by' => $_POST['request_by'],
        'status' => "Pending",
        'request_processed_date' => $_POST['request_processed_date'],
        'request_processed_by' => $_POST['request_processed_by'],
        'quantity_returned' => $_POST['quantity_returned'],
        'receipt_date' => $_POST['receipt_date'],
        'received_by' => $_POST['received_by'],
    ];
    $cssd->insertCSSDServiceRequest($data);
    header('location:CSSDServiceRequest.php?status=success&message=CSSD Service Requested  Successfully');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'service_id' => $_POST['service_id'],
        'item_id' => $_POST['item_id'],
        // 'department_id' => $_POST['department_id'],
        'quantity' => $_POST['quantity'],
        'request_date' => $_POST['request_date'],
        'request_by' => $_POST['request_by'],
        'status' => $_POST['status'],
        'request_processed_date' => $_POST['request_processed_date'],
        'request_processed_by' => $_POST['request_processed_by'],
        'quantity_returned' => $_POST['quantity_returned'],
        'receipt_date' => $_POST['receipt_date'],
        'received_by' => $_POST['received_by'],
    ];

    $cssd->updateCSSDServiceRequest($data);
    header('location:CSSDServiceRequest.php?status=success&message=CSSD Service Request Updated Successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $cssd->destroyCSSDServiceRequest($_POST['deleteId']);
    header('location:CSSDServiceRequest.php?status=success&message=CSSD Service Request Deleted Successfully');
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
    <title><?php echo xlt('CSSD Service Request') ?></title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script> -->

</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <section class="main-containerx" style="flex-direction: column;">
        <div class="left-con">

            <div class="search_container">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: flex;">
                    <input type="text" class="form-control" name="search" id="search" placeholder="search...">
                    <button type="submit" class="btn btn-primary" style="margin-left: 20px;"><?php echo xlt('Search') ?></button>
                </form>
            </div>

            <?php if ($display_mesasge == 'block') { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
                    <strong><?php echo xlt('Success') ?>!</strong> <?php echo $message; ?>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>


            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <h4 class="section-head"><?php echo xlt('CSSD Service Request') ?></h4>
                <button type="button" class="btn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#addModal">
                    <?php echo xlt('New Service Request') ?>
                </button>
            </div>


            <table>
                <tr>
                    <th><?php echo xlt('Service Name') ?></th>
                    <th><?php echo xlt('Item') ?></th>
                    <th><?php echo xlt('Quantity') ?></th>
                    <th><?php echo xlt('Request Date') ?></th>
                    <th><?php echo xlt('Request By') ?></th>
                    <th><?php echo xlt('Status') ?></th>
                    <th><?php echo xlt('Processed Date') ?></th>
                    <th><?php echo xlt('Processed By') ?></th>
                    <th><?php echo xlt('Received By') ?></th>
                    <th><?php echo xlt('Actions') ?></th>
                </tr>

                <?php foreach ($getCssdRequest as $request) {
                ?>
                    <tr>
                        <td><?php echo $request['service_name']; ?></td>
                        <td><?php echo $request['item_name']; ?></td>
                        <td><?php echo $request['quantity']; ?></td>
                        <td><?php echo $request['request_date']; ?></td>
                        <td><?php echo $request['request_by']; ?></td>
                        <td><?php echo $request['status']; ?></td>
                        <td><?php echo $request['request_processed_date']; ?></td>
                        <td><?php echo $request['request_processed_by']; ?></td>
                        <td><?php echo $request['received_by']; ?></td>

                        <td style="display: flex;">
                            <button type="button" class="btn btn-primary updateBtn" style="margin-right: 5px;" data-toggle="modal" data-target="#bedModal" data-id="<?php echo $request['id']; ?>" data-service_name="<?php echo $request['service_name']; ?>" data-item_name="<?php echo $request['service_name']; ?> " data-quantity="<?php echo $request['quantity']; ?>" data-request_date="<?php echo $request['request_date']; ?>" data-request_by="<?php echo $request['request_by']; ?>" data-status="<?php echo $request['status']; ?>" data-request_processed_date="<?php echo $request['request_processed_date']; ?>" data-request_processed_by="<?php echo $request['request_processed_by']; ?>" data-quantity_returned="<?php echo $request['quantity_returned']; ?>" data-receipt_date="<?php echo $request['receipt_date']; ?>" data-received_by="<?php echo $request['received_by']; ?>">
                                <?php echo xlt('Update') ?>
                            </button>

                            <button type="button " class="btn btn-danger deleteBtn" style="" data-toggle="modal" data-target="#deleteBedModal" data-request_id="<?php echo $request['id']; ?>">
                                <?php echo xlt('Delete') ?>
                            </button>

                        </td>

                    </tr>
                <?php
                } ?>
            </table>

        </div>

    </section>

    <!-- cssd item request-->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModal"><?php echo xlt('CSSD Service Request') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="new_service_request" id="new_service_request" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Service') ?></label>
                            <select class="form-control" style="width: 100%;" name="service_id" id="service_id">
                                <option value=""><?php echo xlt('Select Service') ?></option>
                                <?php foreach ($getCssd as $Cssd_name) { ?>
                                    <option value="<?php echo $Cssd_name['id'] ?>"><?php echo $Cssd_name['service_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Item') ?></label>
                            <select class="form-control" style="width: 100%;" name="item_id" id="item_id">
                                <option value=""><?php echo xlt('Select Item') ?></option>
                                <?php foreach ($getCssdItem as $Cssd_item) { ?>
                                    <option value="<?php echo $Cssd_item['id'] ?>"><?php echo $Cssd_item['item_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Quantity') ?></label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Request Date') ?></label>
                            <input type="date" class="form-control" id="request_date" name="request_date">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Request By') ?></label>
                            <select class="form-control" style="width: 100%;" id="request_by" name="request_by">
                                <option value=""><?php echo xlt('Request By') ?> </option>
                                <?php foreach ($providers as $provider) { ?>
                                    <option value="<?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?>"><?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Request Status') ?></label>
                            <select class="form-control" style="width: 100%;" name="status" id="status">
                                <option value="Active"><?php echo xlt('Active') ?></option>
                                <option value="Inactive"><?php echo xlt('Inactive') ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Request Processed Date') ?></label>
                            <input type="date" class="form-control" id="request_processed_date" name="request_processed_date">
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Request Processed By') ?></label>
                            <select class="form-control" style="width: 100%;" id="request_processed_by" name="request_processed_by">
                                <option value=""><?php echo xlt('Request Processed By') ?> </option>
                                <?php foreach ($providers as $provider) { ?>
                                    <option value="<?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?>"><?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Quantity Returned') ?></label>
                            <input type="number" class="form-control" id="quantity_returned" name="quantity_returned">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('receipt Date') ?></label>
                            <input type="date" class="form-control" id="receipt_date" name="receipt_date">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('receipt By') ?> </label>
                            <input type="text" class="form-control" id="received_by" name="received_by">
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


    <!-- edit cssd item  request-->
    <div class="modal fade" id="bedModal" tabindex="-1" aria-labelledby="bedModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bedModal"><?php echo xlt('Update CSSD Item Request') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="updated_by" name="updated_by" value="">

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Service') ?> </label>
                            <select class="form-control" style="width: 100%;" name="service_id" id="service_id">
                                <?php foreach ($getCssd as $Cssd_name) { ?>
                                    <option value="<?php echo $Cssd_name['id'] ?>"><?php echo $Cssd_name['service_name'] ?></option>

                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Success') ?>Item </label>
                            <select class="form-control" style="width: 100%;" name="item_id" id="item_id">
                                <?php foreach ($getCssdItem as $Cssd_item) { ?>
                                    <option value="<?php echo $Cssd_item['id'] ?>"><?php echo $Cssd_item['item_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Quantity') ?></label>
                            <input type="number" class="form-control" name="quantity" id="quantity_number" value="">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Request Date') ?></label>
                            <input type="date" class="form-control" name="request_date" id="request_date_dating">
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Request By') ?></label>
                            <select class="form-control" style="width: 100%;" name="request_by" id="request_by_by">
                                <?php foreach ($providers as $provider) { ?>
                                    <option value="<?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?>"><?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Status') ?></label>
                            <select class="form-control" style="width: 100%;" name="status" id="status_request">
                                <option value=""><?php echo xlt('Select Status') ?></option>
                                <option value="Pending"><?php echo xlt('Pending') ?></option>
                                <option value="Item Picked Up"><?php echo xlt('Item Picked Up') ?></option>
                                <option value="Item Returned"><?php echo xlt('Item Returned') ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"><?php echo xlt('Request Processed Date') ?></label>
                            <input type="date" class="form-control" name="request_processed_date" id="request_processed_date_date">
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Request Processed By') ?> </label>
                            <select class="form-control" style="width: 100%;" name="request_processed_by" id="request_processed_by_by">
                                <?php foreach ($providers as $provider) { ?>
                                    <option value="<?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?>"><?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Quantity Returned') ?> </label>
                            <input type="number" class="form-control" name="quantity_returned" id="quantity_returned_request">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('receipt Date') ?> </label>
                            <input type="date" class="form-control" name="receipt_date" id="receipt_date_request">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2"> <?php echo xlt('Receieved By') ?> </label>
                            <input type="text" class="form-control" name="received_by" id="received_by_by">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> <?php echo xlt('Close') ?> </button>
                            <button type="submit" class="btn btn-primary"> <?php echo xlt('Save') ?> </button>
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
                    <h5 class="modal-title" id="deleteBedModal"> <?php echo xlt('Confirm Delete') ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> <?php echo xlt('Are you sure you want to delete Request?') ?> </p>

                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deleteId" id="deleteId" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> <?php echo xlt('Close') ?> </button>
                            <button type="submit" class="btn btn-danger"> <?php echo xlt('Delete') ?> </button>
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
                var item_name = $(this).data('service_name');
                // var department_id = $(this).data('department_id');
                var quantity = $(this).data('quantity');
                var request_date = $(this).data('request_date');
                var request_by = $(this).data('request_by');
                var status = $(this).data('status');
                var request_processed_date = $(this).data('request_processed_date');
                var request_processed_by = $(this).data('request_processed_by');
                var quantity_returned = $(this).data('quantity_returned');
                var receipt_date = $(this).data('receipt_date');
                var received_by = $(this).data('received_by');

                $('#id').val(id);
                $('#service_name').val(service_name);
                $('#service_name').val(item_name);
                // $('#department_id').val(department_id);
                $('#quantity_number').val(quantity);
                $('#request_date_dating').val(request_date);
                $('#request_by_by').val(request_by);
                $('#status_request').val(status);
                $('#request_processed_date_date').val(request_processed_date);
                $('#request_processed_by_by').val(request_processed_by);
                $('#quantity_returned_request').val(quantity_returned);
                $('#receipt_date_request').val(receipt_date);
                $('#received_by_by').val(received_by);
            });

            $(".deleteBtn").click(function() {
                var request_id = $(this).data('request_id');
                $('#deleteId').val(request_id);
            });

            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);
        };
    </script>





    <?php include_once "./components/footer.php"; ?>