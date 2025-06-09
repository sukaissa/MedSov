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
use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;

require_once "../../../../globals.php";

require_once "./components/sql/AdmissionQueueQuery.php";
require_once "./components/sql/BedQuery.php";
require_once "./components/sql/SurgeryQuery.php";
require_once "./components/sql/InpatientQuery.php";
require_once "./components/sql/WardQuery.php";

$admissionQueuQuery = new AdmissionQueueQuery();
$bedQuery = new BedQuery();
$inpatientQuery = new InpatientQuery();
$wardQuery = new WardQuery();
$surgeryQuery = new SurgeryQuery();

$wards = $wardQuery->getWards();

$display_mesasge = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_mesasge = 'block';
}

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'name' => $_POST['name'],
        'short_name' => $_POST['short_name'],
    ];
    $wardQuery->insertWard($data);
    header('location:wards.php?status=success&message=Ward added successfully');
    // header('Refresh:0');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $wardQuery->destroyWard($_POST['deleteId']);
    header('location:wards.php?status=success&message=Ward deleted successfully');
    // header('Refresh:0');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'name' => $_POST['name'],
        'short_name' => $_POST['short_name'],
        'id' => $_POST['id'],
    ];
    $wardQuery->updateWard($data);
    header('location:wards.php?status=success&message=Ward updated successfully');
    // header('Refresh:0');
}

include_once "./components/head.php";
?>

<!-- check condition of display message -->
<?php if ($display_mesasge == 'block') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
        <strong><?php echo xlt('Success'); ?>! </strong> <?php echo xlt($message); ?>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
    </div>
<?php } ?>

<section class="main-containerx">
    <div class="left-con" style="width: 100%;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
            <h4 class="section-head"><?php echo xlt("Wards") ?></h4>

            <button type="button" class="btn " style="background-color: #40E0D0;" data-toggle="modal" data-target="#newWardModal">
                <?php echo xlt("New Ward") ?>
            </button>
        </div>

        <table>
            <tr>
                <th><?php echo xlt("Name") ?></th>
                <th><?php echo xlt("Short Name") ?></th>
                <th></th>
            </tr>

            <?php foreach ($wards as $ward) {
            ?>
                <tr>
                    <td><?php echo $ward['name']; ?></td>
                    <td><?php echo $ward['short_name']; ?></td>
                    <td>
                        <button type="button" class="btn btn-primary updateBtn" style="margin-right: 8px;" data-toggle="modal" data-target="#updateWardModal" data-id="<?php echo $ward['id']; ?>" data-name="<?php echo $ward['name']; ?>" data-short_name="<?php echo $ward['short_name']; ?>">
                            <?php echo xlt("Update") ?>
                        </button>
                        <button type="button" class="btn btn-danger deleteBtn" style="" data-toggle="modal" data-target="#deleteWardModal" data-id="<?php echo $ward['id']; ?>">
                            <?php echo xlt("Delete") ?>
                        </button>

                    </td>
                </tr>
            <?php
            } ?>
        </table>

    </div>

</section>


<!-- update -->
<div class="modal fade" id="updateWardModal" tabindex="-1" aria-labelledby="updateWardModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wardModal"><?php echo xlt("Update Ward") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="id" id="id" value="">

                    <div class="form-group">
                        <label for="formGroupExampleInput"><?php echo xlt("Name") ?></label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2"><?php echo xlt("Short Name") ?></label>
                        <input type="text" name="short_name" class="form-control" id="short_name">
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

<!-- new -->
<div class="modal fade" id="newWardModal" tabindex="-1" aria-labelledby="newWardModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wardModal"><?php echo xlt("New Ward") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="new" id="new" value="">

                    <div class="form-group">
                        <label for="formGroupExampleInput"><?php echo xlt("Name") ?></label>
                        <input type="text" name="name" class="form-control" id="name">
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2"><?php echo xlt("Short Name") ?></label>
                        <input type="text" name="short_name" class="form-control" id="short_name">
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

<!-- delete -->
<div class="modal fade" id="deleteWardModal" tabindex="-1" aria-labelledby="deleteWardModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteWardModal"><?php echo xlt("Confirm Delete") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo xlt("Are you sure you want to delete bed?") ?></p>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="deleteId" id="deleteId" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt("Close") ?></button>
                        <button type="submit" class="btn btn-danger"><?php echo xlt("Delete") ?></button>
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
            var name = $(this).data('name');
            var short_name = $(this).data('short_name');

            var data = {
                id,
                name,
                short_name
            }

            $('#id').val(id);
            $('#name').val(name);
            $('#short_name').val(short_name);
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