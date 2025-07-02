<?php

$contentPartsPath = __DIR__ . '/';

ob_start();
include $contentPartsPath . '/beds/index.php';
$mainContent = ob_get_clean();


ob_start();
include $contentPartsPath . '/wards/index.php';
$wardsContent = ob_get_clean();

function getFormsModalContent()
{
    // Return the structured patient modal content
    return buildFormsModalContent();
}

function buildFormsModalContent()
{
    // Explicitly bring global variables into the function's scope
    global $mainContent, $wardsContent;


    return  [
        'modalContents' => [
            'main' => $mainContent,
            'wards' => $wardsContent,
        ]
    ];
}
