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

class MemberQuery
{

    /**
     * @return array
     */
    function getMembers($id)
    {
        $query = "SELECT
                inp_surgical_team.*,
                users.fname AS fname,
                users.lname AS lname,
                users.mname AS mname,
                users.username
            FROM
                inp_surgical_team
            Left JOIN users ON inp_surgical_team.employee_id = users.id
            WHERE inp_surgical_team.surgery_id=$id
        ";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_surgical_team",
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
    function getExternalMembers($id)
    {
        $query = "SELECT * FROM inp_external_surgical_team WHERE surgery_id=$id";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_external_surgical_team",
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
    function insertMember($data)
    {
        $sets = "admission_id = ?, 
            surgery_id = ?, 
            employee_id = ?, 
            role = ?
        ";

        $bindArray = array(
            $data['admission_id'],
            $data['surgery_id'],
            $data['employee_id'],
            $data['role'],
        );
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_surgical_team",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_surgical_team SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_surgical_team SET $sets", $bindArray);
    }

    /**
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertExternalMember($data)
    {
        $sets = "admission_id = ?, 
            surgery_id = ?, 
            username = ?, 
            role = ?
        ";

        $bindArray = array(
            $data['admission_id'],
            $data['surgery_id'],
            $data['username'],
            $data['role'],
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_external_surgical_team",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_external_surgical_team SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_external_surgical_team SET $sets", $bindArray);
    }


    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateMember($data)
    {
        $sets = "number = ?, 
            bed_type = ?, 
            ward_id = ?,
            price_per_day = ?,
            availability = ?
        ";

        $bindArray = array(
            $data['number'],
            $data['bed_type'],
            $data['ward_id'],
            $data['price_per_day'],
            $data['availability'],
            $data['id'],
        );

        $sql = "UPDATE inp_surgical_team SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_surgical_team",
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
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateExternalMember($data)
    {
        $sets = "number = ?, 
            bed_type = ?, 
            ward_id = ?,
            price_per_day = ?,
            availability = ?
        ";

        $bindArray = array(
            $data['number'],
            $data['bed_type'],
            $data['ward_id'],
            $data['price_per_day'],
            $data['availability'],
            $data['id'],
        );

        $sql = "UPDATE inp_external_surgical_team SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_external_surgical_team",
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
    function destroyMember($id)
    {
        $sql = "DELETE FROM inp_surgical_team WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_surgical_team",
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
