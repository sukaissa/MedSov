<?php
// filepath: /Applications/MAMP/htdocs/MedSov/interface/modules/custom_modules/oe-inpatient-module/public/components/sql/PreDischargeChecklistQuery.php

namespace OpenEMR\Modules\InpatientModule;

use OpenEMR\Common\Logging\EventAuditLogger;

class PreDischargeChecklistQuery
{
    /**
     * Count all predischarge forms
     * @return int
     */
    public function countForms()
    {
        $results = sqlStatement("SELECT * FROM form_predischarge");
        $total = 0;
        foreach ($results as $value) {
            $total++;
        }

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query form_predischarge count",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            "SELECT * FROM form_predischarge",
            1,
            'open-emr',
            'inpatient'
        );

        return $total;
    }

    /**
     * Insert a new predischarge form
     * @param int $patientId
     * @return int The ID of the newly created form
     */
    public function insertForm($patientId)
    {
        $formId = sqlInsert("
            INSERT INTO form_predischarge (pid, created_by) 
            VALUES (?, ?)", 
            [$patientId, $_SESSION['authUser']]
        );

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert form_predischarge",
            $patientId, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            "INSERT INTO form_predischarge (pid, created_by)",
            1,
            'open-emr',
            'inpatient'
        );

        return $formId;
    }

    /**
     * Insert checklist items for a predischarge form
     * @param int $formId
     * @return void
     */
    public function insertFormItems($formId)
    {
        $listOptions = sqlStatement("
            SELECT option_id 
            FROM list_options 
            WHERE list_id = 'pre_discharge_items'
        ");

        while ($row = sqlFetchArray($listOptions)) {
            sqlInsert("
                INSERT INTO form_predischarge_items (form_id, list_option_id, created_by) 
                VALUES (?, ?, ?)", 
                [$formId, $row['option_id'], $_SESSION['authUser']]
            );
        }

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert form_predischarge_items",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            "INSERT INTO form_predischarge_items (form_id, list_option_id, created_by)",
            1,
            'open-emr',
            'inpatient'
        );
    }

    /**
     * Get all predischarge forms with patient information
     * @return array
     */
    public function getAllForms()
    {
        $query = "
            SELECT 
                fp.id AS form_id,
                fp.pid AS patient_id,
                CONCAT(pd.fname, ' ', pd.lname) AS patient_name,
                fp.created_at AS form_created_at,
                fp.created_by AS form_created_by
            FROM 
                form_predischarge fp
            LEFT JOIN 
                patient_data pd ON fp.pid = pd.pid
            ORDER BY 
                fp.created_at DESC
        ";

        $results = sqlStatement($query);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query all form_predischarge with patient data",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            $query,
            1,
            'open-emr',
            'inpatient'
        );

        $data = [];
        while ($row = sqlFetchArray($results)) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Update a checklist item in a predischarge form
     * @param array $data
     * @return void
     */
    public function updateFormItem($data)
    {
        $sql = "
            UPDATE form_predischarge_items 
            SET list_option_value = ?, 
                notes = ?, 
                created_by = ?, 
                created_at = NOW()
            WHERE id = ?
        ";

        sqlStatement($sql, [
            $data['list_option_value'],
            $data['notes'],
            $_SESSION['authUser'],
            $data['id']
        ]);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update form_predischarge_items",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            $sql,
            1,
            'open-emr',
            'inpatient'
        );
    }

    /**
     * Update checklist items in a predischarge form based on form_id
     * @param int $formId
     * @param array $items Array of checklist items to update (each item contains id, list_option_value, and notes)
     * @return void
     */
    public function updateFormItems($formId, $items)
    {
        foreach ($items as $item) {
            $sql = "
                UPDATE form_predischarge_items 
                SET list_option_value = ?, 
                    notes = ?, 
                    created_by = ?, 
                    created_at = NOW()
                WHERE form_id = ? AND id = ?
            ";

            sqlStatement($sql, [
                $item['list_option_value'],
                $item['notes'],
                $_SESSION['authUser'],
                $formId,
                $item['id']
            ]);

            EventAuditLogger::instance()->newEvent(
                "inpatient-module: update form_predischarge_items",
                null, // pid
                $_SESSION["authUser"], // authUser
                $_SESSION["authProvider"], // authProvider
                $sql,
                1,
                'open-emr',
                'inpatient'
            );
        }
    }

    /**
     * Delete a predischarge form and its items
     * @param int $formId
     * @return void
     */
    public function deleteForm($formId)
    {
        $sql = "DELETE FROM form_predischarge WHERE id = ?";
        sqlStatement($sql, [$formId]);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete form_predischarge",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            $sql,
            1,
            'open-emr',
            'inpatient'
        );
    }

    /**
     * Get filtered predischarge forms based on patient name and date range
     * @param string $searchName
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getFilteredForms($searchName, $startDate, $endDate)
    {
        $query = "
            SELECT 
                fp.id AS form_id,
                fp.pid AS patient_id,
                CONCAT(pd.fname, ' ', pd.lname) AS patient_name,
                fp.created_at AS form_created_at,
                fp.created_by AS form_created_by
            FROM 
                form_predischarge fp
            LEFT JOIN 
                patient_data pd ON fp.pid = pd.pid
            WHERE 1=1
        ";

        $params = [];

        // Add filters dynamically
        if (!empty($searchName)) {
            $query .= " AND CONCAT(pd.fname, ' ', pd.lname) LIKE ?";
            $params[] = '%' . $searchName . '%';
        }

        if (!empty($startDate)) {
            $query .= " AND fp.created_at >= ?";
            $params[] = $startDate;
        }

        if (!empty($endDate)) {
            $query .= " AND fp.created_at <= ?";
            $params[] = $endDate;
        }

        $query .= " ORDER BY fp.created_at DESC";

        $results = sqlStatement($query, $params);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query filtered form_predischarge",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            $query,
            1,
            'open-emr',
            'inpatient'
        );

        $data = [];
        while ($row = sqlFetchArray($results)) {
            $data[] = $row;
        }

        return $data;
    }
}
