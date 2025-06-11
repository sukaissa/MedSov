<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
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

// Fetch all predischarge forms and their related checklist items
$records = $preDischargeChecklist->getAllForms();

$display_message = 'none';
$message = '';
if (isset($_GET['status'])) {
    $message = $_GET['message'];
    $display_message = 'block';
}

// Handle form creation
if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $formId = $preDischargeChecklist->insertForm($_POST['pid']);
    header('location:predischarge.php?status=success&message=Form created successfully');
}

// Handle form deletion
if (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $preDischargeChecklist->deleteForm($_POST['deleteId']);
    header('location:predischarge.php?status=success&message=Form deleted successfully');
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
            <h4 class="section-head"><?php echo xlt("All Pre-Discharge Forms") ?></h4>

            <button type="button" class="btn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#newFormModal">
                <?php echo xlt("New Form") ?>
            </button>
        </div>

        <table>
            <tr>
                <th><?php echo xlt("Form ID") ?></th>
                <th><?php echo xlt("Patient Name") ?></th>
                <th><?php echo xlt("Created At") ?></th>
                <th><?php echo xlt("Created By") ?></th>
                <th></th>
            </tr>

            <?php foreach ($records as $record) { ?>
                <tr>
                    <td><?php echo $record['form_id']; ?></td>
                    <td><?php echo $record['patient_name']; ?></td>
                    <td><?php echo $record['form_created_at']; ?></td>
                    <td><?php echo $record['form_created_by']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#deleteFormModal"
                            data-id="<?php echo $record['form_id']; ?>">
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