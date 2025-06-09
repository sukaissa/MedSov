<!-- schudule surgury-->
<div class="modal fade" id="neSurgeryModal" tabindex="-1" aria-labelledby="neSurgeryModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wardModal">Schedule Surgery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body surgery-modal">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <input type="hidden" name="patient_id" id="surg_pid" value="">
                    <input type="hidden" name="admission_id" id="surg_admission_id" value="">
                    <input type="hidden" name="created_by" value="<?php echo $_SESSION["authUser"]; ?>">
                    <input type="hidden" name="new_surgery" id="new_surgery" value="">

                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control w-100" name="code" id="surgery_code">
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Theaters Name</label>
                        <select class="form-control" style="width: 100%;" name="theater_id" id="theater_id">
                            <option value="">Select Theater</option>
                            <?php foreach ($theater as $theaters) { ?>
                                <option value="<?php echo $theaters['id'] ?>"><?php echo $theaters['theater_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Surgical Procedure</label>
                        <select class="form-control" style="width: 100%;" name="procedure_id" id="procedure_id">
                            <option value="">Select Procedure</option>
                            <?php foreach ($procedure as $pro) { ?>
                                <option value="<?php echo $pro['id'] ?>"><?php echo $pro['procedure_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Start Date</label>
                        <input type="datetime-local" class="form-control" name="start_date" id="start_date">
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">End Date</label>
                        <input type="datetime-local" class="form-control" name="end_date" id="end_date">
                    </div>

                    <div style="display: flex;">
                        <div class="form-group" style="display: flex; flex-direction: column;">
                            <input type="radio" name="pc_alldayevent" id="pc_alldayevent" value="on">
                            <label for="formGroupExampleInput2">All day event</label>
                        </div>

                        <div class="form-group" style="margin-left: auto;">
                            <input type="radio" name="pc_alldayevent" id="pc_alldayevent" value="off">
                            <label for="formGroupExampleInput2">Duration (min)</label>
                            <input type="number" class="form-control" name="duration" id="duration" value="15">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Surgery Status</label>
                        <select class="form-control" style="width: 100%;" name="status" id="status">
                            <option value="">Select Status</option>
                            <option value="Awaiting">Awaiting</option>
                            <option value="Completed">Completed</option>
                            <option value="Canceled">Canceled</option>
                        </select>
                    </div>


                    <!-- surgery part -->
                    <div class="form-group">
                        <label for="formGroupExampleInput2">Category</label>
                        <select class="form-control" style="width: 100%;" name="pc_title" id="pc_title">
                            <?php
                            foreach ($calenderCat as $cat) {
                            ?>
                                <option value="<?php echo $cat['pc_catname'] ?>"><?php echo $cat['pc_catname'] ?></option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pc_hometext">Comment</label>
                        <input type="text" class="form-control" name="pc_hometext" id="pc_hometext">
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