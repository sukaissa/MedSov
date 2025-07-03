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



// use OpenEMR\Common\Crypto;

class VitalQuery
{
    /**
     * @return array
     */
    function getVitals()
    {
        $query = "SELECT
                inp_inpatient_vitals.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
            FROM
                inp_inpatient_vitals
            Left JOIN patient_data ON inp_inpatient_vitals.patient_id = patient_data.pid
            Left JOIN inp_ward ON inp_inpatient_vitals.ward_id = inp_ward.id
            left JOIN inp_beds ON inp_inpatient_vitals.bed_id = inp_beds.id
            WHERE inp_inpatient_vitals.status='in-queue'
        ";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_inpatient_vitals",
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

    function getAdmissionVitals($admissionId)
    {
        $query = "SELECT * FROM inp_inpatient_vitals WHERE admission_id=$admissionId ORDER BY time_taken DESC";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_inpatient_vitals",
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

    function getLatestAdmissionVital($admissionId)
    {
        $query = "SELECT * FROM inp_inpatient_vitals WHERE admission_id = ? ORDER BY time_taken DESC LIMIT 1";

        $bindArray = array($admissionId);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_inpatient_vitals",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );

        $result = sqlQuery($query, $bindArray);
        return $result;
    }

    /**
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertVital($data)
    {
        $sets = "admission_id = ?, 
        patient_id = ?,
        blood_pressure = ?,
        pulse = ?,
        temperature = ?,
        respiratory_rate = ?,
        spo_2 = ?,
        pain_score = ?,
        height = ?,
        weight = ?,
        fluid_input = ?,
        fluid_output = ?,
        time_taken = ?
        ";

        $bindArray = array(
            $data['admission_id'],
            $data['patient_id'],
            $data['blood_pressure'],
            $data['pulse'],
            $data['temperature'],
            $data['respiratory_rate'],
            $data['spo_2'],
            $data['pain_score'],
            $data['height'],
            $data['weight'],
            $data['fluid_input'],
            $data['fluid_output'],
            $data['time_taken'],
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_inpatient_vitals",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_inpatient_vitals SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_inpatient_vitals SET $sets", $bindArray);
    }

    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateVital($data)
    {
        $sets = "ward_id = ?,
            bed_id = ?
        ";

        $bindArray = array(
            $data['ward_id'],
            $data['bed_id'],
            $data['id']
        );

        $sql = "UPDATE inp_inpatient_vitals SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_inpatient_vitals",
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
    function destroyVital($id)
    {
        $sql = "DELETE FROM inp_inpatient_vitals WHERE id = ?;";


        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_inpatient_vitals",
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
