<?php
// Person Filling Out Questionnaire Section
?>
<fieldset class="border p-4 mb-5">
    <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Person filling out questionnaire</legend>
    <div class="row g-3 mb-3">
        <!-- Name -->
        <div class="col-md-4">
            <label for="person-first-name" class="form-label">First name</label>
            <input type="text" class="form-control" id="person-first-name" name="person-first-name">
        </div>
        <div class="col-md-2">
            <label for="person-middle-initial" class="form-label">Middle Initial</label>
            <input type="text" class="form-control text-center" id="person-middle-initial" name="person-middle-initial" maxlength="1">
        </div>
        <div class="col-md-6">
            <label for="person-last-name" class="form-label">Last name</label>
            <input type="text" class="form-control" id="person-last-name" name="person-last-name">
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-8">
            <label for="street-address" class="form-label">Street address</label>
            <input type="text" class="form-control" id="street-address" name="street-address">
        </div>
        <div class="col-md-4">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country">
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city">
        </div>
        <div class="col-md-4">
            <label for="state-province" class="form-label">State/Province</label>
            <input type="text" class="form-control" id="state-province" name="state-province">
        </div>
        <div class="col-md-4">
            <label for="zip-postal" class="form-label">ZIP/Postal code</label>
            <input type="text" class="form-control" id="zip-postal" name="zip-postal">
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <label for="home-phone" class="form-label">Home telephone</label>
            <input type="tel" class="form-control" id="home-phone" name="home-phone">
        </div>
        <div class="col-md-4">
            <label for="other-phone" class="form-label">Other telephone</label>
            <input type="tel" class="form-control" id="other-phone" name="other-phone">
        </div>
        <div class="col-md-4">
            <label for="email" class="form-label">E-mail address</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
    </div>
    <!-- Relationship -->
    <div class="row mb-3">
        <div class="col-md-12">
            <label class="form-label d-block">Relationship to baby</label>
            <div class="row">
                <div class="col-md-4">
                    <input class="form-control-input" type="radio" name="relationship" id="rel-parent" value="Parent">
                    <label class="form-control-label" for="rel-parent">Parent</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control-input" type="radio" name="relationship" id="rel-grandparent" value="Grandparent or other relative">
                    <label class="form-control-label" for="rel-grandparent">Grandparent or other relative</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control-input" type="radio" name="relationship" id="rel-guardian" value="Guardian">
                    <label class="form-control-label" for="rel-guardian">Guardian</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control-input" type="radio" name="relationship" id="rel-foster" value="Foster parent">
                    <label class="form-control-label" for="rel-foster">Foster parent</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control-input" type="radio" name="relationship" id="rel-teacher" value="Teacher">
                    <label class="form-control-label" for="rel-teacher">Teacher</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control-input" type="radio" name="relationship" id="rel-provider" value="Child care provider">
                    <label class="form-control-label" for="rel-provider">Child care provider</label>
                </div>
                <div class="col-md-4 d-flex align-items-center">
                    <input class="form-control-input" type="radio" name="relationship" id="rel_other" value="Other">
                    <label class="form-control-label mr-2" for="rel_other">Other</label>
                    <input type="text" class="form-control form-control-sm" id="relationship_other_text" name="relationship_other_text" placeholder="Specify">
                </div>
            </div>
        </div>
    </div>

    <!-- Assisting names -->
    <div class="row mb-3">
        <div class="col-md-12">
            <label class="form-label" for="assisting-name-1">Names assisting with completion</label>
        </div>

        <div class="col-md-6 mt-md-0">
            <input type="text" class="form-control mb-1" id="assisting_name_1" name="assisting_name_1" placeholder="Name 1">
        </div>
        <div class="col-md-6 mt-md-0">
            <input type="text" class="form-control" id="assisting_name_2" name="assisting_name_2" placeholder="Name 2">
        </div>

    </div>
</fieldset>