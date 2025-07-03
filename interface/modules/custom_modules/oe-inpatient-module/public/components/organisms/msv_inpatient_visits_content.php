<?php

use OpenEMR\Modules\InpatientModule\InpatientQuery;
use OpenEMR\Modules\InpatientModule\PatientQuery;


require_once __DIR__ . "/../../../../../../globals.php";
require_once __DIR__ . "/../sql/InpatientQuery.php";
require_once __DIR__ . "/../sql/PatientQuery.php";

$inpatientQuery = new InpatientQuery();
$patientQuery = new PatientQuery();

// Server-side validation
if (isset($_POST['new_visit']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $errors = [];

    // Validate visitor name
    if (empty($_POST['visitor_name']) || trim($_POST['visitor_name']) === '') {
        $errors[] = "Visitor name is required";
    } elseif (strlen(trim($_POST['visitor_name'])) < 2) {
        $errors[] = "Visitor name must be at least 2 characters long";
    }

    // Validate patient selection
    if (empty($_POST['patient']) || trim($_POST['patient']) === '') {
        $errors[] = "Patient selection is required";
    } elseif (!is_numeric($_POST['patient'])) {
        $errors[] = "Invalid patient selection";
    }

    // Validate relationship
    if (empty($_POST['relationship_with_patient']) || trim($_POST['relationship_with_patient']) === '') {
        $errors[] = "Relationship is required";
    }

    // Validate time in
    if (empty($_POST['time_in']) || trim($_POST['time_in']) === '') {
        $errors[] = "Time in is required";
    } else {
        // Validate time format
        if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $_POST['time_in'])) {
            $errors[] = "Invalid time format for time in";
        }
    }

    // Validate time out
    if (empty($_POST['time_out']) || trim($_POST['time_out']) === '') {
        $errors[] = "Time out is required";
    } else {
        // Validate time format
        if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $_POST['time_out'])) {
            $errors[] = "Invalid time format for time out";
        }

        // Validate that time out is after time in
        if (!empty($_POST['time_in']) && $_POST['time_out'] <= $_POST['time_in']) {
            $errors[] = "Time out must be after time in";
        }
    }

    // Validate reason for visit
    if (empty($_POST['comment']) || trim($_POST['comment']) === '') {
        $errors[] = "Reason for visit is required";
    } elseif (strlen(trim($_POST['comment'])) < 5) {
        $errors[] = "Reason for visit must be at least 5 characters long";
    }

    // Display errors or process form
    if (!empty($errors)) {
        $error_message = implode("\\n", $errors);
        echo "<script>alert('$error_message');</script>";
    } else {
        // Process the form data
        $data = [
            'visitor_name' => trim($_POST['visitor_name']),
            'patient' => intval($_POST['patient']),
            'relationship_with_patient' => trim($_POST['relationship_with_patient']),
            'time_in' => $_POST['time_in'],
            'time_out' => $_POST['time_out'],
            'comment' => trim($_POST['comment']),
        ];
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update'])) {
    $data = [
        'id' => $_POST['id'],
        'patient_id' => $_POST['patient'],
        'visitor_name' => $_POST['visitor_name'],
        'relationship_with_patient' => $_POST['relationship_with_patient'],
        'time_in' => $_POST['time_in'],
        'time_out' => $_POST['time_out'],
        'comment' => $_POST['comment'],
    ];
    $patientQuery->updateVisitor($data);
} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['deleteId'])) {
    $patientQuery->destroyVisitor($_POST['deleteId']);
    header('location:visits.php?status=success&message=Bed deleted successfully');
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['search'])) {
    $visitors = $patientQuery->searchVisitor($_POST['search']);
    // header('Refresh:0');
}

$visitors = $patientQuery->getVisitors();
$inpatients = $inpatientQuery->getInpatients();


?>

<main class="flex-1">


    <div class="bg-gradient-to-b h-[241px] from-[#FFA97F] to-[#ED2024] p-6">
        <div class="flex justify-between items-center">
            <p class="text-[32px] font-[500] text-white ml-16">Visitors Registry</p>

            <button class="flex mr-16 rounded-md items-center w-[36px] h-[36px] bg-white justify-center" onclick="showFormsModal('visitorsRegistryForm')">
                +
            </button>
        </div>
    </div>

    <div class="flex w-full items-center flex-col justify-center">

        <div class="-mt-[150px] w-[1070px] min-h-[493px] bg-white p-[30px]">

            <div class="flex gap-5 align-items-center border-b pb-5 mb-5 ">
                <div class="h-[50px] w-full rounded-lg border border-[#8C898A] flex items-center gap-3 px-2">

                    <input type="text" class="px-5 focus:ring-0 focus:outline-none flex-1 h-full"
                        placeholder="Enter service name" />
                </div>

                <button class="flex items-center justify-center w-[50px] h-[50px] bg-[#ED2024] rounded-lg">
                    <img src="./assets/img/msv-search-icon.svg" alt="">
                </button>
            </div>


            <?php include_once __DIR__ . '/tables/visitors_registry_table.php'; ?>


        </div>

</main>