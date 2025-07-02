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

use OpenEMR\Modules\InpatientModule\AdmissionQueueQuery;
use OpenEMR\Modules\InpatientModule\AuthQuery;
use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;

require_once "../../../../globals.php";
require_once "./components/sql/AdmissionQueueQuery.php";
require_once "./components/sql/AuthQuery.php";
require_once "./components/sql/BedQuery.php";
require_once "./components/sql/InpatientQuery.php";
require_once "./components/sql/SurgeryQuery.php";
require_once "./components/sql/WardQuery.php";

$admissionQueuQuery = new AdmissionQueueQuery();
$authQuery = new AuthQuery();
$bedQuery = new BedQuery();
$inpatientQuery = new InpatientQuery();
$wardQuery = new WardQuery();
$surgeryQuery = new SurgeryQuery();

$admissionsQueue = [];
$beds = $bedQuery->getAvailableBeds();

$wards = $wardQuery->getWards();
$admissionsQueue = $admissionQueuQuery->getAdmissionQueue();
$dischargedPatients = $admissionQueuQuery->getDischargedPatients();
$providers = $authQuery->getProviders();
$users = $authQuery->getUsers();

$display_mesasge = 'none';
$display_err_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    // if status is success then display success message
    if ($_GET['status'] == 'success') {
        $message = $_GET['message'];
        $display_mesasge = 'block';
    } else {
        $message = $_GET['message'];
        $display_err_mesasge = 'block';
    }
}

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'patient_id' => $_POST['patient_id'],
        'ward_id' => $_POST['ward'],
        'bed_id' => $_POST['bed'],
        'opd_case_doctor_id' => $_POST['opd_case_doctor_id'],
        'assigned_nurse_id' => $_POST['assigned_nurse_id'],
        'assigned_provider' => $_POST['assigned_provider'],
        'admission_type' => $_POST['admission_type'],
        'status' => $_POST['status'],
    ];
    $admissionQueuQuery->insertAdmission($data);
    header('location:index.php?status=success&message=Entry added successfully');
    // header('Refresh:0');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $admissionQueuQuery->destroyAdmission($_POST['deleteId']);
    header('location:index.php?status=success&message=Entry Deleted successfully');
    // header('Refresh:0');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'ward_id' => $_POST['ward'],
        'bed_id' => $_POST['bed'],
        'opd_case_doctor_id' => $_POST['opd_case_doctor_id'],
        'assigned_nurse_id' => $_POST['assigned_nurse_id'],
        'assigned_provider' => $_POST['assigned_provider'],
        'admission_type' => $_POST['admission_type'],
    ];
    $admissionQueuQuery->updateAdmission($data);
    header('location:index.php?status=success&message=Updated successfully');
    // header('Refresh:0');
} elseif (isset($_POST['change_stat']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'status' => $_POST['status'],
        'id' => $_POST['inp_id'],
        'bed_id' => $_POST['bed_id'],
        'ward_id' => $_POST['ward_id'],
    ];
    // print_r($data);
    $res = $inpatientQuery->insertInpatient($data);
    // if bed is occupied display error message
    if ($res == 'bed_occupied') {
        header('location:index.php?status=error&message=Bed is occupied');
    } else {
        header('location:index.php?status=success&message=Patient Admitted successfully');
    }
    // header('location:index.php?status=success&message=Patient Admitted successfully');
    // header('Refresh:0');
} elseif (isset($_POST['search']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $search = $_POST['search'];
    $admissionsQueue = $admissionQueuQuery->searchAdmissionQueue($search);
}


// include_once "./components/head.php";
?>

<!-- check condition of display message -->
<?php if ($display_mesasge == 'block') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
        <strong> <?php echo xlt("Success") ?>!</strong> <?php echo $message; ?>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
    </div>
<?php } ?>

<!-- check condition of display message -->
<?php if ($display_err_mesasge == 'block') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert">
        <strong><?php echo xlt("Error") ?>!</strong> <?php echo $message; ?>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
    </div>
<?php } ?>

