<?php

/*
 *
 * @package     OpenEMR Inpatient Module
 * @link        https://lifemesh.ai/telehealth/
 *
 * @author      Stanley kwamina Otabil <stanleyotabil10@gmail.com@gmail.com>
 * @copyright   Copyright (c) 2022 MedSov <telehealth@lifemesh.ai>
 * @license     GNU General Public License 3
 *
 */

use OpenEMR\Modules\InpatientModule\PatientQuery;

require_once "../../../../globals.php";
// require_once "../sql/PatientQuery.php";
// $patientQuery = new PatientQuery();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'patient_id' => $_POST['patient'],
        'visitor_name' => $_POST['visitor_name'],
        'relationship_with_patient' => $_POST['relationship_with_patient'],
        'time_in' => $_POST['time_in'],
        'time_out' => $_POST['time_out'],
        'reason' => $_POST['reason'],
    ];

    // $patientQuery->insertVisitor($data);
    // header('Refresh:0');
}

$menuItems = [
    [
        'id' => 1,
        'name' => "Clinical Management Plan",
        'url' => '__treatment_plan.php',
        'active' => true,
    ],
    [
        'id' => 7,
        'name' => "Follow up Treatment",
        'active' => false,
        'url' => '__tracker.php'
    ],
    [
        'id' => 2,
        'name' => "Vital",
        'active' => false,
        'url' => '__vitals.php'
    ],
    [
        'id' => 3,
        'name' => "Bills",
        'active' => false,
        'url' => '__bills.php'
    ],
    [
        'id' => 4,
        'name' => "SOAP Notes",
        'active' => false,
        'url' => '__soap_notes.php'
    ],
    [
        'id' => 6,
        'name' => "Ward Transfer",
        'active' => false,
        'url' => '--ward_transfer.php'
    ],
    [
        'id' => 89,
        'name' => "Meal Requests",
        'active' => false,
        'url' => '__food_requests.php'
    ],
];

$admission_id = $_GET['admission_id'];
$patient_id = $_GET['patient_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/dashboard.css">
    <title>Patient Dashboard - Clinical Management Plan</title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">


    <div style="margin-top: 25px;">
        <a href="../inpatient.php">Back</a>
        <p></p>

    </div>

    <section class="main-containerx" style="">
        <div class="inp_left_menu">
            <?php
            foreach ($menuItems as $item) {
            ?>
                <a href="<?php echo $item['url'] . "?admission_id=" . $admission_id . "&patient_id=" . $patient_id . "&bed_id=" . $bed_id . "&ward_id=" . $ward_id; ?>" class="<?php echo $item['active'] == true ? 'inp__dash_menu_item_active' : 'inp__dash_menu_item' ?>"><?php echo $item['name']; ?></a>
            <?php
            }
            ?>
        </div>
        <div class="inp_right_contents">
            <h1>Clinical Management Plan</h1>


        </div>
    </section>

</body>