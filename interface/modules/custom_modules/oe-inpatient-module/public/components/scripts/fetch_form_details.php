<?php

use OpenEMR\Modules\InpatientModule\PreDischargeChecklistQuery;

require_once "../../../../globals.php";
require_once "./components/sql/PreDischargeChecklistQuery.php";

header('Content-Type: application/json'); // Ensure the response is JSON

ini_set('display_errors', 1); // Enable error reporting for debugging
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$formId = $_GET['form_id'] ?? null;

if (!$formId) {
    echo json_encode(['success' => false, 'message' => 'Invalid form ID']);
    exit;
}

try {
    $preDischargeChecklist = new PreDischargeChecklistQuery();
    $form = $preDischargeChecklist->getPreDischargeFormById($formId);

    if ($form) {
        echo json_encode([
            'success' => true,
            'form' => $form,
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Form not found']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}