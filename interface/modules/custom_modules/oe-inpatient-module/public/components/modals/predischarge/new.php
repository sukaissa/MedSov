<?php

use OpenEMR\Modules\InpatientModule\ListsQuery;

require_once "../../sql/ListsQuery.php";

$listsQuery = new ListsQuery();
$checklistItems = $listsQuery->getListItemsByListId('pre_discharge_items');
?>

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