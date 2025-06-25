<?php
// Person Filling Out Questionnaire Section
function render_person_filling($data = []) {
?>
    <fieldset class="border p-4 mb-5">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Person filling out questionnaire</legend>
        <div class="row g-3 mb-3">
            <!-- Name -->
            <div class="col-md-4">
                <label for="pf_first_name" class="form-label">First name</label>
                <input type="text" class="form-control" id="pf_first_name" name="pf_first_name" value="<?php echo htmlspecialchars($data['pf_first_name'] ?? ''); ?>">
            </div>
            <div class="col-md-2">
                <label for="pf_middle_initial" class="form-label">Middle Initial</label>
                <input type="text" class="form-control text-center" id="pf_middle_initial" name="pf_middle_initial" maxlength="1" value="<?php echo htmlspecialchars($data['pf_middle_initial'] ?? ''); ?>">
            </div>
            <div class="col-md-6">
                <label for="pf_last_name" class="form-label">Last name</label>
                <input type="text" class="form-control" id="pf_last_name" name="pf_last_name" value="<?php echo htmlspecialchars($data['pf_last_name'] ?? ''); ?>">
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-8">
                <label for="street_address" class="form-label">Street address</label>
                <input type="text" class="form-control" id="pf_street_address" name="pf_street_address" value="<?php echo htmlspecialchars($data['pf_street_address'] ?? ''); ?>">
            </div>
            <div class="col-md-4">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control" id="pf_country" name="cpf_ountry" value="<?php echo htmlspecialchars($data['pf_country'] ?? ''); ?>">
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" id="pf_city" name="pf_city" value="<?php echo htmlspecialchars($data['pf_city'] ?? ''); ?>">
            </div>
            <div class="col-md-4">
                <label for="state_province" class="form-label">State/Province</label>
                <input type="text" class="form-control" id="pf_state_province" name="pf_state_province" value="<?php echo htmlspecialchars($data['pf_state_province'] ?? ''); ?>">
            </div>
            <div class="col-md-4">
                <label for="zip_postal" class="form-label">ZIP/Postal code</label>
                <input type="text" class="form-control" id="pf_zip_postal" name="pf_zip_postal" value="<?php echo htmlspecialchars($data['pf_zip_postal'] ?? ''); ?>">
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="home_phone" class="form-label">Home telephone</label>
                <input type="tel" class="form-control" id="pf_home_phone" name="pf_home_phone" value="<?php echo htmlspecialchars($data['pf_home_phone'] ?? ''); ?>">
            </div>
            <div class="col-md-4">
                <label for="other_phone" class="form-label">Other telephone</label>
                <input type="tel" class="form-control" id="pf_other_phone" name="pf_other_phone" value="<?php echo htmlspecialchars($data['pf_other_phone'] ?? ''); ?>">
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail address</label>
                <input type="email" class="form-control" id="pf_email" name="pf_email" value="<?php echo htmlspecialchars($data['pf_email'] ?? ''); ?>">
            </div>
        </div>
        <!-- Relationship -->
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label d-block">Relationship to baby</label>
                <div class="row">
                    <?php
                    $relationships = [
                        'Parent' => 'Parent',
                        'Grandparent or other relative' => 'Grandparent or other relative',
                        'Guardian' => 'Guardian',
                        'Foster parent' => 'Foster parent',
                        'Teacher' => 'Teacher',
                        'Child care provider' => 'Child care provider',
                        'Other' => 'Other'
                    ];
                    $selected_relationship = $data['relationship'] ?? '';
                    foreach ($relationships as $value => $label) {
                        $id = 'rel_' . strtolower(str_replace([' ', '/'], ['_', ''], $value));
                        $checked = ($selected_relationship === $value) ? 'checked' : '';
                        echo '<div class="col-md-4 d-flex align-items-center">';
                        echo '<input class="form-control-input mr-1" type="radio" name="pf_relationship" id="' . $id . '" value="' . htmlspecialchars($value) . '" ' . $checked . '>';
                        echo '<label class="form-control-label mr-3" for="' . $id . '">' . $label . '</label>';
                        if ($value === 'Other') {
                            $other_val = htmlspecialchars($data['pf_relationship_other'] ?? '');
                            echo '<input type="text" class="form-control form-control-sm" id="relationship_other_text" name="pf_relationship_other" placeholder="Specify" value="' . $other_val . '">';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Assisting names -->
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label" for="pf_assisting_name_1">Names assisting with completion</label>
            </div>
            <div class="col-md-6 mt-md-0">
                <input type="text" class="form-control mb-1" id="pf_assisting_name_1" name="pf_assisting_name_1" placeholder="Name 1" value="<?php echo htmlspecialchars($data['pf_assisting_name_1'] ?? ''); ?>">
            </div>
            <div class="col-md-6 mt-md-0">
                <input type="text" class="form-control" id="pf_assisting_name_2" name="pf_assisting_name_2" placeholder="Name 2" value="<?php echo htmlspecialchars($data['pf_assisting_name_2'] ?? ''); ?>">
            </div>
        </div>
    </fieldset>
<?php
}
