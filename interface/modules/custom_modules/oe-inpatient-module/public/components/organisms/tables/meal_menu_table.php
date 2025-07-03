<div>

    <?php
    $menuItemsArray = iterator_to_array($menuItems);

    $dataSource = array_map(function($item) {
        return [
            'id' => $item['id'] ?? 'N/A',
            'meal_name' => $item['name'] ?? 'N/A',
            'meal_type' => $item['category'] ?? 'N/A',
            'price' => $item['price'] ?? '0',
            'availability' => $item['availability'] ?? 'Available',
        ];
    }, $menuItemsArray);

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