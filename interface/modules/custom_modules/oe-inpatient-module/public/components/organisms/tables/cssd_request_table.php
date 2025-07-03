<div>
    <?php

    $getCssdRequestArray = iterator_to_array($getCssdRequest);

    $dataSource = array_map(function ($request) {
        return [
            'id' => $request['id'] ?? 'N/A',
            'service_name' => $request['service_name'] ?? 'N/A',
            'item' => $request['item_name'] ?? 'N/A',
            'quantity' => $request['quantity'] ?? '0',
            'request_date' => isset($request['request_date']) ? date('Y-m-d', strtotime($request['request_date'])) : 'N/A',
            'request_by' => $request['requested_by'] ?? 'N/A',
            'status' => ucfirst(strtolower($request['status'] ?? 'Pending')),
            'processed_date' => isset($request['processed_date']) ? date('Y-m-d', strtotime($request['processed_date'])) : 'N/A',
            'processed_by' => $request['processed_by'] ?? 'N/A',
            'received_by' => $request['received_by'] ?? 'N/A',
            'actions' => '' // This will be handled by the table component
        ];
    }, $getCssdRequestArray);


    $columns = [
        ['title' => 'Service Name', 'dataIndex' => 'service_name'],
        ['title' => 'Item', 'dataIndex' => 'item'],
        ['title' => 'Quantity', 'dataIndex' => 'quantity'],
        ['title' => 'Request Date', 'dataIndex' => 'request_date'],
        ['title' => 'Request By', 'dataIndex' => 'request_by'],
        ['title' => 'Status', 'dataIndex' => 'status'],
        ['title' => 'Processed Date', 'dataIndex' => 'processed_date'],
        ['title' => 'Processed By', 'dataIndex' => 'processed_by'],
        ['title' => 'Received By', 'dataIndex' => 'received_by'],
        ['title' => 'Actions', 'dataIndex' => 'actions']
    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>