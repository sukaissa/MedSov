<!-- update -->
<div class="modal fade" id="updateAdmission" tabindex="-1" aria-labelledby="updateAdmission" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Admission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="id" id="id" value="">

                    <div class="form-group">
                        <label for="ward">Ward</label>
                        <select class="form-control" id="ward_update" name="ward">
                            <option value="">Select Ward</option>
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name'] . " - " . $ward['name'] . " | " . $ward['available_beds']; ?> Beds</option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Bed</label>
                        <select class="form-control" id="bed_update" name="bed">
                            <option value="">Select Bed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="opd_case_doctor_id">OPD Case Doctor</label>
                        <select class="form-control" id="opd_case_doctor_id_update" name="opd_case_doctor_id">
                            <option value="">Select Case Doctor</option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nurse">Assigned Nurse</label>
                        <select class="form-control" name="assigned_nurse_id" id="nurse_update">
                            <option value="">Select Nurse</option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Assigned User</label>
                        <select class="form-control" id="provider_update" name="assigned_provider">
                            <option value="">Select User</option>
                            <?php foreach ($providers as $provider) { ?>
                                <option value="<?php echo $provider['id']; ?>"><?php echo $provider['fname'] . " " . $provider['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="admission_type">Admission Types</label>
                        <select class="form-control" id="admission_type" name="admission_type">
                            <option value="">Select Type</option>
                            <!-- <?php foreach ($users as $user) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?> </option>
                            <?php
                                    }  ?> -->
                            <option value="Chronic Follow-Up (CRO)">Chronic Follow-Up (CRO)</option>
                            <option value="Emergency (EME)">Emergency (EME)</option>
                            <option value="Acute Episode (ACU)">Acute Episode (ACU)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Admission Date</label>
                        <input type="date" class="form-control" id="admission_date_update" name="admission_date">
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