<?php
/*
 * ASQ-3: 2-Month Questionnaire Form report.php
 *
 * @package   MedSov EMR
 * @link      https://www.medsov.com
 * @author    Mark Amoah <mcprah@gmail.com>
 * @copyright Copyright (c) 2025 Medsov <info@medsov.com> Omega Systems
 */

require_once(dirname(__FILE__) . '/../../globals.php');
require_once($GLOBALS["srcdir"] . "/api.inc.php");

function two_month_asq_report($pid, $encounter, $cols, $id)
{
    $data = formFetch("form_two_month_asq", $id);
    if (!$data) {
        echo "<p>" . xlt("No data found for this form.") . "</p>";
        return;
    }
    // Helper for formatting
    function _asq_val($val, $key = '')
    {
        if ($val === '' || $val === '0000-00-00' || $val === '0000-00-00 00:00:00') return '';
        if (strpos($key, 'dob') !== false || strpos($key, 'date') !== false) return oeFormatShortDate($val);
        return text($val);
    }
    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "<div class='col-md-12 p-4'>";
    echo "<h3 class='mb-4'>" . xlt("Ages & Stages Questionnaires® (ASQ®): 2-Month Questionnaire") . "</h3>";

    // Baby's Information
    echo "<fieldset class='border p-2 mb-5'><legend class='w-auto px-2 font-weight-medium'>" . xlt("Baby's information") . "</legend>";
    echo "<table class='table table-sm'>";
    $baby = [
        'baby_first_name' => 'First name',
        'baby_middle_initial' => 'Middle Initial',
        'baby_last_name' => 'Last name',
        'baby_dob' => 'Date of birth',
        'baby_premature_weeks' => 'Weeks premature',
        'baby_gender' => 'Gender',
    ];
    foreach ($baby as $k => $label) {
        if ($v = _asq_val($data[$k] ?? '', $k)) {
            echo "<tr><td class='width:70%'>" . xlt($label) . "</td><td class='width:30%'><strong>" . $v . "</strong></td></tr>";
        }
    }
    echo "</table></fieldset>";

    // Person Filling Out Questionnaire
    echo "<fieldset class='border p-2 mb-4'><legend class='w-auto px-2 font-weight-medium'>" . xlt("Person filling out questionnaire") . "</legend>";
    echo "<table class='table table-sm'>";
    $pf = [
        'pf_first_name' => 'First name',
        'pf_middle_initial' => 'Middle Initial',
        'pf_last_name' => 'Last name',
        'pf_street_address' => 'Street address',
        'pf_country' => 'Country',
        'pf_city' => 'City',
        'pf_state_province' => 'State/Province',
        'pf_zip_postal' => 'ZIP/Postal code',
        'pf_home_phone' => 'Home telephone',
        'pf_other_phone' => 'Other telephone',
        'pf_email' => 'E-mail address',
        'pf_relationship' => 'Relationship to baby',
        'pf_relationship_other' => 'Other relationship (specify)',
        'pf_assisting_name_1' => 'Names assisting with completion 1',
        'pf_assisting_name_2' => 'Names assisting with completion 2',
    ];
    foreach ($pf as $k => $label) {
        if ($v = _asq_val($data[$k] ?? '', $k)) {
            echo "<tr><td class='width:70%'>" . xlt($label) . "</td><td class='width:30%'><strong>" . $v . "</strong></td></tr>";
        }
    }
    echo "</table></fieldset>";

    // Program Information
    echo "<fieldset class='border p-2 mb-4'><legend class='w-auto px-2 font-weight-medium'>" . xlt("Program Information") . "</legend>";
    echo "<table class='table table-sm'>";
    $prog = [
        'program_baby_id' => 'Baby ID #',
        'program_id' => 'Program ID #',
        'program_name' => 'Program name',
        'program_age_admin_months' => 'Age at administration (months)',
        'program_age_admin_days' => 'Age at administration (days)',
        'program_adj_age_months' => 'Adjusted age (months, if premature)',
        'program_adj_age_days' => 'Adjusted age (days, if premature)',
    ];
    foreach ($prog as $k => $label) {
        if ($v = _asq_val($data[$k] ?? '', $k)) {
            echo "<tr><td class='width:70%'>" . xlt($label) . "</td><td class='width:30%'><strong>" . $v . "</strong></td></tr>";
        }
    }
    echo "</table></fieldset>";

    // Section helper for 6-question domains
    function asq_section($legend, $prefix, $labels, $data)
    {
        echo "<fieldset class='border p-2 mb-4'><legend class='w-auto px-2 font-weight-medium'>" . xlt($legend) . "</legend>";
        echo "<table class='table table-sm'>";
        foreach ($labels as $i => $q) {
            $k = $prefix . "_" . $i;
            if ($v = _asq_val($data[$k] ?? '', $k)) {
                echo "<tr><td class='width:70%'>" . xlt($q) . "</td><td class='width:30%'><strong>" . xlt(ucfirst(str_replace('_', ' ', $v))) . "</strong></td></tr>";
            }
        }
        $total = $data[$prefix . '_total'] ?? '';
        if ($total !== '') {
            echo "<tr><td class='font-weight-bold width:80%'>" . xlt("Total") . "</td><td><strong>" . text($total) . "</strong></td></tr>";
        }
        echo "</table></fieldset>";
    }
    
    asq_section("Communication", "comm", [
        1 => 'Does your baby sometimes make throaty or gurgling sounds?',
        2 => 'Does your baby make cooing sounds such as “ooo,” “gah,” and “aah”?',
        3 => 'When you speak to your baby, does she make sounds back to you?',
        4 => 'Does your baby smile when you talk to him?',
        5 => 'Does your baby chuckle softly?',
        6 => 'After you have been out of sight, does your baby smile or get excited when she sees you?'
    ], $data);
    asq_section("Gross Motor", "gross", [
        1 => 'While your baby is on his back, does he wave his arms and legs, wiggle, and squirm?',
        2 => 'When your baby is on her tummy, does she turn her head to the side?',
        3 => 'When your baby is on his tummy, does he hold his head up longer than a few seconds?',
        4 => 'When your baby is on her back, does she kick her legs?',
        5 => 'While your baby is on his back, does he move his head from side to side?',
        6 => 'After holding her head up while on her tummy, does your baby lay her head back down on the floor, rather than let it drop or fall forward?'
    ], $data);
    asq_section("Fine Motor", "fine", [
        1 => 'Is your baby\'s hand usually tightly closed when he is awake? (If your baby used to do this but no longer does, mark “yes.”)',
        2 => 'Does your baby grasp your finger if you touch the palm of her hand?',
        3 => 'When you put a toy in his hand, does your baby hold it in his hand briefly?',
        4 => 'Does your baby touch her face with her hands?',
        5 => 'Does your baby hold his hands open or partly open when he is awake (rather than in fists, as they were when he was a newborn)?',
        6 => 'Does your baby grab or scratch at her clothes?'
    ], $data);
    asq_section("Problem Solving", "ps", [
        1 => 'Does your baby look at objects that are 8-10 inches away?',
        2 => 'When you move around, does your baby follow you with his eyes?',
        3 => 'When you move a toy slowly from side to side in front of your baby\'s face (about 10 inches away), does your baby follow the toy with her eyes, sometimes turning her head?',
        4 => 'When you move a small toy up and down slowly in front of your baby\'s face (about 10 inches away), does your baby follow the toy with his eyes?',
        5 => 'When you hold your baby in a sitting position, does she look at a toy (about the size of a cup or rattle) that you place on the table or floor in front of her?',
        6 => 'When you dangle a toy above your baby while he is lying on his back, does he wave his arms toward the toy?'
    ], $data);
    asq_section("Personal-Social", "psoc", [
        1 => 'Does your baby sometimes try to suck, even when she\'s not feeding?',
        2 => 'Does your baby cry when he is hungry, wet, tired, or wants to be held?',
        3 => 'Does your baby smile at you?',
        4 => 'When you smile at your baby, does she smile back?',
        5 => 'Does your baby watch his hands?',
        6 => 'When your baby sees the breast or bottle, does she seem to know she is about to be fed?'
    ], $data);

    // Overall Section
    echo "<fieldset class='border p-2 mb-4'><legend class='w-auto px-2 font-weight-medium'>" . xlt("Overall") . "</legend>";
    echo "<table class='table table-sm'>";
    $overall = [
        1 => 'Did your baby pass the newborn hearing screening test? If no, explain:',
        2 => 'Does your baby move both hands and both legs equally well? If no, explain:',
        3 => 'Does either parent have a family history of childhood deafness, hearing impairment, or vision problems? If yes, explain:',
        4 => 'Has your baby had any medical problems? If yes, explain:',
        5 => 'Do you have concerns about your baby\'s behavior (for example, eating, sleeping)? If yes, explain:',
        6 => 'Does anything about your baby worry you? If yes, explain:'
    ];
    foreach ($overall as $i => $label) {
        $v = _asq_val($data["overall_{$i}"] ?? '', "overall_{$i}");
        $c = _asq_val($data["overall_{$i}_comment"] ?? '', "overall_{$i}_comment");
        if ($v || $c) {
            echo "<tr><td class='width:70%'>" . xlt($label) . "</td><td class='width:30%'><strong>" . ($v ? xlt(ucfirst($v)) : '') . ($c ? '<br/><span class=\'text-muted\'>' . text($c) . '</span>' : '') . "</strong></td></tr>";
        }
    }
    echo "</table></fieldset>";
    echo "</div></div></div>";
}
