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

class ReferralQuery
{
    /**
     * @param $number
     * @param $ward_id
     * @param $price_per_day
     * @return bool
     */
    function insertReferral($data)
    {
        $title   = empty($_REQUEST['title']) ? 'LBTref' : $_REQUEST['title'];
        $form_id = $title;

        $userauthorized = 1;
        $sets = "title = ?, user = ?, groupname = ?, authorized = ?, date = NOW(), pid = ?";
        $sqlBindArray = array($form_id, $_SESSION['authUser'], $_SESSION['authProvider'], $userauthorized, $data['pid']);

        $new_id = sqlInsert("INSERT INTO transactions SET $sets", $sqlBindArray);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: transactions",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO transactions SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        foreach ($data as $key => $value) {
            if (!empty($value)) {
                sqlStatement(
                    "INSERT INTO lbt_data " .
                        "( form_id, field_id, field_value ) VALUES ( ?, ?, ? )",
                    array($new_id, $key, $value)
                );
            }
        }
    }
}
