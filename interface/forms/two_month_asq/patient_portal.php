<?php

/**
 * ASQ-3: 2-Month Questionnaire form.
 *
 * @package   MedSov EMR
 * @link      https://www.medsov.com
 * @author    Mark Amoah <mcprah@gmail.com>
 * @copyright Copyright (c) 2025 Medsov <info@medsov.com> Omega Systems
 */

require_once(__DIR__ . "/../../globals.php");
require_once(__DIR__ . "/report.php");

$formid = $_GET['formid'] ?? null;
if (empty($formid)) {
    exit;
}

$formMetaData = sqlQuery("SELECT `date` FROM `forms` WHERE `form_id` = ? AND `formdir` = ?", [$formid, 'two_month_asq']);

ob_start();
echo "<h2>" . xlt("2-Month ASQ Questionnaire") . "</h2>";
echo text(oeFormatShortDate($formMetaData['date'])) . "<br><br>";
sdoh_report('', '', '', $formid);
echo json_encode(ob_get_clean());
