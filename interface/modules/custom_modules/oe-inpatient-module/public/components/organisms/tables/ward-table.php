<div>


    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'name' => 'Pediatrics Ward',
            'short_name' => 'PW',
        ],
        [
            'id' => 'S002',
            'name' => 'Pediatrics Ward',
            'short_name' => 'PW',
        ],
        [
            'id' => 'S003',
            'name' => 'Pediatrics Ward',
            'short_name' => 'PW',
        ],
    ];


    $columns = [
        ['title' => 'Name', 'dataIndex' => 'name'],
        ['title' => 'Short Name', 'dataIndex' => 'short_name'],

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>