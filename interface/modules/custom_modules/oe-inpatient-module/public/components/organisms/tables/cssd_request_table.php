<div>


    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'service_name' => 'Test',
            'supervisor' => 'Test',
            'status' => 'Available',

        ],
        [
            'id' => 'S001',
            'service_name' => 'Test',
            'supervisor' => 'Test',
            'status' => 'Available',

        ],
    ];


    $columns = [
        ['title' => 'Service Name', 'dataIndex' => 'service_name'],
        ['title' => 'Supervisor Name', 'dataIndex' => 'supervisor'],
        ['title' => 'Status', 'dataIndex' => 'status']

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>