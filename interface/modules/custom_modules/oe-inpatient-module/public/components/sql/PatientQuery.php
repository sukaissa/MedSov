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

class PatientQuery
{
    /**
     * @return array
     */
    function getPatientsSearch($search)
    {
        $all = [];

        $getPatientSQL = "SELECT
            patient_data.pid,
            `pid`,
            `fname`,
            `mname`,
            `lname`,
            `DOB`,
            inp_patient_admission.*
        FROM
            `patient_data`
        JOIN `inp_patient_admission` ON patient_data.pid = inp_patient_admission.patient_id
        WHERE fname LIKE '%$search%' OR lname LIKE '%$search%' OR mname LIKE '%$search%'";
        // -- inp_patient_admission.discharge_date IS NOT NULL AND

        $results = sqlStatement($getPatientSQL);
        foreach ($results as $patient) {
            array_push($all, [
                'id' => $patient['pid'],
                'pid' =>  $patient['pid'],
                'DOB' => $patient['DOB'],
                'fname' => $patient['fname'],
                // 'ward_id' => $patient['ward_id'],
                'lname' => $patient['lname'],
                'mname' => $patient['mname'],
            ]);
        }

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $getPatientSQL,
            1,
            'open-emr',
            'dashboard'
        );
        return $all;
    }



    /**
     * @return array
     */
    function getDrugSearch($search)
    {
        $all = [];
        $getPatientSQL = '';

        if (empty($search)) {
            $getPatientSQL = "SELECT * FROM `drugs`";
        } else {
            $getPatientSQL = "SELECT * FROM `drugs` WHERE name LIKE '%$search%'";
        }

        $results = sqlStatement($getPatientSQL);
        foreach ($results as $drug) {
            array_push($all, [
                'id' => $drug['drug_id'],
                'name' =>  $drug['name'],
            ]);
        }
        return $all;
    }

    /**
     * @return array
     */
    function getSurgerySearch($search)
    {
        $all = [];
        $getPatientSQL = '';

        if (empty($search)) {
            $getPatientSQL = "SELECT * FROM `inp_surgery`";
        } else {
            $getPatientSQL = "SELECT * FROM `inp_surgery` WHERE code LIKE '%$search%'";
        }

        $results = sqlStatement($getPatientSQL);
        foreach ($results as $drug) {
            array_push($all, [
                'id' => $drug['id'],
                'name' =>  $drug['code'],
            ]);
        }
        return $all;
    }


    function searchManagementPlan($admissionId)
    {
        $all = [];

        $query = "SELECT
            inp_treatment_plan.*
            -- lists.title,
            -- lists.type
        FROM
            inp_treatment_plan
        JOIN lists ON inp_treatment_plan.uuid = lists.uuid
        WHERE
            admission_id=$admissionId";
        $results = sqlStatement($query);
        foreach ($results as $drug) {
            array_push($all, [
                'id' => $drug['id'],
                'instructions' =>  $drug['instructions'],
                'title' =>  $drug['title'],
                'type' =>  $drug['type'],
                'action_start_time' =>  $drug['action_start_time'],
                'action_end_time' =>  $drug['action_end_time'],
                'action_start_time' =>  $drug['action_start_time'],
            ]);
        }


        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_treatment_plan",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );

        return $all;
    }



    function getVisitors()
    {
        $query = "SELECT
        inp_visits.id,
        patient_data.fname,
        patient_data.mname,
        patient_data.lname,
        inp_visits.visitor_name,
        inp_visits.relationship_with_patient,
        inp_visits.time_in,
        inp_visits.time_out,
        inp_visits.comment,
        inp_visits.created_at,
        inp_patient_admission.patient_id
    FROM
        inp_visits
    JOIN inp_patient_admission ON inp_visits.patient_id = inp_patient_admission.patient_id
    JOIN patient_data ON inp_visits.patient_id = patient_data.pid
        ";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_visits",
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
    function insertVisitor($data)
    {
        $sets = "patient_id = ?, 
            visitor_name = ?, 
            relationship_with_patient = ?,
            time_in = ?,
            time_out = ?,
            comment = ?
        ";

        $bindArray = array(
            $data['patient_id'],
            $data['visitor_name'],
            $data['relationship_with_patient'],
            $data['time_in'],
            $data['time_out'],
            $data['comment']
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_visits",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_visits SET $sets",
            1,
            'open-emr',
            'dashboard'
        );

        sqlInsert("INSERT INTO inp_visits SET $sets", $bindArray);
    }


    function searchVisitor($visitor)
    {
        $query = "SELECT DISTINCT
            inp_visits.*,
            inp_beds.number,
            patient_data.sex,
            patient_data.fname,
            patient_data.lname,
            patient_data.mname,
            inp_patient_admission.bed_id,
            inp_patient_admission.ward_id,
            inp_ward.name AS ward_name
            FROM inp_visits
            JOIN patient_data ON inp_visits.patient_id = patient_data.pid
            JOIN inp_patient_admission ON inp_visits.patient_id = inp_patient_admission.patient_id
            JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            WHERE inp_visits.visitor_name LIKE '%$visitor%' AND inp_patient_admission.status='admitted'";
        $visitors =    sqlStatement($query);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_visits",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        return $visitors;
    }



    function filterVisitors($data)
    {
        $query = "";
        if ($data['start_date'] != null && $data['end_date'] != null && $data['provider'] != null) {
            $query = "SELECT
                inp_visits.*,
                inp_beds.number,
                patient_data.sex,
                patient_data.fname,
                patient_data.lname,
                patient_data.mname,
                inp_patient_admission.bed_id,
                inp_patient_admission.ward_id,
                inp_ward.name AS ward_name
            FROM inp_visits
            JOIN patient_data ON inp_visits.patient_id = patient_data.pid
            JOIN inp_patient_admission ON inp_visits.patient_id = inp_patient_admission.patient_id
            JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            WHERE inp_patient_admission.assigned_provider = $data[provider]
            AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
            ORDER BY
                inp_patient_admission.created_at
            DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null) {
            $query = "SELECT 
                inp_visits.*,
                inp_beds.number,
                patient_data.sex,
                patient_data.fname,
                patient_data.lname,
                patient_data.mname,
                inp_patient_admission.bed_id,
                inp_patient_admission.ward_id,
                inp_ward.name AS ward_name
            FROM inp_visits
            JOIN patient_data ON inp_visits.patient_id = patient_data.pid
            JOIN inp_patient_admission ON inp_visits.patient_id = inp_patient_admission.patient_id
            JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            WHERE inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
            ORDER BY
                inp_patient_admission.created_at
            DESC";
        } elseif ($data['provider'] != null) {
            $query = "SELECT 
                inp_visits.*,
                inp_beds.number,
                patient_data.sex,
                patient_data.fname,
                patient_data.lname,
                patient_data.mname,
                inp_patient_admission.bed_id,
                inp_patient_admission.ward_id,
                inp_ward.name AS ward_name
            FROM inp_visits
            JOIN patient_data ON inp_visits.patient_id = patient_data.pid
            JOIN inp_patient_admission ON inp_visits.patient_id = inp_patient_admission.patient_id
            JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            WHERE
                inp_patient_admission.assigned_provider = $data[provider]";
        } else {
            $query = "SELECT 
                inp_visits.*,
                inp_beds.number,
                patient_data.sex,
                patient_data.fname,
                patient_data.lname,
                patient_data.mname,
                inp_patient_admission.bed_id,
                inp_patient_admission.ward_id,
                inp_ward.name AS ward_name
            FROM inp_visits
            JOIN patient_data ON inp_visits.patient_id = patient_data.pid
            JOIN inp_patient_admission ON inp_visits.patient_id = inp_patient_admission.patient_id
            JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            ORDER BY
                inp_patient_admission.created_at
            DESC";
        }

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_visits",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        $results = sqlStatement($query);

        $total = 0;
        foreach ($results as $value) {
            $total = $total + 1;
        }

        return [
            'results' => $results,
            'total' => $total
        ];
    }


    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateVisitor($data)
    {
        $sets = "patient_id = ?, 
        visitor_name = ?, 
        relationship_with_patient = ?,
        time_in = ?,
        time_out = ?,
        comment = ?
    ";

        $bindArray = array(
            $data['patient_id'],
            $data['visitor_name'],
            $data['relationship_with_patient'],
            $data['time_in'],
            $data['time_out'],
            $data['comment'],
            $data['id']
        );

        $sql = "UPDATE inp_visits SET $sets WHERE id = ?;";


        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_visits",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, $bindArray);
        // return true;
    }


    /**
     * @param $id
     * @return bool
     */
    function destroyVisitor($id)
    {
        $sql = "DELETE FROM inp_visits WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_visits",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, intval($id));
        // return true;
    }
}
