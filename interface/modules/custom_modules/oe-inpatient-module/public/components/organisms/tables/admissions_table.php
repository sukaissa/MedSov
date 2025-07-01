<div>


    <?php

    $dataSource = [

        [
            'id' => 'S002',
            'name' => 'Lily Cho',
            'patient_id' => 'P003',
            'ward' => 'Woman’s Medical',
            'date_admitted' => '2025-06-04 14:59:05',
            'days_spent' => '12',
            'bed' => '101',
        ],

    ];


    $columns = [
        ['title' => 'Patient ID', 'dataIndex' => 'patient_id'],
        ['title' => 'Name', 'dataIndex' => 'name'],
        ['title' => 'Ward', 'dataIndex' => 'ward'],
        ['title' => 'Bed', 'dataIndex' => 'bed'],
        ['title' => 'Admitted', 'dataIndex' => 'date_admitted'],
        ['title' => 'Days Spent', 'dataIndex' => 'days_spent'],

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>