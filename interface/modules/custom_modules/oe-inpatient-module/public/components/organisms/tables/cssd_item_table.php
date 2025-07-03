<div>
    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'service_name' => 'Test1',


        ],
        [
            'id' => 'S002',
            'service_name' => 'Test2',

        ],

    ];


    $columns = [
        ['title' => 'Service Name', 'dataIndex' => 'service_name']

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>