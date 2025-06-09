<!-- mamagement plan -->
<div class="modal fade" id="setTreatment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Treatment Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST'>
                    <input type="hidden" name="treatment_plan" id="treatment_plan" value="">
                    <input type="hidden" name="mng_admission_id" id="mng_admission_id" value="">
                    <input type="hidden" name="mng_patient_id" id="mng_patient_id" value="">
                    <input type="hidden" name="mng_action_type" id="mng_action_type" value="">

                    <div class="form-group">
                        <label for="type">Plan</label>
                        <select class="form-control" name="type" id="type">
                            <option value="">Select Plan</option>
                            <?php foreach ($issueList as $plan) { ?>
                                <option value="<?php echo $plan['type']; ?>"><?php echo $plan['singular']; ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group" style="flex: 1;">
                        <label for="title">Enter Title</label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>

                    <div style="display: flex;">
                        <div class="form-group" style="flex: 1;">
                            <label for="action_start_time">Start Time</label>
                            <input type="time" class="form-control" name="action_start_time" id="action_start_time">
                        </div>

                        <div class="form-group" style="margin-left: 10px; flex: 1;">
                            <label for="action_end_time">End Time</label>
                            <input type="time" class="form-control" name="action_end_time" id="action_end_time">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="time_interval">Time Interval</label>
                        <input type="text" class="form-control" name="time_interval" id="time_interval">
                    </div>

                    <div class="form-group">
                        <label for="staff_id">Staff</label>
                        <select class="form-control" name="staff_id" id="staff_id">
                            <option value="">Select Staff</option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . " " . $user['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="formGroupExampleInput">Instructions</label>
                        <textarea name="instructions" id="instructions" cols="30" rows="10" class="form-control" id="formGroupExampleInput" placeholder="Instructions"></textarea>
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