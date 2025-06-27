<div>


    <?php
    $wardsArray = iterator_to_array($wards);

    // Map $wards to the required $dataSource structure (robust: handles objects and arrays)
    $dataSource = $wardsArray ?? [];

    $columns = [
        ['title' => 'Name', 'dataIndex' => 'name'],
        ['title' => 'Short Name', 'dataIndex' => 'short_name'],
        ['title' => 'Available Beds', 'dataIndex' => 'available_beds'],
    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>