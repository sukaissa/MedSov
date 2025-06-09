<!-- vital modal -->
<div class="modal fade" id="wardTransfer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Transfer Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST'>
                    <input type="hidden" name="transfer_ward" value="">
                    <input type="hidden" name="admission_id" id="trs_admission_id" value="">
                    <input type="hidden" name="admission_date" id="trs_admission_date" value="">
                    <input type="hidden" name="patient_id" id="trs_patient_id" value="">
                    <input type="hidden" name="old_ward" id="trs_old_ward" value="">
                    <input type="hidden" name="old_bed" id="trs_old_bed" value="">

                    <div class="form-group">
                        <label for="ward">Ward</label>
                        <select class="form-control" id="ward" name="ward">
                            <option value="">Select Ward</option>
                            <?php foreach ($wards as $ward) { ?>
                                <option value="<?php echo $ward['id']; ?>"><?php echo $ward['short_name'] . " - " . $ward['name']; ?> | <?php echo $ward['available_beds']; ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <?php
                    $beds = $bedQuery->getAvailableBeds();
                    ?>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Bed</label>
                        <select class="form-control" id="bed" name="bed">
                            <option value="">Select Bed</option>
                            <?php foreach ($beds as $bed) { ?>
                                <option value="<?php echo $bed['id']; ?>"><?php echo $bed['number']; ?> - <?php echo $bed['bed_type']; ?> - <?php echo $bed['price_per_day']; ?></option>
                            <?php
                            }  ?>
                        </select>
                    </div>


                    <div class=" form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="transfer_date">Transfer Date</label>
                                <input type="date" class="form-control" name="transfer_date">
                            </div>
                        </div>
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