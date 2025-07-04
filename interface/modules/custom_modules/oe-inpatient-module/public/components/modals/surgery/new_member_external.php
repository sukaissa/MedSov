<div class="modal fade" id="newMemberExternal" tabindex="-1" aria-labelledby="newMemberExternal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New External Surgical Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST'>
                    <input type="hidden" name="new_external_member">
                    <input type="hidden" name="admission_id" id="admission_id" value="<?php echo $admission_id; ?>">
                    <input type="hidden" name="surgery_id" id="surgery_id" value="<?php echo $patientSurgery['id']; ?>">

                    <div class="form-group">
                        <label for="username">Name</label>
                        <input type="text" class="form-control" name="username">
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" name="role">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>