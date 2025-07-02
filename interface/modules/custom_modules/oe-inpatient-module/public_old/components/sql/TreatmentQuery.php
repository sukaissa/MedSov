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

class TreatmentQuery
{
    /**
     * @return array
     */
    function getManagement()
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

    /**
     * @return array
     */
    function getPatientTreatmentPlan($admissionId)
    {
        $managements = [];
        $medQuery = "SELECT DISTINCT
                inp_treatment_plan.*,
                users.username,
                users.fname,
                users.lname,
                lists.title,
                lists.type
            FROM
                inp_treatment_plan
            JOIN users ON inp_treatment_plan.staff_id = users.id
            JOIN lists ON inp_treatment_plan.uuid = lists.uuid
            WHERE  inp_treatment_plan.admission_id = $admissionId";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_treatment_plan",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $medQuery,
            1,
            'open-emr',
            'dashboard'
        );
        $medResults = sqlStatement($medQuery);
        foreach ($medResults as $result) {
            array_push($managements, [
                'id' => $result['id'],
                'username' => $result['username'],
                'fname' => $result['fname'],
                'lname' => $result['lname'],
                'admission_id' => $result['admission_id'],
                'staff_id' => $result['staff_id'],
                'action_start_time' => $result['action_start_time'],
                'action_end_time' => $result['action_end_time'],
                'time_interval' => $result['time_interval'],
                'instructions' => $result['instructions'],
                'patient_id' => $result['patient_id'],
                'title' => $result['title'],
                'type' => $result['type'],
                'status' => $result['status'],
            ]);
        }


        return $managements;
    }


    /**
     * @return array
     */
    function filterPatientManagement($data)
    {
        $query = "";
        if ($data['provider'] != null) {
            $query = "SELECT DISTINCT
                    inp_treatment_plan.*,
                    users.username,
                    users.fname,
                    users.lname,
                    lists.title,
                    lists.type
                FROM
                    inp_treatment_plan
                JOIN users ON inp_treatment_plan.staff_id = users.id
                JOIN lists ON inp_treatment_plan.uuid = lists.uuid
                WHERE staff_id = $data[provider]";
        } else {
            $query = "SELECT DISTINCT
                    inp_treatment_plan.*,
                    users.username,
                    users.fname,
                    users.lname,
                    lists.title,
                    lists.type
                FROM
                    inp_treatment_plan
                JOIN users ON inp_treatment_plan.staff_id = users.id
                JOIN lists ON inp_treatment_plan.uuid = lists.uuid";
        }
        $results = sqlStatement($query);

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
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertTreatmentPlan($data)
    {
        $sets = "admission_id = ?, 
            patient_id = ?,
            type = ?,
            title = ?,
            action_start_time = ?,
            action_end_time = ?,
            time_interval = ?,
            staff_id = ?,
            instructions = ?,
            uuid = ?
        ";

        $bindArray = array(
            $data['admission_id'],
            $data['patient_id'],
            $data['type'],
            $data['title'],
            $data['action_start_time'],
            $data['action_end_time'],
            $data['time_interval'],
            $data['staff_id'],
            $data['instructions'],
            $data['uuid'],
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_treatment_plan",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_treatment_plan SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_treatment_plan SET $sets", $bindArray);
    }


    /**
     * @return array
     */
    function getPatientTracker($admissionId)
    {
        $managements = [];

        $query = "SELECT inp_treatment_plan_tracker.*,   
            users.fname,
            users.mname,
            users.lname,
            inp_treatment_plan.title,
            inp_treatment_plan.type
        FROM inp_treatment_plan_tracker
            JOIN inp_treatment_plan ON inp_treatment_plan_tracker.plan_id = inp_treatment_plan.id 
            JOIN users ON inp_treatment_plan_tracker.staff_id = users.id
            -- JOIN lists ON inp_treatment_plan_tracker.plan_id = lists.id
            WHERE inp_treatment_plan_tracker.admission_id = $admissionId  
            ";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_treatment_plan_tracker",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        $medResults = sqlStatement($query);
        foreach ($medResults as $result) {
            array_push($managements, [
                'id' => $result['id'],
                'title' => $result['title'],
                'lname' => $result['lname'],
                'mname' => $result['mname'],
                'fname' => $result['fname'],
                'admission_id' => $result['admission_id'],
                'staff_id' => $result['staff_id'],
                'plan_id' => $result['plan_id'],
                'action_time' => $result['action_time']
            ]);
        }


        return $managements;
    }

    /**
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertTracker($data)
    {
        $sets = "plan_id = ?, 
            action_time = ?,
            staff_id = ?,
            admission_id = ?
            ";
        $bindArray = array(
            $data['plan_id'],
            $data['action_time'],
            $data['staff_id'],
            $data['admission_id'],
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_treatment_plan_tracker",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_treatment_plan_tracker SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_treatment_plan_tracker SET $sets", $bindArray);
        return true;
    }

    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateTracker($data)
    {
        $sets = "plan_id = ?, 
        action_time = ?,
        staff_id = ?
        ";
        $bindArray = array(
            $data['plan_id'],
            $data['action_time'],
            $data['staff_id'],
            $data['id']
        );

        $sql = "UPDATE inp_treatment_plan_tracker SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_treatment_plan_tracker",
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
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateTreatmentPlan($data)
    {
        $sets = "type = ?,
            title = ?,
            action_start_time = ?,
            action_end_time = ?,
            time_interval = ?,
            staff_id = ?,
            instructions = ?,
            status = ?
        ";

        $bindArray = array(
            $data['type'],
            $data['title'],
            $data['action_start_time'],
            $data['action_end_time'],
            $data['time_interval'],
            $data['staff_id'],
            $data['instructions'],
            $data['status'],
            $data['id']

        );
        $sql = "UPDATE inp_treatment_plan SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_treatment_plan",
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
    function destroyTreatmentPlan($id)
    {
        $sql = "DELETE FROM inp_treatment_plan WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_treatment_plan",
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


    /**
     * @param $id
     * @return bool
     */
    function destroyManagementTracker($id)
    {
        $sql = "DELETE FROM inp_treatment_plan_tracker WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_treatment_plan_tracker",
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


    /**
     * @return array
     */
    function getPatientBill($admissionId)
    {
        $query = "SELECT * FROM inp_requested_services
            JOIN inp_treatment_plan ON inp_requested_services.plan_id = inp_treatment_plan.id 
            JOIN users ON inp_requested_services.staff_id = users.id
            WHERE inp_requested_services.admission_id = $admissionId";
        $results = sqlStatement($query);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_requested_services",
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
