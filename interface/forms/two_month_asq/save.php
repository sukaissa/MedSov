<?php

/**
 * Save handler for ASQ-3: 2-Month Questionnaire form.
 *
 * @package   MedSov EMR
 */

require_once(__DIR__ . "/../../globals.php");
require_once("$srcdir/api.inc.php");
require_once("$srcdir/forms.inc.php");

use OpenEMR\Common\Csrf\CsrfUtils;

if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token_form"])) {
    CsrfUtils::csrfNotVerified();
}

$id = (int) (isset($_GET['id']) ? $_GET['id'] : '');

// Build the field list and values for insert/update
$fields = [
    // Baby’s Information
    'baby_first_name',
    'baby_middle_initial',
    'baby_last_name',
    'baby_dob',
    'baby_premature_weeks',
    'baby_gender',
    // Person Filling Out Questionnaire
    'pf_first_name',
    'pf_middle_initial',
    'pf_last_name',
    'pf_street_address',
    'pf_country',
    'pf_city',
    'pf_state_province',
    'pf_zip_postal',
    'pf_home_phone',
    'pf_other_phone',
    'pf_email',
    'pf_relationship',
    'pf_relationship_other',
    'pf_assisting_name_1',
    'pf_assisting_name_2',
    // Program Information
    'program_baby_id',
    'program_id',
    'program_name',
    'program_age_admin_months',
    'program_age_admin_days',
    'program_adj_age_months',
    'program_adj_age_days',
    // Communication
    'comm_1',
    'comm_2',
    'comm_3',
    'comm_4',
    'comm_5',
    'comm_6',
    'comm_total',
    // Gross Motor
    'gross_1',
    'gross_2',
    'gross_3',
    'gross_4',
    'gross_5',
    'gross_6',
    'gross_total',
    // Fine Motor
    'fine_1',
    'fine_2',
    'fine_3',
    'fine_4',
    'fine_5',
    'fine_6',
    'fine_total',
    // Problem Solving
    'ps_1',
    'ps_2',
    'ps_3',
    'ps_4',
    'ps_5',
    'ps_6',
    'ps_total',
    // Personal-Social
    'psoc_1',
    'psoc_2',
    'psoc_3',
    'psoc_4',
    'psoc_5',
    'psoc_6',
    'psoc_total',
    // Overall
    'overall_1',
    'overall_1_comment',
    'overall_2',
    'overall_2_comment',
    'overall_3',
    'overall_3_comment',
    'overall_4',
    'overall_4_comment',
    'overall_5',
    'overall_5_comment',
    'overall_6',
    'overall_6_comment',
    // Parent/Caregiver Info
    'caregiver_child_name',
    'caregiver_child_dob',
    'caregiver_completed_by',
    'caregiver_relationship',
    'caregiver_date_completed'
];

$sets = implode(", ", array_map(function ($f) {
    return "$f = ?";
}, $fields));
$values = array_map(function ($f) {
    return isset($_POST[$f]) ? $_POST[$f] : null;
}, $fields);

if (empty($id)) {
    $newid = sqlInsert(
        "INSERT INTO form_asq_2_month SET $sets",
        $values
    );
    addForm($encounter, "ASQ-3 2-Month Questionnaire", $newid, "two_month_asq", $pid, $userauthorized);
} else {
    sqlStatement(
        "UPDATE form_asq_2_month SET $sets WHERE id = ?",
        array_merge($values, [$id])
    );
}

formHeader("Redirecting....");
formJump();
formFooter();
