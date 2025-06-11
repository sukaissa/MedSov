<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Mark Amoah <mcprah@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

use OpenEMR\Modules\InpatientModule\AdmissionQueueQuery;
use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\PreDischargeChecklistQuery;
use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;


require_once "../../../../globals.php";
require_once "./components/sql/PreDischargeChecklistQuery.php";
require_once "./components/sql/AdmissionQueueQuery.php";
require_once "./components/sql/InpatientQuery.php";
require_once "./components/sql/BedQuery.php";
require_once "./components/sql/SurgeryQuery.php";
require_once "./components/sql/WardQuery.php";

$admissionQueuQuery = new AdmissionQueueQuery();
$bedQuery = new BedQuery();
$inpatientQuery = new InpatientQuery();
$wardQuery = new WardQuery();
$surgeryQuery = new SurgeryQuery();
$preDischargeChecklist = new PreDischargeChecklistQuery();


$records = $preDischargeChecklist->getAllChecklists();

$display_message = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_message = 'block';
}

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'patient_id' => $_POST['patient_id'],
        'discharge_date' => $_POST['discharge_date'],
        'list_option_id' => $_POST['list_option_id'],
        'list_option_value' => filter_var($_POST['list_option_value'], FILTER_VALIDATE_BOOLEAN),
        'notes' => $_POST['notes'],
        'created_by' => $_SESSION['authUser'],
    ];
    $preDischargeChecklist->insertChecklist($data);
    header('location:predischarge.php?status=success&message=Record added successfully');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $preDischargeChecklist->deleteChecklist($_POST['deleteId']);
    header('location:predischarge.php?status=success&message=Record deleted successfully');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'list_option_value' => filter_var($_POST['list_option_value'], FILTER_VALIDATE_BOOLEAN),
        'notes' => $_POST['notes'],
        'updated_by' => $_SESSION['authUser'],
    ];
    $preDischargeChecklist->updateChecklist($data);
    header('location:predischarge.php?status=success&message=Record updated successfully');
}

include_once "./components/head.php";


?>



<!-- Display success message -->
<?php if ($display_message == 'block') { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert">
        <strong><?php echo xlt('Success'); ?>! </strong> <?php echo xlt($message); ?>
    </div>
<?php } ?>

<section class="main-containerx">
    <div class="left-con" style="width: 100%;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
            <h4 class="section-head"><?php echo xlt("All Pre-Discharge Records") ?></h4>

            <button type="button" class="btn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#newRecordModal">
                <?php echo xlt("New Record") ?>
            </button>
        </div>

        <table>
            <tr>
                <th><?php echo xlt("Patient ID") ?></th>
                <th><?php echo xlt("Discharge Date") ?></th>
                <th><?php echo xlt("Option ID") ?></th>
                <th><?php echo xlt("Option Value") ?></th>
                <th><?php echo xlt("Notes") ?></th>
                <th><?php echo xlt("Created By") ?></th>
                <th></th>
            </tr>

            <?php foreach ($records as $record) { ?>
                <tr>
                    <td><?php echo $record['patient_id']; ?></td>
                    <td><?php echo $record['discharge_date']; ?></td>
                    <td><?php echo $record['list_option_id']; ?></td>
                    <td><?php echo $record['list_option_value'] ? xlt("Yes") : xlt("No"); ?></td>
                    <td><?php echo $record['notes']; ?></td>
                    <td><?php echo $record['created_by']; ?></td>
                    <td>
                        <button type="button" class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateRecordModal"
                            data-id="<?php echo $record['id']; ?>"
                            data-list_option_value="<?php echo $record['list_option_value']; ?>"
                            data-notes="<?php echo $record['notes']; ?>">
                            <?php echo xlt("Update") ?>
                        </button>
                        <button type="button" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#deleteRecordModal"
                            data-id="<?php echo $record['id']; ?>">
                            <?php echo xlt("Delete") ?>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</section>

<!-- Modals -->
<?php include_once "./components/modals/predischarge_modals.php"; ?>

<script defer>
    window.onload = function() {
        $(".updateBtn").click(function() {
            var id = $(this).data('id');
            var list_option_value = $(this).data('list_option_value');
            var notes = $(this).data('notes');

            $('#id').val(id);
            $('#list_option_value').val(list_option_value);
            $('#notes').val(notes);
        });

        $(".deleteBtn").click(function() {
            var id = $(this).data('id');
            $('#deleteId').val(id);
        });

        // Hide alert
        setTimeout(function() {
            $('#alert').hide();
        }, 3000);
    };
</script>

<?php include_once "./components/footer.php"; ?>