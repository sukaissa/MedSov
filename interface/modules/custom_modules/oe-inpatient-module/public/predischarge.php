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

$searchName = $_GET['search_name'] ?? '';
$startDate = $_GET['start_date'] ?? '';
$endDate = $_GET['end_date'] ?? '';
$records = $preDischargeChecklist->getFilteredForms($searchName, $startDate, $endDate);

$display_message = isset($_GET['status']) ? 'block' : 'none';
$message = $_GET['message'] ?? '';

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $formId = $preDischargeChecklist->insertForm($_POST['pid']);
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
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newFormModal">
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

<?php include_once "./components/modals/predischarge_modals.php"; ?>

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