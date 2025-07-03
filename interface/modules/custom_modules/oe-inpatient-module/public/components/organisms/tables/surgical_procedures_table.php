<div>


    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'name' => 'Appendectomy',
            'status' => 'Active',
            'price' => '100',

        ],
        [
            'id' => 'S002',
            'name' => 'Knee Arthroscopy',
            'status' => 'Active',
            'price' => '100',
        ],

    ];


    $columns = [
        ['title' => 'No', 'dataIndex' => 'id'],
        ['title' => 'Name', 'dataIndex' => 'name'],
        ['title' => 'Status', 'dataIndex' => 'status'],
        ['title' => 'Price', 'dataIndex' => 'price'],

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>