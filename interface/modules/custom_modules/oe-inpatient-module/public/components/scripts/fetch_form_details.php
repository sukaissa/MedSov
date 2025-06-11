<?php

use OpenEMR\Modules\InpatientModule\PreDischargeChecklistQuery;

require_once "../../../../globals.php";
require_once "./components/sql/PreDischargeChecklistQuery.php";

$formId = $_GET['form_id'] ?? null;

if (!$formId) {
    echo json_encode(['success' => false, 'message' => 'Invalid form ID']);
    exit;
}

$preDischargeChecklist = new PreDischargeChecklistQuery();
$form = $preDischargeChecklist->getFormById($formId);
$checklistItems = $preDischargeChecklist->getChecklistItemsByFormId($formId);

if ($form) {
    echo json_encode([
        'success' => true,
        'form' => $form,
        'checklist_items' => $checklistItems
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Form not found']);
}