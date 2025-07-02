<div>
    <?php

    $allAdmissionsArray = iterator_to_array($allAdmissions);

    // Map $allAdmissionsArray to the required $dataSource structure
    $dataSource = array_map(function ($admission) {
        // Handle both object and array types
        $admission = (array)$admission;
        return [
            'id' => isset($admission['id']) ? $admission['id'] : '',
            'name' => trim(
                (isset($admission['fname']) ? $admission['fname'] : '') . ' ' .
                    (isset($admission['mname']) ? $admission['mname'] : '') . ' ' .
                    (isset($admission['lname']) ? $admission['lname'] : '')
            ),
            'patient_id' => isset($admission['patient_id']) ? $admission['patient_id'] : '',
            'ward' => isset($admission['ward_name']) ? $admission['ward_name'] : '',
            'date_admitted' => isset($admission['admission_date']) ? $admission['admission_date'] : '',
            'days_spent' => isset($admission['admission_date']) ? (new DateTime())->diff(new DateTime($admission['admission_date']))->days : '',
            'status' => isset($admission['status']) ? $admission['status'] : '',
            'bed' => isset($admission['bed_number']) ? $admission['bed_number'] : '',
        ];
    }, $allAdmissionsArray);

    $columns = [
        ['title' => 'Patient ID', 'dataIndex' => 'patient_id'],
        ['title' => 'Name', 'dataIndex' => 'name'],
        ['title' => 'Ward', 'dataIndex' => 'ward'],
        ['title' => 'Bed', 'dataIndex' => 'bed'],
        ['title' => 'Status', 'dataIndex' => 'status'],
        ['title' => 'Admitted On', 'dataIndex' => 'date_admitted'],
        ['title' => 'Days Spent', 'dataIndex' => 'days_spent'],
    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>
</div>