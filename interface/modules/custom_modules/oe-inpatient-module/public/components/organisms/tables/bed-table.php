<div>


    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'bed_number' => 1,
            'type' => 'Private',
            'price' => '20',
            'availability' => 'Available',
            'ward' => 'Male Ward',
        ],
        [
            'id' => 'S001',
            'bed_number' => 2,
            'type' => 'Private',
            'price' => '20',
            'availability' => 'Available',
            'ward' => 'Male Ward',
        ],
        [
            'id' => 'S001',
            'bed_number' => 3,
            'type' => 'Private',
            'price' => '20',
            'availability' => 'Available',
            'ward' => 'Male Ward',
        ],
        [
            'id' => 'S001',
            'bed_number' => 4,
            'type' => 'Private',
            'price' => '20',
            'availability' => 'Available',
            'ward' => 'Male Ward',
        ],
    
    ];


    $columns = [
        ['title' => 'Bed number', 'dataIndex' => 'bed_number'],
        ['title' => 'Type', 'dataIndex' => 'type'],
        ['title' => 'Price per day', 'dataIndex' => 'price'],
        ['title' => 'Availability', 'dataIndex' => 'availability'],
        ['title' => 'Ward', 'dataIndex' => 'ward'],
    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>