<?php

$contentPartsPath = __DIR__ . '/';

ob_start();
include $contentPartsPath . '/beds/index.php';
$mainContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/wards/index.php';
$wardsContent = ob_get_clean();

ob_start();
include $contentPartsPath . '/meal_menu/index.php';
$mealMenuContent = ob_get_clean();

ob_start();
include $contentPartsPath . '/meal_request/index.php';
$mealRequestContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/cssd_item/index.php';
$cssdItemContent = ob_get_clean();

ob_start();
include $contentPartsPath . '/cssd_service_request/index.php';
$cssdServiceRequestContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/surgical_procedure/index.php';
$surgicalProcedureContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/visits/index.php';
$visitsContent = ob_get_clean();


function getFormsModalContent()
{
    // Return the structured patient modal content
    return buildFormsModalContent();
}

function buildFormsModalContent()
{
    // Explicitly bring global variables into the function's scope
    global $mainContent, $wardsContent, $mealMenuContent, $mealRequestContent, $cssdItemContent, $cssdServiceRequestContent, $surgicalProcedureContent, $visitsContent;


    return  [
        'modalContents' => [
            'main' => $mainContent,
            'wards' => $wardsContent,
            'mealMenu' => $mealMenuContent,
            'mealRequest' => $mealRequestContent,
            'cssdItem' => $cssdItemContent,
            'cssdServiceRequest' => $cssdServiceRequestContent,
            'surgicalProcedure' => $surgicalProcedureContent,
            'visits' => $visitsContent,
        ]
    ];
}
