<?php
/*
 * ASQ-3: 2-Month Questionnaire Form report.php
 *
 * @package   MedSov EMR
 * @link      https://www.medsov.com
 * @author    Mark Amoah <mcprah@gmail.com>
 * @copyright Copyright (c) 2025 Medsov <info@medsov.com> Omega Systems
 */

require_once(dirname(__FILE__) . '/../../globals.php');
require_once($GLOBALS["srcdir"] . "/api.inc.php");

function two_month_asq_report($pid, $encounter, $cols, $id)
{
    $data = formFetch("form_two_month_asq", $id);
    if ($data) {
        echo "<table class='table table-bordered'>";
        echo "<tr><th colspan='2'>" . xlt("Ages & Stages Questionnaires® (ASQ®): 2-Month Questionnaire") . "</th></tr>";
        
        foreach ($data as $key => $value) {
            if ($value == "" || $value == "0000-00-00 00:00:00") {
                continue;
            }
            if ($key == "baby_dob") {
                $value = oeFormatShortDate($value);
            }
            echo "<tr><td>" . xlt(ucwords(str_replace("_", " ", $key))) . "</td><td>" . text($value) . "</td></tr>";
        }
        
        echo "</table>";
    } else {
        echo "<p>" . xlt("No data found for this form.") . "</p>";
    }
}