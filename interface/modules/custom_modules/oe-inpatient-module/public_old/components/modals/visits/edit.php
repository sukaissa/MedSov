<!-- visits modal -->
<div class="modal fade" id="updateVisitor" tabindex="-1" aria-labelledby="updateVisitor" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateVisitor"><?php echo xlt('Update Inpatient Visit') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="update">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group" style="flex: 1;">
                        <label for="patient"><?php echo xlt('Search Patient') ?></label>
                        <select class="form-control" style="width: 100%;" id="patient" style="height: 50px;" name="patient">
                            <option value=""><?php echo xlt('Select Patient') ?></option>
                            <?php foreach ($inpatients as $user) { ?>
                                <option value="<?php echo $user['patient_id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="visitor_name"><?php echo xlt('Name of Visitor') ?></label>
                        <input type="text" class="form-control" name="visitor_name" id="visitor_name">
                    </div>

                    <div class="form-group">
                        <label for="relationship_with_patient"><?php echo xlt('Relationship to Patient') ?></label>
                        <input type="text" class="form-control" name="relationship_with_patient" id="relationship_with_patient">
                    </div>

                    <div class="form-group">
                        <label for="time_in"><?php echo xlt('Time In') ?></label>
                        <input type="time" class="form-control" name="time_in" id="time_in">
                    </div>

                    <div class="form-group">
                        <label for="time_out"><?php echo xlt('Time Out') ?></label>
                        <input type="time" class="form-control" name="time_out" id="time_out">
                    </div>

                    <div class="form-group">
                        <label for="comment"><?php echo xlt('Reason for Visit') ?></label>
                        <input type="text" class="form-control" name="comment" id="comment">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo xlt('Close') ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo xlt('Save') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>