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

class BillQuery
{

    /**
     * @return array
     */
    function getPatientBills($pid, $admission_id)
    {
        $query = "SELECT * FROM billing WHERE code_type = 'inp' AND pid = $pid";
        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query billing",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );

        $bedsRes = sqlStatement("SELECT
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
                WHERE admission_id = $admission_id
                GROUP BY
                    admission_id,
                    bed_id");

        return $results;
    }
}