<section class="main-containerx" style="flex-direction: column;">
    
    <div class="left-con">

        <div class="search_container">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display: flex;">
                <input type="text" class="form-control" name="search" id="search" placeholder="search...">
                <button type="submit" class="btn btn-primary" style="margin-left: 20px;"> <?php echo xlt("Search") ?> </button>
            </form>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
            <h4 class="section-head"> <?php echo xlt("Admission Queue") ?> </h4>

            <!-- <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#newAdmission">
                New Admission
            </button> -->
        </div>


        <table>
            <tr>
                <th> <?php echo xlt("Name") ?> </th>
                <th> <?php echo xlt("Age") ?> </th>
                <th> <?php echo xlt("Gender") ?> </th>
                <th> <?php echo xlt("Ward") ?> </th>
                <th> <?php echo xlt("Bed") ?> </th>
                <th> <?php echo xlt("Action") ?> </th>
            </tr>

            <?php foreach ($admissionsQueue as $value) {
            ?>
                <tr>
                    <td><?php echo $value['fname']; ?> <?php echo $value['mname']; ?> <?php echo $value['lname']; ?></td>
                    <td><?php
                        $dateOfBirth = new DateTime($value['dob']);
                        $today = new DateTime();
                        $age = $today->diff($dateOfBirth)->y;
                        echo $age; ?></td>
                    <td><?php echo $value['sex']; ?></td>
                    <td> <?php echo $value['ward_short_name']; ?> - <?php echo $value['ward_name']; ?></td>
                    <td><?php echo $value['bed_number']; ?></td>
                    <td>
                        <div style="display: flex;">
                            <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-right: 8px;">
                                <input type="hidden" name="change_stat" value="">
                                <input type="hidden" name="status" value="admitted">
                                <input type="hidden" name="bed_id" value="<?php echo $value['bed_id']; ?>">
                                <input type="hidden" name="ward_id" value="<?php echo $value['ward_id']; ?>">
                                <input type="hidden" name="inp_id" value="<?php echo $value['id']; ?>">

                                <button type="submit" class="btn-primary btn" data-toggle="modal">
                                    <?php echo xlt("Accept") ?>
                                </button>
                            </form>
                            <button type="button" class="btn-primary btn updateBtn" data-toggle="modal" data-target="#updateAdmission" data-id="<?php echo $value['id']; ?>" data-ward="<?php echo $value['ward_id']; ?>" data-bed="<?php echo $value['bed_id']; ?>" data-admission_date="<?php echo $value['admission_date']; ?>" data-provider="<?php echo $value['assigned_provider']; ?>" data-nurse="<?php echo $value['assigned_nurse_id']; ?>" data-opd_case_doctor_id="<?php echo $value['opd_case_doctor_id']; ?>">
                                <?php echo xlt("Update") ?>
                            </button>

                            <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-right: 8px; margin-left: 8px;">
                                <input type="hidden" name="change_stat" value="">
                                <input type="hidden" name="status" value="denied">
                                <input type="hidden" name="inp_id" value="<?php echo $value['id']; ?>">

                                <!-- <button type="submit" class="btn-primary btn" data-toggle="modal">
                                    <?php echo xlt("Deny") ?>
                                </button> -->
                            </form>

                            <button type="button" class="btn-primary btn deleteBtn" data-toggle="modal" data-target="#deleteAdmission" data-id="<?php echo $value['id']; ?>">
                                <?php echo xlt("Delete") ?>
                            </button>
                        </div>
                    </td>
                </tr>
            <?php
            } ?>
        </table>

    </div>

    <div class="right-con">
        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
            <h4 class="section-head"> <?php echo xlt("Discharged Patients") ?> </h4>
        </div>

        <table>
            <tr>
                <th> <?php echo xlt("Name") ?> </th>
                <th> <?php echo xlt("Age") ?> </th>
                <th> <?php echo xlt("Gender") ?> </th>
                <!-- <th>User</th> -->
                <th> <?php echo xlt("Ward") ?> </th>
                <th> <?php echo xlt("Bed") ?> </th>
            </tr>

            <?php foreach ($dischargedPatients as $value) {
            ?>
                <tr>
                    <td><?php echo $value['fname']; ?> <?php echo $value['mname']; ?> <?php echo $value['lname']; ?></td>
                    <td><?php $dateOfBirth = new DateTime($value['dob']);
                        $today = new DateTime();
                        $age = $today->diff($dateOfBirth)->y;
                        echo $age; ?></td>
                    <td><?php echo $value['sex']; ?></td>
                    <!-- <td><?php echo $value['provider']; ?></td> -->
                    <td> <?php echo $value['ward_short_name']; ?> - <?php echo $value['ward_name']; ?></td>
                    <td><?php echo $value['bed_number']; ?></td>
                </tr>
            <?php
            } ?>
        </table>
    </div>

</section>

<?php include_once "./components/modals/admission/new.php"; ?>
<?php include_once "./components/modals/admission/update.php"; ?>
<?php include_once "./components/modals/admission/delete.php"; ?>


<?php
$beds = $bedQuery->getAvailableBeds();
?>
<script defer>
    window.onload = function() {
        $(".updateBtn").click(function() {
            var id = $(this).data('id');
            var ward = $(this).data('ward');
            var bed = $(this).data('bed');

            var admission_date = $(this).data('admission_date');
            var provider = $(this).data('provider');
            var nurse = $(this).data('nurse');
            var opd_case_doctor_id = $(this).data('opd_case_doctor_id');


            $('#id').val(id);
            $('#ward_update').val(ward);
            $('#bed_update').val(bed);

            $('#admission_date_update').val(admission_date);
            $('#provider_update').val(provider);
            $('#nurse_update').val(nurse);
            $('#opd_case_doctor_id_update').val(opd_case_doctor_id);
        });

        $(".deleteBtn").click(function() {
            var id = $(this).data('id');
            $('#deleteId').val(id);
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
            $("#bed_new").empty().append("<option>Select  Bed</option>");
            $(filteredBeds).each(function(i) {
                $("#bed_new").append(`<option value='${filteredBeds[i].id}'> ${filteredBeds[i].number} | ${filteredBeds[i].bed_type} | ${filteredBeds[i].price_per_day} </option>`)
            });
        });


        $('#ward_update').on('change', function(e) {
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
            $("#bed_update").empty().append("<option>Select  Bed</option>");
            $(filteredBeds).each(function(i) {
                $("#bed_update").append(`<option value='${filteredBeds[i].id}'> ${filteredBeds[i].number} | ${filteredBeds[i].bed_type} | ${filteredBeds[i].price_per_day} </option>`)
            });
        });

        // hide alert
        setTimeout(function() {
            $('#alert').hide();
        }, 3000);
    };
</script>
<?php include_once "./components/footer.php"; ?>