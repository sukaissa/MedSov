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
use OpenEMR\Modules\InpatientModule\CSSDServiceQuery;
use OpenEMR\Modules\InpatientModule\TreatmentQuery;
use OpenEMR\Modules\InpatientModule\MemberQuery;
use OpenEMR\Modules\InpatientModule\SurgeryQuery;

require_once "../../../../../globals.php";
require_once "../components/sql/AuthQuery.php";
require_once "../components/sql/CSSDServiceQuery.php";
require_once "../components/sql/TreatmentQuery.php";
require_once "../components/sql/MemberQuery.php";
require_once "../components/sql/SurgeryQuery.php";

$authQuery = new AuthQuery();
$treatmentQuery = new TreatmentQuery();
$memberQuery = new MemberQuery();
$surgeryQuery = new SurgeryQuery();
$cssdRequests = new CSSDServiceQuery();

$admission_id = $_GET['admission_id'];
$patient_id = $_GET['patient_id'];
$ward_id  = $_GET['ward_id'];
$bed_id = $_GET['bed_id'];

$patientSurgery = $surgeryQuery->getPatientSurgery($admission_id, $patient_id);
$users = $authQuery->getUsers();
$memebrs = $memberQuery->getMembers($patientSurgery['id']);
$externalMemebrs = $memberQuery->getExternalMembers($patientSurgery['id']);
$instruments = $cssdRequests->getCSSDServiceRequestSurgery($patientSurgery['id']);
$providers = $authQuery->getProviders();
$getCssdItem = $cssdRequests->getCSSDServiceItem();
$getCssd = $cssdRequests->getCSSDService();


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
        'active' => false,
        'url' => '__food_requests.php'
    ],
    [
        'id' => 20,
        'name' => "Surgery",
        'active' => true,
        'url' => '__surgery.php'
    ],
];


