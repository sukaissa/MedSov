<div>
    <?php
    $mealRequestsArray = iterator_to_array($mealRequests) ?? [];

    $dataSource = array_map(function ($mealRequest) {
        // Construct full patient name
        $patientName = trim(($mealRequest['fname'] ?? '') . ' ' . ($mealRequest['mname'] ?? '') . ' ' . ($mealRequest['lname'] ?? ''));
        if (empty($patientName)) {
            $patientName = 'Unknown Patient';
        }

        return [
            'id' => $mealRequest['id'] ?? 'N/A',
            'patient_name' => $patientName,
            'meal_name' => $mealRequest['food_name'] ?? 'N/A',
            'meal_type' => $mealRequest['category'] ?? 'N/A',
            'staff_name' => $mealRequest['username'] ?? 'N/A',
            'request_date' => isset($mealRequest['requested_date']) ?
                date('Y-m-d', strtotime($mealRequest['requested_date'])) : (isset($mealRequest['created_at']) ? date('Y-m-d', strtotime($mealRequest['created_at'])) : 'N/A'),
        ];
    }, $mealRequestsArray);

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