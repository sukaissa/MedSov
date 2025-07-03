<div>
    <?php

    $columns = [
        [
            'title' => 'Patient ID',
            'dataIndex' => 'pid'
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
            'title' => 'Admitted on',
            'dataIndex' => 'admitted'
        ],
        [
            'title' => 'Days Spent',
            'dataIndex' => 'days_spent'
        ],
        // [
        //     'title' => 'Actions',
        //     'dataIndex' => 'actions',
        //     'render' => function ($record) {
        //         $patientId = htmlspecialchars($record['pid']);
        //         return '<div class="flex space-x-2">
        //                         <a role="button" href="dashboard.php?id=' . $patientId . '" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded-md shadow-sm transition duration-200">View</a>
        //                         <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded-md shadow-sm transition duration-200">Delete</button>
        //                     </div>';
        //     }
        // ],
    ];
    $inpatientsArray = iterator_to_array($inpatients);

    // Map $inpatientsArray to $dataSource for the table using array_map
    $dataSource = [];
    if ($inpatientsArray) {
        $dataSource = array_map(function ($item) {
            if (is_array($item)) {
                return [
                    'id' => $item['id'] ?? '',
                    'pid' => $item['patient_id'] ?? '',
                    'name' => trim(($item['fname'] ?? '') . ' ' . ($item['mname'] ?? '') . ' ' . ($item['lname'] ?? '')),
                    'ward' => $item['ward_name'] ?? '',
                    'bed' => $item['bed_number'] ?? '',
                    'admitted' => $item['admission_date'] ?? '',
                    'days_spent' => (isset($item['admission_date']) && $item['admission_date'])
                        ? (
                            isset($item['discharge_date']) && $item['discharge_date']
                            ? max(1, (int) ceil((strtotime($item['discharge_date']) - strtotime($item['admission_date'])) / 86400))
                            : max(1, (int) ceil((time() - strtotime($item['admission_date'])) / 86400))
                        )
                        : ''
                ];
            }
            return null;
        }, $inpatientsArray);
        // Remove nulls if any
        $dataSource = array_filter($dataSource);
    }


    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>
</div>