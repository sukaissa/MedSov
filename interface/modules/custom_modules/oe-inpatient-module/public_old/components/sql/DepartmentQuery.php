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

use OpenEMR\Common\Logging\EventAuditLogger;



// use OpenEMR\Common\Crypto;

class DepartmentQuery
{
    /**
     * @param $department name
     * @return bool
     */


    function insertDepartment($data)
    {
        sqlInsert("INSERT INTO `inp_department`
        (`department_name`, 
        `created_by`) VALUES 
        
        ('$data[department_name]',
        '$data[created_by]')");

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_department",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO `inp_department`
        (`department_name`, 
        `created_by`) VALUES 
        
        ('$data[department_name]',
        '$data[created_by]')",
            1,
            'open-emr',
            'dashboard'
        );
    }



    function getDepartment()
    {
        $query = "SELECT * FROM inp_department";
        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_department",
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


    function updateDepartment($data)
    {
        $sets = "department_name = ?,  
                updated_by = ?,
        ";

        $bindArray = array(
            $data['department_name'],
            $data['updated_by'],
            $data['department_id'],
        );

        $sql = "UPDATE inp_department SET $sets WHERE department_id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_department",
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


    function destroyDepartment($department_id)
    {
        $sql = "DELETE FROM inp_department WHERE department_id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_department",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, intval($department_id));
        // return true;
    }
}
