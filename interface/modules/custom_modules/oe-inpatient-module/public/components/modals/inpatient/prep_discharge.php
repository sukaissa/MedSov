<!-- discharge modal -->
<div class="modal fade" id="prepdischargePatient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo xlt("Prepare for Discharge"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="modal-body">
                    <p><?php echo xlt("Prepare this patient for discharge"); ?></p>

                    <!-- Hidden fields -->
                    <input type="hidden" name="prep_discharge" value="">
                    <input type="hidden" name="prep_admission_id" id="prep_admission_id" value="">
                    <input type="hidden" name="prep_patient_id" id="prep_patient_id" value="">
                    <input type="hidden" name="prep_encounter_id" id="prep_encounter_id" value="">


                    <!-- Checklist Items -->
                    <h6 class="font-weight-bold mb-3"><?php echo xlt("Checklist Items"); ?></h6>
                    <div class="form-checklist container-fluid">
                        <div class="row">
                            <?php if (!empty($checklistItems)) { ?>
                                <?php foreach ($checklistItems as $item) { ?>
                                    <div class="form-group col-md-6 checklist-group">
                                        <div class="form-check">
                                            <input class="form-check-input checklist-item" type="checkbox" name="checklist_items[<?php echo htmlspecialchars($item['option_id']); ?>]" id="checklist_<?php echo htmlspecialchars($item['option_id']); ?>" value="1">
                                            <label class="form-check-label" for="checklist_<?php echo htmlspecialchars($item['option_id']); ?>">
                                                <?php echo htmlspecialchars($item['title']); ?>
                                            </label>
                                        </div>
                                        <textarea rows="2" class="form-control mt-2 checklist-notes d-none" name="checklist_notes[<?php echo htmlspecialchars($item['option_id']); ?>]" placeholder="<?php echo xlt('Enter notes'); ?>"></textarea>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="col-12">
                                    <p class="text-muted"><?php echo xlt("No checklist items found."); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt("Close"); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo xlt("Prepare"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checklistItems = document.querySelectorAll('.checklist-item');
        checklistItems.forEach(item => {
            item.addEventListener('change', function() {
                const container = this.closest('.checklist-group');
                const notesField = container.querySelector('.checklist-notes');
                if (this.checked) {
                    notesField.classList.remove('d-none');
                } else {
                    notesField.classList.add('d-none');
                    notesField.value = '';
                }
            });
        });
    });
</script>