<div>
    <?php
    $getCssdItems = iterator_to_array($getCssdItems);

    $dataSource = array_map(function ($item) {
        return [
            'id' => $item['id'] ?? 'N/A',
            'service_name' => $item['item_name'] ?? 'N/A',
        ];
    }, $getCssdItems);

    $columns = [
        ['title' => 'Service Name', 'dataIndex' => 'service_name']

    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>

    

</div>