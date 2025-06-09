<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Stanley kwamina Otabil <stanleyotabil10@gmail.com@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

namespace OpenEMR\Modules\InpatientModule;

use OpenEMR\Common\Logging\EventAuditLogger;

class NoteQuery
{

    function getAdmissionNote($admissionId)
    {
        $query = "SELECT * FROM inp_inpatient_nurses_note WHERE admission_id=$admissionId";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_inpatient_nurses_note",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        $results = sqlStatement($query);
        return $results;
    }
    /**
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertNote($data)
    {
        $sets = "admission_id = ?, 
            patient_id = ?,
            note = ?
        ";

        $bindArray = array(
            $data['admission_id'],
            $data['patient_id'],
            $data['note'],
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_inpatient_nurses_note",
            $data['patient_id'], //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_inpatient_nurses_note SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_inpatient_nurses_note SET $sets", $bindArray);
    }

    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateNote($data)
    {
        $sets = "ward_id = ?,
            bed_id = ?
        ";

        $bindArray = array(
            $data['ward_id'],
            $data['bed_id'],
            $data['id']
        );

        $sql = "UPDATE inp_patient_admission SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_inpatient_nurses_note",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, $bindArray);
    }


    /**
     * @param $id
     * @return bool
     */
    function destroyNote($id)
    {
        $sql = "DELETE FROM inp_patient_admission WHERE id = ?;";


        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_inpatient_nurses_note",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, intval($id));
    }
}
