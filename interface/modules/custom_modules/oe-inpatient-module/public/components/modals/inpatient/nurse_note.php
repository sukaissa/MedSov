<!-- note modal -->
<div class="modal fade" id="inpatientNursesNote" tabindex="-1" aria-labelledby="inpatientNursesNote" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Inpatient Nurses Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="nurse_note" value="">
                    <input type="hidden" name="note_admission_id" id="note_admission_id" value="">
                    <input type="hidden" name="note_pid" id="note_pid" value="">

                    <div class="form-group">
                        <label for="formGroupExampleInput">Notes</label>
                        <textarea name="note" id="note" cols="30" rows="10" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder"></textarea>
                    </div>

                    <!-- <div class="form-group">
                        <label for="formGroupExampleInput2">Time Taken</label>
                        <input type="time" name="time" class="form-control" id="formGroupExampleInput2">
                    </div> -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>