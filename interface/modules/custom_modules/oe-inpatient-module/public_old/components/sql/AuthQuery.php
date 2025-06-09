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

class AuthQuery
{
    /**
     * @return array
     */
    public function getProviders()
    {
        $users = array();
        $res = sqlStatement("SELECT id, fname, mname, lname FROM users WHERE authorized=1 AND active ='1'");
        foreach ($res as $row) {
            array_push($users,   [
                'id' => $row['id'],
                'fname' =>  $row['fname'],
                'lname' => $row['lname'],
                'mname' => $row['mname']
            ]);
        }

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query users",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "SELECT id, fname, lname FROM users WHERE authorized=1 AND active ='1'",
            1,
            'open-emr',
            'dashboard'
        );
        return $users;
    }

    /**
     * @return array
     */
    public function getUsersList()
    {
        $users = array();
        $res = sqlStatement("SELECT id, fname, lname FROM users WHERE active ='1' AND `username` IS NOT NULL AND `password` IS NOT NULL");
        foreach ($res as $row) {
            array_push($users,   [
                'id' => $row['id'],
                'fname' =>  $row['fname'],
                'lname' => $row['lname']
            ]);
        }
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query users",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "SELECT id, fname, lname FROM users WHERE active ='1' AND `username` IS NOT NULL AND `password` IS NOT NULL",
            1,
            'open-emr',
            'dashboard'
        );
        return $users;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        $users = array();
        $res = sqlStatement("SELECT id, fname, lname, street, city, state, zip  FROM users WHERE authorized=1 AND active='1' ");
        foreach ($res as $row) {
            array_push($users,   [
                'id' => $row['id'],
                'fname' =>  $row['fname'],
                'lname' => $row['lname']
            ]);
        }
        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query users",
            null, //pid
            $_SESSION["authUser"], //authUser
            $_SESSION["authProvider"], //authProvider
            "SELECT id, fname, lname, street, city, state, zip  FROM users WHERE authorized=1 AND active='1' ",
            1,
            'open-emr',
            'dashboard'
        );
        return $users;
    }
}
