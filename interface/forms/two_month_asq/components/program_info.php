<?php
// Program Information Section
function render_program_info($data = [])
{
?>
    <fieldset class="border p-4 mb-5">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Program Information</legend>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label" for="baby_id">Baby ID #</label>
                <input type="text" class="form-control" id="program_baby_id" name="program_baby_id" maxlength="30" value="<?php echo htmlspecialchars($data['program_baby_id'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="program_id">Program ID #</label>
                <input type="text" class="form-control" id="program_id" name="program_id" maxlength="30" value="<?php echo htmlspecialchars($data['program_id'] ?? ''); ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label" for="program_name">Program name</label>
                <input type="text" class="form-control" id="program_name" name="program_name" maxlength="100" value="<?php echo htmlspecialchars($data['program_name'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="program_age_admin_months">Age at administration (months)</label>
                <input type="number" class="form-control" id="program_age_admin_months" name="program_age_admin_months" min="0" max="60" value="<?php echo htmlspecialchars($data['program_age_admin_months'] ?? ''); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label" for="program_age_admin_days">Age at administration (days)</label>
                <input type="number" class="form-control" id="program_age_admin_days" name="program_age_admin_days" min="0" max="31" value="<?php echo htmlspecialchars($data['program_age_admin_days'] ?? ''); ?>">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <label class="form-label" for="program_adj_age_months">Adjusted age (months, if premature)</label>
                <input type="number" class="form-control" id="program_adj_age_months" name="program_adj_age_months" min="0" max="60" value="<?php echo htmlspecialchars($data['program_adj_age_months'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label" for="program_adj_age_days">Adjusted age (days, if premature)</label>
                <input type="number" class="form-control" id="program_adj_age_days" name="program_adj_age_days" min="0" max="31" value="<?php echo htmlspecialchars($data['program_adj_age_dd'] ?? ''); ?>">
            </div>
        </div>
    </fieldset>
<?php
}
