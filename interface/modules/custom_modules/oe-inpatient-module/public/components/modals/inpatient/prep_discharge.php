<!-- discharge modal -->
<div class="modal fade" id="prepdischargePatient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Prepare for Discharge</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Prepare this patient for discharge</p>
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="prep_discharge" value="">
                    <input type="hidden" name="prep_admission_id" id="prep_admission_id" value="">
                    <input type="hidden" name="prep_patient_id" id="prep_patient_id" value="">
                    <input type="hidden" name="prep_encounter_id" id="prep_encounter_id" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Prepare</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>