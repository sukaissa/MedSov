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
use OpenEMR\Modules\InpatientModule\TreatmentQuery;

require_once "../../../../../globals.php";
require_once "../components/sql/AuthQuery.php";
require_once "../components/sql/FoodQuery.php";
require_once "../components/sql/TreatmentQuery.php";

$authQuery = new AuthQuery();
$treatmentQuery = new TreatmentQuery();
$foodQuery = new FoodQuery();

$admission_id = $_GET['admission_id'];
$patient_id = $_GET['patient_id'];
$ward_id  = $_GET['ward_id'];
$bed_id = $_GET['bed_id'];

$foodRequests = $foodQuery->getPatientFoodRequests($admission_id, $patient_id);
$foodItems = $foodQuery->getMenuItems();
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
        'active' => true,
        'url' => '__food_requests.php'
    ],

];


if (isset($_POST['food_req_new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $admission_id,
        'patient' => $patient_id,
        'food' => $_POST['food'],
        'staff' => $_POST['staff'],
        'requested_date' => $_POST['requested_date'],
    ];
    $foodQuery->insertFoodRequest($data);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'patient' => $_POST['patient'],
        'food' => $_POST['food'],
        'staff' => $_POST['staff'],
        'requested_date' => $_POST['requested_date'],
    ];
    $foodQuery->updateFoodRequest($data);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->destroyFoodItem($_POST['deleteId']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['deliver_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->deliverFood($_POST['deliver_id']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['cancel_id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $foodQuery->cancelFood($_POST['cancel_id']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['search']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $search = $_POST['search'];
    $admissionsQueue = $admissionQueuQuery->searchAdmissionQueue($search);
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
    <title>Patient Dashboard - Meal Requests</title>

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
                <h1>Meal Requests</h1>
                <a href="#" style="margin-left: 10px; background-color: #40E0D0;" class="btn-md btn trackerBtn" data-toggle="modal" data-target="#newFoodRequest" data-pid="<?php echo $patient_id; ?>" data-admission_id="<?php echo $admission_id; ?>">
                    New Entry
                </a>
            </div>

            <!-- table to loop over management plan -->
            <table>
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Meal Types</th>
                        <th scope="col">Meal</th>
                        <th scope="col">Status</th>
                        <th scope="col">User</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foodRequests as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $value['category']; ?></td>
                            <td><?php echo $value['food_name']; ?></td>
                            <td><?php echo $value['status']; ?></td>
                            <td><?php echo $value['username']; ?></td>
                            <td><?php echo $value['requested_date']; ?></td>
                            <td>
                                <!-- <a href="#" class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateItem" data-id="<?php echo $value['id']; ?>" data-username="<?php echo $value['username']; ?>" data-status="<?php echo $value['status']; ?>" data-patient_id="<?php echo $value['patient_id']; ?>" data-category="<?php echo $value['category']; ?>">Delivered</a> -->
                                <a href="#" class="btn btn-primary deliverBtn" data-toggle="modal" data-target="#deliveredFood" data-id="<?php echo $value['id']; ?>">Delivered</a>
                                <a href="#" class="btn btn-danger cancelBtn" data-toggle="modal" data-target="#cancelFood" data-id="<?php echo $value['id']; ?>">Cancel</a>
                                <!-- <a href="#" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#itemDelete" data-id="<?php echo $value['id']; ?>">Cancel</a> -->
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>



    <!-- new Modal -->
    <div class="modal fade" id="newFoodRequest" tabindex="-1" aria-labelledby="newFoodRequest" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST'>
                        <input type="hidden" name="food_req_new" id="food_req_new" value="">

                        <div class="form-group">
                            <label for="food">Meal</label>
                            <select class="form-control" id="food" name="food">
                                <option value="">Select food</option>
                                <?php foreach ($foodItems as $food) { ?>
                                    <option value="<?php echo $food['id']; ?>"><?php echo $food['category']; ?> | <?php echo $food['price']; ?> | <?php echo $food['name']; ?></option>
                                <?php
                                }  ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="staff">Staff</label>
                            <select class="form-control" name="staff" id="staff">
                                <option value="">Select Staff</option>
                                <?php foreach ($users as $user) { ?>
                                    <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?></option>
                                <?php
                                }  ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="requested_date">Request Date</label>
                            <input type="datetime-local" class="form-control" name="requested_date">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- update -->
    <div class="modal fade" id="updateAdmission" tabindex="-1" aria-labelledby="updateAdmission" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Admission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST'>
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label for="ward">Ward</label>
                            <select class="form-control" id="ward_update" name="ward">
                                <option value="">Select Ward</option>
                                <?php foreach ($wards as $ward) { ?>
                                    <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name']; ?> - <?php echo $ward['name']; ?></option>
                                <?php
                                }  ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Bed</label>
                            <select class="form-control" id="bed" name="bed">
                                <option value="">Select Bed</option>
                                <?php foreach ($beds as $bed) { ?>
                                    <option value="<?php echo $bed['id']; ?>"><?php echo $bed['number']; ?> - <?php echo $bed['type_name']; ?> - <?php echo $bed['price_per_day']; ?></option>
                                <?php
                                }  ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">OPD Case Doctor</label>
                            <select class="form-control" id="doctor" name="doctor">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Assigned Nurse</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Assigned User</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Staff</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Status</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Admission Date</label>
                            <input type="date" class="form-control" id="formGroupExampleInput2">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
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
                    <h5 class="modal-title" id="deleteBedModal">Confirm Delivery</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure this food item has been delivered?</p>
                    <form method='POST'>
                        <input type="hidden" name="deliver_id" id="deliver_id" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
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
                    <h5 class="modal-title" id="deleteBedModal">Confirm Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel this request?</p>
                    <form method='POST'>
                        <input type="hidden" name="cancel_id" id="cancel_id" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes</button>
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
                    <h5 class="modal-title" id="deleteBedModal">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete queue?</p>
                    <form method='POST'>
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

    <script>
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



            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);

        };
    </script>

    <?php include_once "../components/footer.php"; ?>