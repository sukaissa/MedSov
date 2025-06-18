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
                'render' => function($record) {
                    $patientId = htmlspecialchars($record['id']);
                    // This function allows you to render custom HTML for a cell.
                    // $record contains the entire row's data.
                    return '<div class="flex space-x-2">
                                <a role="button" href="dashboard.php?id=' .$patientId. '" class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded-md shadow-sm transition duration-200">View</a>
                                <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-2 py-1 rounded-md shadow-sm transition duration-200">Delete</button>
                            </div>';
                }
            ],
        ];
        $dataSource = [
            ['id' => 'P001', 'name' => 'Lily Cho', 'ward' => "Woman’s Medical", 'bed' => '001', 'addmitted' => '2025-06-04 14:59:05',"days_spent" => 12],
            ['id' => 'P002', 'name' => 'Jane Smith', 'ward' => "Woman’s Medical", 'bed' => '002', 'addmitted' => '2025-06-04 14:59:05',"days_spent" => 12],
            ['id' => 'P003', 'name' => 'Mike Johnson', 'ward' => "Woman’s Medical", 'bed' => '003', 'addmitted' => '2025-06-04 14:59:05', "days_spent" => 12],
            ['id' => 'P004', 'name' => 'Emily Brown', 'ward' => "Woman’s Medical", 'bed' => '004', 'addmitted' => '2025-06-04 14:59:05', "days_spent" => 12],
            ['id' => 'P005', 'name' => 'Chris Green', 'ward' => "Woman’s Medical", 'bed' => '005', 'addmitted' => '2025-06-04 14:59:05', "days_spent" => 12],
        ];

        $isLoading = false;
        $responsive = true;

        include_once __DIR__ . '/data-table.php';
        ?>
</div>