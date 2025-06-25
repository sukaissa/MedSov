<?php
// Program Information Section
?>
<fieldset class="border p-4 mb-5">
    <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Program Information</legend>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label" for="baby_id">Baby ID #</label>
            <input type="text" class="form-control" id="baby_id" name="baby_id" maxlength="30">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="program_id">Program ID #</label>
            <input type="text" class="form-control" id="program_id" name="program_id" maxlength="30">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label" for="program_name">Program name</label>
            <input type="text" class="form-control" id="program_name" name="program_name" maxlength="100">
        </div>
        <div class="col-md-3">
            <label class="form-label" for="age_admin_mm">Age at administration (months)</label>
            <input type="number" class="form-control" id="age_admin_mm" name="age_admin_mm" min="0" max="60">
        </div>
        <div class="col-md-3">
            <label class="form-label" for="age_admin_dd">Age at administration (days)</label>
            <input type="number" class="form-control" id="age_admin_dd" name="age_admin_dd" min="0" max="31">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <label class="form-label" for="adj_age_mm">Adjusted age (months, if premature)</label>
            <input type="number" class="form-control" id="adj_age_mm" name="adj_age_mm" min="0" max="60">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="adj_age_dd">Adjusted age (days, if premature)</label>
            <input type="number" class="form-control" id="adj_age_dd" name="adj_age_dd" min="0" max="31">
        </div>
    </div>
</fieldset>
