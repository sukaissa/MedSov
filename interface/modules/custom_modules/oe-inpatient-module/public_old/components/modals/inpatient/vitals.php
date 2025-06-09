<!-- vital modal -->
<div class="modal fade" id="inpatientVitals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Inpatient Vitals</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method='POST' action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="inpatient_vitals" value="">
                    <input type="hidden" name="vit_admission_id" id="vit_admission_id" value="">
                    <input type="hidden" name="vit_pid" id="vit_pid" value="">

                    <div class="form-group">
                        <label for="formGroupExampleInput">Blood Pressure</label>
                        <input type="text" class="form-control" id="blood_pressure" name="blood_pressure">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput2">Pulse</label>
                        <input type="text" class="form-control" id="pulse" name="pulse">
                    </div>
                    <div class="form-group">
                        <label for="">SPO2</label>
                        <input type="text" class="form-control" id="spo_2" name="spo_2" ">
                    </div>

                    <div class=" form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Temperature</label>
                                <input type="number" min="0" class="form-control" id="temperature" name="temperature">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Respiratory Rate</label>
                                <input type="number" min="0" class="form-control" id="respiratory_rate" name="respiratory_rate">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Height</label>
                                <input type="number" class="form-control" id="height" name="height">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Weight</label>
                                <input type="number" class="form-control" id="weight" name="weight">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Fluid Input</label>
                                <input type="text" class="form-control" id="fluid_input" name="fluid_input">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Fluid Output</label>
                                <input type="text" class="form-control" id="fluid_output" name="fluid_output">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="formGroupExampleInput2">Time Taken</label>
                        <input type="time" name="time_taken" class="form-control" id="formGroupExampleInput2">
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