if (isset($_POST['new_member']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['admission_id'],
        'surgery_id' => $_POST['surgery_id'],
        'employee_id' => $_POST['employee_id'],
        'role' => $_POST['role'],
    ];
    $memberQuery->insertMember($data);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['new_external_member']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['admission_id'],
        'surgery_id' => $_POST['surgery_id'],
        'username' => $_POST['username'],
        'role' => $_POST['role'],
    ];
    $memberQuery->insertExternalMember($data);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['new_service_request']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'surgery_id' => $_POST['surgery_id'],
        'service_id' => $_POST['service_id'],
        'item_id' => $_POST['item_id'],
        'department_id' => 1,
        'department_id' => 1,
        'quantity' => $_POST['quantity'],
        'request_date' => $_POST['request_date'],
        'request_by' => $_POST['request_by'],
        'status' => $_POST['status'],
        'request_processed_date' =>     1,
        'request_processed_by' => 1,
        'quantity_returned' => 1,
        'receipt_date' => $_POST['receipt_date'],
        'received_by' => $_POST['received_by'],
        'created_by' => 1
    ];
    $cssdRequests->insertCSSDServiceRequest($data);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['update_member']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['admission_id'],
        'surgery_id' => $_POST['surgery_id'],
        'employee_id' => $_POST['employee_id'],
        'role' => $_POST['role'],
    ];
    $memberQuery->updateMember($data, $_POST['member_id']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['update_external_member']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['admission_id'],
        'surgery_id' => $_POST['surgery_id'],
        'name' => $_POST['name'],
        'role' => $_POST['role'],
    ];
    $memberQuery->updateExternalMember($data, $_POST['member_id']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['update_instrument']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'admission_id' => $_POST['admission_id'],
        'surgery_id' => $_POST['surgery_id'],
        'name' => $_POST['name'],
        'quantity' => $_POST['quantity'],
    ];
    $memberQuery->updateInstrument($data, $_POST['instrument_id']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['delete_member']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $memberQuery->deleteMember($_POST['member_id']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['delete_external_member']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $memberQuery->deleteExternalMember($_POST['member_id']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['delete_instrument']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $memberQuery->deleteInstrument($_POST['instrument_id']);
    header("location:" . pathinfo(__FILE__, PATHINFO_FILENAME) . ".php?$_SERVER[QUERY_STRING]");
} elseif (isset($_POST['delete_surgery']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $surgeryQuery->deleteSurgery($_POST['surgery_id']);
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
    <title>Patient Dashboard - Surgery</title>

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
                <!-- <h1>Surgery</h1> -->
                <!-- <a href="#" style="margin-left: 10px;" class="btn-md btn btn-primary trackerBtn" data-toggle="modal" data-target="#newFoodRequest" data-pid="<?php echo $patient_id; ?>" data-admission_id="<?php echo $admission_id; ?>">
                        New Entry
                    </a> -->
            </div>


            <div>
                <h3><?php echo "$patientSurgery[fname] $patientSurgery[mname] $patientSurgery[lname]" ?></h3>

                <div style="display: flex;">
                    <p style="width: 30%; "> <span style="font-weight: bold;">Procedure </span> : <?php echo "$patientSurgery[name]" ?></p>
                    <p style="width: 30%; "> <span style="font-weight: bold;">Theater </span> : <?php echo "$patientSurgery[theater_name]" ?></p>
                    <p style="width: 30%; "> <span style="font-weight: bold;">Date </span> : <?php echo "$patientSurgery[created_at]" ?></p>
                </div>


                <div style="display: flex;">
                    <p style="margin-right: 10px; font-weight: bold;"> Status</p>
                    <p><?php echo "$patientSurgery[status]" ?></p>
                    <!-- <select class="form-control" style="width: 100%;" name="status" id="status">
                            <option value="">Select Status</option>
                            <option value="Awaiting">Awaiting</option>
                            <option value="Completed">Completed</option>
                            <option value="Canceled">Canceled</option>
                        </select> -->
                </div>
            </div>


            <div style="display: flex; border-top: 1px solid gray; padding-top: 30px;">
                <section style="width: 30%; margin-right: 10px; border-right: 1px solid black; padding: 3px;">
                    <div style="display: flex; justify-content: space-between;">
                        <h5>Surgical Members</h5>

                        <a href="#" style="margin-left: 10px;" class="btn-md btn btn-primary trackerBtn" data-toggle="modal" data-target="#newMember" data-surgery_id="<?php echo $patientSurgery['id']; ?>" data-admission_id="<?php echo $admission_id; ?>">
                            Add
                        </a>

                    </div>

                    <div>
                        <?php
                        foreach ($memebrs as $member) {
                        ?>
                            <p><?php echo "$member[fname] $member[mname] $member[lname]" ?></p>
                        <?php
                        }
                        ?>
                    </div>
                </section>

                <section style="width: 30%; margin-right: 10px; border-right: 1px solid black; padding: 3px;">
                    <div style="display: flex; justify-content: space-between;">
                        <h5>External Surgical Members</h5>
                        <a href="#" style="margin-left: 10px;" class="btn-md btn btn-primary trackerBtn" data-toggle="modal" data-target="#newMemberExternal" data-surgery_id="<?php echo $patientSurgery['id']; ?>" data-admission_id="<?php echo $admission_id; ?>">
                            Add
                        </a>
                    </div>

                    <div>
                        <?php
                        foreach ($externalMemebrs as $externalMember) {
                        ?>
                            <p><?php echo $externalMember['username'] ?></p>
                        <?php
                        }
                        ?>
                    </div>
                </section>

                <section style="width: 30%; padding: 3px;">
                    <div style="display: flex; justify-content: space-between;">
                        <h5>Request for Instrument</h5>
                        <a href="#" style="margin-left: 10px;" class="btn-md btn btn-primary trackerBtn" data-toggle="modal" data-target="#instrumentRequest" data-surgery_id="<?php echo $patientSurgery['id']; ?>" data-admission_id="<?php echo $admission_id; ?>">
                            Request
                        </a>
                    </div>

                    <div>
                        <?php
                        foreach ($instruments as $instrument) {
                        ?>
                            <p><?php echo $instrument['service_name'] ?></p>
                        <?php
                        }
                        ?>
                    </div>
                </section>
            </div>


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
                    <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="admission_id" id="food_admission_id" value="">
                        <input type="hidden" name="food_req_new" id="food_req_new" value="">
                        <input type="hidden" name="pid" id="food_req_pid" value="">

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

    <!-- cssd item request-->
    <div class="modal fade" id="instrumentRequest" tabindex="-1" aria-labelledby="instrumentRequest" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="instrumentRequest">CSSD Service Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='POST'>
                        <input type="hidden" name="new_service_request" id="new_service_request" value="">
                        <input type="hidden" name="surgery_id" value="<?php echo $patientSurgery['id']; ?>">

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Service Name</label>
                            <select class="form-control" style="width: 100%;" name="service_id" id="service_id">
                                <?php foreach ($getCssd as $Cssd_name) { ?>
                                    <option value="<?php echo $Cssd_name['id'] ?>"><?php echo $Cssd_name['service_name'] ?></option>

                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Item Name</label>
                            <select class="form-control" style="width: 100%;" name="item_id" id="item_id">
                                <option value="">Select Service</option>
                                <?php foreach ($getCssdItem as $Cssd_item) { ?>
                                    <option value="<?php echo $Cssd_item['id'] ?>"><?php echo $Cssd_item['service_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Request Date</label>
                            <input type="date" class="form-control" id="request_date" name="request_date">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Request By</label>
                            <select class="form-control" style="width: 100%;" id="request_by" name="request_by">
                                <option value="">Request By </option>
                                <?php foreach ($providers as $provider) { ?>
                                    <option value="<?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?>"><?php echo $provider['fname'] . " " . $provider['mname'] . " " . $provider['lname'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2">Request Status</label>
                            <select class="form-control" style="width: 100%;" name="status" id="status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                            <label for="formGroupExampleInput2">Request Processed Date</label>
                            <input type="date" class="form-control" id="request_processed_date" name="request_processed_date">
                        </div> -->


                        <!-- <div class="form-group">
                            <label for="formGroupExampleInput2">Request Processed By</label>
                            <select class="form-control" style="width: 100%;" id="request_processed_by" name="request_processed_by">
                                <option value="">Request Processed By </option>
                                <?php foreach ($providers as $provider) { ?>
                                    <option value="<?php echo $provider['fname'] ?>"><?php echo $provider['fname'] ?> <?php echo $provider['lname'] ?></option>
                                <?php } ?>
                            </select>
                        </div> -->


                        <!-- <div class="form-group">
                            <label for="formGroupExampleInput2">Quantity Returned</label>
                            <input type="number" class="form-control" id="quantity_returned" name="quantity_returned">
                        </div> -->

                        <div class="form-group">
                            <label for="formGroupExampleInput2">receipt Date</label>
                            <input type="date" class="form-control" id="receipt_date" name="receipt_date">
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput2">receipt By</label>
                            <input type="text" class="form-control" id="received_by" name="received_by">
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



    <?php include_once "../components/modals/surgery/new_member.php"; ?>
    <?php include_once "../components/modals/surgery/new_member_external.php"; ?>

    <script>
        window.onload = function() {
            // hide alert
            setTimeout(function() {
                $('#alert').hide();
            }, 3000);
        };
    </script>

    <?php include_once "../components/footer.php"; ?>