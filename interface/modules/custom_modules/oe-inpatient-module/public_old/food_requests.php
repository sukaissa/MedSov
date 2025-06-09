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
use OpenEMR\Modules\InpatientModule\FoodQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;

require_once "../../../../globals.php";
require_once "./components/sql/AuthQuery.php";
require_once "./components/sql/FoodQuery.php";
require_once "./components/sql/InpatientQuery.php";

$authQuery = new AuthQuery();
$foodQuery = new FoodQuery();
$inpatientQuery = new InpatientQuery();

$patients = $inpatientQuery->getInpatients();
$foodRequests = $foodQuery->getFoodRequests();
$foodItems = $foodQuery->getMenuItems();
$users = $authQuery->getUsers();

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'patient' => $_POST['patient'],
        'food' => $_POST['food'],
        'staff' => $_POST['staff'],
        'requested_date' => $_POST['requested_date'],
        'admission_id' => 0,
    ];
    $foodQuery->insertFoodRequest($data);
    header('Refresh:0');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'patient' => $_POST['patient'],
        'food' => $_POST['food'],
        'staff' => $_POST['staff'],
        'requested_date' => $_POST['requested_date'],
    ];
    $foodQuery->updateFoodRequest($data);
    header('Refresh:0');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->destroyFoodItem($_POST['deleteId']);
    header('Refresh:0');
} elseif (isset($_POST['deliver_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->deliverFood($_POST['deliver_id']);
    header('Refresh:0');
} elseif (isset($_POST['cancel_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->cancelFood($_POST['cancel_id']);
    header('Refresh:0');
} elseif (isset($_POST['search']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $search = $_POST['search'];
    $admissionsQueue = $admissionQueuQuery->searchAdmissionQueue($search);
    header('Refresh:0');
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
    <title><?php echo xlt("Inpatient - Meal Request") ?> </title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">
    <div style="margin-top: 25px;">
        <a href="./inpatient.php"><?php echo xlt("Back") ?></a>
        <p></p>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; margin-top: 50px;">
        <h4 class="section-head"><?php echo xlt('Meal Request') ?></h4>
        <button type="button" class="btn btn-primary" style="" data-toggle="modal" data-target="#newFoodRequest">
            <?php echo xlt('Meal Request') ?>
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col"><?php echo xlt('Patient') ?></th>
                <th scope="col"><?php echo xlt('Meal Types') ?></th>
                <th scope="col"><?php echo xlt('Meal') ?></th>
                <th scope="col"><?php echo xlt('Status') ?></th>
                <th scope="col"><?php echo xlt('User') ?></th>
                <th scope="col"><?php echo xlt('Date') ?></th>
                <th scope="col"><?php echo xlt('Action') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($foodRequests as $key => $value) { ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value['fname'] . " " . $value['mname'] . " " . $value['lname']; ?></td>
                    <td><?php echo $value['category']; ?></td>
                    <td><?php echo $value['food_name']; ?></td>
                    <td><?php echo $value['status']; ?></td>
                    <td><?php echo $value['username']; ?></td>
                    <td><?php echo $value['requested_date']; ?></td>
                    <td>
                        <!-- <a href="#" class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateItem" data-id="<?php echo $value['id']; ?>" data-username="<?php echo $value['username']; ?>" data-status="<?php echo $value['status']; ?>" data-patient_id="<?php echo $value['patient_id']; ?>" data-category="<?php echo $value['category']; ?>">Delivered</a> -->
                        <a href="#" class="btn btn-primary deliverBtn" data-toggle="modal" data-target="#deliveredFood" data-id="<?php echo $value['id']; ?>"><?php echo xlt('Delivered') ?></a>
                        <a href="#" class="btn btn-danger cancelBtn" data-toggle="modal" data-target="#cancelFood" data-id="<?php echo $value['id']; ?>"><?php echo xlt('Cancel') ?></a>
                        <!-- <a href="#" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#itemDelete" data-id="<?php echo $value['id']; ?>">Cancel</a> -->
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <!-- new Modal -->
    <div class="modal fade" id="newFoodRequest" tabindex="-1" aria-labelledby="newFoodRequest" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo xlt("New Meal Request") ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="new" value="new">

                        <div class="form-group">
                            <label for="patient"><?php echo xlt("Patient") ?> </label>
                            <select class="form-control" name="patient" id="patient_new">
                                <option value=""><?php echo xlt("Select patient") ?> </option>
                                <?php foreach ($patients as $patient) { ?>
                                    <option value="<?php echo $patient['patient_id']; ?>"><?php echo $patient['fname'] . " " . $patient['mname'] . " " . $patient['lname']; ?> | <?php echo $patient['ward_name']; ?> | <?php echo "Bed - " . $patient['bed_number']; ?></option>
                                <?php
                                }  ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="food"><?php echo xlt("Meal") ?> </label>
                            <select class="form-control" id="food" name="food">
                                <option value=""><?php echo xlt("Select food") ?> </option>
                                <?php foreach ($foodItems as $food) { ?>
                                    <option value="<?php echo $food['id']; ?>"><?php echo $food['category']; ?> | <?php echo $food['price']; ?> | <?php echo $food['name']; ?></option>
                                <?php
                                }  ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="staff"> <?php echo xlt("Staff") ?> </label>
                            <select class="form-control" name="staff" id="staff">
                                <option value=""> <?php echo xlt("Select Staff") ?> </option>
                                <?php foreach ($users as $user) { ?>
                                    <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?></option>
                                <?php
                                }  ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="requested_date"> <?php echo xlt("Request Date") ?> </label>
                            <input type="datetime-local" class="form-control" name="requested_date">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> <?php echo xlt("Close") ?> </button>
                            <button type="submit" class="btn btn-primary"> <?php echo xlt("Save") ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- delivered -->
    <div class="modal fade" id="deliveredFood" tabindex="-1" aria-labelledby="deliveredFood" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBedModal"> <?php echo xlt('Confirm Delivery') ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> <?php echo xlt('Are you sure this food item has been delivered?') ?> </p>
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deliver_id" id="deliver_id" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                            <button type="submit" class="btn btn-danger"><?php echo xlt('Yes') ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- cancel -->
    <div class="modal fade" id="cancelFood" tabindex="-1" aria-labelledby="cancelFood" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBedModal"><?php echo xlt('Confirm Cancel') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo xlt('Are you sure you want to cancel this request?') ?></p>
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="cancel_id" id="cancel_id" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                            <button type="submit" class="btn btn-danger"><?php echo xlt('Yes') ?></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- delete -->
    <div class="modal fade" id="deleteAdmission" tabindex="-1" aria-labelledby="deleteAdmission" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBedModal"> <?php echo xlt('Confirm Delete') ?> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p> <?php echo xlt('Are you sure you want to delete queue?') ?> </p>
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
            $(".deliverBtn").click(function() {
                var id = $(this).data('id');
                $('#deliver_id').val(id);
            });

            $(".cancelBtn").click(function() {
                var id = $(this).data('id');
                $('#cancel_id').val(id);
            });

            $(".updateBtn").click(function() {
                var id = $(this).data('id');
                var ward = $(this).data('ward');
                var bed = $(this).data('bed');
                $('#id').val(id);
                $('#ward_update').val(ward);
                $('#bed').val(bed);
            });

            $(".deleteBtn").click(function() {
                var id = $(this).data('id');
                $('#deleteId').val(id);
            });

        };
    </script>
    <?php include_once "./components/footer.php"; ?>