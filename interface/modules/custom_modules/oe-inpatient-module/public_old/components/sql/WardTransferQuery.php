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

class WardTransferQuery
{

    //  function to transfer a ward
    function transferWard($data)
    {
        $sql = "UPDATE inp_patient_admission SET ward_id = ?, bed_id = ? WHERE id = ?;";
        sqlStatement($sql, array(
            $data['ward_id'],
            $data['bed_id'],
            $data['admission_id']
        ));

        // update bed status
        sqlStatement("UPDATE inp_beds SET availability=? WHERE id = ?;", array(
            'Occupied',
            $data['bed_id'],
        ));
        sqlStatement("UPDATE inp_beds SET availability=? WHERE id = ?;",  array(
            'Available',
            $data['old_bed'],
        ));
        sqlStatement("UPDATE inp_bed_records SET end_date = ? WHERE bed_id = ?;", array(date("Y-m-d H:i:s"), $data['old_bed']));
        sqlInsert("INSERT INTO inp_bed_records SET bed_id = $data[bed_id], ward_id = $data[ward_id] , admission_id  = $data[admission_id]");

        // insert into ward transfer table
        sqlInsert(
            "INSERT INTO inp_patient_ward_transfer SET 
            `admission_id`= ?,
            `patient_id`= ?,
            `transfer_date`= ?,
            `ward_id`= ?,
            `old_ward`= ?,
            `bed_id`= ?,
            `old_bed`= ?,
            `ward_staff_id` = ?,
            `days` = ?",
            array(
                $data['admission_id'],
                $data['patient_id'],
                $data['transfer_date'],
                $data['ward_id'],
                $data['old_ward'],
                $data['bed_id'],
                $data['old_bed'],
                1,
                round((time() - strtotime($data['admission_date'])) / (60 * 60 * 24))
            )
        );

        // use bed price as fee
        $fee = sqlQuery("SELECT price_per_day FROM inp_beds WHERE id = ?", array($data['bed_id']));
        $fee = $fee['price_per_day'];

        // $billingSet = "date = now(),
        //  code_type = 'Bed Bill',
        //  code = $data[bed_id],
        //  groupname = 'Default',
        //  authorized = 1,
        //  activity = 1,
        //  units = 1,
        //  pid = ?,
        //  user = ?,
        //  encounter = ?,
        //  fee = ?
        //  ";
        // $billingArray = array($data['patient_id'],    $_SESSION['authUserID'],  $data['encounter_id'], $fee);
        // sqlInsert("INSERT INTO billing SET $billingSet", $billingArray);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_ward_transfer",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
    }


    // function to retrieve all ward transfer
    function getWardTransfers($admission_id)
    {
        $sql = "SELECT inp_patient_ward_transfer.*,
            inp_beds.number, 
            inp_beds.availability, 
            inp_beds.price_per_day,
            inp_ward.name,
            inp_ward.short_name,
            users.fname,
            users.lname,
            users.mname
            FROM inp_patient_ward_transfer 
            JOIN inp_ward ON inp_ward.id = inp_patient_ward_transfer.ward_id
            JOIN inp_beds ON inp_beds.id = inp_patient_ward_transfer.bed_id
            JOIN users ON users.id = inp_patient_ward_transfer.ward_staff_id
            WHERE admission_id = ? ORDER BY id DESC";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_ward_transfer",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
        $result = sqlStatement($sql, array($admission_id));
        return $result;
    }


    /**
     * @return array
     */
    function filterPatientTransfer($data)
    {
        $query = "";

        if ($data['patient'] != null && $data['start_date'] != null) {
            $query = "SELECT
            ipt.transfer_date,
            ipt.days,
            ow.name AS old_ward_name,
            nw.name AS new_ward_name,
            ob.number AS old_bed_number,
            nb.number AS new_bed_number,
            patient_data.fname,
            patient_data.mname,
            patient_data.lname
        FROM
            inp_patient_ward_transfer ipt
        JOIN inp_ward ow ON
            ipt.old_ward = ow.id
        JOIN inp_ward nw ON
            ipt.ward_id = nw.id
        JOIN inp_beds ob ON
            ipt.old_bed = ob.id
        JOIN inp_beds nb ON
            ipt.bed_id = nb.id
        JOIN patient_data ON ipt.patient_id = patient_data.pid
        WHERE
            ipt.patient_id = $data[patient] AND
            ipt.transfer_date BETWEEN '$data[start_date]' AND '$data[end_date]';
        ";
            // break;
        } else if ($data['patient']) {
            $query = "SELECT
                    ipt.transfer_date,
                    ipt.days,
                    ow.name AS old_ward_name,
                    nw.name AS new_ward_name,
                    ob.number AS old_bed_number,
                    nb.number AS new_bed_number,
                    patient_data.fname,
                    patient_data.mname,
                    patient_data.lname
                FROM
                    inp_patient_ward_transfer ipt
                JOIN inp_ward ow ON
                    ipt.old_ward = ow.id
                JOIN inp_ward nw ON
                    ipt.ward_id = nw.id
                JOIN inp_beds ob ON
                    ipt.old_bed = ob.id
                JOIN inp_beds nb ON
                    ipt.bed_id = nb.id
                JOIN patient_data ON ipt.patient_id = patient_data.pid
                WHERE
                    ipt.patient_id = $data[patient]";
        } else {
            $query = "SELECT
                    ipt.transfer_date,
                    ipt.days,
                    ow.name AS old_ward_name,
                    nw.name AS new_ward_name,
                    ob.number AS old_bed_number,
                    nb.number AS new_bed_number,
                    patient_data.fname,
                    patient_data.mname,
                    patient_data.lname
                FROM
                    inp_patient_ward_transfer ipt
                JOIN inp_ward ow ON
                    ipt.old_ward = ow.id
                JOIN inp_ward nw ON
                    ipt.ward_id = nw.id
                JOIN inp_beds ob ON
                    ipt.old_bed = ob.id
                JOIN inp_beds nb ON
                    ipt.bed_id = nb.id
                JOIN patient_data ON ipt.patient_id = patient_data.pid";
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
}
