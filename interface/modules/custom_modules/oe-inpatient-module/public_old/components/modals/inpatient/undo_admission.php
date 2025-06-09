<!-- discharge modal -->
<div class="modal fade" id="undoAdmission" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Undo Admission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="undo_admission" value="">
                    <input type="hidden" name="undo_bed_id" id="undo_bed_id" value="">
                    <input type="hidden" name="undo_admission_id" id="undo_admission_id" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Undo Admission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>