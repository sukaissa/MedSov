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

function getPatientModalContent()
{
    // Explicitly bring global variables into the function's scope
    global $mainContent, $printWristbandContent, $reprintWristbandContent, $printTreatmentContent, $printAddTreatmentContent;

    return  [
        'patientName' => 'Lily Cho',
        'patientPID' => 'MSV987654',
        'dateTime' => 'June 24, 2025 • 10:30AM',
        'patientDepartment' => 'Woman’s Medical',
        'patientRoom' => 'A-205',
        'modalContents' => [
            'main' => $mainContent,
            'printWristband' => $printWristbandContent,
            'reprintWristband' => $reprintWristbandContent,
            'treatment' => $printTreatmentContent,
            'addTreatment' => $printAddTreatmentContent,
        ]
    ];
}