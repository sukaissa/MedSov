<div>
    <?php

    $columns = [
        [
            'title' => 'Patient ID',
            'dataIndex' => 'id'
        ],
        [
            'title' => 'Full Name',
            'dataIndex' => 'name'
        ],
        [
            'title' => 'Ward',
            'dataIndex' => 'ward'
        ],
        [
            'title' => 'Bed',
            'dataIndex' => 'bed'
        ],
        [
            'title' => 'Admitted',
            'dataIndex' => 'addmitted'
        ],
        [
            'title' => 'Days Spent',
            'dataIndex' => 'days_spent'
        ],
        [
            'title' => 'Actions',
            'dataIndex' => 'actions',
            'render' => function ($record) {
                $patientId = htmlspecialchars($record['id']);
                return '<div class="flex space-x-2">
                                <a role="button" href="dashboard.php?id=' . $patientId . '" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded-md shadow-sm transition duration-200">View</a>
                                <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded-md shadow-sm transition duration-200">Delete</button>
                            </div>';
            }
        ],
    ];

    $dataSource = [];
    // Map $inpatients to $dataSource for the table
    // If $inpatients is an object (e.g., sqlStatement result), fetch rows as arrays
    
    if (is_object($inpatients)) {
        while ($item = sqlFetchArray($inpatients)) {
            $dataSource[] = [
                'id' => $item['patient_id'] ?? $item['id'] ?? '',
                'name' => trim(($item['fname'] ?? '') . ' ' . ($item['mname'] ?? '') . ' ' . ($item['lname'] ?? '')),
                'ward' => $item['ward_name'] ?? '',
                'bed' => $item['bed_number'] ?? '',
                'addmitted' => $item['admission_date'] ?? '',
                'days_spent' => (isset($item['admission_date']) && $item['admission_date'])
                    ? (
                        isset($item['discharge_date']) && $item['discharge_date']
                        ? max(1, (int) ceil((strtotime($item['discharge_date']) - strtotime($item['admission_date'])) / 86400))
                        : max(1, (int) ceil((time() - strtotime($item['admission_date'])) / 86400))
                    )
                    : ''
            ];
        }
    } elseif (is_array($inpatients)) {
        foreach ($inpatients as $item) {
            if (is_object($item)) {
                $item = (array)$item;
            }
            if (is_array($item)) {
                $dataSource[] = [
                    'id' => $item['patient_id'] ?? $item['id'] ?? '',
                    'name' => trim(($item['fname'] ?? '') . ' ' . ($item['mname'] ?? '') . ' ' . ($item['lname'] ?? '')),
                    'ward' => $item['ward_name'] ?? '',
                    'bed' => $item['bed_number'] ?? '',
                    'addmitted' => $item['admission_date'] ?? '',
                    'days_spent' => (isset($item['admission_date']) && $item['admission_date'])
                        ? (
                            isset($item['discharge_date']) && $item['discharge_date']
                            ? max(1, (int) ceil((strtotime($item['discharge_date']) - strtotime($item['admission_date'])) / 86400))
                            : max(1, (int) ceil((time() - strtotime($item['admission_date'])) / 86400))
                        )
                        : ''
                ];
            }
        }
    }

    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>
</div>