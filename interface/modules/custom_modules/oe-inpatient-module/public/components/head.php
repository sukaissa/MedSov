<?php

/**
 * Inpatient Module
 *
 * @package   OpenEMR
 * @link      http://www.open-emr.org
 *
 * @author    Stanley Otabil <stanleykwaminaotabil@gmail.com>
 * @author    Knapps <hh@gmail.com>
 * @copyright Copyright (c) 2022 Stanley Otabil <stanleykwaminaotabil@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 */

$admissions_count = $admissionQueuQuery->countAdmissions();
$inpatient_count = $inpatientQuery->countInpatients();
$bed_count = $bedQuery->countBeds();
$bed_count_av = $bedQuery->countBedsAvailable();
$ward_count = $wardQuery->countWards();
$surgery_count = $surgeryQuery->countSurgery();
// $pre_discharge_checklist_count = $preDischargeChecklist->countChecklists();

$navLinks = [
    [
        'name' => 'Admission',
        'link' => 'index',
        'icon' => '<i class="bi bi-people-fill"></i>',
        'number' => $admissions_count
    ],
    [
        'name' => 'Beds',
        'link' => 'beds',
        'icon' => '<i class="bi bi-truck-flatbed"></i>',
        'number' => $bed_count_av . "/" . $bed_count

    ],
    [
        'name' => 'Wards',
        'link' => 'wards',
        'icon' => '<i class="bi bi-house-fill"></i>',
        'number' => $ward_count

    ],
    [
        'name' => 'Inpatients',
        'link' => 'inpatient',
        'icon' => '<i class="bi bi-people-fill"></i>',
        'number' => $inpatient_count
    ],

    [
        'name' => 'Surgery',
        'link' => 'surgery',
        'icon' => '<i class="bi bi-graph-up-arrow"></i>',
        'number' => $surgery_count
    ],

    [
        'name' => 'Emergency',
        'link' => 'emergency',
        'icon' => '<i class="bi bi-thermometer-high"></i>',
        'number' => 0
    ],
    [
        'name' => 'PreDischarge',
        'link' => 'predischarge',
        'icon' => '<i class="bi bi-check-circle-fill"></i>',
        'number' => 0
    ],
    // [
    //     'name' => 'Nurses Note',
    //     'link' => 'nurse_note',
    //     'icon' => '<i class="bi bi-people-fill"></i>',
    //     'number' => '40'
    // ]
];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"> -->
    <link rel="stylesheet" href="./assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/bootstrap/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/js/bootstrap/bootstrap.min.js">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title>Inpatient Dashboard</title>

    <!-- <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <script src="./assets/js/jquery-3.6.2.js"></script>
    <link href="./assets/css/select2/select2.min.css" rel="stylesheet" />
    <script src="./assets/js/select2/select2.min.js"></script>

</head>



<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">

    <div class="d-flex" style="margin: 20px auto;">
        <?php foreach ($navLinks as  $value) {
        ?>
            <a role="button" href="<?php echo $value['link']; ?>.php" class="main-links btn btn-primary font-weight-bold d-flex justify-content-center align-items-center mx-4">
                <?php echo $value['name']; ?>
                <div class="d-flex flex-column justify-content-center ml-4">
                    <?php echo $value['icon']; ?>
                    <?php echo $value['number']; ?>
                </div>
            </a>
        <?php
        } ?>
    </div>