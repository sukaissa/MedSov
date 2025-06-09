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

class TheaterQuery
{

    function getTheater()
    {
        $query = "SELECT * FROM inp_theater";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_theater",
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
    function insertTheater($data)
    {
        $sets = "theater_name = ?, 
        status = ?
        ";

        $bindArray = array(
            $data['name'],
            $data['status']
        );
        sqlInsert("INSERT INTO inp_theater SET $sets", $bindArray);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insertinp_theater",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_theater SET $sets",
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
    function updateTheater($data)
    {
        $sets = "theater_name = ?, 
            status = ?
        ";

        $bindArray = array(
            $data['name'],
            $data['status'],
            $data['id'],
        );

        $sql = "UPDATE inp_theater SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_theater",
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
    function destroyTheater($id)
    {
        $sql = "DELETE FROM inp_theater WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_theater",
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
