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

class CSSDServiceQuery
{
    /**
     * @param $service_name
     * @param $supervisor
     * @param $status
     * @return bool
     */
    function insertCSSDService($data)
    {
        sqlInsert("INSERT INTO `inp_cssd_service`
        (`service_name`, 
        `supervisor`, 
        `availability_status`, 
        `created_by`) VALUES 
        
        ('$data[service_name]',
        '$data[supervisor]',
        '$data[availability_status]',
        '$data[created_by]')");



        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO `inp_cssd_service`
        (`service_name`, 
        `supervisor`, 
        `availability_status`, 
        `created_by`) VALUES 
        
        ('$data[service_name]',
        '$data[supervisor]',
        '$data[availability_status]',
        '$data[created_by]')",
            1,
            'open-emr',
            'dashboard'
        );
    }

    function insertCSSDServiceItem($data)
    {
        sqlInsert("INSERT INTO `inp_cssd_service_item`
        (`item_name`, 
        `created_by`) VALUES 
        
        ('$data[item_name]',
        '$data[created_by]')");

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO `inp_cssd_service_item`
        (`item_name`, 
        `created_by`) VALUES 
        
        ('$data[item_name]',
        '$data[created_by]')",
            1,
            'open-emr',
            'dashboard'
        );
    }

    function insertCSSDServiceRequest($data)
    {
        sqlInsert("INSERT INTO `inp_cssd_service_request`
        (`service_id`,
        `surgery_id`,
        `item_id`,
        `quantity`,
        `request_date`,
        `request_by`,
        `status`,
        `request_processed_date`,
        `request_processed_by`,
        `quantity_returned`,
        `receipt_date`,
        `received_by`) VALUES 
        
        ('$data[service_id]',
        '$data[surgery_id]',
        '$data[item_id]',
        '$data[quantity]',
        '$data[request_date]',
        '$data[request_by]',
        '$data[status]',
        '$data[request_processed_date]',
        '$data[request_processed_by]',
        '$data[quantity_returned]',
        '$data[receipt_date]',
        '$data[received_by]'
        )");

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO `inp_cssd_service_request`
        (`service_id`,
        `surgery_id`,
        `item_id`,
        `quantity`,
        `request_date`,
        `request_by`,
        `status`,
        `request_processed_date`,
        `request_processed_by`,
        `quantity_returned`,
        `receipt_date`,
        `received_by`) VALUES 
        
        ('$data[service_id]',
        '$data[surgery_id]',
        '$data[item_id]',
        '$data[quantity]',
        '$data[request_date]',
        '$data[request_by]',
        '$data[status]',
        '$data[request_processed_date]',
        '$data[request_processed_by]',
        '$data[quantity_returned]',
        '$data[receipt_date]',
        '$data[received_by]'
        )",
            1,
            'open-emr',
            'dashboard'
        );
    }


    /**
     * @return array
     */

