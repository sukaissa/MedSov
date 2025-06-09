<!-- discharge modal -->
<div class="modal fade" id="dischargePatient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Discharge Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="discharge" value="">
                    <input type="hidden" name="dis_bed_id" id="dis_bed_id" value="">
                    <input type="hidden" name="dis_admission_id" id="dis_admission_id" value="">

                    <div class="form-group">
                        <label for="deceased">Deceased</label>
                        <select class="form-control" id="deceased" name="deceased">
                            <option value="">Select Status</option>
                            <option value="Yes">Yes</option>
                            <option value="No" active>No</option>
                        </select>
                    </div>


                    <div class="form-group" id='dateField' style="display: none;">
                        <label for="deceased_date">Deceased Date</label>
                        <input type="date" class="form-control" name="deceased_date" id="deceased_date" />
                    </div>

                    <div class="form-group" id='reasonField' style="display: none;">
                        <label for="deceased_reason">Deceased Reason</label>
                        <input type="text" class="form-control" name="deceased_reason" id="deceased_reason">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Discharge</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // JavaScript code to show/hide additional fields based on the selected option
    const selectOption = document.getElementById('deceased');
    const dateField = document.getElementById('dateField');
    const reasonField = document.getElementById('reasonField');

    selectOption.addEventListener('change', () => {
        if (selectOption.value === 'Yes') {
            dateField.style.display = 'block';
            reasonField.style.display = 'block';
        } else {
            dateField.style.display = 'none';
            reasonField.style.display = 'none';
        }
    });
</script>