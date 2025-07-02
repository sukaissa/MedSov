<div>


    <?php
    $bedsArray = iterator_to_array($beds);
    $dataSource = $bedsArray ?? [];

    $columns = [
        ['title' => 'Bed number', 'dataIndex' => 'number'],
        ['title' => 'Type', 'dataIndex' => 'bed_type'],
        ['title' => 'Price per day', 'dataIndex' => 'price_per_day'],
        ['title' => 'Availability', 'dataIndex' => 'availability'],
        ['title' => 'Ward', 'dataIndex' => 'ward_name'],
    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>