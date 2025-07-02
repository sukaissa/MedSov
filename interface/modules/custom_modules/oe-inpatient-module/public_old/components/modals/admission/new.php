<!-- new Modal -->
<div class="modal fade" id="newAdmission" tabindex="-1" aria-labelledby="newAdmission" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Admission Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="new" value="new">
                    <input type="hidden" name="status" value="in-queue">

                    <div class="form-group">
                        <label for="ward">Ward</label>
                        <select class="form-control" id="ward" name="ward">
                            <option value="">Select Ward</option>
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name']; ?> | <?php echo $ward['name']; ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bed">Bed</label>
                        <select class="form-control" name="bed" id="bed_new">
                            <option value="">Select Bed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="opd_case_doctor_id">OPD Case Doctor</label>
                        <select class="form-control" id="opd_case_doctor_id" name="opd_case_doctor_id">
                            <option value="">Select Case Doctor</option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nurse">Assigned Nurse</label>
                        <select class="form-control" id="nurse" name="assigned_nurse_id">
                            <option value="">Select Nurse</option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Assigned User</label>
                        <select class="form-control" id="provider" name="assigned_provider">
                            <option value="">Select User</option>
                            <?php foreach ($providers as $provider) { ?>
                                <option value="<?php echo $provider['id']; ?>"><?php echo $provider['fname'] . " " . $provider['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Admission Date</label>
                        <input type="date" class="form-control" name="admission_date">
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