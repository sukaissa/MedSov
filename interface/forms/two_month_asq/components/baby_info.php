<?php
// Baby’s Information Section
?>
<fieldset class="border p-4 mb-5">
    <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Baby’s information</legend>
    <div class="row g-3 mb-3">
        <!-- Name -->
        <div class="col-md-4">
            <label for="baby-first-name" class="form-label">First name</label>
            <input type="text" class="form-control" id="baby-first-name" name="baby-first-name">
        </div>
        <div class="col-md-2">
            <label for="baby-middle-initial" class="form-label">Middle Initial</label>
            <input type="text" class="form-control text-center" id="baby-middle-initial" name="baby-middle-initial" maxlength="1">
        </div>
        <div class="col-md-6">
            <label for="baby-last-name" class="form-label">Last name</label>
            <input type="text" class="form-control" id="baby-last-name" name="baby-last-name">
        </div>
    </div>
    <div class="row g-3 mb-3">
        <!-- Date of Birth -->
        <div class="col-md-4">
            <label for="baby-dob" class="form-label">Date of birth</label>
            <input type="date" class="form-control" id="baby-dob" name="baby-dob">
        </div>
        <!-- Prematurity -->
        <div class="col-md-4">
            <label for="premature-weeks" class="form-label">
                If ≥3 weeks premature, weeks premature
            </label>
            <input type="number" class="form-control" id="premature-weeks" name="premature-weeks" min="0">
        </div>
        <!-- Gender -->
        <div class="col-md-4">
            <label class="form-label d-block">Gender</label>
            <div class="form-control form-control-inline">
                <input class="form-control-input" type="radio" name="baby-gender" id="gender-male" value="Male">
                <label class="form-control-label" for="gender-male">Male</label>
            </div>
            <div class="form-control form-control-inline">
                <input class="form-control-input" type="radio" name="baby-gender" id="gender-female" value="Female">
                <label class="form-control-label" for="gender-female">Female</label>
            </div>
        </div>
    </div>
</fieldset>
