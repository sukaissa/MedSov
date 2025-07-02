<?php

require_once("../../globals.php");

header('Content-Type: application/json');

$aResult = array();

if( !isset($_POST['functionname']) ) { 
    $aResult['error'] = 'No function name!'; 
}

if( !isset($aResult['error']) ) {

    if(isset($_POST['functionname']) && $_POST['functionname'] == "addmission_queue_add"){

        $aResult['result'] = addmission_queue_add();
    }
    if(isset($_POST['functionname']) && $_POST['functionname'] == "close_case"){

        $aResult['result'] = close_case();
    }

}

function addmission_queue_add(){

    $sets = "patient_id = ?,
        encounter_id = ?, 
        ward_id = ?,
        bed_id = ?,
        opd_case_doctor_id = ?,
        assigned_nurse_id = ?,
        assigned_provider = ?,
        status = ?
    ";

    $bindArray = array(
        $_SESSION["pid"],
        $_SESSION["encounter"],
        0,
        0,
        $_SESSION["authUser"],
        $_SESSION["authUser"],
        $_SESSION["authUser"],
        "in-queue",
    );

    sqlInsert("INSERT INTO inp_patient_admission SET $sets", $bindArray);

    return 1;
}

function close_case(){
    $sql = "UPDATE form_encounter SET date_end = (CURRENT_DATE),discharge_disposition = ?  WHERE pid=? AND encounter=?";
    $result = sqlStatement($sql, [$_POST['disposition'],$_SESSION['pid'], $_SESSION['encounter']]);
    return 1;
}

echo json_encode($aResult);
?>