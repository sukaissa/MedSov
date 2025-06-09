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

class ActionPlanQuery
{

    /**
     * @return array
     */
    function getActionPlansNew()
    {
        $query = "SELECT * FROM lists";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query lists",
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
    function getIssueList()
    {
        $query = "SELECT * FROM issue_types WHERE force_show=1";

        $results = sqlStatement($query);
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query issue_types",
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
}