    function getCSSDService()
    {
        $query = "SELECT * FROM inp_cssd_service";
        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
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


    function getCSSDServiceItem()
    {
        $query = "SELECT *  FROM
            inp_cssd_service_item";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
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

    function getCSSDServiceRequest()
    {
        $query = "SELECT
            inp_cssd_service_request.*,
            inp_cssd_service.service_name,
            inp_cssd_service_item.item_name,
            inp_department.name as department_name
        FROM
            inp_cssd_service_request
        left JOIN inp_cssd_service ON inp_cssd_service_request.service_id = inp_cssd_service.id
        left JOIN inp_cssd_service_item ON inp_cssd_service_request.item_id = inp_cssd_service_item.id
        LEFT JOIN inp_department ON inp_cssd_service_request.department_id = inp_department.id";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query inp_cssd_service_request",
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


    function getCSSDServiceRequestSurgery($id)
    {
        $query = "SELECT
            inp_cssd_service_request.*,
            inp_cssd_service.service_name,
            inp_department.name as department_name
        FROM
            inp_cssd_service_request
        left JOIN inp_cssd_service ON inp_cssd_service_request.service_id = inp_cssd_service.id
        left JOIN inp_cssd_service_item ON inp_cssd_service_request.item_id = inp_cssd_service_item.id
        LEFT JOIN inp_department ON inp_cssd_service_request.department_id = inp_department.id
        WHERE inp_cssd_service_request.surgery_id=$id";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service_request",
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
     *  @param $service_name
     * @param $supervisor
     * @param $status
     * @return bool
     */
    function updateCSSDService($data)
    {
        $sets = "service_name = ?,  
            supervisor = ?,
            availability_status = ?
        ";

        $bindArray = array(
            $data['service_name'],
            $data['supervisor'],
            $data['availability_status'],
            $data['id'],
        );

        $sql = "UPDATE inp_cssd_service SET $sets WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
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


    function updateCSSDServiceItem($data)
    {
        $sets = "item_name = ?,  
                updated_by = ?
            ";

        $bindArray = array(
            $data['item_name'],
            $data['updated_by'],
            $data['id'],
        );

        $sql = "UPDATE inp_cssd_service_item SET $sets WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
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

    function updateCSSDServiceRequest($data)
    {
        $sets = "service_id = ?,  
                 item_id = ?,
                 quantity = ?,
                 request_date = ?,
                 request_by = ?,
                 status = ?,
                 request_processed_date = ?,
                 request_processed_by = ?,
                 quantity_returned = ?,
                 receipt_date = ?,
                 received_by = ?
                ";

        $bindArray = array(
            $data['service_id'],
            $data['item_id'],
            $data['quantity'],
            $data['request_date'],
            $data['request_by'],
            $data['status'],
            $data['request_processed_date'],
            $data['request_processed_by'],
            $data['quantity_returned'],
            $data['receipt_date'],
            $data['received_by'],
            $data['id'],
        );

        $sql = "UPDATE inp_cssd_service_request SET $sets WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
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
     * @param $service_id
     * @return bool
     */
    function destroyCSSDService($service_id)
    {
        $sql = "DELETE FROM inp_cssd_service WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, intval($service_id));
        // return true;
    }


    function destroyCSSDServiceItem($item_id)
    {
        $sql = "DELETE FROM inp_cssd_service_item WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service_item",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, intval($item_id));
        // return true;
    }

    function destroyCSSDServiceRequest($request_id)
    {
        $sql = "DELETE FROM inp_cssd_service_request WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service_request",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        sqlStatement($sql, intval($request_id));
        // return true;
    }

    function filterCSSDService($data)
    {
        $query = "SELECT * FROM inp_cssd_service WHERE 1=1 ";

        if ($data['start_date'] != null) {
            $query .= " AND inp_cssd_service.created_at BETWEEN '$data[start_date]' AND '$data[end_date]' ";
        }

        if ($data['supervisor'] != null) {
            $query .= " AND inp_cssd_service.supervisor LIKE '%$data[supervisor]%' ";
        }

        if ($data['service_name'] != null) {
            $query .= " AND inp_cssd_service.service_name = '$data[service_name]' ";
        }

        if ($data['status'] != null) {
            $query .= " AND inp_cssd_service.availability_status = '$data[status]' ";
        }

        $query .= " ORDER BY created_at DESC";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service",
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

    function filterCSSDServiceItem($data)
    {
        $query =  "SELECT inp_cssd_service_item.*, 
                    inp_cssd_service.service_name,
                    inp_cssd_service_request.quantity,
                    inp_cssd_service_request.status,
                    inp_cssd_service_request.request_date,
                    inp_cssd_service_request.request_by
                FROM inp_cssd_service_item 
                Left Join inp_cssd_service_request on inp_cssd_service_item.id = inp_cssd_service_request.item_id 
                Left Join inp_cssd_service on inp_cssd_service_request.service_id = inp_cssd_service.id 
                WHERE 1=1  ";

        if ($data['service_name'] != null) {
            $query .=  " AND WHERE inp_cssd_service.service_name = '$data[service_name]' ";
        }

        if ($data['provider'] != null) {
            $query .=  " AND WHERE inp_cssd_service_request.request_by = '$data[provider]' ";
        }

        if ($data['start_date'] != null) {
            $query .=   " AND WHERE inp_cssd_service_request.request_date BETWEEN '$data[start_date]' AND '$data[end_date]' ";
        }

        $query .=  " ORDER BY inp_cssd_service_request.request_date DESC ";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service_item",
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


    function filterCSSDServiceRequest($data)
    {
        $query =  "SELECT inp_cssd_service_request.*,
            inp_cssd_service.service_name,
            inp_department.name as department_name,
            inp_cssd_service_item.item_name
            FROM
                inp_cssd_service_request
            LEFT JOIN inp_cssd_service ON inp_cssd_service_request.service_id = inp_cssd_service.id
            LEFT JOIN inp_cssd_service_item ON inp_cssd_service_request.item_id = inp_cssd_service_item.id
            LEFT JOIN inp_department ON inp_cssd_service_request.department_id = inp_department.id WHERE 1=1  ";

        if ($data['provider'] != null) {
            $query .= " AND inp_cssd_service_request.created_by = $data[provider] ";
        }

        if ($data['start_date'] != null) {
            $query .= " AND inp_cssd_service_request.request_date BETWEEN '$data[start_date]' AND '$data[end_date]' ";
        }

        if ($data['request_by'] != null) {
            $query .= " AND inp_cssd_service_request.request_by = '$data[request_by]' ";
        }

        if ($data['status'] != null) {
            $query .= " AND inp_cssd_service_request.status = '$data[status]' ";
        }

        if ($data['service_id'] != null) {
            $query .= " AND inp_cssd_service_request.service_id = '$data[service_id]' ";
        }

        $query .= " ORDER BY created_at DESC";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_cssd_service_request",
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
