<?php
// components/organisms/data-table.php


// --- PROPS ---
// $columns: array of associative arrays, e.g.,
//   [
//     ['title' => 'Name', 'dataIndex' => 'name'],
//     ['title' => 'Age', 'dataIndex' => 'age'],
//     ['title' => 'Actions', 'dataIndex' => 'actions', 'render' => function($record) {
//         return '<button class="bg-blue-500 text-white px-2 py-1 rounded">View ' . htmlspecialchars($record['name']) . '</button>';
//     }]
//   ]
// $dataSource: array of associative arrays, e.g.,
//   [
//     ['name' => 'Alice', 'age' => 30],
//     ['name' => 'Bob', 'age' => 24]
//   ]
// $isLoading: boolean, true to show loading state
// $responsive: boolean, true for 'table-auto', false for 'table-fixed'

$columns = isset($columns) && is_array($columns) ? $columns : [];
$dataSource = isset($dataSource) && is_array($dataSource) ? $dataSource : [];
$isLoading = isset($isLoading) ? (bool)$isLoading : false;
$responsive = isset($responsive) ? (bool)$responsive : false;

?>

<?php if ($isLoading): ?>
<table class="table-fixed w-full">
    <thead>
        <tr class="h-10">
            <?php foreach ($columns as $column): ?>
            <th class="text-left px-4 text-gray-600 text-sm font-normal">
                <?php echo htmlspecialchars($column['title']); ?>
            </th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colSpan="<?php echo count($columns); ?>" class="text-center py-4 text-gray-500">
                <div>Loading...</div>
            </td>
        </tr>
    </tbody>
</table>
<?php else: ?>
<table class="<?php echo $responsive ? 'table-auto' : 'table-fixed'; ?> w-full border-collapse">
    <thead>
        <tr class="h-[50px] border-b-[6px]">
            <?php foreach ($columns as $column): ?>
            <th class="text-left px-4 text-[#282224] bg-white text-sm font-[500]">
                <?php echo htmlspecialchars($column['title']); ?>
            </th>
            <?php endforeach; ?>
        </tr>
    </thead>

    <?php if (count($dataSource) > 0): ?>
    <tbody>
        <?php foreach ($dataSource as $index => $record): ?>
        <tr
            class="border-b h-[60px] border-b-[#E7E7E7] hover:bg-[#ED2024] font-[300] text-[#282224] hover:text-white transition-all duration-200 ease-in-out">
            <?php foreach ($columns as $column): ?>
            <td class="px-3 py-2 text-sm font-[300]">
                <?php
                                // Check if a custom render function is provided and is callable
                                if (isset($column['render']) && is_callable($column['render'])) {
                                    // Call the render function, passing the current record
                                    echo call_user_func($column['render'], $record);
                                } else {
                                    // Otherwise, display the data directly from dataIndex
                                    echo htmlspecialchars(isset($record[$column['dataIndex']]) ? $record[$column['dataIndex']] : '');
                                }
                                ?>
            </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <?php else: ?>
    <tbody>
        <tr>
            <td colSpan="<?php echo count($columns); ?>" class="text-center py-4 text-gray-500 text-sm">
                No data available.
            </td>
        </tr>
    </tbody>
    <?php endif; ?>
</table>
<?php endif; ?>