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

class FoodQuery
{
    /**
     * @return array
     */
    function getMenuItems()
    {
        $query = "SELECT * FROM inp_food_item ORDER BY category";
        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_food_item",
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
    function insertFoodItem($data)
    {
        $sets = "name = ?, 
            category = ?, 
            price = ?,
            availability = ?
        ";

        $bindArray = array(
            $data['name'],
            $data['category'],
            $data['price'],
            'Available'
        );
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_food_item",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_food_item SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_food_item SET $sets", $bindArray);
    }

    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateFoodItem($data)
    {
        $sets = "name = ?, 
            category = ?, 
            price = ?,
            availability = ?
        ";

        $bindArray = array(
            $data['name'],
            $data['category'],
            $data['price'],
            $data['availability'],
            $data['id'],
        );

        $sql = "UPDATE inp_food_item SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_food_item",
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
    function destroyFoodItem($id)
    {
        $sql = "DELETE FROM inp_food_item WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_food_item",
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
    function getFoodRequests()
    {
        $query = "SELECT inp_food_request.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                users.username,
                inp_food_item.name as food_name,
                inp_food_item.category as category
            FROM inp_food_request 
            JOIN users ON inp_food_request.staff_id = users.id
            JOIN inp_food_item ON inp_food_request.food_id = inp_food_item.id
            JOIN patient_data ON inp_food_request.patient_id = patient_data.pid
            ORDER BY created_at DESC";
        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_food_request",
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
    function getPatientFoodRequests($admission_id = null, $patient_id)
    {
        $whereClause = "WHERE inp_food_request.patient_id = ?";
        $bindArray = array($patient_id);
        
        if ($admission_id !== null && $admission_id !== 0) {
            $whereClause .= " AND inp_food_request.admission_id = ?";
            $bindArray[] = $admission_id;
        }
        
        $query = "SELECT inp_food_request.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                users.username,
                inp_food_item.name as food_name,
                inp_food_item.category as category
            FROM inp_food_request 
            JOIN users ON inp_food_request.staff_id = users.id
            JOIN inp_food_item ON inp_food_request.food_id = inp_food_item.id
            JOIN patient_data ON inp_food_request.patient_id = patient_data.pid
            $whereClause
            ORDER BY created_at DESC";
    
        $results = sqlStatement($query, $bindArray);
    
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_food_request",
            $patient_id, //pid
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
    function filterFoodRequests($data)
    {
        $query = '';
        if (1 > 2) {
            echo "something";
        } elseif ($data['start_date'] != null && $data['end_date'] != null) {
            $query = "SELECT inp_food_request.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                users.username,
                inp_food_item.name as food_name,
                inp_food_item.category as category
            FROM inp_food_request 
            JOIN users ON inp_food_request.staff_id = users.id
            JOIN inp_food_item ON inp_food_request.food_id = inp_food_item.id
            JOIN patient_data ON inp_food_request.patient_id = patient_data.pid
            WHERE inp_food_request.category = '$data[category]'
            ORDER BY created_at DESC";
        } elseif ($data['category'] != null) {
            $query = "SELECT inp_food_request.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                users.username,
                inp_food_item.name as food_name,
                inp_food_item.category as category
            FROM inp_food_request 
            JOIN users ON inp_food_request.staff_id = users.id
            JOIN inp_food_item ON inp_food_request.food_id = inp_food_item.id
            JOIN patient_data ON inp_food_request.patient_id = patient_data.pid
            JOIN inp_patient_admission ON inp_food_request.patient_id = inp_patient_admission.patient_id
            WHERE inp_patient_admission.status = '$data[category]'
            ORDER BY created_at DESC";
        } elseif ($data['status'] != null) {
            $query = "SELECT inp_food_request.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                users.username,
                inp_food_item.name as food_name,
                inp_food_item.category as category
            FROM inp_food_request 
            JOIN users ON inp_food_request.staff_id = users.id
            JOIN inp_food_item ON inp_food_request.food_id = inp_food_item.id
            JOIN patient_data ON inp_food_request.patient_id = patient_data.pid
            WHERE inp_food_request.status = '$data[status]'
            ORDER BY created_at DESC";
        } elseif ($data['patient'] != null) {
            $query = "SELECT inp_food_request.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                users.username,
                inp_food_item.name as food_name,
                inp_food_item.category as category
            FROM inp_food_request 
            JOIN users ON inp_food_request.staff_id = users.id
            JOIN inp_food_item ON inp_food_request.food_id = inp_food_item.id
            JOIN patient_data ON inp_food_request.patient_id = patient_data.pid
            WHERE patient_data.pid = $data[patient]
            ORDER BY created_at DESC";
        } else {
            $query = "SELECT inp_food_request.*,
            patient_data.title,
            patient_data.fname,
            patient_data.mname,
            patient_data.lname,
            patient_data.sex,
            patient_data.dob,
            users.username,
            inp_food_item.name as food_name,
            inp_food_item.category as category
        FROM inp_food_request 
        JOIN users ON inp_food_request.staff_id = users.id
        JOIN inp_food_item ON inp_food_request.food_id = inp_food_item.id
        JOIN patient_data ON inp_food_request.patient_id = patient_data.pid
        ORDER BY created_at DESC";
        }

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_food_request",
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
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertFoodRequest($data)
    {
        $sets = "patient_id = ?, 
            food_id = ?, 
            staff_id = ?,
            requested_date = ?,
            admission_id = ?,
            status = ?
        ";

        $bindArray = array(
            $data['patient'],
            $data['food'],
            $data['staff'],
            $data['requested_date'],
            $data['admission_id'] ? $data['admission_id'] : '0',
            'Pending'
        );
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_food_request",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_food_request SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_food_request SET $sets", $bindArray);
    }
    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateFoodRequest($data)
    {
        $sets = "patient_id = ?, 
            food_id = ?, 
            staff_id = ?,
            requested_date = ?,
            admission_id = ?,
            category = ?,
            status = ?
        ";

        $bindArray = array(
            $data['patient'],
            $data['food'],
            $data['staff'],
            $data['requested_date'],
            '1',
            'Breakfast',
            'Pending',
            $data['id'],
        );

        $sql = "UPDATE inp_food_request SET $sets WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_food_request",
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

    function deliverFood($id)
    {
        $sets = "status = ?";
        $bindArray = array(
            'Delivered',
            $id,
        );

        $sql = "UPDATE inp_food_request SET $sets WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_food_request",
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

    function cancelFood($id)
    {
        $sets = "status = ?";
        $bindArray = array(
            'Cancelled',
            $id,
        );

        $sql = "UPDATE inp_food_request SET $sets WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update inp_food_request",
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
    function destroyFoodRequest($id)
    {
        $sql = "DELETE FROM inp_food_request WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete inp_food_request",
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
}
