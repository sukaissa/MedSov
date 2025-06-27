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

class InpatientQuery
{
    /**
     * @return int
     */
    function countInpatients()
    {
        $results = sqlStatement("SELECT * FROM inp_patient_admission WHERE inp_patient_admission.status='Admitted'");
        $total = 0;
        foreach ($results as $value) {
            $total = $total + 1;
        }
        return $total;
    }


    /**
     * @return array
     */
    function getInpatients()
    {
        $query = "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number,
                inp_beds.price_per_day,
                SUM(bed_charges.bed_bill) AS total_bed_bill,
                SUM(billing.fee) AS total_bill,
                fr.total_price AS total_food_price,
                SUM(billing.fee) AS total_bill
            FROM
                inp_patient_admission
            LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            LEFT JOIN(
                SELECT admission_id,
                    price_per_day,
                    SUM(
                        DATEDIFF(
                            IFNULL(end_date, CURRENT_TIMESTAMP),
                            start_date
                        )
                    ) AS days,
                    SUM(
                        price_per_day * DATEDIFF(
                            IFNULL(end_date, CURRENT_TIMESTAMP),
                            start_date
                        )
                    ) AS bed_bill
                FROM
                    inp_bed_records
                LEFT JOIN inp_beds ON inp_bed_records.bed_id = inp_beds.id
                GROUP BY
                    admission_id,
                    price_per_day
            ) AS bed_charges
            ON
                inp_patient_admission.id = bed_charges.admission_id
            LEFT JOIN billing ON inp_patient_admission.encounter_id = billing.encounter
            LEFT JOIN(
                SELECT fr.admission_id,
                    SUM(fi.price) AS total_price
                FROM
                    inp_food_request fr
                JOIN inp_food_item fi ON
                    fr.food_id = fi.id
                GROUP BY
                    fr.admission_id
            ) AS fr
            ON
                inp_patient_admission.id = fr.admission_id
            WHERE
                inp_patient_admission.status != 'In Queue'
            GROUP BY
                inp_patient_admission.id
            ORDER BY
                admission_date
            DESC
                ;";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
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
    function searchInpatients($data)
    {
        $query = "";

        if ($data['ward_id'] != null && $data['word'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.ward_id = $data[ward_id] 
                AND (patient_data.fname LIKE '%$data[word]%' 
                    OR patient_data.lname LIKE '%$data[word]%' 
                    OR patient_data.mname LIKE '%$data[word]%')
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['ward_id'] != null && $data['word'] == null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.ward_id = $data[ward_id]
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['word'] != null && $data['ward_id'] == null) {
            $query =  "SELECT
            inp_patient_admission.*,
            patient_data.title,
            patient_data.fname,
            patient_data.mname,
            patient_data.lname,
            patient_data.sex,
            patient_data.dob,
            inp_ward.name AS ward_name,
            inp_ward.short_name AS ward_short_name,
            inp_beds.number AS bed_number
            FROM
                inp_patient_admission
            LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            WHERE
                inp_patient_admission.status = 'Admitted' 
            AND (patient_data.fname LIKE '%$data[word]%' 
                OR patient_data.lname LIKE '%$data[word]%' 
                OR patient_data.mname LIKE '%$data[word]%')
            ORDER BY
                admission_date
            DESC";
        }


        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
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


    function filterInpatients($data)
    {
        $query = "";
        // AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
        if ($data['start_date'] != null && $data['end_date'] != null && $data['gender'] != null && $data['ward'] != null && $data['provider'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number,
                count(inp_patient_admission.id) AS total
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                AND inp_patient_admission.assigned_provider = $data[provider] 
                AND inp_patient_admission.ward_id = $data[ward]
                AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['ward'] != null && $data['gender'] != null && $data['provider'] != null) {
            echo "1";
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.ward_id = $data[ward]
                AND patient_data.sex = '$data[gender]'
                AND inp_patient_admission.assigned_provider = $data[provider] 
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null && $data['gender'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                -- AND inp_patient_admission.assigned_provider = $data[provider] 
                -- AND inp_patient_admission.ward_id = $data[ward]
                AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null && $data['ward'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                -- AND inp_patient_admission.assigned_provider = $data[provider] 
                AND inp_patient_admission.ward_id = $data[ward]
                -- AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null && $data['provider'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                AND inp_patient_admission.assigned_provider = $data[provider] 
                -- AND inp_patient_admission.ward_id = $data[ward]
                -- AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                -- AND inp_patient_admission.ward_id = $data[ward]
                -- AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['ward'] != null && $data['gender'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.ward_id = $data[ward]
                AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['gender'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['ward'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Admitted' 
                AND inp_patient_admission.ward_id = $data[ward]
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['provider'] != null) {
            $query =  "SELECT
            inp_patient_admission.*,
            patient_data.title,
            patient_data.fname,
            patient_data.mname,
            patient_data.lname,
            patient_data.sex,
            patient_data.dob,
            inp_ward.name AS ward_name,
            inp_ward.short_name AS ward_short_name,
            inp_beds.number AS bed_number
            FROM
                inp_patient_admission
            LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            WHERE
                inp_patient_admission.assigned_provider = $data[provider] 
            ORDER BY
                admission_date
            DESC";
        } else {
            $query =  "SELECT
            inp_patient_admission.*,
            patient_data.title,
            patient_data.fname,
            patient_data.mname,
            patient_data.lname,
            patient_data.sex,
            patient_data.dob,
            inp_ward.name AS ward_name,
            inp_ward.short_name AS ward_short_name,
            inp_beds.number AS bed_number
            FROM
                inp_patient_admission
            LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            ORDER BY
                admission_date
            DESC";
        }
        // AND (patient_data.fname LIKE '%$data[word]%' 
        // OR patient_data.lname LIKE '%$data[word]%' 
        // OR patient_data.mname LIKE '%$data[word]%')
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
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


    function filterDischargedPatients($data)
    {
        $query = "";
        // AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'

        if ($data['start_date'] != null && $data['end_date'] != null && $data['gender'] != null && $data['ward'] != null && $data['provider'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                AND inp_patient_admission.assigned_provider = $data[provider] 
                AND inp_patient_admission.ward_id = $data[ward]
                AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['ward'] != null && $data['gender'] != null && $data['provider'] != null) {
            echo "1";
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND inp_patient_admission.ward_id = $data[ward]
                AND patient_data.sex = '$data[gender]'
                AND inp_patient_admission.assigned_provider = $data[provider] 
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null && $data['gender'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                -- AND inp_patient_admission.assigned_provider = $data[provider] 
                -- AND inp_patient_admission.ward_id = $data[ward]
                AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null && $data['ward'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                -- AND inp_patient_admission.assigned_provider = $data[provider] 
                AND inp_patient_admission.ward_id = $data[ward]
                -- AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null && $data['provider'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                AND inp_patient_admission.assigned_provider = $data[provider] 
                -- AND inp_patient_admission.ward_id = $data[ward]
                -- AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['start_date'] != null && $data['end_date'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND inp_patient_admission.created_at BETWEEN '$data[start_date]' AND '$data[end_date]'
                -- AND inp_patient_admission.ward_id = $data[ward]
                -- AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['ward'] != null && $data['gender'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND inp_patient_admission.ward_id = $data[ward]
                AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['gender'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND patient_data.sex = '$data[gender]'
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['ward'] != null) {
            $query =  "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number
                FROM
                    inp_patient_admission
                LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
                LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
                LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
                WHERE
                    inp_patient_admission.status = 'Discharged' 
                AND 
                    inp_patient_admission.ward_id = $data[ward]
                ORDER BY
                    admission_date
                DESC";
        } elseif ($data['provider'] != null) {
            $query =  "SELECT
            inp_patient_admission.*,
            patient_data.title,
            patient_data.fname,
            patient_data.mname,
            patient_data.lname,
            patient_data.sex,
            patient_data.dob,
            inp_ward.name AS ward_name,
            inp_ward.short_name AS ward_short_name,
            inp_beds.number AS bed_number
            FROM
                inp_patient_admission
            LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            WHERE
                inp_patient_admission.status = 'Discharged'
            AND
                inp_patient_admission.assigned_provider = $data[provider] 
            ORDER BY
                admission_date
            DESC";
        } else {
            $query =  "SELECT
            inp_patient_admission.*,
            patient_data.title,
            patient_data.fname,
            patient_data.mname,
            patient_data.lname,
            patient_data.sex,
            patient_data.dob,
            inp_ward.name AS ward_name,
            inp_ward.short_name AS ward_short_name,
            inp_beds.number AS bed_number
            FROM
                inp_patient_admission
            LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            WHERE
                    inp_patient_admission.status = 'Discharged'
            ORDER BY
                admission_date
            DESC";
        }

        $results = sqlStatement($query);
        return $results;
    }

    /**
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertInpatient($data)
    {
        // check if bed is available
        $bed = sqlQuery("SELECT availability FROM inp_beds WHERE id = ?", array($data['bed_id']));
        if ($bed['availability'] == 'Occupied') {
            return 'bed_occupied';
        }

        $bindArray = array($data['status'],  $data['id']);
        $sql = "UPDATE inp_patient_admission SET status = ?, admission_date = now() WHERE id = ?;";
        sqlStatement($sql, $bindArray);


        $bedArray = array('Occupied',  $data['bed_id']);
        $bedsql = "UPDATE inp_beds SET availability = ? WHERE id = ?;";
        sqlStatement($bedsql, $bedArray);


        // get encounter id from inp_patient_admission
        $encounter = sqlQuery("SELECT encounter_id, patient_id FROM inp_patient_admission WHERE id = ?", array($data['id']));
        $data['encounter_id'] = $encounter['encounter_id'];
        $data['patient_id'] = $encounter['patient_id'];


        // use bed price as fee
        $fee = sqlQuery("SELECT price_per_day FROM inp_beds WHERE id = ?", array($data['bed_id']));
        $fee = $fee['price_per_day'];

        // $billingSet = "date = now(),
        // code_type = 'Bed Bill',
        // code = $data[bed_id],
        // groupname = 'Default',
        // authorized = 1,
        // activity = 1,
        // units = 1,
        // pid = ?,
        // user = ?,
        // encounter = ?,
        // fee = ?
        // ";
        // $billingArray = array($data['patient_id'],  $_SESSION['authUserID'], $data['encounter_id'], $fee);
        // sqlInsert("INSERT INTO billing SET $billingSet", $billingArray);


        sqlInsert("INSERT INTO inp_bed_records SET bed_id = $data[bed_id], ward_id = $data[ward_id] , admission_id  = $data[id]");
    }


    /**
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function updateInpatient($data)
    {
        $sets = "ward_id = ?,
            bed_id = ?
        ";

        $bindArray = array(
            $data['ward_id'],
            $data['bed_id'],
            $data['id']
        );

        $sql = "UPDATE inp_patient_admission SET $sets WHERE id = ?;";

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
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
     * @param $name
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function dischargeInpatient($data)
    {
        $sets = "status = ?,
        discharge_date = ?
        ";
        $bindArray = array(
            'Discharged',
            $data['discharge_date'] ? $data['discharge_date']  : date('Y-m-d H:i:s'),
            $data['id'],
        );
        $sql = "UPDATE inp_patient_admission SET $sets WHERE id = ?;";
        sqlStatement($sql, $bindArray);


        $bedsets = "availability = ?
        ";
        $bedArray = array(
            'Available',
            $data['bed_id'],
        );
        $bedsql = "UPDATE inp_beds SET $bedsets WHERE id = ?;";
        sqlStatement($bedsql, $bedArray);


        if ($data['deceased'] == "Yes") {
            sqlStatement("UPDATE patient_data SET $sets WHERE deceased_date=?, deceased_reason=? WHERE pid=?", array(
                $data['deceased_date'] ? $data['deceased_date']  : date('Y-m-d H:i:s'),
                $data['deceased_reason'],
                $data['pid'],
            ));
        }


        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
    }


    function prepareDischarge($data)
    {
        $bedRes = sqlStatement("SELECT
                admission_id,
                bed_id,
                price_per_day,
                SUM(
                    DATEDIFF(
                        IFNULL(end_date, CURRENT_TIMESTAMP),
                        start_date
                    )
                ) AS days,
                price_per_day * SUM(
                    DATEDIFF(
                        IFNULL(end_date, CURRENT_TIMESTAMP),
                        start_date
                    )
                ) AS bed_bill
            FROM
                inp_bed_records
            LEFT JOIN inp_beds ON inp_bed_records.bed_id = inp_beds.id
            WHERE
                inp_bed_records.admission_id = '$data[id]'
            GROUP BY
                admission_id,
                bed_id");

        $foodRes = sqlStatement("SELECT
                fr.admission_id,
                SUM(fi.price) AS total_price
            FROM
                inp_food_request fr
            JOIN inp_food_item fi ON
                fr.food_id = fi.id
            WHERE
                fr.admission_id = '$data[id]'
            GROUP BY
                fr.admission_id;");


        $totalFoodBill = 0;
        foreach ($foodRes as $item) {
            $totalFoodBill += $item['total_price'];
        }

        $totalBedBill = 0;
        foreach ($bedRes as $item) {
            $totalBedBill += $item['bed_bill'];
        }

        // echo "Total Bed Bill: " . $totalBedBill;
        // echo "Total Food Bill: " . $totalFoodBill;
        // echo "Total Bill: " . ($totalFoodBill + $totalBedBill);

        sqlInsert("INSERT INTO billing SET date = now(),
                code_type = 'Inpatient',
                code = 2210,
                groupname = 'Default',
                authorized = 1,
                activity = 1,
                units = 1,
                pid = ?,
                user = ?,
                encounter = ?,
                fee = ?", array(
            $data['patient_id'],
            $_SESSION['authUserID'],
            $data['encounter_id'],
            $totalFoodBill + $totalBedBill
        ));

        sqlStatement("UPDATE inp_patient_admission SET status = 'Pay Bills' WHERE id = $data[id];");

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
            $data['patient_id'], //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $bedRes . $foodRes,
            1,
            'open-emr',
            'dashboard'
        );
    }


    function undoAdmission($data)
    {
        $sets = "status = ?";
        $bindArray = array(
            'In Queue',
            $data['id'],
        );
        $sql = "UPDATE inp_patient_admission SET $sets WHERE id = ?;";
        sqlStatement($sql, $bindArray);


        $bedsets = "availability = ?
        ";
        $bedArray = array(
            'Available',
            $data['bed_id'],
        );
        $bedsql = "UPDATE inp_beds SET $bedsets WHERE id = ?;";
        sqlStatement($bedsql, $bedArray);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: undo admission inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
    }



    /**
     * @param $id
     * @return bool
     */
    function destroyAdmission($id)
    {
        $sql = "DELETE FROM inp_patient_admission WHERE id = ?;";
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
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


    function insertNurseNote($data)
    {
        $sets = "admission_id = ?, 
            note = ?
        ";

        $bindArray = array(
            $data['admission_id'],
            $data['note'],
        );


        EventAuditLogger::instance()->newEvent(
            "inpatient-module: inp_patient_admission",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO inp_inpatient_nurses_note SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO inp_inpatient_nurses_note SET $sets", $bindArray);
    }

    /**
     * Fetch inpatient admission data by patient pid
     * @param int $pid
     * @return array|null
     */
    function getInpatientByPid($pid)
    {
        $query = "SELECT
                inp_patient_admission.*,
                patient_data.title,
                patient_data.fname,
                patient_data.mname,
                patient_data.lname,
                patient_data.sex,
                patient_data.dob,
                inp_ward.name AS ward_name,
                inp_ward.short_name AS ward_short_name,
                inp_beds.number AS bed_number,
                inp_beds.price_per_day
            FROM
                inp_patient_admission
            LEFT JOIN patient_data ON inp_patient_admission.patient_id = patient_data.pid
            LEFT JOIN inp_ward ON inp_patient_admission.ward_id = inp_ward.id
            LEFT JOIN inp_beds ON inp_patient_admission.bed_id = inp_beds.id
            WHERE
                patient_data.pid = ?
            ORDER BY
                admission_date DESC
            LIMIT 1";

        $result = sqlQuery($query, array($pid));
        return $result ? $result : null;
    }
}
