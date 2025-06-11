<?php

// session_start();

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
use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;
use OpenEMR\Modules\InpatientModule\PreDischargeChecklistQuery;

require_once "../../../../globals.php";
require_once "./components/sql/AdmissionQueueQuery.php";
require_once "./components/sql/InpatientQuery.php";
require_once "./components/sql/BedQuery.php";
require_once "./components/sql/SurgeryQuery.php";
require_once "./components/sql/WardQuery.php";
require_once "./components/sql/PreDischargeChecklistQuery.php";

$admissionQueuQuery = new AdmissionQueueQuery();
$bedQuery = new BedQuery();
$inpatientQuery = new InpatientQuery();
$wardQuery = new WardQuery();
$surgeryQuery = new SurgeryQuery();
$preDischargeChecklist = new PreDischargeChecklistQuery();

$beds = $bedQuery->getBeds();
$wards = $wardQuery->getWards();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'bed_type' => $_POST['bed_type'],
        'price_per_day' => $_POST['price_per_day'],
        'number' => $_POST['number'],
        'ward_id' => $_POST['ward_id'],
        'availability' => $_POST['availability'],
    ];
    $bedQuery->insertBed($data);
    header('location:beds.php?status=success&message=Bed added successfully');
    // header('Refresh:0');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $bedQuery->destroyBed($_POST['deleteId']);
    header('location:beds.php?status=success&message=Bed deleted successfully');
    // header('Refresh:0');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'bed_type' => $_POST['bed_type'],
        'price_per_day' => $_POST['price_per_day'],
        'number' => $_POST['number'],
        'ward_id' => $_POST['ward_id'],
        'availability' => $_POST['availability'],
        'id' => $_POST['id'],
    ];
    $bedQuery->updateBed($data);
    header('location:beds.php?status=success&message=Bed updated successfully');
    // header('Refresh:0');
}

include_once "./components/head.php";
?>

<!-- check condition of display message -->
<?php if ($display_mesasge == 'block') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
        <strong><?php echo xlt('Success') ?>!</strong> <?php echo $message; ?>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
    </div>
<?php } ?>

<section class="main-containerx">
    <div class="left-con" style="width: 100%;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
            <h4 class="section-head"><?php echo xlt('Beds') ?></h4>

            <button type="button" class="btn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#newBedModal">
                <?php echo xlt('New Bed') ?>
            </button>
        </div>

        <table>
            <tr>
                <th><?php echo xlt('Bed number') ?></th>
                <th><?php echo xlt('Type') ?></th>
                <th><?php echo xlt('Price per day') ?></th>
                <th><?php echo xlt('Availability') ?></th>
                <th><?php echo xlt('Ward') ?></th>
                <th></th>
            </tr>

            <?php foreach ($beds as $bed) {
            ?>
                <tr>
                    <td><?php echo $bed['number']; ?></td>
                    <td><?php echo $bed['bed_type']; ?></td>
                    <td><?php echo $bed['price_per_day']; ?></td>
                    <td><?php echo $bed['availability']; ?></td>
                    <td><?php echo $bed['ward_name']; ?></td>
                    <td style="display: flex;">
                        <!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> -->
                        <!-- <input type="hidden" name="id" value="<?php echo $bed['id']; ?>"> -->
                        <button type="button" class="btn btn-primary updateBtn" style="margin-right: 8px;" data-toggle="modal" data-target="#bedModal" data-id="<?php echo $bed['id']; ?>" data-number="<?php echo $bed['number']; ?>" data-price="<?php echo $bed['price_per_day']; ?>" data-bed_type="<?php echo $bed['bed_type']; ?>" data-ward_id="<?php echo $bed['ward_id']; ?>" data-availability="<?php echo $bed['availability']; ?>">
                            <?php echo xlt('Update') ?>
                        </button>
                        <!-- </form> -->

                        <button type="button" class="btn btn-danger deleteBtn" style="" data-toggle="modal" data-target="#deleteBedModal" data-id="<?php echo $bed['id']; ?>">
                            <?php echo xlt('Delete') ?>
                        </button>

                    </td>
                </tr>
            <?php
            } ?>
        </table>

    </div>

    <!-- <div class="right-con">
        <h4 class="section-head">Discharged Patients</h4>
    </div> -->

