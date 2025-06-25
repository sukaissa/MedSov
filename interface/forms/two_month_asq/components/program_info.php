<?php
// Program Information Section
?>
<fieldset class="border p-4 mb-5">
    <legend class="float-none w-auto px-2 fw-bold text-center w-100">Program Information</legend>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label" for="baby-id">Baby ID #</label>
            <input type="text" class="form-control" id="baby-id" name="baby-id" maxlength="30">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="program-id">Program ID #</label>
            <input type="text" class="form-control" id="program-id" name="program-id" maxlength="30">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label" for="program-name">Program name</label>
            <input type="text" class="form-control" id="program-name" name="program-name" maxlength="100">
        </div>
        <div class="col-md-3">
            <label class="form-label" for="age-admin-mm">Age at administration (months)</label>
            <input type="number" class="form-control" id="age-admin-mm" name="age-admin-mm" min="0" max="60">
        </div>
        <div class="col-md-3">
            <label class="form-label" for="age-admin-dd">Age at administration (days)</label>
            <input type="number" class="form-control" id="age-admin-dd" name="age-admin-dd" min="0" max="31">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6">
            <label class="form-label" for="adj-age-mm">Adjusted age (months, if premature)</label>
            <input type="number" class="form-control" id="adj-age-mm" name="adj-age-mm" min="0" max="60">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="adj-age-dd">Adjusted age (days, if premature)</label>
            <input type="number" class="form-control" id="adj-age-dd" name="adj-age-dd" min="0" max="31">
        </div>
    </div>
</fieldset>
