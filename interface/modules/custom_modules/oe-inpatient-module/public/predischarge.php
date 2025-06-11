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
    $checklistNotes = $_POST['checklist_notes'] ?? [];

    // Insert the new predischarge form entry
    $formId = $preDischargeChecklist->insertForm($patientId, $checklistItems, $checklistNotes);

    header('location:predischarge.php?status=success&message=Form created successfully');
} elseif (isset($_GET['form_id']) && $_SERVER['REQUEST_METHOD'] === 'GET') {

    try {
        header('Content-Type: application/json');

        $formId = $_GET['form_id'];
        $form = $preDischargeChecklist->getPreDischargeFormById($formId);

        if ($form) {
            echo json_encode([
                'success' => true,
                'form' => $form,
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Predischarge Form not found']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
    exit;
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
        <div>
            <button class="btn btn-secondary mr-2" id="printAllToPdfBtn">
                <?php echo xlt("Print") ?>
            </button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#newPreDischargeFormModal">
                <?php echo xlt("New Form") ?>
            </button>
        </div>
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
                    <button type="submit" class="btn btn-success w-100 mr-2"><?php echo xlt("Filter"); ?></button>
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
                        <th><?php echo xlt("Patient") ?></th>
                        <th><?php echo xlt("Created At") ?></th>
                        <th><?php echo xlt("Created By") ?></th>
                        <th><?php echo xlt("Actions") ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($records)) { ?>
                        <?php foreach ($records as $record) { ?>
                            <tr>
                                <td><?php echo $record['patient_name']; ?></td>
                                <td><?php echo $record['form_created_at']; ?></td>
                                <td><?php echo $record['form_created_by']; ?></td>
                                <td>
                                    <button class="btn btn-outline-info btn-sm viewBtn" data-toggle="modal" data-target="#viewPreDischargeFormModal" data-id="<?php echo $record['form_id']; ?>">
                                        <?php echo xlt("View") ?>
                                    </button>
                                    <!-- <button class="btn btn-outline-danger btn-sm deleteBtn" data-bs-toggle="modal" data-bs-target="#deleteFormModal" data-id="<?php echo $record['form_id']; ?>">
                                        <?php echo xlt("Delete") ?>
                                    </button> -->
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
                    <div class="form-checklist container">
                        <div class="row">
                            <?php if (!empty($checklistItems)) { ?>
                                <?php foreach ($checklistItems as $item) { ?>
                                    <div class="form-check mb-2 col-md-6">
                                        <input class="form-check-input checklist-item" type="checkbox" name="checklist_items[<?php echo htmlspecialchars($item['option_id']); ?>]" id="checklist_<?php echo htmlspecialchars($item['option_id']); ?>" value="1">
                                        <label class="form-check-label" for="checklist_<?php echo htmlspecialchars($item['option_id']); ?>">
                                            <?php echo htmlspecialchars($item['title']); ?>
                                        </label>
                                        <!-- Hidden notes field -->
                                        <textarea rows="2" type="text" class="form-control mt-2 checklist-notes d-none" name="checklist_notes[<?php echo htmlspecialchars($item['option_id']); ?>]" placeholder="<?php echo xlt('Enter notes'); ?>"></textarea>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <p><?php echo xlt("No checklist items found."); ?></p>
                            <?php } ?>
                        </div>
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

<div class="modal fade" id="viewPreDischargeFormModal" tabindex="-1" role="dialog" aria-labelledby="viewPreDischargeFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPreDischargeFormModalLabel">
                    <?php echo xlt("Pre-Discharge Details"); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div id="viewFormContent" class="">
                    <div class="text-center text-muted">
                        <div class="spinner-border text-secondary" role="status"></div>
                        <p class="mt-3"><?php echo xlt("Loading form details..."); ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                    <?php echo xlt("Close"); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
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

    document.addEventListener('DOMContentLoaded', function() {
        const printAllToPdfBtn = document.getElementById('printAllToPdfBtn');
        printAllToPdfBtn.addEventListener('click', function() {
            const pdf = new jspdf.jsPDF();
            const table = document.querySelector('.table'); // Select the table containing the records

            pdf.text("All Pre-Discharge Forms", 10, 10); // Add a title to the PDF
            pdf.autoTable({
                html: table, // Use the table's HTML to generate the PDF
                startY: 20, // Start rendering the table below the title
                styles: {
                    fontSize: 10, // Adjust font size for better readability
                    cellPadding: 2,
                },
            });

            pdf.save("pre_discharge_forms.pdf"); // Save the PDF
        });

        const checklistItems = document.querySelectorAll('.checklist-item');
        checklistItems.forEach(item => {
            item.addEventListener('change', function() {
                const notesField = this.closest('div').querySelector('.checklist-notes');
                if (this.checked) {
                    notesField.classList.remove('d-none');
                } else {
                    notesField.classList.add('d-none');
                    notesField.value = '';
                }
            });
        });

        const viewButtons = document.querySelectorAll('.viewBtn');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const formId = this.dataset.id;
                const modalContent = document.getElementById('viewFormContent');
                modalContent.innerHTML = `
                    <div class="text-center">
                        <div class="spinner-border text-secondary" role="status"></div>
                        <p class="mt-3"><?php echo xlt("Loading form details..."); ?></p>
                    </div>`;

                fetch(`predischarge.php?form_id=${formId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            modalContent.innerHTML = `
                                <div class="mb-3">
                                    <strong><?php echo xlt("Patient ID"); ?>:</strong> ${data.form.patient_id}<br>
                                    <strong><?php echo xlt("Patient Name"); ?>:</strong> ${data.form.patient_name}<br>
                                    <strong><?php echo xlt("Created At"); ?>:</strong> ${data.form.form_created_at}
                                </div>
                                <div>
                                    <p class="text-muted mb-0"><?php echo xlt("Pre-Discharge Checklist"); ?>:</p>
                                    <ul class="list-group mt-1">
                                        ${data.form.checklist_items.map(item => `
                                            <li class="list-group-item">
                                                <div class="font-weight-bold">${item.item_title}</div>
                                                <small class="text-muted">${item.notes || '<?php echo xlt("No notes"); ?>'}</small>
                                            </li>`).join('')}
                                    </ul>
                                </div>`;
                        } else {
                            modalContent.innerHTML = `<p class="text-danger">${data.message}</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching form details:', error);
                        modalContent.innerHTML = `<p class="text-danger"><?php echo xlt("An error occurred while loading the form details."); ?></p>`;
                    });
            });
        });
    });
</script>

<?php include_once "./components/footer.php"; ?>