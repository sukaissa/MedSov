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

class ProcedureQuery
{

    function getProcedure()
    {
        $query = "SELECT * FROM inp_procedure";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_procedure",
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
    function insertProcedure($data)
    {
        $sets = "procedure_name = ?, 
        insurance_status = ?, 
        g_drg_code = ?,
        price = ?
        ";

        $bindArray = array(
            $data['procedure_name'],
            "Active",
            $data['g_drg_code'],
            $data['price'],
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert inp_procedure",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_procedure SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_procedure SET $sets", $bindArray);
    }


    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateProcedure($data)
    {
        $sets = "procedure_name = ?, 
        insurance_status = ?, 
        g_drg_code = ?,
        price = ?
        ";

        $bindArray = array(
            $data['procedure_name'],
            $data['insurance_status'],
            $data['g_drg_code'],
            $data['price'],
            $data['id'],
        );

        $sql = "UPDATE inp_procedure SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_procedure",
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
    function destroyProcedure($id)
    {
        $sql = "DELETE FROM inp_procedure WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module:  delete inp_procedure",
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
    
    /**
     * @param $data
     * @return array
     */
    function getProcedureTypes($data)
    {
        $sql = "SELECT procedure_code,name FROM procedure_type ";
        $sql .= "WHERE procedure_type = 'ord' AND (name LIKE ? OR procedure_code LIKE ? )";

        $data = '%' . $data . '%';

        EventAuditLogger::instance()->newEvent(
            "inpatient-module:  select inp_procedure",
            null, 
            $_SESSION["authUser"],
            $_SESSION["authProvider"],
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        $res = sqlStatement($sql, [$data, $data]);

        while ($row = sqlFetchArray($res)) {
            $results[] = array(
                "id"             => $row['procedure_code'],
                "name"           => $row['name'],
                "procedure_code" => $row['procedure_code'] 
            );
            # code...
        }

        return $results;
    }
}
