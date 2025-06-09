<?php

use OpenEMR\Modules\InpatientModule\PatientQuery;
use OpenEMR\Modules\InpatientModule\ProcedureQuery;

require_once "../../../../globals.php";

require_once "./components/sql/PatientQuery.php";
require_once "./components/sql/ProcedureQuery.php";
$patientQuery = new PatientQuery();
$managentPlan = new PatientQuery();


$search = $_GET['search'];
$q = $_GET['q'];
$term = $_GET['term'];

if ($search == 'search_for_patients') {
    $patients = $patientQuery->getPatientsSearch($q);
    echo json_encode([
        "resp" => "success",
        'q' => $q,
        'patients' => $patients
    ]);
}



if ($search == 'search_for_Drug') {
    $drugs = $patientQuery->getDrugSearch($q);
    echo json_encode([
        "resp" => "success",
        'q' => $q,
        'results' => $drugs
    ]);
}


if ($search == 'search_for_Surgery') {
    $surgeries = $patientQuery->getSurgerySearch($q);
    echo json_encode([
        "resp" => "success",
        'q' => $q,
        'results' => $surgeries
    ]);
}

if ($search == 'search_for_treatment_plan') {
    $managementPlans = $patientQuery->searchManagementPlan($q);
    echo json_encode($managementPlans);
}

if ($search == 'surgery_code') {
    $procedureQuery = new ProcedureQuery();
    $procedures = $procedureQuery->getProcedureTypes($term);

    echo json_encode([
        "resp" => "success",
        'q' => $q,
        'results' => $procedures
    ]);
}
