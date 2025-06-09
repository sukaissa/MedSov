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

use OpenEMR\Modules\InpatientModule\TheaterQuery;

require_once "../../../../globals.php";
require_once "./components/sql/TheaterQuery.php";

$theaterQuery = new TheaterQuery();
$theaters = $theaterQuery->getTheater();

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'name' => $_POST['name'],
        'status' => "Available",
    ];
    $theaterQuery->insertTheater($data);
    header('Refresh:0');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'status' => $_POST['status'],
    ];
    $theaterQuery->updateTheater($data);
    header('Refresh:0');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $theaterQuery->destroyTheater($_POST['deleteId']);
    header('Refresh:0');
} elseif (isset($_POST['search']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $search = $_POST['search'];
    $admissionsQueue = $admissionQueuQuery->searchAdmissionQueue($search);
    header('Refresh:0');
}

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
    <title><?php echo xlt('Inpatient - Theater') ?> </title>

    <script src="https://code.jquery.com/jquery-3.6.2.js" integrity="sha256-pkn2CUZmheSeyssYw3vMp1+xyub4m+e+QK4sQskvuo4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">
    <div style="margin-top: 25px;">
        <a href="./inpatient.php"><?php echo xlt("Back") ?></a>
        <p></p>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; margin-top: 50px;">
        <h4 class="section-head"><?php echo xlt('Theater') ?></h4>
        <button type="button" class="btn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#newTheater">
            <?php echo xlt('New Theater') ?>
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th scope="col"><?php echo xlt('No.') ?></th>
                <th scope="col"><?php echo xlt('Name') ?></th>
                <th scope="col"><?php echo xlt('Location') ?></th>
                <th scope="col"><?php echo xlt('Status') ?></th>
                <th scope="col"><?php echo xlt('Action') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($theaters as $key => $value) { ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value['theater_name']; ?></td>
                    <td><?php echo $value['location_id']; ?></td>
                    <td><?php echo $value['status']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateItem" data-id="<?php echo $value['id']; ?>" data-name="<?php echo $value['theater_name']; ?>" data-location="<?php echo $value['location_id']; ?>" data-status="<?php echo $value['status']; ?>"><?php echo xlt('Edit') ?></a>
                        <a href="#" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#itemDelete" data-id="<?php echo $value['id']; ?>"><?php echo xlt('Delete') ?></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php include_once "./components/modals/theater/new.php"; ?>
    <?php include_once "./components/modals/theater/update.php"; ?>
    <?php include_once "./components/modals/theater/delete.php"; ?>

    <script defer>
        window.onload = function() {
            $(".updateBtn").click(function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var status = $(this).data('status');

                $('input[name=id]').val(id);
                $('input[name=name]').val(name);
                $('select[name=status]').val(status);
            });

            $(".deleteBtn").click(function() {
                var id = $(this).data('id');
                $('#deleteId').val(id);
            });
        };
    </script>
    <?php include_once "./components/footer.php"; ?>