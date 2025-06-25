<?php

/**
 * ASQ-3: 2-Month Questionnaire form.
 *
 * @package   MedSov EMR
 * @link      https://www.medsov.com
 * @author    Mark Amoah <mcprah@gmail.com>
 * @copyright Copyright (c) 2025 Medsov <info@medsov.com> Omega Systems
 */

require_once(__DIR__ . "/../../globals.php");
require_once("$srcdir/api.inc.php");

formHeader("2-Month ASQ Questionnaire");

?>
<html>

<head>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-4">
        <h1 class="mb-3">Ages &amp; Stages Questionnaires® (ASQ®): 2-Month Questionnaire</h1>
        <p class="fst-italic">To be filled out by parent or caregiver</p>
        <h2 class="mt-4">General Instructions</h2>
        <p>Please read each question carefully and select the option that best describes your child’s ability. Answer based on what your child is doing now. If your child has a medical condition, please explain at the end of the questionnaire.</p>

        <form action="#" method="post" id="asqForm">
            <!-- Baby’s Information -->
            <fieldset class="border p-4 mb-5">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">Baby’s information</legend>
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
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="baby-gender" id="gender-male" value="Male">
                            <label class="form-check-label" for="gender-male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="baby-gender" id="gender-female" value="Female">
                            <label class="form-check-label" for="gender-female">Female</label>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Person filling out questionnaire -->
            <fieldset class="border p-4 mb-5">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">Person filling out questionnaire</legend>
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
                <div class="mb-3">
                    <label class="form-label d-block">Relationship to baby</label>
                    <div class="row gx-2 gy-1">
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="radio" name="relationship" id="rel-parent" value="Parent">
                            <label class="form-check-label" for="rel-parent">Parent</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="radio" name="relationship" id="rel-grandparent" value="Grandparent or other relative">
                            <label class="form-check-label" for="rel-grandparent">Grandparent or other relative</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="radio" name="relationship" id="rel-guardian" value="Guardian">
                            <label class="form-check-label" for="rel-guardian">Guardian</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="radio" name="relationship" id="rel-foster" value="Foster parent">
                            <label class="form-check-label" for="rel-foster">Foster parent</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="radio" name="relationship" id="rel-teacher" value="Teacher">
                            <label class="form-check-label" for="rel-teacher">Teacher</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="radio" name="relationship" id="rel-provider" value="Child care provider">
                            <label class="form-check-label" for="rel-provider">Child care provider</label>
                        </div>
                        <div class="col-md-4 d-flex align-items-center form-check">
                            <input class="form-check-input" type="radio" name="relationship" id="rel-other" value="Other">
                            <label class="form-check-label ms-1 me-2" for="rel-other">Other</label>
                            <input type="text" class="form-control form-control-sm" id="relationship-other-text" name="relationship-other-text" placeholder="Specify">
                        </div>
                    </div>
                </div>

                <!-- Assisting names -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label" for="assisting-name-1">Names assisting with completion</label>
                    </div>
                    <div class="row g-3 mt-0">
                        <div class="col-md-6 mt-md-0">
                            <input type="text" class="form-control mb-1" id="assisting-name-1" name="assisting-name-1" placeholder="Name 1">
                        </div>
                        <div class="col-md-6 mt-md-0">
                            <input type="text" class="form-control" id="assisting-name-2" name="assisting-name-2" placeholder="Name 2">
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Program Information -->
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
            <!-- End Program Information -->

            <fieldset class="border p-3 mb-4">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">Communication</legend>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:3%"></th>
                                <th style="width:60%"> </th>
                                <th class="text-center" style="width:10%">Yes</th>
                                <th class="text-center" style="width:14%">Sometimes</th>
                                <th class="text-center" style="width:13%">Not Yet</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Does your baby sometimes make throaty or gurgling sounds?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-1" id="comm-1-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-1" id="comm-1-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-1" id="comm-1-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Does your baby make cooing sounds such as “ooo,” “gah,” and “aah”?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-2" id="comm-2-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-2" id="comm-2-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-2" id="comm-2-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>When you speak to your baby, does she make sounds back to you?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-3" id="comm-3-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-3" id="comm-3-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-3" id="comm-3-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Does your baby smile when you talk to him?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-4" id="comm-4-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-4" id="comm-4-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-4" id="comm-4-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Does your baby chuckle softly?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-5" id="comm-5-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-5" id="comm-5-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-5" id="comm-5-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>After you have been out of sight, does your baby smile or get excited when she sees you?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-6" id="comm-6-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-6" id="comm-6-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="comm-6" id="comm-6-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold" style="font-size:1.1rem;">COMMUNICATION TOTAL</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm text-center" name="comm-total" id="comm-total" style="width:5em;" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </fieldset>

            <fieldset class="border p-3 mb-4">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">Gross Motor</legend>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:3%"></th>
                                <th style="width:60%"></th>
                                <th class="text-center" style="width:10%">Yes</th>
                                <th class="text-center" style="width:14%">Sometimes</th>
                                <th class="text-center" style="width:13%">Not Yet</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>While your baby is on his back, does he wave his arms and legs, wiggle, and squirm?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-1" id="gross-1-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-1" id="gross-1-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-1" id="gross-1-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>When your baby is on her tummy, does she turn her head to the side?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-2" id="gross-2-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-2" id="gross-2-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-2" id="gross-2-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>When your baby is on his tummy, does he hold his head up longer than a few seconds?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-3" id="gross-3-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-3" id="gross-3-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-3" id="gross-3-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>When your baby is on her back, does she kick her legs?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-4" id="gross-4-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-4" id="gross-4-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-4" id="gross-4-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>While your baby is on his back, does he move his head from side to side?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-5" id="gross-5-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-5" id="gross-5-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-5" id="gross-5-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>After holding her head up while on her tummy, does your baby lay her head back down on the floor, rather than let it drop or fall forward?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-6" id="gross-6-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-6" id="gross-6-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="gross-6" id="gross-6-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold" style="font-size:1.1rem;">GROSS MOTOR TOTAL</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm text-center" name="gross-total" id="gross-total" style="width:5em;" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </fieldset>

            <fieldset class="border p-3 mb-4">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">Fine Motor</legend>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:3%"></th>
                                <th style="width:60%"></th>
                                <th class="text-center" style="width:10%">Yes</th>
                                <th class="text-center" style="width:14%">Sometimes</th>
                                <th class="text-center" style="width:13%">Not Yet</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>
                                    Is your baby’s hand usually tightly closed when he is awake?
                                    <span class="fst-italic small">(If your baby used to do this but no longer does, mark “yes.”)</span>
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-1" id="fine-1-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-1" id="fine-1-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-1" id="fine-1-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>
                                    Does your baby grasp your finger if you touch the palm of her hand?
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-2" id="fine-2-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-2" id="fine-2-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-2" id="fine-2-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>
                                    When you put a toy in his hand, does your baby hold it in his hand briefly?
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-3" id="fine-3-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-3" id="fine-3-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-3" id="fine-3-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Does your baby touch her face with her hands?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-4" id="fine-4-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-4" id="fine-4-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-4" id="fine-4-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>
                                    Does your baby hold his hands open or partly open when he is awake (rather than in fists, as they were when he was a newborn)?
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-5" id="fine-5-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-5" id="fine-5-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-5" id="fine-5-not-yet" value="not-yet">
                                </td>
                                <td class="text-center align-middle" style="font-size:1.2em;">*</td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>Does your baby grab or scratch at her clothes?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-6" id="fine-6-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-6" id="fine-6-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="fine-6" id="fine-6-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold" style="font-size:1.1rem;">FINE MOTOR TOTAL</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm text-center" name="fine-total" id="fine-total" style="width:5em;" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="small text-muted mt-2">
                        *If Fine Motor item 5 is marked “yes,” mark Fine Motor item 1 as “yes.”
                    </div>
                </div>
            </fieldset>

            <fieldset class="border p-3 mb-4">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">Problem Solving</legend>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:3%"></th>
                                <th style="width:60%"></th>
                                <th class="text-center" style="width:10%">Yes</th>
                                <th class="text-center" style="width:14%">Sometimes</th>
                                <th class="text-center" style="width:13%">Not Yet</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1.</td>
                                <td>Does your baby look at objects that are 8–10 inches away?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-1" id="ps-1-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-1" id="ps-1-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-1" id="ps-1-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>When you move around, does your baby follow you with his eyes?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-2" id="ps-2-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-2" id="ps-2-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-2" id="ps-2-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>When you move a toy slowly from side to side in front of your baby’s face (about 10 inches away), does your baby follow the toy with her eyes, sometimes turning her head?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-3" id="ps-3-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-3" id="ps-3-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-3" id="ps-3-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>When you move a small toy up and down slowly in front of your baby’s face (about 10 inches away), does your baby follow the toy with his eyes?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-4" id="ps-4-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-4" id="ps-4-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-4" id="ps-4-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>When you hold your baby in a sitting position, does she look at a toy (about the size of a cup or rattle) that you place on the table or floor in front of her?</td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-5" id="ps-5-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-5" id="ps-5-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-5" id="ps-5-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>
                                    When you dangle a toy above your baby while he is lying on his back, does he wave his arms toward the toy?
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-6" id="ps-6-yes" value="yes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-6" id="ps-6-sometimes" value="sometimes">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="ps-6" id="ps-6-not-yet" value="not-yet">
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end fw-bold" style="font-size:1.1rem;">PROBLEM SOLVING TOTAL</td>
                                <td>
                                    <input type="text" class="form-control form-control-sm text-center" name="ps-total" id="ps-total" style="width:5em;" readonly>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </fieldset>

            <fieldset class="border p-3 mb-4">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">5. Personal-Social</legend>
                <div class="mb-3">
                    <label class="form-label">5.1 Does your baby enjoy being held or cuddled?</label>
                    <div class="form-check"><input class="form-check-input" type="radio" name="q5-1" id="q5-1-yes" value="yes"><label class="form-check-label" for="q5-1-yes">Yes</label></div>
                    <div class="form-check"><input class="form-check-input" type="radio" name="q5-1" id="q5-1-sometimes" value="sometimes"><label class="form-check-label" for="q5-1-sometimes">Sometimes</label></div>
                    <div class="form-check"><input class="form-check-input" type="radio" name="q5-1" id="q5-1-not-yet" value="not-yet"><label class="form-check-label" for="q5-1-not-yet">Not yet</label></div>
                </div>
                <!-- ... questions 5.2 to 5.6 ... -->
            </fieldset>

            <fieldset class="border p-3 mb-4">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">6. Overall Section</legend>
                <div class="mb-3">
                    <label class="form-label">6.1 Do you think your child hears well?</label>
                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="q6-1" id="q6-1-yes" value="yes"><label class="form-check-label" for="q6-1-yes">Yes</label></div>
                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="q6-1" id="q6-1-no" value="no"><label class="form-check-label" for="q6-1-no">No</label></div>
                    <textarea class="form-control mt-2" id="q6-1-comment" name="q6-1-comment" placeholder="Comment"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">6.2 Do you think your child sees well?</label>
                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="q6-2" id="q6-2-yes" value="yes"><label class="form-check-label" for="q6-2-yes">Yes</label></div>
                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="q6-2" id="q6-2-no" value="no"><label class="form-check-label" for="q6-2-no">No</label></div>
                    <textarea class="form-control mt-2" id="q6-2-comment" name="q6-2-comment" placeholder="Comment"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">6.3 If you have concerns about your child’s behavior, describe:</label>
                    <textarea class="form-control" id="q6-3" name="q6-3" placeholder="Describe concerns"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">6.4 Other concerns:</label>
                    <textarea class="form-control" id="q6-4" name="q6-4" placeholder="Other concerns"></textarea>
                </div>
            </fieldset>

            <fieldset class="border p-3 mb-4">
                <legend class="float-none w-auto px-2 fw-bold text-center w-100">Parent/Caregiver Information</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="child-name" class="form-label">Child’s Name</label>
                        <input type="text" class="form-control" id="child-name" name="child-name">
                    </div>
                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob">
                    </div>
                    <div class="col-md-6">
                        <label for="completed-by" class="form-label">Completed By</label>
                        <input type="text" class="form-control" id="completed-by" name="completed-by">
                    </div>
                    <div class="col-md-6">
                        <label for="relationship" class="form-label">Relationship to Child</label>
                        <input type="text" class="form-control" id="relationship" name="relationship">
                    </div>
                    <div class="col-md-6">
                        <label for="date-completed" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date-completed" name="date-completed">
                    </div>
                </div>
            </fieldset>

            <div class="text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#previewModal" id="previewButton">Preview &amp; Submit</button>
            </div>
        </form>
    </div>


    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Preview Your Responses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="previewBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Edit</button>
                    <button type="button" class="btn btn-primary" id="modalSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('previewButton').addEventListener('click', function() {
            const form = document.getElementById('asqForm');
            const data = new FormData(form);
            let html = '';
            data.forEach((value, key) => {
                html += `<p><strong>${key.replace(/\-/g, ' ')}:</strong> ${value}</p>`;
            });
            document.getElementById('previewBody').innerHTML = html;
        });
        document.getElementById('modalSubmit').addEventListener('click', function() {
            document.getElementById('asqForm').submit();
        });
    </script>
</body>

</html>

<?php
formFooter();
?>