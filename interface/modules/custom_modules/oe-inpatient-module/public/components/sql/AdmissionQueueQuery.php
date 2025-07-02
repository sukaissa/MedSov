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

class AdmissionQueueQuery
{
    /**
     * @return int
     */
    function countAdmissions()
    {
        $results = sqlStatement("SELECT * FROM inp_patient_admission WHERE inp_patient_admission.status='in-queue'");

        $total = 0;
        foreach ($results as $value) {
            $total = $total + 1;
        }
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "SELECT * FROM inp_patient_admission WHERE inp_patient_admission.status='in-queue'",
            1,
            'open-emr',
            'dashboard'
        );
        return $total;
    }


    /**
     * @return array
     * @property inpatient array
     */
    function getAllAdmissions()
    {
        $query = "SELECT
                inp_patient_admission.*,
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
                inp_patient_admission
            Left JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            Left JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            left JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
        ";


        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        return $results;
    }

    /**
     * @return array
     * @property inpatient array
     */
    function getAdmissionQueue()
    {
        $query = "SELECT
                inp_patient_admission.*,
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
                inp_patient_admission
            Left JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            Left JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            left JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            WHERE inp_patient_admission.status='in-queue'
        ";


        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        return $results;
    }


    /**
     * @return array
     * @property discharged_patients
     */
    function getDischargedPatients()
    {
        $query = "SELECT
                inp_patient_admission.*,
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
                inp_patient_admission
            Left JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            Left JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            left JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            WHERE inp_patient_admission.status='discharged'
        ";


        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        return $results;
    }

    /**
     * @return array
     */
    function searchAdmissionQueue($search)
    {
        $query = "SELECT
                inp_patient_admission.*,
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
                inp_patient_admission
            Left JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            Left JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            left JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            WHERE inp_patient_admission.status='in-queue' 
            AND (patient_data.fname LIKE '%$search%' OR patient_data.lname LIKE '%$search%' OR patient_data.mname LIKE '%$search%')
        ";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        return $results;
    }

    /**
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertAdmission($data)
    {
        $sets = "patient_id = ?, 
            ward_id = ?,
            bed_id = ?,
            opd_case_doctor_id = ?,
            assigned_nurse_id = ?,
            assigned_provider = ?,
            admission_type = ?,
            status = ?
        ";

        $bindArray = array(
            $data['patient_id'],
            $data['ward_id'],
            $data['bed_id'],
            $data['opd_case_doctor_id'],
            $data['assigned_nurse_id'],
            $data['assigned_provider'],
            $data['admission_type'],
            $data['status'],
        );
        sqlInsert("INSERT INTO inp_patient_admission SET $sets", $bindArray);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_patient_admission SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
    }


    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateAdmission($data)
    {
        $sets = "ward_id = ?,
            bed_id = ?,
            opd_case_doctor_id = ?,
            assigned_nurse_id = ?,
            assigned_provider = ?,
            admission_type = ?
        ";

        $bindArray = array(
            $data['ward_id'],
            $data['bed_id'],
            $data['opd_case_doctor_id'],
            $data['assigned_nurse_id'],
            $data['assigned_provider'],
            $data['admission_type'],
            $data['id']
        );

        $sql = "UPDATE inp_patient_admission SET $sets WHERE id = ?;";
        sqlStatement($sql, $bindArray);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
    }


    function admissionStatus($data)
    {
        $sets = "status = ?,
        admission_date = ?
        ";

        $bindArray = array(
            $data['status'],
            date('Y-m-d H:i:s'),
            $data['id'],
        );


        $bedsets = "availability = ?
        ";
        $bedArray = array(
            'Occupied',
            $data['bed_id'],
        );
        $bedsql = "UPDATE inp_beds SET $bedsets WHERE id = ?;";
        sqlStatement($bedsql, $bedArray);

        $sql = "UPDATE inp_patient_admission SET $sets WHERE id = ?;";
        sqlStatement($sql, $bindArray);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
    }


    /**
     * @param $id
     * @return bool
     */
    function destroyAdmission($id)
    {
        $sql = "DELETE FROM inp_patient_admission WHERE id = ?;";
        sqlStatement($sql, intval($id));
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
    }


    function insertNurseNote($data)
    {
        $sets = "admission_id = ?, 
            note = ?
        ";

        $bindArray = array(
            $data['admission_id'],
            $data['note'],
        );
        sqlInsert("INSERT INTO inp_inpatient_nurses_note SET $sets", $bindArray);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert inp_inpatient_nurses_note",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_inpatient_nurses_note SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
    }

    function getAdmissions()
    {
        $query = "SELECT * FROM patient_admission WHERE id = $_SESSION'['pid'];";
        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        return $results;
    }
}