</section>


<!-- edit Modal -->
<div class="modal fade" id="bedModal" tabindex="-1" aria-labelledby="bedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bedModal"><?php echo xlt('Edit Bed') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="id" id="id" value="">

                    <div class="form-group">
                        <label for="number"> <?php echo xlt('Bed number') ?></label>
                        <input type="text" name="number" class="form-control" id="number">
                    </div>

                    <div class="form-group">
                        <label for="bed_type"> <?php echo xlt('Bed Type') ?></label>
                        <select class="form-control" id="bed_type" name="bed_type">
                            <option value="Private"> <?php echo xlt('Private') ?></option>
                            <option value="VIP"> <?php echo xlt('VIP') ?></option>
                            <option value="Regular"> <?php echo xlt('Regular') ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price_per_day"> <?php echo xlt('Price per Day') ?></label>
                        <input type="number" name="price_per_day" class="form-control" id="price_per_day">
                    </div>

                    <div class="form-group">
                        <label for="ward"> <?php echo xlt('Ward') ?></label>
                        <select class="form-control" id="ward" name="ward_id">
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name']; ?> - <?php echo $ward['name']; ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="availability"> <?php echo xlt('Availability') ?></label>
                        <select class="form-control" id="availability" name="availability">
                            <option value="<?php echo xlt('Available') ?>"> <?php echo xlt('Available') ?></option>
                            <option value="<?php echo xlt('Occupied') ?><"> <?php echo xlt('Occupied') ?></option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <?php echo xlt('Close') ?></button>
                        <button type="submit" class="btn btn-primary"> <?php echo xlt('Save') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- new bed -->
<div class="modal fade" id="newBedModal" tabindex="-1" aria-labelledby="newBedModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newBedModal"> <?php echo xlt('Bed Form') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="new" id="new" value="">
                    <input type="hidden" name="availability" id="availability" value="Available">

                    <div class="form-group">
                        <label for="number"> <?php echo xlt('Bed number') ?></label>
                        <input type="text" name="number" class="form-control" id="number">
                    </div>

                    <div class="form-group">
                        <label for="bed_type"> <?php echo xlt('Bed Type') ?></label>
                        <select class="form-control" id="bed_type" name="bed_type">
                            <option value="<?php echo xlt('Private') ?>"> <?php echo xlt('Private') ?></option>
                            <option value="<?php echo xlt('VIP') ?>"> <?php echo xlt('VIP') ?></option>
                            <option value="<?php echo xlt('Regular') ?>"> <?php echo xlt('Regular') ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price_per_day"> <?php echo xlt('Price per Day') ?></label>
                        <input type="number" name="price_per_day" class="form-control" id="formGroupExampleInput2">
                    </div>

                    <div class="form-group">
                        <label for="ward"> <?php echo xlt('Ward') ?></label>
                        <select class="form-control" id="ward" name="ward_id">
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name']; ?> - <?php echo $ward['name']; ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <?php echo xlt('Close') ?></button>
                        <button type="submit" class="btn btn-primary"> <?php echo xlt('Save') ?></button>
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
                <h5 class="modal-title" id="deleteBedModal"> <?php echo xlt('Confirm Delete') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p> <?php echo xlt('Are you sure you want to delete bed?') ?></p>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="deleteId" id="deleteId" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <?php echo xlt('Close') ?></button>
                        <button type="submit" class="btn btn-danger"> <?php echo xlt('Delete') ?></button>
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
            var number = $(this).data('number');
            var price = $(this).data('price');
            var ward_id = $(this).data('ward_id');
            var bed_type = $(this).data('bed_type');
            var availability = $(this).data('availability');

            $('#id').val(id);
            $('#ward').val(ward_id);
            $('#number').val(number);
            $('#price_per_day').val(price);
            $('#bed_type').val(bed_type);
            $('#availability').val(availability);
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
<?php include_once "./components/footer.php"; ?>