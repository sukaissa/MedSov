<div>


    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'meal_name' => 'Chicken',
            'meal_type' => 'Breakfast',
            'price' => '100',
            'availability' => 'Available',

        ],
        [
            'id' => 'S002',
            'meal_name' => 'Beef',
            'meal_type' => 'Lunch',
            'price' => '100',
            'availability' => 'Available',
        ],

    ];


    $columns = [
        ['title' => 'No', 'dataIndex' => 'id'],
        ['title' => 'Item Name', 'dataIndex' => 'meal_name'],
        ['title' => 'Meal Type', 'dataIndex' => 'meal_type'],
        ['title' => 'Price', 'dataIndex' => 'price'],
        ['title' => 'Availability', 'dataIndex' => 'availability'],

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>