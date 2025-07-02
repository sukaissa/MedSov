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
include $contentPartsPath . '/treatment/empty_state.php';
$printTreatmentEmptyStateContent = ob_get_clean();

ob_start();
include $contentPartsPath . '/treatment/add_treatment.php';
$printAddTreatmentContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/vitals/index.php';
$printVitalsContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/vitals/recordVital.php';
$printRecordVitalsContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/vitals/settings.php';
$printVitalsSettingsContent = ob_get_clean();

ob_start();
include $contentPartsPath . '/meals/index.php';
$printMealsContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/meals/add_meal.php';
$printAddMealContent = ob_get_clean();



ob_start();
include $contentPartsPath . '/notes/index.php';
$printNotesContent = ob_get_clean();



ob_start();
include $contentPartsPath . '/surgeries/index.php';
$printSurgeriesContent = ob_get_clean();



ob_start();
include $contentPartsPath . '/transfer/index.php';
$printTransferContent = ob_get_clean();

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
    global $mainContent, $printWristbandContent, $reprintWristbandContent, $printTreatmentContent, $printAddTreatmentContent, $printTreatmentEmptyStateContent, $printVitalsContent, $printMealsContent, $printTransferContent, $printNotesContent, $printSurgeriesContent, $printVitalsSettingsContent, $printRecordVitalsContent, $printAddMealContent;

    $treatmentPlan = [1];

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
            'treatment' => empty($treatmentPlan) ? $printTreatmentEmptyStateContent : $printTreatmentContent,
            'addTreatment' => $printAddTreatmentContent,
            'vitals' => $printVitalsContent,
            'surgeries' => $printSurgeriesContent,
            'meals' => $printMealsContent,
            'transfer' => $printTransferContent,
            'notes' => $printNotesContent,
            'vitalsSettings' => $printVitalsSettingsContent,
            'recordVitals' => $printRecordVitalsContent,
            'addMeals' => $printAddMealContent,
        ]
    ];
}
