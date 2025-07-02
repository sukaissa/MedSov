<div>


    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'surgery_name' => 'Appendectomy',
            'patient_id' => 'P001',
            'patient_name' => 'John Doe',
            'date' => '2024-06-15',
            'time' => '10:00 AM',
            'surgeon' => 'Dr. Alice Smith',
            'status' => 'Completed',
            'room' => 'OR 1'
        ],
        [
            'id' => 'S002',
            'surgery_name' => 'Knee Arthroscopy',
            'patient_id' => 'P003',
            'patient_name' => 'Mike Johnson',
            'date' => '2024-06-16',
            'time' => '09:30 AM',
            'surgeon' => 'Dr. Bob Williams',
            'status' => 'Scheduled',
            'room' => 'OR 2'
        ],

    ];


    $columns = [
        ['title' => 'Surgery ID', 'dataIndex' => 'id'],
        ['title' => 'Surgery Name', 'dataIndex' => 'surgery_name'],
        ['title' => 'Patient', 'dataIndex' => 'patient_name'],
        ['title' => 'Date', 'dataIndex' => 'date'],
        ['title' => 'Time', 'dataIndex' => 'time'],
        ['title' => 'Surgeon', 'dataIndex' => 'surgeon'],
        ['title' => 'Status', 'dataIndex' => 'status'],
        ['title' => 'Room', 'dataIndex' => 'room'],
        ['title' => 'Actions', 'dataIndex' => 'actions', 'render' => function ($record) {
            return '<a class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded-md shadow-sm transition duration-200" href="surgery_details.php?id=' . htmlspecialchars($record['id']) . '">Details</a>';
        }]
    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>