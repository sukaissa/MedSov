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
// $_SESSION['authUser']
// add_escape_custom($_SESSION['authUser'])
// add_escape_custom($_SESSION['authProvider'])
// $this->provider = new User($_SESSION['authUserID']);
// $_SESSION['authUserID'];
// $this->provider = new User($_SESSION['authUserID']);

class ListsQuery
{

    /**
     * @param $action_name
     * @return bool
     */
    function insertList($data)
    {

        $sets = "date=now(),
        begdate=cast(now() as date),
        type=?,
        activity=?,
        pid=?,
        user=?,
        groupname=?,
        title=?,
        uuid=?
    ";

        $bindArray = array(
            // new DateTime(),
            // new DateTime(),
            add_escape_custom($data['type']),
            1,
            add_escape_custom($data['patient_id']),
            add_escape_custom($_SESSION['authUser']),
            add_escape_custom($_SESSION['authProvider']),
            add_escape_custom($data['title']),
            $data['uuid']
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert lists",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "INSERT INTO lists SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
        sqlInsert("INSERT INTO lists SET $sets", $bindArray);
    }
}
