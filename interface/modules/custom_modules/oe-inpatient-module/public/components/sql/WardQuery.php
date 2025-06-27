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

class WardQuery
{
    /**
     * @return int
     */
    function countWards()
    {
        $results = sqlStatement("SELECT * FROM inp_ward");
        $total = 0;
        foreach ($results as $value) {
            $total = $total + 1;
        }
        return $total;
    }


    /**
     * @return array
     */
    function getWards()
    {
        $query = "SELECT
                w.id,
                w.short_name,
                w.name,
                COUNT(b.id) AS available_beds
            FROM
                inp_ward w
            LEFT JOIN
                inp_beds b ON w.id = b.ward_id AND b.availability = 'Available'
            GROUP BY
                w.id
        ";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_ward",
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
    function insertWard($data)
    {
        $sets = "name = ?, short_name = ?";

        $bindArray = array(
            $data['name'],
            $data['short_name']
        );
        sqlInsert("INSERT INTO inp_ward SET $sets", $bindArray);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert inp_ward",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_ward SET $sets",
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
    function updateWard($data)
    {
        $sets = "name = ?, short_name = ?";

        $bindArray = array(
            $data['name'],
            $data['short_name'],
            $data['id'],
        );

        $sql = "UPDATE inp_ward SET $sets WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_ward",
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
    function destroyWard($id)
    {
        $sql = "DELETE FROM inp_ward WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_ward",
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
     * Search wards by name (case-insensitive, partial match)
     * @param string $word
     * @return array
     */
    function searchWardsByName($searchTerm)
    {
        $word = trim($searchTerm);
        if ($word === '') {
            return []; // Return empty array if no search term is provided
        }

    
        $query = "SELECT
                w.id,
                w.short_name,
                w.name,
                COUNT(b.id) AS available_beds
            FROM
                inp_ward w
            LEFT JOIN
                inp_beds b ON w.id = b.ward_id AND b.availability = 'Available'
            WHERE
                w.name LIKE ?
            GROUP BY
                w.id
        ";

        $likeWord = '%' . $searchTerm . '%';

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: search inp_ward",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );
        $results = sqlStatement($query, array($likeWord));
        return $results;
    }
}
