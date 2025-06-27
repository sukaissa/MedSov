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

class BedQuery
{
    /**
     * @return array
     */
    function countBeds()
    {
        $results = sqlStatement("SELECT * FROM inp_beds");
        $total = 0;
        foreach ($results as $value) {
            $total = $total + 1;
        }
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query bed",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "SELECT * FROM inp_beds",
            1,
            'open-emr',
            'dashboard'
        );
        return $total;
    }
    function countBedsAvailable()
    {
        $results = sqlStatement("SELECT * FROM inp_beds where inp_beds.availability='Available'");
        $total = 0;
        foreach ($results as $value) {
            $total = $total + 1;
        }
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query available bed",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "SELECT * FROM inp_beds where inp_beds.availability='Available'",
            1,
            'open-emr',
            'dashboard'
        );
        return $total;
    }

    /**
     * @return array
     */
    function getBeds()
    {
        $query = "SELECT
                inp_beds.*,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name
            FROM
                inp_beds
            Left JOIN inp_ward ON inp_beds.ward_id = inp_ward.id
        ";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query bed",
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

    function getAvailableBeds()
    {
        $query = "SELECT
                inp_beds.*,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name
            FROM
                inp_beds
            Left JOIN inp_ward ON inp_beds.ward_id = inp_ward.id
            where inp_beds.availability='Available'
        ";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query available bed",
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
    function insertBed($data)
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
            $data['availability']
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert bed",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_beds SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_beds SET $sets", $bindArray);
    }


    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateBed($data)
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

        $sql = "UPDATE inp_beds SET $sets WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_beds",
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
    function destroyBed($id)
    {
        $sql = "DELETE FROM inp_beds WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_beds",
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
     * Filter beds by ward, type, and availability
     * @param int|null $ward_id
     * @param string|null $bed_type
     * @param string|null $availability
     * @return array|object
     */
    function filterBeds($ward_id = null, $bed_type = null, $availability = null)
    {
        $query = "SELECT
                inp_beds.*,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name
            FROM
                inp_beds
            LEFT JOIN inp_ward ON inp_beds.ward_id = inp_ward.id
            WHERE 1=1";
        $params = [];

        if ($ward_id !== null) {
            $query .= " AND inp_beds.ward_id = ?";
            $params[] = $ward_id;
        }
        if ($bed_type !== null) {
            $query .= " AND inp_beds.bed_type LIKE ?";
            $params[] = '%' . $bed_type . '%';
        }
        if ($availability !== null) {
            $query .= " AND inp_beds.availability LIKE ?";
            $params[] = '%' . $availability . '%';
        }

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: filter beds",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );

        return sqlStatement($query, $params);
    }
}
