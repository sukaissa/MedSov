<?php
/*
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 * @author      Mark Amoah <mcprah@gmail.com>
 * @copyright   Copyright (c) 2025 MedSov <info@medsov.com>
 * @license     GNU General Public License 3
 */

use OpenEMR\Modules\InpatientModule\AdmissionQueueQuery;
use OpenEMR\Modules\InpatientModule\BedQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\PreDischargeChecklistQuery;
use OpenEMR\Modules\InpatientModule\SurgeryQuery;
use OpenEMR\Modules\InpatientModule\WardQuery;
use OpenEMR\Modules\InpatientModule\ListsQuery;

require_once "../../../../globals.php";
require_once "./components/sql/PreDischargeChecklistQuery.php";
require_once "./components/sql/AdmissionQueueQuery.php";
require_once "./components/sql/InpatientQuery.php";
require_once "./components/sql/BedQuery.php";
require_once "./components/sql/SurgeryQuery.php";
require_once "./components/sql/WardQuery.php";
require_once "./components/sql/ListsQuery.php";

$admissionQueuQuery = new AdmissionQueueQuery();
$bedQuery = new BedQuery();
$inpatientQuery = new InpatientQuery();
$wardQuery = new WardQuery();
$surgeryQuery = new SurgeryQuery();
$preDischargeChecklist = new PreDischargeChecklistQuery();
$listsQuery = new ListsQuery();


$searchName = $_GET['search_name'] ?? '';
$startDate = $_GET['start_date'] ?? '';
$endDate = $_GET['end_date'] ?? '';
$records = $preDischargeChecklist->getFilteredForms($searchName, $startDate, $endDate);
$checklistItems = $listsQuery->getListItemsByListId('pre_discharge_items');

$display_message = isset($_GET['status']) ? 'block' : 'none';
$message = $_GET['message'] ?? '';

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $patientId = $_POST['pid'];
    $checklistItems = $_POST['checklist_items'] ?? [];

    // Insert the new form
    $formId = $preDischargeChecklist->insertForm($patientId);

    // Insert selected checklist items
    foreach ($checklistItems as $optionId => $value) {
        sqlInsert(
            "
            INSERT INTO form_predischarge_items (form_id, list_option_id, list_option_value, created_by) 
            VALUES (?, ?, ?, ?)",
            [$formId, $optionId, $value, $_SESSION['authUser']]
        );
    }

    header('location:predischarge.php?status=success&message=Form created successfully');
}

if (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $preDischargeChecklist->deleteForm($_POST['deleteId']);
    header('location:predischarge.php?status=success&message=Form deleted successfully');
}

include_once "./components/head.php";
?>

<?php if ($display_message == 'block') { ?>
    <div class="alert alert-success alert-dismissible fade show border-start border-success ps-3" role="alert" id="alert">
        <strong><?php echo xlt('Success'); ?>! </strong> <?php echo xlt($message); ?>
    </div>
<?php } ?>

<section class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold"><?php echo xlt("All Pre-Discharge Forms") ?></h4>
        <button class="btn btn-primary" data-toggle="modal" data-target="#newPreDischargeFormModal">
            <?php echo xlt("New Form") ?>
        </button>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="predischarge.php" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label"><?php echo xlt("Patient Name"); ?></label>
                    <input type="text" name="search_name" class="form-control" value="<?php echo htmlspecialchars($searchName); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label"><?php echo xlt("Start Date"); ?></label>
                    <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($startDate); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label"><?php echo xlt("End Date"); ?></label>
                    <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($endDate); ?>">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100"><?php echo xlt("Filter"); ?></button>
                    <a href="predischarge.php" class="btn btn-outline-secondary w-100"><?php echo xlt("Reset"); ?></a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th><?php echo xlt("Form ID") ?></th>
                        <th><?php echo xlt("Patient Name") ?></th>
                        <th><?php echo xlt("Created At") ?></th>
                        <th><?php echo xlt("Created By") ?></th>
                        <th><?php echo xlt("Actions") ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($records)) { ?>
                        <?php foreach ($records as $record) { ?>
                            <tr>
                                <td><?php echo $record['form_id']; ?></td>
                                <td><?php echo $record['patient_name']; ?></td>
                                <td><?php echo $record['form_created_at']; ?></td>
                                <td><?php echo $record['form_created_by']; ?></td>
                                <td>
                                    <button class="btn btn-outline-danger btn-sm deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteFormModal" data-id="<?php echo $record['form_id']; ?>">
                                        <?php echo xlt("Delete") ?>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted"><?php echo xlt("No records found."); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="newPreDischargeFormModal" tabindex="-1" role="dialog" aria-labelledby="newPreDischargeFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPreDischargeFormModalLabel"><?php echo xlt("New Pre-Discharge Form"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="predischarge.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patient_id" class="form-label"><?php echo xlt("Patient ID"); ?></label>
                        <input type="text" name="pid" id="patient_id" class="form-control" placeholder="<?php echo xlt("Enter Patient ID"); ?>" required>
                    </div>

                    <h6 class="fw-bold"><?php echo xlt("Checklist Items"); ?></h6>
                    <div class="form-checklist">
                        <?php if (!empty($checklistItems)) { ?>
                            <?php foreach ($checklistItems as $item) { ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="checklist_items[<?php echo htmlspecialchars($item['option_id']); ?>]" id="checklist_<?php echo htmlspecialchars($item['option_id']); ?>" value="1">
                                    <label class="form-check-label" for="checklist_<?php echo htmlspecialchars($item['option_id']); ?>">
                                        <?php echo htmlspecialchars($item['title']); ?>
                                    </label>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p><?php echo xlt("No checklist items found."); ?></p>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt("Cancel"); ?></button>
                    <button type="submit" name="new" class="btn btn-primary"><?php echo xlt("Save"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script defer>
    window.onload = function() {
        $(".deleteBtn").click(function() {
            var id = $(this).data('id');
            $('#deleteId').val(id);
        });

        setTimeout(function() {
            $('#alert').fadeOut('slow');
        }, 3000);
    };
</script>

<?php include_once "./components/footer.php"; ?>