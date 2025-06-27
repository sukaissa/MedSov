<?php

$contentPartsPath = __DIR__ . '/';

ob_start();
include $contentPartsPath . 'main.php';
$mainContent = ob_get_clean();

ob_start();
include $contentPartsPath . '/wristband/index.php';
$printWristbandContent = ob_get_clean();

ob_start();
include $contentPartsPath . '/wristband/reprint.php';
$reprintWristbandContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/treatment/index.php';
$printTreatmentContent = ob_get_clean();

ob_start();
include $contentPartsPath . '/treatment/add_treatment.php';
$printAddTreatmentContent = ob_get_clean();

function getPatientModalContent($inpatientData = null, $pid = null)
{
    // If no inpatient data is provided, return an empty array
    if (!$inpatientData) {
        return [];
    }

    // Ensure the PID is set in the inpatient data
    if (!isset($inpatientData['pid']) || $inpatientData['pid'] !== $pid) {
        $inpatientData['pid'] = $pid;
    }

    // Return the structured patient modal content
    return buildPatientModalContent($inpatientData);
}

function buildPatientModalContent($inpatientData)
{
    // Explicitly bring global variables into the function's scope
    global $mainContent, $printWristbandContent, $reprintWristbandContent, $printTreatmentContent, $printAddTreatmentContent;

    return  [
        'patientName' => $inpatientData['fname'] . ' ' . $inpatientData['mname'] . ' ' . $inpatientData['lname'],
        'patientPID' => $inpatientData['pid'],
        'dateTime' => date('F j, Y • g:ia', strtotime($inpatientData['admission_date'])),
        'patientDepartment' => $inpatientData['ward_name'],
        'patientRoom' => $inpatientData['bed_number'],
        'modalContents' => [
            'main' => $mainContent,
            'printWristband' => $printWristbandContent,
            'reprintWristband' => $reprintWristbandContent,
            'treatment' => $printTreatmentContent,
            'addTreatment' => $printAddTreatmentContent,
        ]
    ];
}
