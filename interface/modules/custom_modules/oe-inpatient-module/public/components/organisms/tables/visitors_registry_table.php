<div>
    <?php
    $visitorsArray = iterator_to_array($visitors);

    $dataSource = array_map(function($visitor) {
        // Construct full patient name
        $patientName = trim(($visitor['patient_fname'] ?? '') . ' ' . ($visitor['patient_mname'] ?? '') . ' ' . ($visitor['patient_lname'] ?? ''));
        if (empty($patientName)) {
            $patientName = 'Unknown Patient';
        }

        // Construct full visitor name
        $visitorName = trim(($visitor['visitor_fname'] ?? '') . ' ' . ($visitor['visitor_mname'] ?? '') . ' ' . ($visitor['visitor_lname'] ?? ''));
        if (empty($visitorName)) {
            $visitorName = $visitor['visitor_name'] ?? 'Unknown Visitor';
        }

        return [
            'id' => $visitor['id'] ?? 'N/A',
            'visitor_name' => $visitorName,
            'patient_name' => $patientName,
            'relationship' => ucfirst(strtolower($visitor['relationship_with_patient'] ?? 'N/A')),
        ];
    }, $visitorsArray);

    $columns = [
        ['title' => 'Visitor Name', 'dataIndex' => 'visitor_name'],
        ['title' => 'Patient Name', 'dataIndex' => 'patient_name'],
        ['title' => 'Relationship', 'dataIndex' => 'relationship'],
    ];
    $isLoading = false;
    $responsive = true;

    include_once __DIR__ . '/data-table.php';
    ?>



</div>