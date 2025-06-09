<!-- mamagement plan -->
<div class="modal fade" id="managementTracker" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Follow up Treatment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST'>
                    <input type="hidden" name="tracker" id="tracker" value="">
                    <input type="hidden" name="admission_id" id="tra_admission_id" value="">

                    <div class="form-group">
                        <label for="tracker_plan_id">Plan</label>
                        <select class="form-control" name="plan_id" id="tracker_plan_id">
                            <option value="">Select Plan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="action_time">Time Interval</label>
                        <input type="time" class="form-control" name="action_time" id="action_time">
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

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>