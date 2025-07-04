<?php

/**
 * EmployerService handles the data retrieval for the employer data for a patient
 *
 * @package openemr
 * @link      http://www.open-emr.org
 * @author    Stephen Nielson <snielson@discoverandchange.com>
 * @copyright Copyright (c) 2024 Care Management Solutions, Inc. <stephen.waite@cmsvt.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

namespace OpenEMR\Services;

class EmployerService extends BaseService
{
    const TABLE_NAME = "employer_data";

    public function __construct()
    {
        parent::__construct(self::TABLE_NAME);
    }

    // we want to grab the puuid from the patient table so people can search on it
    public function getSelectFields(string $tableAlias = '', string $columnPrefix = ""): array
    {
        $fields = parent::getSelectFields($tableAlias, $columnPrefix);
        $fields[] = '`patient`.`puuid`';
        return $fields;
    }
    // used in the search clause for EmployerService
    public function getSelectJoinTables(): array
    {
        return [
            'patient' => [
                'type' => 'INNER JOIN',
                'table' => '(select `pid` AS `patient_pid`, `uuid` AS puuid FROM `patient_data`)',
                'alias' => 'patient',
                'join_clause' => '`patient`.`patient_pid` = `' . self::TABLE_NAME . '`.`pid`',
            ]
        ];
    }

    public function search($search, $isAndCondition = true)
    {
        // if we wanted to modify the search we could do that here...
        // leaving this so people understand that we are leveraging several base methods to do the work
        return parent::search($search, $isAndCondition); // TODO: Change the autogenerated stub
    }

    public function getUuidFields(): array
    {
        // need this function to make sure the puuid is converted to a string uuid
        return ['puuid'];
    }
}
