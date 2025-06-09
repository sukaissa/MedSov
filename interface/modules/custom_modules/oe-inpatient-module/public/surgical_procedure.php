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

use OpenEMR\Modules\InpatientModule\ProcedureQuery;

require_once "../../../../globals.php";
require_once "./components/sql/procedureQuery.php";

$surProcedure = new ProcedureQuery();
$procedures = $surProcedure->getProcedure();

if (isset($_POST['new']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'procedure_name' => $_POST['name'],
        'g_drg_code' => $_POST['code'],
        'price' => $_POST['price'],
    ];
    $surProcedure->insertProcedure($data);
    header('Refresh:0');
} elseif (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'procedure_name' => $_POST['name'],
        'insurance_status' => $_POST['status'],
        'g_drg_code' => $_POST['code'],
        'price' => $_POST['price'],
        'status' => $_POST['status'],
    ];
    $surProcedure->updateProcedure($data);
    header('Refresh:0');
} elseif (isset($_POST['deleteId']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $surProcedure->destroyProcedure($_POST['deleteId']);
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
    <?php require_once(__DIR__ . "/include_files.php"); ?>
    
    <title><?php echo xlt("Inpatient - Surgical Procedure") ?></title>
</head>

<body class="container-fluid d-flex flex-column" style="padding-left: 30px; padding-right: 30px;">
    <div style="margin-top: 25px;">
        <a href="./inpatient.php"><?php echo xlt("Back") ?></a>
        <p></p>
    </div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; margin-top: 50px;">
        <h4 class="section-head"><?php echo xlt('Surgical Procedure') ?></h4>
        <button type="button" class="btn" style="background-color: #40E0D0;" data-toggle="modal" data-target="#newProcedure">
            <?php echo xlt('New Procedure') ?>
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th scope="col"> No</th>
                <th scope="col"><?php echo xlt('Name') ?> </th>
                <th scope="col"><?php echo xlt('Status') ?> </th>
                <th scope="col"><?php echo xlt('Price') ?> </th>
                <th scope="col"><?php echo xlt('Code') ?> </th>
                <th scope="col"><?php echo xlt('Action') ?> </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($procedures as $key => $value) { ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value['procedure_name']; ?></td>
                    <td><?php echo $value['insurance_status']; ?></td>
                    <td><?php echo $value['price']; ?></td>
                    <td><?php echo $value['g_drg_code']; ?></td>
                    <td>
                        <a href="#" class="btn btn-primary updateBtn" data-toggle="modal" data-target="#updateItem" data-id="<?php echo $value['id']; ?>" data-name="<?php echo $value['procedure_name']; ?>" data-insurance_status="<?php echo $value['insurance_status']; ?>" data-price="<?php echo $value['price']; ?>" data-g_drg_code="<?php echo $value['g_drg_code']; ?>"><?php echo xlt('Edit') ?></a>
                        <a href="#" class="btn btn-danger deleteBtn" data-toggle="modal" data-target="#itemDelete" data-id="<?php echo $value['id']; ?>"><?php echo xlt('Delete') ?></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <?php include_once "./components/modals/surgical_procedure/new.php"; ?>
    <?php include_once "./components/modals/surgical_procedure/update.php"; ?>
    <?php include_once "./components/modals/surgical_procedure/delete.php"; ?>

    <script defer>
        window.onload = function() {
            $(".updateBtn").click(function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var price = $(this).data('price');
                var code = $(this).data('g_drg_code');
                var status = $(this).data('insurance_status');

                $('input[name=id]').val(id);
                $('input[name=name]').val(name);
                $('input[name=price]').val(price);
                $('input[name=code]').val(code);
                $('select[name=status]').val(status);
            });

            $(".deleteBtn").click(function() {
                var id = $(this).data('id');
                $('#deleteId').val(id);
            });
        };
    </script>
    <?php include_once "./components/footer.php"; ?>