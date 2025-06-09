<?php
/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Mohammed Awal Saeed <awalsaeed736@gmail.com@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

namespace OpenEMR\Modules\InpatientModule;

use Ramsey\Uuid\Uuid;
use OpenEMR\Common\Logging\EventAuditLogger;


class SurgeryQuery
{
    /**
     * @param $patient_id
     * @param $theater_id
     * @param $procedure_id
     * @param $start_date
     * @param $end_date
     * @return bool
     */
    function insertSurgery($data)
    {
        $uuid = Uuid::uuid4();

        sqlInsert("INSERT INTO `inp_surgery`
        (`patient_id`, 
            `theater_id`, 
            `code`, 
            `procedure_id`, 
            `admission_id`,
            `start_date`,
            `end_date`,
            `status`,
            `created_by`) 
        VALUES ('$data[patient_id]',
            '$data[theater_id]',
            '$data[code]',
            '$data[procedure_id]',
            '$data[admission_id]',
            '$data[start_date]',
            '$data[end_date]',
            '$data[status]',
            '$data[created_by]')
        ");


        $sets = "pc_catid = ?, 
                pc_aid = ?, 
                pc_pid = ?, 
                pc_title = ?,
                
                pc_time = ?, 
                pc_hometext = ?, 
                pc_room = ?, 
                pc_informant = ?, 

                pc_eventDate = ?,
                pc_endDate = ?, 
                pc_duration = ?, 
                pc_recurrtype = ?, 

                pc_recurrspec = ?, 
               
                pc_startTime = ?, 
                pc_endTime = ?, 
                pc_alldayevent = ?, 
                pc_apptstatus = ?, 

                pc_prefcatid = ?, 
                pc_facility = ?, 
                pc_billing_location = ?,
               
                pc_eventstatus = ?,
                pc_sharing = ?,
                uuid = ?,
               
                pc_location = ?
            ";


        $date = strtotime($data['start_date']);
        $interval = intval($data['duration'])  * 60; // 20 minutes in seconds
        $new_date = date('Y-m-d H:i:s', $date + $interval);

        $bindArray = array(
            12,
            $_SESSION['authUserID'],
            $data['patient_id'],
            $data['pc_title'],

            date('Y-m-d H:i:s'),
            $data['pc_hometext'],
            '3',
            $_SESSION['authUserID'],

            $data['start_date'],
            // $data['end_date']
            '0000-00-00',
            $interval,
            0,

            serialize(array(
                'event_repeat_freq' => '0',
                'event_repeat_freq_type' => '0',
                'event_repeat_on_num' => '1',
                'event_repeat_on_day' => '0',
                'event_repeat_on_freq' => '0',
                'exdate' => ''
            )),

            date('H:i:s', $date),
            $new_date,
            $data['pc_alldayevent'],
            '^',

            0,
            3,
            3,

            1,
            1,
            $uuid->getBytes(),

            serialize(array(
                'event_location' => '3',
                'event_street1' => '',
                'event_street2' => '',
                'event_city' => '',
                'event_state' => '',
                'event_postal' => '',
            )),
        );


        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert inp_surgery",
            $data['patient_id'], //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO `inp_surgery`
        (`patient_id`, 
            `theater_id`, 
            `code`, 
            `procedure_id`, 
            `admission_id`,
            `start_date`,
            `end_date`,
            `status`,
            `created_by`) 
        VALUES ('$data[patient_id]',
            '$data[theater_id]',
            '$data[code]',
            '$data[procedure_id]',
            '$data[admission_id]',
            '$data[start_date]',
            '$data[end_date]',
            '$data[status]',
            '$data[created_by]')
        ",
            1,
            'open-emr',
            'dashboard'
        );

        sqlInsert("INSERT INTO openemr_postcalendar_events SET $sets", $bindArray);
    }

    /**
     * @return array
     */
    /* function getSurgery()
    {
        $query = "SELECT * FROM inp_surgery";
        $results = sqlStatement($query);
        return $results;
    }*/
    function getSurgery()
    {
        $query = "SELECT
                inp_surgery.*,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                inp_procedure.procedure_name,
                inp_theater.theater_name
            FROM
                inp_surgery
            Left JOIN patient_data ON inp_surgery.patient_id = patient_data.pid
            Left JOIN inp_procedure ON inp_surgery.procedure_id = inp_procedure.id
            left JOIN inp_theater ON inp_surgery.theater_id = inp_theater.id";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_surgery",
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
     * pt = procedure_type table
     */
    function getPatientSurgery($admission_id, $patient_id)
    {

        $surgery = [];
        $query = "SELECT
                inp_surgery.*,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                inp_procedure.procedure_name,
                inp_theater.theater_name,
                pt.name, pt.procedure_code, pt.procedure_type
            FROM
                inp_surgery
            Left JOIN patient_data ON inp_surgery.patient_id = patient_data.pid
            Left JOIN inp_procedure ON inp_surgery.procedure_id = inp_procedure.id
            left JOIN inp_theater ON inp_surgery.theater_id = inp_theater.id
            LEFT JOIN procedure_type pt ON pt.procedure_code = inp_surgery.code
            WHERE inp_surgery.admission_id = '$admission_id' AND inp_surgery.patient_id = '$patient_id' AND pt.procedure_type = 'ord'
            ORDER BY
                created_at
            DESC
            ";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_surgery",
            $patient_id, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        $results = sqlStatement($query);

        foreach ($results as $result) {
            array_push($surgery, $result);
        }

        return $surgery[0];
    }


    /**
     * @param $theater_id
     * @param $procedure_id
     * @param $start_date
     * @param $end_date
     * @return bool
     */
    function updateSurgery($data)
    {
        $sets = "theater_id = ?,  
            procedure_id = ?,
            start_date = ?,
            end_date = ?,
            status = ?,
            code = ?,
            updated_by = ?
            
        ";

        $bindArray = array(
            $data['theater_id'],
            $data['procedure_id'],
            $data['start_date'],
            $data['end_date'],
            $data['status'],
            $data['code'],
            $data['updated_by'],
            $data['surgery_id'],
        );

        $sql = "UPDATE inp_surgery SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_surgery",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "UPDATE inp_surgery SET $sets WHERE id = ?;",
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, $bindArray);
        // return true;
    }

    /**
     * @param $surgery_id
     * @return bool
     */
    function destroySurgery($surgery_id)
    {
        $sql = "DELETE FROM inp_surgery WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_surgery",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, intval($surgery_id));
        // return true;
    }


    /**
     * @return int
     */
    function countSurgery()
    {
        $results = sqlStatement("SELECT * FROM inp_surgery");
        $total = 0;
        foreach ($results as $value) {
            $total = $total + 1;
        }
        return $total;
    }


    function getCalendarCat()
    {
        $query = "SELECT * FROM openemr_postcalendar_categories WHERE pc_cattype = 0";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: openemr_postcalendar_categories",
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
}
