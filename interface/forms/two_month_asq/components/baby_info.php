<?php
// Baby's Information Section
function render_baby_info($data = [])
{
?>
    <fieldset class="border p-4 mb-5">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Baby's information</legend>
        <div class="row g-3 mb-3">
            <!-- Name -->
            <div class="col-md-4">
                <label for="baby_first_name" class="form-label">First name</label>
                <input type="text" class="form-control" id="baby_first_name" name="baby_first_name" value="<?php echo htmlspecialchars($data['baby_first_name'] ?? '', ENT_QUOTES); ?>">
            </div>
            <div class="col-md-2">
                <label for="baby_middle_initial" class="form-label">Middle Initial</label>
                <input type="text" class="form-control text-center" id="baby_middle_initial" name="baby_middle_initial" maxlength="1" value="<?php echo htmlspecialchars($data['baby_middle_initial'] ?? '', ENT_QUOTES); ?>">
            </div>
            <div class="col-md-6">
                <label for="baby_last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" id="baby_last_name" name="baby_last_name" value="<?php echo htmlspecialchars($data['baby_last_name'] ?? '', ENT_QUOTES); ?>">
            </div>
        </div>
        <div class="row g-3 mb-3">
            <!-- Date of Birth -->
            <div class="col-md-4">
                <label for="baby_dob" class="form-label">Date of birth</label>
                <input type="date" class="form-control" id="baby_dob" name="baby_dob" value="<?php echo htmlspecialchars($data['baby_dob'] ?? '', ENT_QUOTES); ?>">
            </div>
            <!-- Prematurity -->
            <div class="col-md-4">
                <label for="premature_weeks" class="form-label">
                    If ≥3 weeks premature, weeks premature
                </label>
                <input type="number" class="form-control" id="baby_premature_weeks" name="baby_premature_weeks" min="0" value="<?php echo htmlspecialchars($data['premature_weeks'] ?? '', ENT_QUOTES); ?>">
            </div>
            <!-- Gender -->
            <div class="col-md-4">
                <label class="form-label d-block">Gender</label>
                <div class="form-control form-control-inline">
                    <input class="form-control-input" type="radio" name="baby_gender" id="gender_male" value="Male" <?php if (($data['baby-gender'] ?? '') === 'Male') echo 'checked'; ?>>
                    <label class="form-control-label" for="gender-male">Male</label>
                </div>
                <div class="form-control form-control-inline">
                    <input class="form-control-input" type="radio" name="baby_gender" id="gender_female" value="Female" <?php if (($data['baby-gender'] ?? '') === 'Female') echo 'checked'; ?>>
                    <label class="form-control-label" for="gender-female">Female</label>
                </div>
            </div>
        </div>
    </fieldset>
<?php }
