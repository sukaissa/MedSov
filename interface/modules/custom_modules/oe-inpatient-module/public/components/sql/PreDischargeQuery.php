<?php
// filepath: /Applications/MAMP/htdocs/MedSov/interface/modules/custom_modules/oe-inpatient-module/public/components/sql/PreDischargeChecklist.php

namespace OpenEMR\Modules\InpatientModule;

use OpenEMR\Common\Logging\EventAuditLogger;

class PreDischargeChecklist
{
    /**
     * Insert a new predischarge checklist entry
     * @param array $data
     * @return void
     */
    public function insertChecklist($data)
    {
        // Validate data
        $errors = $this->validateChecklistData($data);
        if (!empty($errors)) {
            throw new \Exception("Validation errors: " . implode(", ", $errors));
        }

        $sets = "patient_id = ?, 
            discharge_date = ?, 
            list_option_id = ?, 
            list_option_value = ?, 
            notes = ?, 
            created_by = ?
        ";

        $bindArray = array(
            $data['patient_id'],
            $data['discharge_date'],
            $data['list_option_id'],
            $data['list_option_value'],
            $data['notes'],
            $data['created_by'],
        );

        sqlInsert("INSERT INTO predischarge_checklist SET $sets", $bindArray);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: insert predischarge_checklist",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            "INSERT INTO predischarge_checklist SET $sets",
            1,
            'open-emr',
            'dashboard'
        );
    }

    /**
     * Get a predischarge checklist entry by ID
     * @param int $id
     * @return array|null
     */
    public function getChecklistById($id)
    {
        $query = "SELECT * FROM predischarge_checklist WHERE id = ?";
        $result = sqlQuery($query, array($id));

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query predischarge_checklist",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );

        return $result;
    }

    /**
     * Update a predischarge checklist entry
     * @param array $data
     * @return void
     */
    public function updateChecklist($data)
    {
         // Validate data
        $errors = $this->validateChecklistData($data);
        if (!empty($errors)) {
            throw new \Exception("Validation errors: " . implode(", ", $errors));
        }
        
        $sets = "list_option_value = ?, 
            notes = ?, 
            updated_by = ?, 
            updated_at = NOW()
        ";

        $bindArray = array(
            $data['list_option_value'],
            $data['notes'],
            $data['updated_by'],
            $data['id'],
        );

        $sql = "UPDATE predischarge_checklist SET $sets WHERE id = ?";
        sqlStatement($sql, $bindArray);

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: update predischarge_checklist",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
    }

    /**
     * Delete a predischarge checklist entry
     * @param int $id
     * @return void
     */
    public function deleteChecklist($id)
    {
        $sql = "DELETE FROM predischarge_checklist WHERE id = ?";
        sqlStatement($sql, array($id));

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: delete predischarge_checklist",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            $sql,
            1,
            'open-emr',
            'dashboard'
        );
    }

    /**
     * Get all predischarge checklist entries for a specific patient
     * @param int $patientId
     * @return array
     */
    public function getChecklistsByPatientId($patientId)
    {
        $query = "SELECT * FROM predischarge_checklist WHERE patient_id = ?";
        $results = sqlStatement($query, array($patientId));

        EventAuditLogger::instance()->newEvent(
            "inpatient-module: query predischarge_checklist",
            null, // pid
            $_SESSION["authUser"], // authUser
            $_SESSION["authProvider"], // authProvider
            $query,
            1,
            'open-emr',
            'dashboard'
        );

        return $results;
    }

    /**
     * Validate predischarge checklist data
     * @param array $data
     * @return array
     */
    private function validateChecklistData($data)
    {
        $errors = [];

        // Validate patient_id
        if (empty($data['patient_id']) || !is_numeric($data['patient_id'])) {
            $errors[] = "Invalid patient ID.";
        }

        // Validate discharge_date
        if (empty($data['discharge_date']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['discharge_date'])) {
            $errors[] = "Invalid discharge date. Use format YYYY-MM-DD.";
        }

        // Validate list_option_id
        if (empty($data['list_option_id']) || !is_string($data['list_option_id'])) {
            $errors[] = "Invalid list option ID.";
        }

        // Validate list_option_value
        if (!isset($data['list_option_value']) || !is_bool($data['list_option_value'])) {
            $errors[] = "Invalid list option value. Must be a boolean.";
        }

        // Validate notes
        if (!empty($data['notes']) && !is_string($data['notes'])) {
            $errors[] = "Notes must be a string.";
        }

        // Validate created_by or updated_by
        if (empty($data['created_by']) && empty($data['updated_by'])) {
            $errors[] = "Created by or updated by field is required.";
        }

        return $errors;
    }
}