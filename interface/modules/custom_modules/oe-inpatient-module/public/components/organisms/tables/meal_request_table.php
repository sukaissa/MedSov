<div>


    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'patient_name' => 'John Doe',
            'meal_name' => 'Chicken',
            'meal_type' => 'Breakfast',
            'staff_name' => 'John Doe',
            'request_date' => '2021-01-01',

        ],
        [
            'id' => 'S002',
            'patient_name' => 'Jane Doe',
            'meal_name' => 'Beef',
            'meal_type' => 'Lunch',
            'staff_name' => 'Jane Doe',
            'request_date' => '2021-01-01',
        ],

    ];


    $columns = [
        ['title' => 'No', 'dataIndex' => 'id'],
        ['title' => 'Patient Name', 'dataIndex' => 'patient_name'],
        ['title' => 'Meal Name', 'dataIndex' => 'meal_name'],
        ['title' => 'Meal Type', 'dataIndex' => 'meal_type'],
        ['title' => 'Staff Name', 'dataIndex' => 'staff_name'],
        ['title' => 'Request Date', 'dataIndex' => 'request_date'],

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>