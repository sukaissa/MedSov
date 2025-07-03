<div>
    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'visitor_name' => 'Test1',
            'patient_name' => 'Test1',
            'relationship' => 'Test1',


        ],
        [
            'id' => 'S002',
            'visitor_name' => 'Test2',
            'patient_name' => 'Test2',
            'relationship' => 'Test2',

        ],

    ];


    $columns = [
        ['title' => 'Visitor Name', 'dataIndex' => 'visitor_name'],
        ['title' => 'Patient Name', 'dataIndex' => 'patient_name'],
        ['title' => 'Relationship', 'dataIndex' => 'relationship'],

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>