<!-- vital modal -->
<div class="modal fade" id="wardReferral" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Referral</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="referral" value="">
                    <input type="hidden" name="ref_admission_id" id="ref_admission_id" value="">
                    <input type="hidden" name="ref_bed_id" id="ref_bed_id" value="">
                    <input type="hidden" name="pid" id="ref_patient_id" value="">
                    <input type="hidden" name="billing_facility_id" id="trs_patient_id" value="1">

                    <div class="form-group">
                        <label for="transfer_date">Referral Date</label>
                        <input type="date" class="form-control" name="refer_date" value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="form-group">
                        <label for="referred_by">Referred By</label>
                        <select class="form-control" id="refer_from" name="refer_from">
                            <option value="">Select User</option>
                            <?php foreach ($providers as $provider) { ?>
                                <option value="<?php echo $provider['id']; ?>"><?php echo $provider['fname'] . " " . $provider['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="referred_by">Referred To</label>
                        <select class="form-control" id="refer_to" name="refer_to">
                            <option value="">Select User</option>
                            <?php foreach ($providers as $provider) { ?>
                                <option value="<?php echo $provider['id']; ?>"><?php echo $provider['fname'] . " " . $provider['lname']; ?> </option>
                            <?php
                            }  ?>
                        </select>
                    </div>


                    <div class=" form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="refer_external">External Referral</label>
                                <select class="form-control" id="refer_external" name="refer_external">
                                    <option value="">Unassigned</option>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="refer_risk_level">Risk Level</label>
                                <select class="form-control" id="refer_risk_level" name="refer_risk_level">
                                    <option value="">Unassigned</option>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="transfer_date">Reason</label>
                        <textarea cols="30" rows="4" class="form-control" name="body" id="body"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="transfer_date">Referral Diagnosis</label>
                        <input type="text" class="form-control" name="refer_diag">
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